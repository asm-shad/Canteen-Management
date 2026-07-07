<?php
include('header.php');

// Get all meal off requests
$all_meal_off = $cls_meassage->getAllMealOffRequests($username);

// Get current month statistics
$current_month_stats = $cls_meassage->getCurrentMonthMealOffStatistics($username);

// Get current month name for display
$currentMonthName = date('F Y');
$currentMonth = date('Y-m');
$today = date('Y-m-d');
$currentTime = date('H:i:s');
$cutoffTime = '09:00:00'; // 9 AM cutoff

// Process all data and store in array for JavaScript
$all_data_json = [];
$all_stats = ['total' => 0, 'meal_off' => 0, 'meal_on' => 0, 'today_meal_off' => 0];
$current_stats = ['total' => 0, 'meal_off' => 0, 'meal_on' => 0];

if ($all_meal_off && $all_meal_off->num_rows > 0) {
    $all_meal_off->data_seek(0);
    while ($data = $all_meal_off->fetch_assoc()) {
        $mealOffDate = $data['meal_off_date'];
        $status = $data['status'];
        
        // Keep status as is from database
        // Default status should be 'Meal Off' when created
        // Only change to 'Meal On' when user toggles it
        
        $mealOffMonth = date('Y-m', strtotime($mealOffDate));
        
        // Check if request is clickable (only if Meal Off status and date is today or future, and time is before 9AM)
        $isClickable = false;
        if ($status === 'Meal Off') {
            if ($mealOffDate > $today) {
                $isClickable = true;
            } elseif ($mealOffDate === $today && $currentTime < $cutoffTime) {
                $isClickable = true;
            }
        }
        
        // Prepare data for JSON
        $row_data = [
            'employee_id' => $data['employee_id'],
            'employee_name' => $data['employee_name'],
            'designation' => $data['designation'],
            'department' => $data['department'],
            'employer_factory' => $data['employer_factory'],
            'meal_off_date' => $mealOffDate,
            'meal_off_date_display' => date('d-m-Y', strtotime($mealOffDate)),
            'request_date' => $data['request_date'],
            'request_date_display' => date('d-m-Y H:i', strtotime($data['request_date'])),
            'status' => $status,
            'remarks' => $data['remarks'],
            'meal_off_month' => $mealOffMonth,
            'is_clickable' => $isClickable,
            'id' => $data['id']
        ];
        
        $all_data_json[] = $row_data;
        
        // All stats
        $all_stats['total']++;
        if ($status === 'Meal Off') $all_stats['meal_off']++;
        elseif ($status === 'Meal On') $all_stats['meal_on']++;
        
        // Today's Meal Off count
        if ($mealOffDate === $today && $status === 'Meal Off') {
            $all_stats['today_meal_off']++;
        }
        
        // Current month stats
        if ($mealOffMonth === $currentMonth) {
            $current_stats['total']++;
            if ($status === 'Meal Off') $current_stats['meal_off']++;
            elseif ($status === 'Meal On') $current_stats['meal_on']++;
        }
    }
}
?>

<style>
    #mealOffTable {
        table-layout: fixed;
        width: 100%;
    }

    #mealOffTable th,
    #mealOffTable td {
        white-space: normal;
        word-break: break-word;
        vertical-align: top;
    }

    .filter-input {
        width: 100% !important;
        box-sizing: border-box;
        font-size: 11px;
        padding: 3px 5px;
        height: 26px;
        border: 1px solid #ddd;
        border-radius: 3px;
    }

    .daterangepicker {
        z-index: 99999 !important;
    }

    .daterangepicker td,
    .daterangepicker th {
        white-space: nowrap !important;
    }

    .export-btn {
        background: #28a745;
        border: none;
        color: white;
        padding: 6px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .export-btn:hover {
        background: #218838;
    }

    .toggle-btn {
        background: #6c757d;
        border: none;
        color: white;
        padding: 6px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s ease;
        min-width: 160px;
        justify-content: center;
    }

    .toggle-btn:hover {
        background: #5a6268;
    }

    .toggle-btn.active {
        background: #007bff;
    }

    .toggle-btn.active:hover {
        background: #0056b3;
    }

    .clear-filters-btn {
        background: #ffc107;
        border: none;
        color: #212529;
        padding: 6px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s ease;
    }

    .clear-filters-btn:hover {
        background: #e0a800;
        color: #212529;
    }

    .dataTables_wrapper .dataTables_filter {
        display: none;
    }

    .dataTables_wrapper .dataTables_length {
        float: left;
    }

    .badge-status {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        min-width: 60px;
    }
    
    .badge-status.clickable:hover {
        transform: scale(1.05);
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }

    .badge-meal-off {
        background: #dc3545; /* Reddish */
        color: white;
    }

    .badge-meal-on {
        background: #28a745; /* Greenish */
        color: white;
    }
    
    .badge-meal-off.clickable {
        cursor: pointer;
        animation: pulse-red 2s infinite;
    }
    
    @keyframes pulse-red {
        0% { opacity: 1; }
        50% { opacity: 0.7; }
        100% { opacity: 1; }
    }

    .badge-meal-off:not(.clickable) {
        cursor: not-allowed;
        opacity: 0.7;
    }

    .meal-off-summary {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        align-items: center;
        margin-bottom: 15px;
        padding: 10px 0;
    }

    .summary-item {
        background: #f8f9fa;
        padding: 8px 20px;
        border-radius: 4px;
        border-left: 3px solid #007bff;
        min-width: 120px;
    }

    .summary-item .label {
        font-size: 11px;
        color: #6c757d;
        display: block;
    }

    .summary-item .value {
        font-size: 22px;
        font-weight: bold;
        margin-top: 2px;
        display: block;
        text-align: center;
    }

    .summary-item .value.meal-off {
        color: #dc3545;
    }
    .summary-item .value.meal-on {
        color: #28a745;
    }
    .summary-item .value.total {
        color: #007bff;
    }
    .summary-item .value.today {
        color: #ffc107;
    }

    .export-wrapper {
        margin-left: auto;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .month-indicator {
        font-size: 14px;
        font-weight: 500;
        color: #495057;
        padding: 6px 15px;
        background: #e9ecef;
        border-radius: 4px;
        display: inline-block;
    }

    .month-indicator i {
        margin-right: 5px;
    }
    
    .dataTables_wrapper .dataTables_info {
        clear: both;
    }
    
    .dataTables_filter {
        display: none !important;
    }
    
    /* Modal styles */
    .modal-content {
        border-radius: 8px;
    }
    
    .modal-header {
        background: #f8f9fa;
        border-radius: 8px 8px 0 0;
        border-bottom: 2px solid #dee2e6;
    }
    
    .modal-header .modal-title {
        font-weight: 600;
    }
    
    .toggle-status-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        padding: 20px 0;
    }
    
    .toggle-label {
        font-size: 16px;
        font-weight: 500;
        padding: 8px 20px;
        border-radius: 20px;
        transition: all 0.3s ease;
        min-width: 100px;
        text-align: center;
    }
    
    .toggle-label.meal-off-label {
        background: #dc3545;
        color: white;
    }
    
    .toggle-label.meal-on-label {
        background: #28a745;
        color: white;
    }
    
    .toggle-switch {
        position: relative;
        width: 60px;
        height: 34px;
        background: #ccc;
        border-radius: 34px;
        cursor: pointer;
        transition: 0.3s;
        display: inline-block;
        box-shadow: inset 0 0 5px rgba(0,0,0,0.2);
    }
    
    .toggle-switch.active {
        background: #28a745;
    }
    
    .toggle-slider {
        position: absolute;
        top: 3px;
        left: 3px;
        width: 28px;
        height: 28px;
        background: white;
        border-radius: 50%;
        transition: 0.3s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    
    .toggle-switch.active .toggle-slider {
        left: 29px;
    }
    
    .status-text {
        font-size: 18px;
        font-weight: 600;
        margin-top: 10px;
        text-align: center;
    }
    
    .status-text.meal-off-text {
        color: #dc3545;
    }
    
    .status-text.meal-on-text {
        color: #28a745;
    }
    
    .modal-remarks {
        margin-top: 15px;
    }
    
    .modal-remarks textarea {
        resize: vertical;
        min-height: 80px;
        border-radius: 4px;
        border: 1px solid #ced4da;
        padding: 8px 12px;
        width: 100%;
        font-size: 14px;
    }
    
    .modal-remarks textarea:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
    }
    
    .modal-footer .btn {
        padding: 8px 25px;
        border-radius: 4px;
        font-weight: 500;
    }
    
    .modal-footer .btn-primary {
        background: #007bff;
        border: none;
    }
    
    .modal-footer .btn-primary:hover {
        background: #0056b3;
    }
    
    .modal-footer .btn-secondary {
        background: #6c757d;
        border: none;
    }
    
    .modal-footer .btn-secondary:hover {
        background: #5a6268;
    }
</style>

<div class="main-content">
    <div class="container-fluid">
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Meal Off Requests</h3>
                <p class="panel-subtitle" id="monthDisplay">
                    <span class="month-indicator">
                        <i class="fa fa-calendar"></i> Current Month: <?= $currentMonthName; ?>
                    </span>
                </p>
            </div>

            <div class="panel-body">
                <!-- Summary Statistics with Export Button -->
                <div class="meal-off-summary">
                    <div class="summary-item">
                        <span class="label">Total Requests</span>
                        <span class="value total" id="totalRequests">
                            <?= $current_stats['total']; ?>
                        </span>
                    </div>
                    <div class="summary-item">
                        <span class="label">Total Meal Off</span>
                        <span class="value meal-off" id="mealOffRequests">
                            <?= $current_stats['meal_off']; ?>
                        </span>
                    </div>
                    <div class="summary-item">
                        <span class="label">Today Meal Off</span>
                        <span class="value today" id="todayMealOff">
                            <?= $all_stats['today_meal_off']; ?>
                        </span>
                    </div>
                    
                    <div class="export-wrapper">
                        <button class="toggle-btn active" id="toggleView">
                            <i class="fa fa-filter"></i> <span id="toggleLabel">All Requests</span>
                        </button>
                        <button class="clear-filters-btn" id="clearFilters">
                            <i class="fa fa-eraser"></i> Clear Filters
                        </button>
                        <button class="export-btn" id="exportExcel">
                            <i class="fa fa-file-excel-o"></i> Export to Excel
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover text-center" id="mealOffTable" autocomplete="off">
                        <thead>
                            <tr>
                                <th style="width:50px">SL</th>
                                <th style="width:100px">Employee ID</th>
                                <th style="width:130px">Employee Name</th>
                                <th style="width:110px">Designation</th>
                                <th style="width:120px">Department</th>
                                <th style="width:120px">Factory</th>
                                <th style="width:100px">Meal Off Date</th>
                                <th style="width:110px">Request Date</th>
                                <th style="width:90px">Status</th>
                                <th style="width:150px">Remarks</th>
                            </tr>

                            <!-- FILTER ROW -->
                            <tr style="background:#f9f9f9">
                                <th></th>
                                <th><input type="text" class="filter-input" data-col="1" placeholder="Search Employee ID"></th>
                                <th><input type="text" class="filter-input" data-col="2" placeholder="Search Name"></th>
                                <th><input type="text" class="filter-input" data-col="3" placeholder="Search Designation"></th>
                                <th><input type="text" class="filter-input" data-col="4" placeholder="Search Department"></th>
                                <th><input type="text" class="filter-input" data-col="5" placeholder="Search Factory"></th>
                                <th>
                                    <input type="text" 
                                           id="meal_off_date_range" 
                                           class="filter-input" 
                                           placeholder="Meal Off Date Range" 
                                           readonly 
                                           data-col="6">
                                </th>
                                <th>
                                    <input type="text" 
                                           id="request_date_range" 
                                           class="filter-input" 
                                           placeholder="Request Date Range" 
                                           readonly 
                                           data-col="7">
                                </th>
                                <th>
                                    <select class="filter-input" id="status_filter" data-col="8">
                                        <option value="">All Status</option>
                                        <option value="Meal Off">Meal Off</option>
                                        <option value="Meal On">Meal On</option>
                                    </select>
                                </th>
                                <th><input type="text" class="filter-input" data-col="9" placeholder="Search Remarks"></th>
                            </tr>
                        </thead>

                        <tbody id="tableBody" style="font-size:12px;">
                            <!-- Data will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Status Update -->
<div class="modal fade" id="statusUpdateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-pencil-square-o"></i> Update Meal Status
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <h6>Employee: <span id="modalEmployeeName" class="font-weight-bold"></span></h6>
                    <p class="text-muted">Meal Off Date: <span id="modalMealOffDate"></span></p>
                </div>
                
                <div class="toggle-status-container">
                    <span class="toggle-label meal-off-label">Meal Off</span>
                    <div class="toggle-switch" id="toggleSwitch">
                        <div class="toggle-slider"></div>
                    </div>
                    <span class="toggle-label meal-on-label">Meal On</span>
                </div>
                
                <div class="status-text meal-off-text" id="statusDisplay">Current: Meal Off</div>
                
                <div class="modal-remarks">
                    <label for="modalRemarks">Remarks <span class="text-danger">*</span></label>
                    <textarea id="modalRemarks" class="form-control" placeholder="Enter remarks for status change..." required></textarea>
                    <small class="text-muted">Please provide reason for changing status</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveStatusUpdate">Update Status</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
$(document).ready(function() {
    // All data from PHP
    var allData = <?= json_encode($all_data_json); ?>;
    var currentMonth = '<?= date('Y-m'); ?>';
    var currentMonthName = '<?= $currentMonthName; ?>';
    var viewMode = 'current'; // 'current' or 'all'
    var currentRequestId = null;
    
    // Filter state
    var filters = {
        employee_id: '',
        employee_name: '',
        designation: '',
        department: '',
        employer_factory: '',
        meal_off_date_start: '',
        meal_off_date_end: '',
        request_date_start: '',
        request_date_end: '',
        status: '',
        remarks: ''
    };
    
    // Initialize DataTable
    var table = $('#mealOffTable').DataTable({
        dom: 'lrtip',
        ordering: false,
        paging: true,
        pageLength: 10,
        lengthChange: true,
        data: [],
        columns: [
            { data: 'sl' },
            { data: 'employee_id' },
            { data: 'employee_name' },
            { data: 'designation' },
            { data: 'department' },
            { data: 'employer_factory' },
            { data: 'meal_off_date_display' },
            { data: 'request_date_display' },
            { 
                data: null,
                render: function(data) {
                    var badgeClass = 'badge-meal-off';
                    var clickableClass = '';
                    var onClick = '';
                    
                    if (data.status === 'Meal On') {
                        badgeClass = 'badge-meal-on';
                        clickableClass = '';
                        onClick = '';
                    } else if (data.status === 'Meal Off') {
                        badgeClass = 'badge-meal-off';
                        if (data.is_clickable) {
                            clickableClass = 'clickable';
                            onClick = ' onclick="openStatusModal(' + data.id + ')"';
                        } else {
                            clickableClass = '';
                            onClick = '';
                        }
                    }
                    
                    return '<span class="badge-status ' + badgeClass + ' ' + clickableClass + '"' + onClick + '>' + data.status + '</span>';
                }
            },
            { data: 'remarks' }
        ],
        columnDefs: [
            { targets: [6, 7], visible: true }
        ],
        drawCallback: function() {
            // Update summary after each draw
            updateSummary();
        }
    });
    
    // Function to filter data
    function getFilteredData() {
        var filtered = allData.filter(function(item) {
            // Month filter
            if (viewMode === 'current' && item.meal_off_month !== currentMonth) {
                return false;
            }
            
            // Status filter
            if (filters.status !== '' && item.status !== filters.status) {
                return false;
            }
            
            // Text filters
            if (filters.employee_id !== '' && item.employee_id.toLowerCase().indexOf(filters.employee_id.toLowerCase()) === -1) {
                return false;
            }
            if (filters.employee_name !== '' && item.employee_name.toLowerCase().indexOf(filters.employee_name.toLowerCase()) === -1) {
                return false;
            }
            if (filters.designation !== '' && item.designation.toLowerCase().indexOf(filters.designation.toLowerCase()) === -1) {
                return false;
            }
            if (filters.department !== '' && item.department.toLowerCase().indexOf(filters.department.toLowerCase()) === -1) {
                return false;
            }
            if (filters.employer_factory !== '' && item.employer_factory.toLowerCase().indexOf(filters.employer_factory.toLowerCase()) === -1) {
                return false;
            }
            if (filters.remarks !== '' && item.remarks.toLowerCase().indexOf(filters.remarks.toLowerCase()) === -1) {
                return false;
            }
            
            // Meal off date range
            if (filters.meal_off_date_start !== '' && item.meal_off_date < filters.meal_off_date_start) {
                return false;
            }
            if (filters.meal_off_date_end !== '' && item.meal_off_date > filters.meal_off_date_end) {
                return false;
            }
            
            // Request date range
            if (filters.request_date_start !== '' && item.request_date < filters.request_date_start) {
                return false;
            }
            if (filters.request_date_end !== '' && item.request_date > filters.request_date_end) {
                return false;
            }
            
            return true;
        });
        
        // Add SL number
        return filtered.map(function(item, index) {
            return { ...item, sl: index + 1 };
        });
    }
    
    // Update table with filtered data
    function updateTable() {
        var filteredData = getFilteredData();
        
        // Clear and add new data
        table.clear();
        if (filteredData.length > 0) {
            table.rows.add(filteredData);
        }
        
        // Draw the table
        table.draw();
    }
    
    // Update summary statistics
    function updateSummary() {
        var filteredData = getFilteredData();
        var total = filteredData.length;
        var mealOff = 0;
        var todayMealOff = 0;
        var today = '<?= date('Y-m-d'); ?>';
        
        filteredData.forEach(function(item) {
            if (item.status === 'Meal Off') {
                mealOff++;
                if (item.meal_off_date === today) {
                    todayMealOff++;
                }
            }
        });
        
        $('#totalRequests').text(total);
        $('#mealOffRequests').text(mealOff);
        $('#todayMealOff').text(todayMealOff);
    }
    
    // Clear all filters
    function clearAllFilters() {
        // Reset filter values
        filters = {
            employee_id: '',
            employee_name: '',
            designation: '',
            department: '',
            employer_factory: '',
            meal_off_date_start: '',
            meal_off_date_end: '',
            request_date_start: '',
            request_date_end: '',
            status: '',
            remarks: ''
        };
        
        // Clear all filter input fields
        $('.filter-input[data-col]').each(function() {
            var colIndex = $(this).data('col');
            // Skip date columns (6 and 7) - they are handled separately
            if ([6, 7].indexOf(colIndex) === -1) {
                $(this).val('');
            }
        });
        
        // Clear status filter
        $('#status_filter').val('');
        
        // Clear date range inputs and reset daterangepicker
        $('#meal_off_date_range').val('');
        $('#request_date_range').val('');
        
        // Reset daterangepicker internal state
        $('#meal_off_date_range').data('daterangepicker').setStartDate(moment());
        $('#meal_off_date_range').data('daterangepicker').setEndDate(moment());
        $('#request_date_range').data('daterangepicker').setStartDate(moment());
        $('#request_date_range').data('daterangepicker').setEndDate(moment());
        
        // Update table
        updateTable();
    }
    
    // Toggle View
    $('#toggleView').on('click', function() {
        if (viewMode === 'current') {
            viewMode = 'all';
            $('#toggleLabel').text('Current Month');
            $('#toggleView').removeClass('active');
            $('#monthDisplay').html('<span class="month-indicator"><i class="fa fa-calendar"></i> All Meal Off Requests</span>');
        } else {
            viewMode = 'current';
            $('#toggleLabel').text('All Requests');
            $('#toggleView').addClass('active');
            $('#monthDisplay').html('<span class="month-indicator"><i class="fa fa-calendar"></i> Current Month: <?= $currentMonthName; ?></span>');
        }
        updateTable();
    });
    
    // Clear Filters button
    $('#clearFilters').on('click', function() {
        clearAllFilters();
    });
    
    // Text filters
    $('.filter-input[data-col]').each(function() {
        var colIndex = $(this).data('col');
        // Skip date columns (6 and 7)
        if ([6, 7].indexOf(colIndex) === -1) {
            $(this).on('keyup change', function() {
                var fieldMap = {
                    1: 'employee_id',
                    2: 'employee_name',
                    3: 'designation',
                    4: 'department',
                    5: 'employer_factory',
                    9: 'remarks'
                };
                var field = fieldMap[colIndex];
                if (field) {
                    filters[field] = $(this).val();
                    updateTable();
                }
            });
        }
    });
    
    // Status filter
    $('#status_filter').on('change', function() {
        filters.status = $(this).val();
        updateTable();
    });
    
    // Meal Off Date Range
    $('#meal_off_date_range').daterangepicker({
        autoUpdateInput: false,
        locale: {
            format: 'YYYY-MM-DD',
            cancelLabel: 'Clear'
        }
    });
    
    $('#meal_off_date_range').on('apply.daterangepicker', function(ev, picker) {
        filters.meal_off_date_start = picker.startDate.format('YYYY-MM-DD');
        filters.meal_off_date_end = picker.endDate.format('YYYY-MM-DD');
        $(this).val(filters.meal_off_date_start + ' - ' + filters.meal_off_date_end);
        updateTable();
    });
    
    $('#meal_off_date_range').on('cancel.daterangepicker', function() {
        filters.meal_off_date_start = '';
        filters.meal_off_date_end = '';
        $(this).val('');
        updateTable();
    });
    
    // Request Date Range
    $('#request_date_range').daterangepicker({
        autoUpdateInput: false,
        locale: {
            format: 'YYYY-MM-DD',
            cancelLabel: 'Clear'
        }
    });
    
    $('#request_date_range').on('apply.daterangepicker', function(ev, picker) {
        filters.request_date_start = picker.startDate.format('YYYY-MM-DD');
        filters.request_date_end = picker.endDate.format('YYYY-MM-DD');
        $(this).val(filters.request_date_start + ' - ' + filters.request_date_end);
        updateTable();
    });
    
    $('#request_date_range').on('cancel.daterangepicker', function() {
        filters.request_date_start = '';
        filters.request_date_end = '';
        $(this).val('');
        updateTable();
    });
    
    // Export to Excel
    $('#exportExcel').on('click', function() {
        var filteredData = getFilteredData();
        
        if (filteredData.length === 0) {
            alert('No data available for export.');
            return;
        }
        
        var headers = [
            'SL', 'Employee ID', 'Employee Name', 'Designation',
            'Department', 'Factory', 'Meal Off Date', 'Request Date',
            'Status', 'Remarks'
        ];
        
        var worksheetData = [headers];
        filteredData.forEach(function(item) {
            worksheetData.push([
                item.sl,
                item.employee_id,
                item.employee_name,
                item.designation,
                item.department,
                item.employer_factory,
                item.meal_off_date_display,
                item.request_date_display,
                item.status,
                item.remarks
            ]);
        });
        
        var wb = XLSX.utils.book_new();
        var ws = XLSX.utils.aoa_to_sheet(worksheetData);
        
        ws['!cols'] = [
            { wch: 6 }, { wch: 14 }, { wch: 20 }, { wch: 20 },
            { wch: 20 }, { wch: 18 }, { wch: 15 }, { wch: 20 },
            { wch: 12 }, { wch: 30 }
        ];
        
        XLSX.utils.book_append_sheet(wb, ws, 'Meal Off Requests');
        
        var viewModeText = viewMode === 'current' ? 'current_month' : 'all';
        var today = new Date();
        var dateStr = today.getFullYear() + '-' + 
                     String(today.getMonth() + 1).padStart(2, '0') + '-' + 
                     String(today.getDate()).padStart(2, '0');
        var filename = 'meal_off_requests_' + viewModeText + '_' + dateStr + '.xlsx';
        
        XLSX.writeFile(wb, filename);
    });
    
    // Fix for pagination - ensure DataTable properly handles pagination events
    // Remove any existing event handlers and reattach
    $(document).off('click', '.paginate_button');
    $(document).on('click', '.paginate_button', function() {
        // Small delay to ensure DataTable has updated
        setTimeout(function() {
            updateSummary();
        }, 100);
    });
    
    // Handle page length change
    $(document).off('change', '.dataTables_length select');
    $(document).on('change', '.dataTables_length select', function() {
        setTimeout(function() {
            updateSummary();
        }, 100);
    });
    
    // Toggle switch functionality
    var isMealOn = false;
    $('#toggleSwitch').on('click', function() {
        $(this).toggleClass('active');
        isMealOn = $(this).hasClass('active');
        
        if (isMealOn) {
            $('#statusDisplay').text('Current: Meal On').removeClass('meal-off-text').addClass('meal-on-text');
        } else {
            $('#statusDisplay').text('Current: Meal Off').removeClass('meal-on-text').addClass('meal-off-text');
        }
    });
    
    // Initial load
    updateTable();
});

// Global function to open status modal
function openStatusModal(requestId) {
    // Find the request data
    var request = null;
    var allData = <?= json_encode($all_data_json); ?>;
    
    for (var i = 0; i < allData.length; i++) {
        if (allData[i].id == requestId) {
            request = allData[i];
            break;
        }
    }
    
    if (!request) {
        alert('Request not found!');
        return;
    }
    
    // Set modal data
    currentRequestId = requestId;
    $('#modalEmployeeName').text(request.employee_name + ' (' + request.employee_id + ')');
    $('#modalMealOffDate').text(request.meal_off_date_display);
    $('#modalRemarks').val('');
    
    // Reset toggle to Meal Off (default)
    $('#toggleSwitch').removeClass('active');
    isMealOn = false;
    $('#statusDisplay').text('Current: Meal Off').removeClass('meal-on-text').addClass('meal-off-text');
    
    // Show modal
    $('#statusUpdateModal').modal('show');
}

// Save status update
$(document).on('click', '#saveStatusUpdate', function() {
    var remarks = $('#modalRemarks').val().trim();
    var newStatus = $('#toggleSwitch').hasClass('active') ? 'Meal On' : 'Meal Off';
    
    // Validate remarks
    if (remarks === '') {
        alert('Please enter remarks for the status change.');
        $('#modalRemarks').focus();
        return;
    }
    
    // Validate - if status is changing to Meal On, allow it
    // If status is already Meal On and user is trying to change to Meal Off, allow it
    // Only restrict if trying to change from Meal Off to Meal On and date/time condition not met
    var request = null;
    var allData = <?= json_encode($all_data_json); ?>;
    
    for (var i = 0; i < allData.length; i++) {
        if (allData[i].id == currentRequestId) {
            request = allData[i];
            break;
        }
    }
    
    if (request) {
        // If current status is Meal Off and trying to change to Meal On, check clickable condition
        if (request.status === 'Meal Off' && newStatus === 'Meal On') {
            if (!request.is_clickable) {
                alert('This request has expired and cannot be changed to Meal On.');
                return;
            }
        }
    }
    
    // Disable button to prevent double submission
    var $btn = $(this);
    $btn.prop('disabled', true).text('Updating...');
    
    // Send AJAX request to update status
    $.ajax({
        url: 'update_meal_status.php',
        type: 'POST',
        data: {
            request_id: currentRequestId,
            status: newStatus,
            remarks: remarks
        },
        dataType: 'json',
        success: function(response) {
            // Re-enable button
            $btn.prop('disabled', false).text('Update Status');
            
            if (response.success) {
                // Close modal
                $('#statusUpdateModal').modal('hide');
                
                // Reload the page to reflect changes (no alert popup)
                location.reload();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            // Re-enable button
            $btn.prop('disabled', false).text('Update Status');
            console.error('Error updating status:', error);
            alert('An error occurred while updating status. Please try again.');
        }
    });
});

// Handle modal close
$(document).on('hidden.bs.modal', '#statusUpdateModal', function() {
    $('#modalRemarks').val('');
    $('#toggleSwitch').removeClass('active');
    isMealOn = false;
    $('#statusDisplay').text('Current: Meal Off').removeClass('meal-on-text').addClass('meal-off-text');
    currentRequestId = null;
});
</script>

<?php include('footer.php'); ?>