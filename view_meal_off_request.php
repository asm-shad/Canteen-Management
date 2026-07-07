<?php
// Start output buffering
ob_start();

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

// Get the IDs from URL (comma-separated list)
$ids_string = isset($_GET['ids']) ? $_GET['ids'] : '';
$allRequestIds = array();

if(!empty($ids_string)) {
    // Explode the comma-separated string into an array
    $allRequestIds = array_map('intval', explode(',', $ids_string));
}

// If no IDs in URL, try to get from session (fallback)
if(empty($allRequestIds) && isset($_SESSION['meal_off_request_ids'])) {
    $allRequestIds = $_SESSION['meal_off_request_ids'];
    unset($_SESSION['meal_off_request_ids']);
}

// If still no IDs, check for single ID in URL
if(empty($allRequestIds)) {
    $request_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if($request_id > 0) {
        $allRequestIds[] = $request_id;
    }
}

// If no IDs found, redirect back
if(empty($allRequestIds)) {
    $_SESSION['meal_off_error'] = "No request found to display.";
    header('Location: meal_off_request.php');
    exit();
}

// Fetch ALL requests using the IDs
$allRequests = array();
if(!empty($allRequestIds)) {
    $idList = implode(',', $allRequestIds);
    $query = $connect->query("
        SELECT * FROM meal_off_requests 
        WHERE id IN ($idList)
        ORDER BY meal_off_date ASC
    ");
    if($query && $query->num_rows > 0) {
        while($row = $query->fetch_assoc()) {
            $allRequests[] = $row;
        }
    }
}

// If no requests found, redirect back
if(empty($allRequests)) {
    $_SESSION['meal_off_error'] = "Request not found.";
    header('Location: meal_off_request.php');
    exit();
}

// Check for session messages
$view_success = isset($_SESSION['meal_off_view_success']) ? $_SESSION['meal_off_view_success'] : false;
$view_message = isset($_SESSION['meal_off_view_message']) ? $_SESSION['meal_off_view_message'] : '';
$submitted_dates = isset($_SESSION['meal_off_submitted_dates']) ? $_SESSION['meal_off_submitted_dates'] : array();
$view_warning = isset($_SESSION['meal_off_view_warning']) ? $_SESSION['meal_off_view_warning'] : '';

// Clear session variables after reading
unset($_SESSION['meal_off_view_success']);
unset($_SESSION['meal_off_view_message']);
unset($_SESSION['meal_off_submitted_dates']);
unset($_SESSION['meal_off_view_warning']);
unset($_SESSION['meal_off_warning']);
unset($_SESSION['meal_off_existing_dates']);
unset($_SESSION['last_meal_off_id']);

// Get the first request for employee info
$firstRequest = $allRequests[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LDC Group - Meal Off Request View</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
    <link rel="shortcut icon" href="assets/ico/lizlogo.png">
    
    <style type="text/css">
        body{
            background-color: #ffffff;
            font-size: 12px;
            padding: 20px;
        }
        
        .container{
            padding: 20px;
            max-width: 800px;
        }
        
        .header-title {
            font-family: fantasy;
            font-size: 230%;
            padding: 1px 5px 2px 5px;
            margin: 0;
        }
        
        .sub-title {
            font-family: sans-serif;
            font-size: 136%;
            padding: 1px 5px 2px 5px;
            margin-top: -5px;
            color: #666;
        }
        
        .shawdow{
            border-collapse: collapse;
            width: 100%;
        }
        
        .shawdow td{
            padding: 8px;
            border: 1px solid #ddd;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .info-table td {
            padding: 5px 8px;
            border: 1px solid #ddd;
            vertical-align: middle;
        }
        
        .info-table .label-cell {
            background: #f5f5f5;
            font-weight: 600;
            width: 130px;
        }
        
        .info-table .value-cell {
            background: #f9f9f9;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: 600;
            padding: 8px 10px;
            background: #f5f5f5;
            border: 1px solid #ddd;
            border-bottom: none;
            margin: 0;
        }
        
        .status-badge {
            padding: 3px 12px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 11px;
            display: inline-block;
        }

        .status-meal-off {
            background: #dc3545; /* Red */
            color: white;
        }

        .status-meal-on {
            background: #28a745; /* Green */
            color: white;
        }

        .status-meal-off {
            background: #dc3545 !important;
            color: white !important;
        }

        .status-meal-on {
            background: #28a745 !important;
            color: white !important;
        }

        .status-active {
            background: #28a745 !important;
            color: white !important;
        }

        .status-completed {
            background: #17a2b8 !important;
            color: white !important;
        }

        .status-cancelled {
            background: #dc3545 !important;
            color: white !important;
        }
        
        .btn-custom {
            padding: 6px 25px;
            font-size: 12px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border: 1px solid #ddd;
            background: #f5f5f5;
            color: #333;
            transition: all 0.3s ease;
        }
        
        .btn-custom:hover {
            background: #e9ecef;
            text-decoration: none;
            color: #333;
        }
        
        .btn-print {
            background: #28a745;
            color: white;
            border-color: #28a745;
        }
        
        .btn-print:hover {
            background: #218838;
            color: white;
            border-color: #218838;
        }
        
        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 12px 15px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        
        .alert-warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 12px 15px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        
        .table-date-list {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table-date-list th {
            background: #f5f5f5;
            padding: 8px 10px;
            border: 1px solid #ddd;
            text-align: left;
            font-weight: 600;
        }
        
        .table-date-list td {
            padding: 8px 10px;
            border: 1px solid #ddd;
        }
        
        .table-date-list tr:nth-child(even) {
            background: #fafafa;
        }
        
        .no-print {
            display: block;
        }
        
        /* Print Styles */
        @media print {
            .no-print {
                display: none !important;
            }
            
            body {
                background: white !important;
                padding: 10px !important;
                margin: 0 !important;
                font-size: 11px !important;
            }
            
            .container {
                max-width: 100% !important;
                padding: 5px !important;
                margin: 0 !important;
                box-shadow: none !important;
            }
            
            .shawdow td {
                padding: 4px !important;
            }
            
            .info-table td {
                padding: 3px 6px !important;
                font-size: 11px !important;
            }
            
            .info-table .label-cell {
                width: 120px !important;
            }
            
            .section-title {
                font-size: 12px !important;
                padding: 5px 8px !important;
            }
            
            .header-title {
                font-size: 180% !important;
            }
            
            .sub-title {
                font-size: 110% !important;
            }
            
            .status-badge {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            .status-active {
                background: #28a745 !important;
                color: white !important;
            }
            
            .status-completed {
                background: #17a2b8 !important;
                color: white !important;
            }
            
            .status-cancelled {
                background: #dc3545 !important;
                color: white !important;
            }
            
            .alert-success {
                background: #d4edda !important;
                border: 1px solid #c3e6cb !important;
                color: #155724 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                padding: 8px 12px !important;
            }
            
            .alert-warning {
                background: #fff3cd !important;
                border: 1px solid #ffeaa7 !important;
                color: #856404 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                padding: 8px 12px !important;
            }
            
            .table-date-list th {
                background: #f5f5f5 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                font-size: 11px !important;
                padding: 5px 8px !important;
            }
            
            .table-date-list td {
                font-size: 11px !important;
                padding: 5px 8px !important;
            }
            
            .table-date-list tr:nth-child(even) {
                background: #fafafa !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>

<body>
<div class="container">
    <!-- Header -->
    <div style="text-align: center; border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 20px;">
        <h2 class="header-title">LDC Group</h2>
        <h4 class="sub-title">Meal Off Request Confirmation</h4>
    </div>
    
    <!-- Success Message -->
    <?php if($view_success): ?>
    <div class="alert-success">
        <strong><i class="fa fa-check-circle"></i> Success!</strong> <?php echo htmlspecialchars($view_message); ?>
        <?php if(!empty($submitted_dates)): ?>
            <br><small>Requested dates: <?php echo implode(', ', array_map('htmlspecialchars', $submitted_dates)); ?></small>
        <?php endif; ?>
        <?php if($view_warning): ?>
            <br><small class="text-warning"><i class="fa fa-warning"></i> <?php echo htmlspecialchars($view_warning); ?></small>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    
    <!-- Employee Information Section -->
    <table class="shawdow" style="margin-top: 10px;">
        <tr>
            <td style="padding: 0;">
                <div class="section-title">
                    <i class="fa fa-user"></i> Employee Information
                </div>
                <table class="info-table">
                    <tr>
                        <td class="label-cell">Employee ID</td>
                        <td class="value-cell"><strong><?php echo htmlspecialchars($firstRequest['employee_id']); ?></strong></td>
                        <td class="label-cell">Name</td>
                        <td class="value-cell"><strong><?php echo htmlspecialchars($firstRequest['employee_name']); ?></strong></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Designation</td>
                        <td class="value-cell"><?php echo htmlspecialchars($firstRequest['designation']); ?></td>
                        <td class="label-cell">Department</td>
                        <td class="value-cell"><?php echo htmlspecialchars($firstRequest['department']); ?></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Section</td>
                        <td class="value-cell"><?php echo htmlspecialchars($firstRequest['section']); ?></td>
                        <td class="label-cell">Contact Number</td>
                        <td class="value-cell"><?php echo htmlspecialchars($firstRequest['phone']); ?></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Email</td>
                        <td class="value-cell"><?php echo htmlspecialchars($firstRequest['email']); ?></td>
                        <td class="label-cell">Factory</td>
                        <td class="value-cell"><?php echo htmlspecialchars($firstRequest['employer_factory']); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <!-- Meal Off Details Section -->
    <table class="shawdow" style="margin-top: 20px;">
        <tr>
            <td style="padding: 0;">
                <div class="section-title">
                    <i class="fa fa-calendar"></i> Meal Off Details
                    <?php if(count($allRequests) > 1): ?>
                        <span style="font-size: 11px; font-weight: normal; color: #666; margin-left: 10px;">
                            (<?php echo count($allRequests); ?> dates requested)
                        </span>
                    <?php endif; ?>
                </div>
                
                <!-- Date List Table -->
                <table class="table-date-list" style="margin-top: 0;">
                    <thead>
                        <tr>
                            <th style="width:50px;">#</th>
                            <th>Meal Off Date</th>
                            <th style="width:120px;">Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>
                        <?php foreach($allRequests as $req): ?>
                        <tr>
                            <td style="text-align:center;"><?php echo $count++; ?></td>
                            <td><strong><?php echo date('d-m-Y', strtotime($req['meal_off_date'])); ?></strong></td>
                            <td>
                                <?php 
                                $status = $req['status'];
                                if($status == 'Meal Off') {
                                    $badge_class = 'status-meal-off';
                                } elseif($status == 'Meal On') {
                                    $badge_class = 'status-meal-on';
                                } else {
                                    $badge_class = 'status-' . strtolower($status);
                                }
                                ?>
                                <span class="status-badge <?php echo $badge_class; ?>">
                                    <?php echo htmlspecialchars($status); ?>
                                </span>
                            </td>
                            <td><?php echo nl2br(htmlspecialchars($req['remarks'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <!-- Additional Info -->
                <table class="info-table" style="margin-top: 5px; border-top: 1px solid #ddd;">
                    <tr>
                        <td class="label-cell" style="width:130px;">Request Date</td>
                        <td class="value-cell"><?php echo date('d-m-Y h:i A', strtotime($firstRequest['request_date'])); ?></td>
                        <?php if(!empty($firstRequest['allotted_seat'])): ?>
                        <td class="label-cell" style="width:130px;">Allotted Seat</td>
                        <td class="value-cell"><?php echo htmlspecialchars($firstRequest['allotted_seat']); ?></td>
                        <?php else: ?>
                        <td class="label-cell" style="width:130px;"></td>
                        <td class="value-cell"></td>
                        <?php endif; ?>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <!-- Action Buttons (Hidden in Print) -->
    <div style="margin-top: 25px; text-align: center; padding-top: 15px; border-top: 1px solid #ddd;" class="no-print">
        <a href="meal_off_request.php" class="btn-custom" style="margin-right: 10px;">
            <i class="fa fa-arrow-left"></i> Back to Request
        </a>
        <button onclick="window.print()" class="btn-custom btn-print">
            <i class="fa fa-print"></i> Print
        </button>
    </div>
    
    <!-- Footer -->
    <div style="margin-top: 15px; padding-top: 10px; border-top: 1px solid #eee;">
        <p style="color: #999; font-size: 10px; text-align: center; margin: 0;">
            <i class="fa fa-info-circle"></i> This is a system generated confirmation. 
            <span class="no-print">Generated on: <?php echo date('d-m-Y h:i A'); ?></span>
        </p>
    </div>
</div>

<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
<?php
ob_end_flush();
?>