<?php
require_once('admin/cls_dbconfig.php');
require_once('admin/cls_meassage.class.php');

$cls_meassage = new cls_meassage();
$search_employee_id = '';

if (isset($_GET['employee_id'])) {
    $search_employee_id = trim($_GET['employee_id']);
}

// Always fetch all data, then filter in PHP
$all_application = $cls_meassage->all_employee_position();
?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LDC Group - Employee Positions</title>

    <style>
        #canteenTable {
            table-layout: fixed;
            width: 100%;
            font-size: 12px;
        }

        #canteenTable th,
        #canteenTable td {
            white-space: normal;
            word-break: break-word;
            vertical-align: top;
        }

        .panel.panel-headline .panel-heading .panel-title {
            font-size: 22px;
            font-weight: 400;
            color: gray;
            text-align: center;
            margin-top: 4px;
        }

        .employee-info-box {
            background: #e8f5e9;
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #4CAF50;
        }
        
        .no-data-message {
            text-align: center;
            padding: 30px;
            background: #f9f9f9;
            border-radius: 5px;
            margin-top: 20px;
        }
        
        .debug-info {
            background: #f0f0f0;
            padding: 10px;
            margin-top: 10px;
            font-size: 12px;
            display: none;
        }
        
        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeeba;
            color: #856404;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap.min.css">
</head>

<body>

    <div class="main-content">
        <div class="container-fluid">

            <div class="panel panel-headline">

                <div class="panel-heading" style="margin-bottom: 0px;">
                    <h3 class="panel-title">Employee Positions</h3>
                </div>

                <!-- Search Form -->
                <div class="row" style="margin-bottom:15px;">
                    <div class="col-md-4">
                        <form method="GET" id="searchForm" onsubmit="return validateForm()">
                            <label><strong>Employee ID Search</strong></label>
                            <div class="input-group">
                                <input type="text" name="employee_id" class="form-control" 
                                       placeholder="Enter Employee ID (e.g., LH1123, 1001)" 
                                       value="<?= htmlspecialchars($search_employee_id); ?>"
                                       id="employee_id_input">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>

                <?php
                // Fetch all data first
                $all_rows = [];
                $found_employee = false;
                $employee_data = null;
                $debug_info = [];

                if ($all_application) {
                    // Load all rows into array
                    while ($data = $all_application->fetch_assoc()) {
                        $all_rows[] = $data;
                        $debug_info[] = $data['employee_id']; // Store all IDs for debugging
                    }
                    
                    // Debug: Check if we have data
                    $total_records = count($all_rows);
                    
                    if ($search_employee_id != '') {
                        // Calculate position for all Requested employees in each canteen
                        $canteen_employees = [];
                        
                        foreach ($all_rows as $row) {
                            $canteen = $row['category'];
                            $status = $row['status'];
                            
                            if ($status == 'Requested') {
                                if (!isset($canteen_employees[$canteen])) {
                                    $canteen_employees[$canteen] = [];
                                }
                                $canteen_employees[$canteen][] = $row;
                            }
                        }
                        
                        // Sort employees within each canteen by total_point
                        foreach ($canteen_employees as $canteen => &$employees) {
                            usort($employees, function($a, $b) {
                                if ($b['total_point'] != $a['total_point']) {
                                    return $b['total_point'] <=> $a['total_point'];
                                }
                                return $b['priority_point'] <=> $a['priority_point'];
                            });
                        }
                        
                        // Create position mapping
                        $position_map = [];
                        foreach ($canteen_employees as $canteen => $employees) {
                            foreach ($employees as $index => $employee) {
                                $position_map[$employee['employee_id']] = $index + 1;
                            }
                        }
                        
                        // Search for the employee (case-insensitive and trim)
                        foreach ($all_rows as $data) {
                            // Case-insensitive comparison
                            if (strcasecmp(trim($data['employee_id']), trim($search_employee_id)) == 0) {
                                $found_employee = true;
                                $employee_data = $data;
                                
                                // Get position
                                $position = '-';
                                if ($data['status'] == 'Requested' && isset($position_map[$data['employee_id']])) {
                                    $position = $position_map[$data['employee_id']];
                                }
                                break;
                            }
                        }
                        
                        // Show warning if not found
                        if (!$found_employee) {
                            // Check if employee ID exists but with different case or spacing
                            $similar_ids = [];
                            foreach ($all_rows as $row) {
                                if (stripos($row['employee_id'], $search_employee_id) !== false) {
                                    $similar_ids[] = $row['employee_id'];
                                }
                            }
                            
                        }
                    }
                }
                ?>

               

                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover text-center" id="canteenTable">
                            <thead>
                                <tr>
                                    <th style="width:70px">Position</th>
                                    <th style="width:80px">Employee ID</th>
                                    <th style="width:120px">Name</th>
                                    <th style="width:110px">Designation</th>
                                    <th style="width:100px">Mobile</th>
                                    <th style="width:95px">Joining Date</th>
                                    <th style="width:120px">Department</th>
                                    <th style="width:120px">Factory</th>
                                    <th style="width:95px">Application Date</th>
                                    <th style="width:90px">Status</th>
                                    <th style="width:75px">Canteen Name</th>
                                    <th style="width:90px">Allotted Seat</th>
                                    <th style="width:95px">Living Status</th>
                                    <!-- <th style="width:120px">Status Changing Date</th>
                                    <th style="width:80px">Total Point</th>
                                    <th style="width:90px">Distance</th> -->
                                </tr>
                            </thead>
                            <tbody style="font-size:12px;">
                                <?php if ($found_employee && $employee_data): 
                                    // Recalculate position for the found employee
                                    $canteen_employees = [];
                                    foreach ($all_rows as $row) {
                                        $canteen = $row['category'];
                                        $status = $row['status'];
                                        if ($status == 'Requested') {
                                            if (!isset($canteen_employees[$canteen])) {
                                                $canteen_employees[$canteen] = [];
                                            }
                                            $canteen_employees[$canteen][] = $row;
                                        }
                                    }
                                    
                                    foreach ($canteen_employees as $canteen => &$emps) {
                                        usort($emps, function($a, $b) {
                                            if ($b['total_point'] != $a['total_point']) {
                                                return $b['total_point'] <=> $a['total_point'];
                                            }
                                            return $b['priority_point'] <=> $a['priority_point'];
                                        });
                                    }
                                    
                                    $position_map = [];
                                    foreach ($canteen_employees as $canteen => $emps) {
                                        foreach ($emps as $index => $emp) {
                                            $position_map[$emp['employee_id']] = $index + 1;
                                        }
                                    }
                                    
                                    $position = '-';
                                    if ($employee_data['status'] == 'Requested' && isset($position_map[$employee_data['employee_id']])) {
                                        $position = $position_map[$employee_data['employee_id']];
                                    }
                                    
                                    $status = $employee_data['status'];
                                    $color = 'black';
                                    
                                    if ($status == 'Accepted') $color = 'green';
                                    elseif ($status == 'Requested') $color = 'orange';
                                    elseif ($status == 'Transfer') $color = 'blue';
                                    elseif ($status == 'Not Accepted') $color = 'red';
                                ?>
                                    <tr>
                                        <td class="position-column">
                                            <?php if ($position != '-'): ?>
                                                <strong style="color: #4CAF50; font-size: 14px;"><?= $position ?></strong>
                                            <?php else: ?>
                                                <?= $position ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($employee_data['employee_id']); ?></td>
                                        <td><?= htmlspecialchars($employee_data['name']); ?></td>
                                        <td><?= htmlspecialchars($employee_data['designations']); ?></td>
                                        <td><?= htmlspecialchars($employee_data['mobile']); ?></td>
                                        <td><?= htmlspecialchars($employee_data['joining_date']); ?></td>
                                        <td><?= htmlspecialchars($employee_data['section_or_department']); ?></td>
                                        <td><?= htmlspecialchars($employee_data['employer_factory']); ?></td>
                                        <td><?= htmlspecialchars($employee_data['application_date']); ?></td>
                                        <td>
                                            <span style="color:<?= $color ?>; font-weight:bold;">
                                                <?= $status ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($employee_data['category']); ?></td>
                                        <td><?= htmlspecialchars($employee_data['allotted_seat']); ?></td>
                                        <td><?= htmlspecialchars($employee_data['living_status']); ?></td>
                                        <!-- <td><?= htmlspecialchars($employee_data['status_changes_date']); ?></td>
                                        <td><strong><?= round($employee_data['total_point'], 2); ?></strong></td>
                                        <td><?= htmlspecialchars($employee_data['location_distance']); ?></td> -->
                                    </tr>
                                <?php elseif ($search_employee_id != '' && !$found_employee): ?>
                                    <tr>
                                        <td colspan="16" class="text-center text-danger">
                                            <strong>No records found for Employee ID: <?= htmlspecialchars($search_employee_id) ?></strong>
                                            <br>
                                            <small>Please check the spelling or try a different Employee ID.</small>
                                        </td>
                                    </tr>
                                <?php elseif ($search_employee_id == ''): ?>
                                    <tr>
                                        <td colspan="16" class="text-center text-muted">
                                            <i class="fa fa-search"></i> Please enter an Employee ID to search
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Debug Section (Hidden by default, can be enabled for troubleshooting) -->
                <?php if (isset($_GET['debug']) && $_GET['debug'] == 1): ?>
                <div class="debug-info" style="display:block;">
                    <strong>Debug Information:</strong><br>
                    Total Records in Database: <?= count($all_rows) ?><br>
                    <?php if (!empty($debug_info)): ?>
                    Available Employee IDs: <?= implode(', ', array_slice(array_unique($debug_info), 0, 20)) ?>
                    <?php if (count(array_unique($debug_info)) > 20) echo '...'; ?>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="assets/js/jquery-1.11.1.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            var hasData = $('#canteenTable tbody tr').length > 0;
            var hasNoDataMessage = $('#canteenTable tbody tr td[colspan="16"]').length > 0;
            
            if (hasData && !hasNoDataMessage) {
                try {
                    if ($.fn.DataTable.isDataTable('#canteenTable')) {
                        $('#canteenTable').DataTable().destroy();
                    }
                    
                    $('#canteenTable').DataTable({
                        dom: 'lrtip',
                        ordering: false,
                        paging: false,
                        lengthChange: false,
                        info: false,
                        retrieve: true,
                        destroy: true
                    });
                    
                } catch(e) {
                    console.error('DataTable initialization error:', e);
                }
            }
        });
        
        function validateForm() {
            var employeeId = document.getElementById('employee_id_input').value.trim();
            if (employeeId === '') {
                alert('Please enter an Employee ID to search');
                return false;
            }
            return true;
        }
    </script>
</body>

</html>