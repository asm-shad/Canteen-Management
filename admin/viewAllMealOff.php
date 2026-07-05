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

// Process all data and store in array for JavaScript
$all_data_json = [];
$all_stats = ['total' => 0, 'active' => 0, 'completed' => 0];
$current_stats = ['total' => 0, 'active' => 0, 'completed' => 0];

if ($all_meal_off && $all_meal_off->num_rows > 0) {
    $all_meal_off->data_seek(0);
    while ($data = $all_meal_off->fetch_assoc()) {
        $mealOffDate = $data['meal_off_date'];
        $status = $data['status'];
        
        // Update status if passed - mark as Completed
        if ($status === 'Active' && $mealOffDate < $today) {
            $status = 'Completed';
        }
        // Convert any 'Used' or 'Passed' to 'Completed'
        if ($status === 'Used' || $status === 'Passed') {
            $status = 'Completed';
        }
        
        $mealOffMonth = date('Y-m', strtotime($mealOffDate));
        
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
            'meal_off_month' => $mealOffMonth
        ];
        
        $all_data_json[] = $row_data;
        
        // All stats
        $all_stats['total']++;
        if ($status === 'Active') $all_stats['active']++;
        elseif ($status === 'Completed') $all_stats['completed']++;
        
        // Current month stats
        if ($mealOffMonth === $currentMonth) {
            $current_stats['total']++;
            if ($status === 'Active') $current_stats['active']++;
            elseif ($status === 'Completed') $current_stats['completed']++;
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
    }

    .badge-active {
        background: #28a745;
        color: white;
    }

    .badge-completed {
        background: #17a2b8;
        color: white;
    }

    .badge-cancelled {
        background: #dc3545;
        color: white;
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

    .summary-item .value.active {
        color: #28a745;
    }
    .summary-item .value.completed {
        color: #17a2b8;
    }
    .summary-item .value.total {
        color: #007bff;
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
                        <span class="label">Active</span>
                        <span class="value active" id="activeRequests">
                            <?= $current_stats['active']; ?>
                        </span>
                    </div>
                    <div class="summary-item">
                        <span class="label">Completed</span>
                        <span class="value completed" id="completedRequests">
                            <?= $current_stats['completed']; ?>
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
                                        <option value="Active">Active</option>
                                        <option value="Completed">Completed</option>
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
                data: 'status',
                render: function(data) {
                    var badgeClass = 'badge-active';
                    if (data === 'Completed') badgeClass = 'badge-completed';
                    else if (data === 'Cancelled') badgeClass = 'badge-cancelled';
                    return '<span class="badge-status ' + badgeClass + '">' + data + '</span>';
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
        var active = 0;
        var completed = 0;
        
        filteredData.forEach(function(item) {
            if (item.status === 'Active') active++;
            else if (item.status === 'Completed') completed++;
        });
        
        $('#totalRequests').text(total);
        $('#activeRequests').text(active);
        $('#completedRequests').text(completed);
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
    
    // Initial load
    updateTable();
});
</script>

<?php include('footer.php'); ?>