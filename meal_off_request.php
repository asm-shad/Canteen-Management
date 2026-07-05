<?php

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

error_reporting(0);

require_once('admin/cls_dbconfig.php');
spl_autoload_register(function($classname) {
    require_once("$classname.class.php");
});

$cls_dbconfig = new cls_dbconfig();
$connect = $cls_dbconfig->connection();

session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Check for meal off submission results
$meal_off_success = isset($_SESSION['meal_off_success']) ? $_SESSION['meal_off_success'] : false;
$meal_off_message = isset($_SESSION['meal_off_message']) ? $_SESSION['meal_off_message'] : '';
$meal_off_details = isset($_SESSION['meal_off_details']) ? $_SESSION['meal_off_details'] : array();
$meal_off_error = isset($_SESSION['meal_off_error']) ? $_SESSION['meal_off_error'] : '';
$meal_off_existing_dates = isset($_SESSION['meal_off_existing_dates']) ? $_SESSION['meal_off_existing_dates'] : array();

// Clear session variables after reading
unset($_SESSION['meal_off_success']);
unset($_SESSION['meal_off_message']);
unset($_SESSION['meal_off_details']);
unset($_SESSION['meal_off_error']);
unset($_SESSION['meal_off_existing_dates']);

// Handle AJAX requests
if(isset($_POST['ajax_action'])) {
    $action = $_POST['ajax_action'];
    $employee_id = isset($_POST['employee_id']) ? $_POST['employee_id'] : '';
    
    if($action == 'check_eligibility') {
        $response = array(
            'is_eligible' => false,
            'message' => '',
            'employee_data' => null,
            'upcoming_meals' => '',
            'history' => ''
        );
        
        if(!empty($employee_id)) {
            $employee_query = $connect->query("
                SELECT ca.*, 
                    ei.name,
                    ei.designation,
                    ei.department,
                    ei.section,
                    ei.phone as mobile,
                    ei.email,
                    ei.joiningdate as joining_date,
                    ca.allotted_seat 
                FROM canteen_application ca
                LEFT JOIN employee_info ei ON ca.employee_id = ei.employeeID
                WHERE ca.employee_id = '$employee_id'
            ");
            
            $employee_data = $employee_query->fetch_assoc();
            
            if (!$employee_data) {
                $response['message'] = 'Employee not found in the system.';
            } 
            // Updated eligibility check: allotted_seat == "VIP" AND (status == "Accepted" OR status == "Transfer")
            elseif (!in_array($employee_data['status'], ['Accepted', 'Transfer'])) {
                $response['message'] = 'Only Accepted or Transfer employees can request meal off. Your status: ' . $employee_data['status'];
            } elseif ($employee_data['allotted_seat'] != 'VIP') {
                $response['message'] = 'Only VIP allotted seat employees can request meal off. Your allotted seat: ' . $employee_data['allotted_seat'];
            } else {
                $response['is_eligible'] = true;
                $response['message'] = 'Eligible';
                $response['employee_data'] = $employee_data;
                
                // Get meal off history
                $meal_off_history = $connect->query("
                    SELECT * FROM meal_off_requests 
                    WHERE employee_id = '$employee_id'
                    ORDER BY meal_off_date DESC
                    LIMIT 20
                ");
                
                if($meal_off_history->num_rows > 0) {
                    $response['history'] = '<div style="margin-top: 60px; border:1px solid #ddd; padding:15px; background:#ffffff; clear:both;">
                        <h5 style="margin-top:0;"><i class="fa fa-history"></i> Meal Off History</h5>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width:50px;">#</th>
                                        <th style="width:120px;">Date</th>
                                        <th style="width:100px;">Status</th>
                                        <th style="width:150px;">Request Date</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>';
                    
                    $count = 1;
                    while($history = $meal_off_history->fetch_assoc()) {
                        $status_class = strtolower($history['status']);
                        $response['history'] .= '<tr>
                            <td>' . $count++ . '</td>
                            <td>' . date('d-m-Y', strtotime($history['meal_off_date'])) . '</td>
                            <td><span class="badge-status badge-' . $status_class . '">' . $history['status'] . '</span></td>
                            <td>' . date('d-m-Y H:i', strtotime($history['request_date'])) . '</td>
                            <td>' . htmlspecialchars($history['remarks']) . '</td>
                        </tr>';
                    }
                    
                    $response['history'] .= '</tbody></table></div></div>';
                }
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
}

// Get current date and time for validation
date_default_timezone_set('Asia/Dhaka');
$currentDateTime = new DateTime();
$currentTime = $currentDateTime->format('H:i');
$currentDate = $currentDateTime->format('Y-m-d');
$currentDateTimeStr = $currentDateTime->format('Y-m-d H:i:s');

// Check if it's past 4 PM
$isPastFourPM = ($currentTime >= '16:00');

// Get tomorrow's date
$tomorrow = new DateTime('tomorrow');
$tomorrowDate = $tomorrow->format('Y-m-d');

// Get the next available date for meal off (if after 4 PM, tomorrow is disabled)
$nextAvailableDate = $isPastFourPM ? date('Y-m-d', strtotime('+2 days')) : $tomorrowDate;

// Set the date input min and max
$minDate = $nextAvailableDate;
$maxDate = date('Y-m-d', strtotime('+30 days'));

// Handle form submission for meal off (only when Submit is clicked)
if(isset($_POST['submit_meal_off'])) {
    $meal_off_dates = isset($_POST['meal_off_date']) ? $_POST['meal_off_date'] : array();
    $remarks_array = isset($_POST['remarks']) ? $_POST['remarks'] : array();
    $meal_off_phone = isset($_POST['phone']) ? $_POST['phone'] : array();
    $meal_off_email = isset($_POST['email']) ? $_POST['email'] : array();
    $employee_id = $connect->real_escape_string($_POST['employee_id']);
    
    // Get employee details for eligibility check (updated)
    $check_eligibility = $connect->query("
        SELECT ca.status, ca.allotted_seat 
        FROM canteen_application ca 
        WHERE ca.employee_id = '$employee_id'
    ");
    $eligibility_check = $check_eligibility->fetch_assoc();
    
    // Updated eligibility check: allotted_seat == "VIP" AND (status == "Accepted" OR status == "Transfer")
    if(!in_array($eligibility_check['status'], ['Accepted', 'Transfer']) || $eligibility_check['allotted_seat'] != 'VIP') {
        $_SESSION['meal_off_error'] = "You are not eligible for meal off request.";
        header('Location: meal_off_request.php');
        exit();
    } else {
        $success_count = 0;
        $error_count = 0;
        $existing_count = 0;
        $submitted_dates = array();
        $existing_dates = array();
        
        foreach($meal_off_dates as $index => $meal_off_date) {
            if(empty($meal_off_date)) continue;
            
            $meal_off_date = $connect->real_escape_string($meal_off_date);
            $remarks = isset($remarks_array[$index]) ? $connect->real_escape_string($remarks_array[$index]) : '';
            
            if($meal_off_date <= $currentDate) {
                $error_count++;
                continue;
            }
            
            if($isPastFourPM && $meal_off_date == $tomorrowDate) {
                $error_count++;
                continue;
            }
            
            // Check for existing request on the same date
            $checkQuery = $connect->query("
                SELECT id FROM meal_off_requests 
                WHERE employee_id = '$employee_id' 
                AND meal_off_date = '$meal_off_date' 
                AND status = 'Active'
            ");
            
            if($checkQuery->num_rows > 0) {
                $existing_count++;
                $existing_dates[] = date('d-m-Y', strtotime($meal_off_date));
                continue;
            }
            
            // Get employee details for the insert
            $empData = $connect->query("
                SELECT ca.*, 
                    ei.name,
                    ei.designation,
                    ei.department,
                    ei.section,
                    ei.phone as mobile,
                    ei.email,
                    ei.joiningdate as joining_date,
                    ca.allotted_seat
                FROM canteen_application ca
                LEFT JOIN employee_info ei ON ca.employee_id = ei.employeeID
                WHERE ca.employee_id = '$employee_id'
            ")->fetch_assoc();
            
            // Get phone and email from POST (they can be updated)
            $phone = isset($meal_off_phone[$index]) ? $connect->real_escape_string($meal_off_phone[$index]) : 
                    (isset($empData['mobile']) ? $connect->real_escape_string($empData['mobile']) : '');
            $email = isset($meal_off_email[$index]) ? $connect->real_escape_string($meal_off_email[$index]) : 
                    (isset($empData['email']) ? $connect->real_escape_string($empData['email']) : '');
            $allotted_seat = isset($empData['allotted_seat']) ? $connect->real_escape_string($empData['allotted_seat']) : '';

            $insertQuery = "INSERT INTO meal_off_requests 
                (employee_id, employee_name, designation, department, section, phone, email, employer_factory, allotted_seat, meal_off_date, request_date, remarks, status) 
                VALUES (
                    '$employee_id',
                    '{$connect->real_escape_string($empData['name'])}',
                    '{$connect->real_escape_string($empData['designation'])}',
                    '{$connect->real_escape_string($empData['department'])}',
                    '{$connect->real_escape_string($empData['section'])}',
                    '$phone',
                    '$email',
                    '{$connect->real_escape_string($empData['employer_factory'])}',
                    '$allotted_seat',
                    '$meal_off_date',
                    '$currentDateTimeStr',
                    '$remarks',
                    'Active'
                )";
            
            if($connect->query($insertQuery)) {
                $success_count++;
                $submitted_dates[] = date('d-m-Y', strtotime($meal_off_date));
                $last_inserted_id = $connect->insert_id; // Get the inserted ID
                
                $updateCountQuery = "UPDATE canteen_application 
                                    SET meal_off_count = meal_off_count + 1 
                                    WHERE employee_id = '$employee_id'";
                $connect->query($updateCountQuery);
            } else {
                $error_count++;
            }
        }
        
        // Determine the appropriate message and redirect
        if($success_count > 0) {
            // Get ALL the request IDs submitted in this batch
            $requestIds = array();
            
            // Get all requests for this employee made at the same time (within the same minute)
            $batchQuery = $connect->query("
                SELECT id FROM meal_off_requests 
                WHERE employee_id = '$employee_id' 
                AND DATE(request_date) = DATE('$currentDateTimeStr')
                AND HOUR(request_date) = HOUR('$currentDateTimeStr')
                AND MINUTE(request_date) = MINUTE('$currentDateTimeStr')
                ORDER BY meal_off_date ASC
            ");
            
            if($batchQuery && $batchQuery->num_rows > 0) {
                while($row = $batchQuery->fetch_assoc()) {
                    $requestIds[] = $row['id'];
                }
            }
            
            // If no batch found, use the last inserted ID
            if(empty($requestIds) && isset($last_inserted_id)) {
                $requestIds[] = $last_inserted_id;
            }
            
            // Create comma-separated list of IDs for URL
            $idsString = implode(',', $requestIds);
            
            // Store success message in session for the view page
            $_SESSION['meal_off_view_success'] = true;
            $_SESSION['meal_off_view_message'] = "Your meal off request has been submitted successfully!";
            $_SESSION['meal_off_submitted_dates'] = $submitted_dates;
            
            // Check if any dates were skipped
            if($existing_count > 0) {
                $_SESSION['meal_off_view_warning'] = "Note: " . $existing_count . " date(s) were already requested and skipped.";
                $_SESSION['meal_off_warning'] = "Some dates were already requested and have been skipped.";
                $_SESSION['meal_off_existing_dates'] = $existing_dates;
            }
            
            // Redirect to the view page with ALL IDs in the URL
            $redirectUrl = "view_meal_off_request.php?ids=" . urlencode($idsString);
            
            header('Location: ' . $redirectUrl);
            exit();
            
        } else {
            // No successful requests
            if($existing_count > 0 && $error_count == 0) {
                // All dates already exist
                $_SESSION['meal_off_error'] = "All requested dates have already been submitted. Please select different dates.";
                $_SESSION['meal_off_existing_dates'] = $existing_dates;
            } elseif($existing_count > 0 && $error_count > 0) {
                // Mixed existing and errors
                $_SESSION['meal_off_error'] = "Request failed. Some dates already exist and some are invalid.";
                $_SESSION['meal_off_existing_dates'] = $existing_dates;
            } else {
                // All errors
                $_SESSION['meal_off_error'] = "Request failed. Please check the dates and try again.";
            }
            
            header('Location: meal_off_request.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LDC Group - Meal Off Request</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
    <link rel="shortcut icon" href="assets/ico/lizlogo.png">
    
    <style type="text/css">
        body{
            background-color: #ffffff;
            font-size: 12px;
        }
        
        .container{
            padding: 20px;
        }
        
        .header-title {
            font-family: fantasy;
            font-size: 230%;
            padding: 1px 5px 2px 5px;
        }
        
        .sub-title {
            font-family: sans-serif;
            font-size: 136%;
            padding: 1px 5px 2px 5px;
            margin-top: -5px;
        }
        
        .form-control{
            height: 29px !important;
            padding: 4px 6px !important;
        }
        
        .btn-small{
            padding: 5px 15px;
            font-size: 12px;
        }
        
        .table{
            font-size: 12px;
        }
        
        .table th{
            background: #f5f5f5;
        }
        
        .shawdow{
            border-collapse: collapse;
            width: 100%;
        }
        
        .shawdow td{
            padding: 8px;
            border: 1px solid #ddd;
        }
        
        .top-div{
            padding-top: 5px;
        }
        
        .col-sm-8 {
            width: 64.666667%;
            margin-left: -28px;
        }
        
        .col-form-label{
            padding-top: 5px;
        }
        
        .header{
            font-size: 19px;
        }
        
        .eligibility-box{
            padding: 12px 15px;
            background: #f9f9f9;
            border-left: 4px solid #28a745;
            margin-bottom: 15px;
        }
        
        .eligibility-box.not-eligible{
            border-left-color: #dc3545;
            background: #fff5f5;
        }
        
        .date-info{
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }
        
        .date-info.warning{
            color: #856404;
            background: #fff3cd;
            padding: 5px 10px;
            border-radius: 4px;
            display: inline-block;
        }
        
        .upcoming-box{
            background: #e3f2fd;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        
        .upcoming-box .upcoming-date{
            font-weight: bold;
            color: #0d6efd;
        }
        
        #equipments{
            height: auto;
        }
        
        .badge-status{
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }
        
        .badge-active{
            background: #28a745;
            color: white;
        }
        
        .badge-used{
            background: #6c757d;
            color: white;
        }
        
        .badge-cancelled{
            background: #dc3545;
            color: white;
        }
        
        .row {
            margin-left: 0;
            margin-right: 0;
        }
        
        .col-md-6 {
            padding-left: 5px;
            padding-right: 5px;
        }
        
        .form-group {
            margin-bottom: 5px;
        }
        
        .form-group label {
            padding-top: 5px;
            font-weight: normal;
        }
        
        .btn-remove-row {
            background: none;
            border: none;
            color: #dc3545;
            padding: 2px 8px;
            cursor: pointer;
            font-size: 16px;
        }
        
        .btn-remove-row:hover {
            color: #c82333;
            background: none;
        }
        
        .btn-remove-row:focus {
            outline: none;
        }
        
        .btn-add-row {
            background-color: #343a40;
            border-color: #343a40;
            color: #fff;
            padding: 5px 15px;
            font-size: 12px;
        }
        
        .btn-add-row:hover {
            background-color: #23272b;
            border-color: #1d2124;
            color: #fff;
        }
        
        .btn-add-row:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        #eligibility_status {
            display: none;
        }
        
        /* Alert styling */
        .alert {
            padding: 12px 15px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        
        .alert .close {
            float: right;
            font-size: 21px;
            font-weight: 700;
            line-height: 1;
            color: #000;
            text-shadow: 0 1px 0 #fff;
            opacity: .5;
            background: none;
            border: none;
            cursor: pointer;
        }
        
        .alert .close:hover {
            opacity: .75;
        }
        
        @media (max-width: 768px) {
            .col-md-6 {
                width: 100%;
            }
        }
    </style>
</head>

<body>
<div class="container">  
    <div id="printableArea">
        <div id="cname"> <center><h2 class="header-title">LDC Group</h2></center> </div>
        <center><h4 class="sub-title">Request for Meal Off</h4></center>

        <!-- Display Success/Error Messages -->
        <?php if($meal_off_success): ?>
        <div class="alert alert-success alert-dismissible" style="margin-bottom: 15px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><i class="fa fa-check-circle"></i> Success!</strong> <?php echo $meal_off_message; ?>
            <br>
            <small>
                <?php 
                if($meal_off_details['success'] > 0) {
                    echo "Successfully requested: " . $meal_off_details['success'] . " day(s)";
                    if(!empty($meal_off_details['dates'])) {
                        echo " (" . implode(', ', $meal_off_details['dates']) . ")";
                    }
                }
                if($meal_off_details['existing'] > 0) {
                    if($meal_off_details['success'] > 0) echo " | ";
                    echo "Already existing: " . $meal_off_details['existing'] . " day(s)";
                    if(!empty($meal_off_details['existing_dates'])) {
                        echo " (" . implode(', ', $meal_off_details['existing_dates']) . ")";
                    }
                }
                if($meal_off_details['errors'] > 0) {
                    if($meal_off_details['success'] > 0 || $meal_off_details['existing'] > 0) echo " | ";
                    echo "Failed: " . $meal_off_details['errors'] . " day(s)";
                }
                ?>
            </small>
        </div>
        <?php endif; ?>

        <?php if($meal_off_error): ?>
        <div class="alert alert-danger alert-dismissible" style="margin-bottom: 15px;">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><i class="fa fa-exclamation-circle"></i> Error!</strong> <?php echo $meal_off_error; ?>
            <?php if(!empty($meal_off_existing_dates)): ?>
                <br>
                <small>Already requested dates: <?php echo implode(', ', $meal_off_existing_dates); ?></small>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Navigation Buttons -->
        <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 7px;">
            <br>
        </div>

        <form role="form" id="multiphase" enctype="multipart/form-data" action="" method="post">
            <table border="1" align="center" cellpadding="0" cellspacing="0" class="shawdow">
                <tr>
                    <td style="padding-left: 10px; padding-right: 10px;">

                        <div id="equipments">
                            <div class="row">
                                <!-- Left Column - Employee ID -->
                                <div class="col-md-6 top-div">
                                    <div class="form-group">
                                        <label for="Employee" class="col-sm-4 col-form-label">Employee ID:</label>
                                        <div class="col-sm-8">
                                            <input type="text" 
                                                   name="employee_id" 
                                                   placeholder="Enter Employee ID" 
                                                   class="employee-id form-control" 
                                                   id="employee_id" 
                                                   style="text-transform:uppercase" 
                                                   autocomplete="off"
                                                   value="<?php echo isset($_POST['employee_id']) ? htmlspecialchars($_POST['employee_id']) : ''; ?>">
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column - Employee Details -->
                                <div id="getuserinfo">
                                    <div class="col-md-6 top-div">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-4 col-form-label">Name:</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="emp_name" placeholder="Enter name..." class="f1-first-name form-control" id="f1-first-name" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 top-div">
                                        <div class="form-group">
                                            <label for="designation" class="col-sm-4 col-form-label">Designation:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="designation" id="f1-designation" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 top-div">
                                        <div class="form-group">
                                            <label for="department" class="col-sm-4 col-form-label">Department:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="department" id="f1-department" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 top-div">
                                        <div class="form-group">
                                            <label for="section" class="col-sm-4 col-form-label">User Section:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="section" id="f1-section" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Phone Number - Now Editable (No +88 prefix) -->
                                    <div class="col-md-6 top-div">
                                        <div class="form-group">
                                            <label for="phone" class="col-sm-4 col-form-label">Contact Number:</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="phone[]" placeholder="Enter phone number" class="form-control" id="f1-phone" 
                                                    value="" style="background-color:#ffffff;" onkeypress="return isNumberKey(event)" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Email - Now Editable -->
                                    <div class="col-md-6 top-div">
                                        <div class="form-group">
                                            <label for="email" class="col-sm-4 col-form-label">Email:</label>
                                            <div class="col-sm-8">
                                                <input type="email" name="email[]" id="f1-email" placeholder="email@example.com" 
                                                    class="form-control" value="" style="background-color:#ffffff;" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 top-div">
                                        <div class="form-group">
                                            <label for="joindate" class="col-sm-4 col-form-label">Join Date:</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="joindate" readonly placeholder="dd-mm-yyyy" class="f1-twitter form-control" id="f1-joindate">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-8 top-div">
                                        <div class="form-group">
                                            <!-- <label for="joindate" class="col-sm-4 col-form-label">I have No Email:</label>
                                            <div class="col-sm-8">
                                                <input class="form-check-input" id="newemail" type="checkbox" name="newemail" value="Yes">
                                                <label class="form-check-label" for="flexRadioDefault1"></label>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Eligibility Status (hidden by default, shown via AJAX) -->
                            <div id="eligibility_status">
                                <div style="margin-top: 10px; margin-bottom: 10px;">
                                    <div class="eligibility-box" id="eligibility_result">
                                        <strong>Eligibility Status:</strong>
                                        <span id="eligibility_text"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Upcoming Meal Offs Container -->
                            <div id="upcoming_meals_container"></div>

                            <hr style="margin: 10px 0;">

                            <!-- Meal Off Details Section -->
                            <div style="margin-top: 5px;">
                                <table border="0" cellspacing="0" cellpadding="0" style="width:100%;">
                                    <tr>
                                        <td height="24" colspan="3"><b class="header">Meal Off Details</b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:30px;">&nbsp;</td>
                                        <td>Date</td>
                                        <td>Remarks</td>
                                    </tr>
                                    <tr id="meal_rows">
                                        <td>
                                            <div class="input-group-prepend">
                                                <button class="btn btn-danger btn-remove-row" id="DeleteRow" type="button">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td style="padding-left: 2px;">
                                            <input type="date" 
                                                   name="meal_off_date[]" 
                                                   class="form-control date-input"
                                                   min="<?php echo $minDate; ?>" 
                                                   max="<?php echo $maxDate; ?>"
                                                   style="width:180px;"
                                                   disabled>
                                        </td>
                                        <td style="padding-left: 2px;">
                                            <textarea class="form-control remarks-input" name="remarks[]" rows="1" placeholder="Reason for meal off" style="width:100%; min-width:200px;" disabled></textarea>
                                        </td>
                                    </tr>
                                </table>
                                <div id="newMealRow"></div>
                                <table>
                                    <tr>
                                        <td colspan="3">
                                            <button id="mealRowAdder" type="button" class="btn btn-dark btn-add-row" disabled style="opacity:0.5; cursor:not-allowed;">
                                                <i class="fa fa-plus"></i> ADD
                                            </button>
                                            <div class="date-info <?php echo $isPastFourPM ? 'warning' : ''; ?>" style="margin-top:5px; display:inline-block; margin-left:15px;">
                                                <?php if($isPastFourPM): ?>
                                                    ⚠️ After 4:00 PM - Available from <?php echo date('d-m-Y', strtotime($minDate)); ?>
                                                <?php else: ?>
                                                    <!-- Available from tomorrow (<?php echo date('d-m-Y', strtotime($tomorrowDate)); ?>) -->
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Submit Button -->
                            <br>
                            <span style="float: right; padding-bottom: 15px;">
                                <input type="hidden" name="employee_id" id="hidden_employee_id" value="">
                                <button type="submit" name="submit_meal_off" id="btnSubmit" class="btn btn-success" disabled>
                                    <i class="fa fa-check"></i> Submit
                                </button>
                                <button type="reset" class="btn btn-default">
                                    <i class="fa fa-refresh"></i> Reset
                                </button>
                            </span>

                            <!-- Meal Off History Container -->
                            <div id="meal_off_history_container"></div>

                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<!-- Javascript -->
<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.backstretch.min.js"></script>
<script src="assets/js/retina-1.1.0.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    // Auto-load on blur (when user clicks outside) - using AJAX
    $('#employee_id').on('blur', function() {
        var employeeID = this.value.trim();
        if(employeeID) {
            checkEligibility(employeeID);
        } else {
            // Clear all fields if empty
            clearAllFields();
        }
    });

    // Enter key on employee ID field triggers check
    $('#employee_id').on('keypress', function(e) {
        if(e.which === 13) {
            e.preventDefault();
            $(this).blur();
        }
    });

    // Auto uppercase for employee ID
    $('#employee_id').on('input', function() {
        this.value = this.value.toUpperCase();
    });

    // Disable enter key on other fields
    $('#multiphase').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13 && !$(e.target).is('#employee_id')) { 
            e.preventDefault();
            return false;
        }
    });

    // Phone number validation - only numbers (no + sign)
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    // "I have No Email" checkbox
    $("#newemail").click(function () {
        $('#email').attr("disabled", $(this).is(":checked"));
    });

    // Add meal row
    $("#mealRowAdder").click(function () {
        var newRowAdd = 
        '<table style="margin-top: 3px; width:100%;">' +
        '<tr id="meal_rows">' +
        '<td style="width:30px;">' +
        '<div class="input-group-prepend">' +
        '<button class="btn btn-danger btn-remove-row" id="DeleteRow" type="button">' +
        '<i class="fa fa-trash"></i></button> </div> </td>' +
        '<td style="padding-left: 2px;">' +
        '<input type="date" name="meal_off_date[]" class="form-control date-input" min="<?php echo $minDate; ?>" max="<?php echo $maxDate; ?>" style="width:180px;" required>' +
        '</td>' +
        '<td style="padding-left: 2px;">' +
        '<textarea class="form-control remarks-input" name="remarks[]" rows="1" placeholder="Reason for meal off" style="width:100%; min-width:200px;"></textarea>' +
        '</td>' +
        '</tr>' +
        '</table>';

        $('#newMealRow').append(newRowAdd);
    });

    // Remove row
    $("body").on("click", "#DeleteRow", function () {
        $(this).closest("tr").remove();
        $(this).closest("table").remove();
    });

    // Function to clear all fields
    function clearAllFields() {
        $('#f1-first-name').val('');
        $('#f1-designation').val('');
        $('#f1-department').val('');
        $('#f1-section').val('');
        $('#f1-phone').val('');
        $('#f1-email').val('');
        $('#f1-joindate').val('');
        $('#hidden_employee_id').val('');
        $('#eligibility_status').hide();
        $('#upcoming_meals_container').html('');
        $('#meal_off_history_container').html('');
        $('input[name="meal_off_date[]"]').prop('disabled', true);
        $('textarea[name="remarks[]"]').prop('disabled', true);
        $('#mealRowAdder').prop('disabled', true).css('opacity', '0.5').css('cursor', 'not-allowed');
        $('#btnSubmit').prop('disabled', true);
        $('#submit_status').html('Enter Employee ID to check eligibility').css('color', '#6c757d');
        // Disable phone and email editing
        $('#f1-phone').prop('readonly', true).css('background-color', '#f5f5f5');
        $('#f1-email').prop('readonly', true).css('background-color', '#f5f5f5');
    }

    // Function to check eligibility via AJAX
    function checkEligibility(employeeID) {
        $.ajax({
            url: window.location.href,
            type: "POST",
            data: {
                ajax_action: 'check_eligibility',
                employee_id: employeeID
            },
            dataType: "json",
            success: function(response) {
                // Update hidden employee ID
                $('#hidden_employee_id').val(employeeID);
                
                if(response.employee_data) {
                    $('#f1-first-name').val(response.employee_data.name || '');
                    $('#f1-designation').val(response.employee_data.designation || '');
                    $('#f1-department').val(response.employee_data.department || '');
                    $('#f1-section').val(response.employee_data.section || '');
                    // Phone - editable, pre-filled with existing value
                    $('#f1-phone').val(response.employee_data.mobile || '');
                    // Email - editable, pre-filled with existing value
                    $('#f1-email').val(response.employee_data.email || '');
                    $('#f1-joindate').val(response.employee_data.joining_date || '');
                } else {
                    $('#f1-first-name').val('');
                    $('#f1-designation').val('');
                    $('#f1-department').val('');
                    $('#f1-section').val('');
                    $('#f1-phone').val('');
                    $('#f1-email').val('');
                    $('#f1-joindate').val('');
                }
                
                // Show eligibility status
                $('#eligibility_status').show();
                var eligibilityBox = $('#eligibility_result');
                var textSpan = $('#eligibility_text');
                
                if(response.is_eligible) {
                    eligibilityBox.removeClass('not-eligible');
                    textSpan.html('<span style="color:#28a745;">Eligible for Meal Off</span>');
                    
                    // Enable meal off fields
                    $('input[name="meal_off_date[]"]').prop('disabled', false);
                    $('textarea[name="remarks[]"]').prop('disabled', false);
                    $('#mealRowAdder').prop('disabled', false).css('opacity', '1').css('cursor', 'pointer');
                    $('#btnSubmit').prop('disabled', false);
                    $('#submit_status').html('<span style="color:#28a745;">You are eligible. Select dates and submit.</span>').css('color', '#28a745');
                    
                    // Load upcoming meals
                    if(response.upcoming_meals) {
                        $('#upcoming_meals_container').html(response.upcoming_meals);
                    } else {
                        $('#upcoming_meals_container').html('');
                    }
                    
                    // Load meal off history
                    if(response.history) {
                        $('#meal_off_history_container').html(response.history);
                    } else {
                        $('#meal_off_history_container').html('');
                    }
                    
                    // Enable phone and email editing
                    $('#f1-phone').prop('readonly', false).css('background-color', '#ffffff');
                    $('#f1-email').prop('readonly', false).css('background-color', '#ffffff');
                    
                } else {
                    eligibilityBox.addClass('not-eligible');
                    textSpan.html('<span style="color:#dc3545;">✗ Not Eligible - ' + response.message + '</span>');
                    
                    // Disable meal off fields
                    $('input[name="meal_off_date[]"]').prop('disabled', true);
                    $('textarea[name="remarks[]"]').prop('disabled', true);
                    $('#mealRowAdder').prop('disabled', true).css('opacity', '0.5').css('cursor', 'not-allowed');
                    $('#btnSubmit').prop('disabled', true);
                    $('#submit_status').html('<span style="color:#dc3545;">You are not eligible for meal off request.</span>').css('color', '#dc3545');
                    
                    // Clear upcoming and history
                    $('#upcoming_meals_container').html('');
                    $('#meal_off_history_container').html('');

                    // Disable phone and email editing
                    $('#f1-phone').prop('readonly', true).css('background-color', '#f5f5f5');
                    $('#f1-email').prop('readonly', true).css('background-color', '#f5f5f5');
                }
            },
            error: function() {
                alert('Error checking eligibility. Please try again.');
            }
        });
    }

    // Form validation - simplified
    $('#btnSubmit').on('click', function(e) {
        var dateInputs = $('input[name="meal_off_date[]"]:not(:disabled)');
        var hasDate = false;
        dateInputs.each(function() {
            if($(this).val()) {
                hasDate = true;
            }
        });
        
        if(!hasDate) {
            alert('Please select at least one date for meal off.');
            e.preventDefault();
            return false;
        }
        
        // Let the form submit naturally with all validation
        var dateCount = dateInputs.filter(function() { return $(this).val(); }).length;
        if (!confirm('Are you sure you want to request meal off for ' + dateCount + ' day(s)?')) {
            e.preventDefault();
            return false;
        }
        
        // The form will submit and the page will reload with success/error messages
    });

    <?php if($meal_off_success): ?>
        // Only clear if at least one new request was successful
        <?php if($meal_off_details['success'] > 0): ?>
            // Clear all form fields
            $('#employee_id').val('');
            $('#f1-first-name').val('');
            $('#f1-designation').val('');
            $('#f1-department').val('');
            $('#f1-section').val('');
            $('#f1-phone').val('');
            $('#f1-email').val('');
            $('#f1-joindate').val('');
            $('#hidden_employee_id').val('');
            $('#eligibility_status').hide();
            $('#upcoming_meals_container').html('');
            $('#meal_off_history_container').html('');
            $('input[name="meal_off_date[]"]').prop('disabled', true);
            $('textarea[name="remarks[]"]').prop('disabled', true);
            $('#mealRowAdder').prop('disabled', true).css('opacity', '0.5').css('cursor', 'not-allowed');
            $('#btnSubmit').prop('disabled', true);
            $('#f1-phone').prop('readonly', true).css('background-color', '#f5f5f5');
            $('#f1-email').prop('readonly', true).css('background-color', '#f5f5f5');
            
            // Remove any extra rows added
            $('#newMealRow').html('');
            
            // Show success message with auto-dismiss
            setTimeout(function() {
                $('.alert-success').fadeOut('slow');
            }, 10000); // Auto dismiss after 10 seconds
        <?php else: ?>
            // If no successful requests, keep the form but reset the date fields
            $('input[name="meal_off_date[]"]').val('');
            $('textarea[name="remarks[]"]').val('');
            $('#newMealRow').html('');
        <?php endif; ?>
    <?php endif; ?>

    <?php if($meal_off_error): ?>
        // Auto dismiss error messages after 15 seconds
        setTimeout(function() {
            $('.alert-danger').fadeOut('slow');
        }, 15000);
    <?php endif; ?>
});
</script>

</body>
</html>