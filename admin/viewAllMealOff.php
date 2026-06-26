<?php
include('header.php');

// Get all meal off requests
$all_meal_off = $cls_meassage->getAllMealOffRequests($username);

// Get current month statistics
$current_month_stats = $cls_meassage->getCurrentMonthMealOffStatistics($username);
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

    .dataTables_wrapper .dataTables_filter {
        display: none;
    }

    .dataTables_wrapper .dataTables_length {
        float: left;
    }

    .table-controls {
        margin-bottom: 15px;
        text-align: right;
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

    .badge-used {
        background: #6c757d;
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
    .summary-item .value.used {
        color: #6c757d;
    }
    .summary-item .value.total {
        color: #007bff;
    }

    .export-wrapper {
        margin-left: auto;
        display: flex;
        align-items: center;
    }

    .summary-label {
        font-size: 13px;
        color: #495057;
        margin-bottom: 5px;
        font-weight: 500;
    }

    /* DataTables override for export button alignment */
    .dataTables_wrapper .dataTables_length {
        float: left;
        padding-top: 8px;
    }
    
    .dataTables_wrapper .dataTables_info {
        clear: both;
    }
</style>

<div class="main-content">
    <div class="container-fluid">
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Meal Off Requests</h3>
                <p class="panel-subtitle">Current Month: <?= date('F Y'); ?></p>
            </div>

            <div class="panel-body">
                <!-- Summary Statistics with Export Button -->
                <div class="meal-off-summary">
                    <div class="summary-item">
                        <span class="label">Total Requests</span>
                        <span class="value total" id="totalRequests">
                            <?= $current_month_stats['total'] ?? 0; ?>
                        </span>
                    </div>
                    <div class="summary-item">
                        <span class="label">Active</span>
                        <span class="value active" id="activeRequests">
                            <?= $current_month_stats['active'] ?? 0; ?>
                        </span>
                    </div>
                    <div class="summary-item">
                        <span class="label">Used</span>
                        <span class="value used" id="usedRequests">
                            <?= $current_month_stats['used'] ?? 0; ?>
                        </span>
                    </div>
                    
                    <div class="export-wrapper">
                        <button class="export-btn" id="exportExcel">
                            <i class="fa fa-file-excel-o"></i> Export to Excel
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover text-center" id="mealOffTable" autocomplete="off">
                        <thead>
                            <!-- COLUMN HEADERS -->
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
                                <th><input type="text" class="filter-input" data-col="1" placeholder="Search"></th>
                                <th><input type="text" class="filter-input" data-col="2" placeholder="Search"></th>
                                <th><input type="text" class="filter-input" data-col="3" placeholder="Search"></th>
                                <th><input type="text" class="filter-input" data-col="4" placeholder="Search"></th>
                                <th><input type="text" class="filter-input" data-col="5" placeholder="Search"></th>
                                <th>
                                    <input type="text" 
                                           id="meal_off_date_range" 
                                           class="filter-input" 
                                           placeholder="Date Range" 
                                           readonly 
                                           data-col="6">
                                </th>
                                <th>
                                    <input type="text" 
                                           id="request_date_range" 
                                           class="filter-input" 
                                           placeholder="Date Range" 
                                           readonly 
                                           data-col="7">
                                </th>
                                <th>
                                    <select class="filter-input" id="status_filter" data-col="8">
                                        <option value="">All</option>
                                        <option value="Active">Active</option>
                                        <option value="Used">Used</option>
                                    </select>
                                </th>
                                <th><input type="text" class="filter-input" data-col="9" placeholder="Search"></th>
                            </tr>
                        </thead>

                        <tbody style="font-size:12px;">
                            <?php 
                            $i = 1; 
                            if ($all_meal_off && $all_meal_off->num_rows > 0) {
                                while ($data = $all_meal_off->fetch_assoc()) { 
                                    $status = $data['status'];
                                    $badgeClass = 'badge-active';
                                    if ($status === 'Used') {
                                        $badgeClass = 'badge-used';
                                    } elseif ($status === 'Cancelled') {
                                        $badgeClass = 'badge-cancelled';
                                    }
                            ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= htmlspecialchars($data['employee_id']); ?></td>
                                    <td><?= htmlspecialchars($data['employee_name']); ?></td>
                                    <td><?= htmlspecialchars($data['designation']); ?></td>
                                    <td><?= htmlspecialchars($data['department']); ?></td>
                                    <td><?= htmlspecialchars($data['employer_factory']); ?></td>
                                    <td><?= date('d-m-Y', strtotime($data['meal_off_date'])); ?></td>
                                    <td><?= date('d-m-Y H:i', strtotime($data['request_date'])); ?></td>
                                    <td>
                                        <span class="badge-status <?= $badgeClass; ?>">
                                            <?= $status; ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($data['remarks']); ?></td>
                                </tr>
                            <?php 
                                }
                            } else { 
                            ?>
                                <tr>
                                    <td colspan="10" class="text-center">No meal off requests found</td>
                                </tr>
                            <?php } ?>
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
        // Date range variables
        var mealOffStart = '';
        var mealOffEnd = '';
        var requestStart = '';
        var requestEnd = '';

        // Custom filtering function for DataTable
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            // Meal Off Date Range (Column 6)
            if (mealOffStart && mealOffEnd && data[6]) {
                var rowDate = moment(data[6], 'DD-MM-YYYY');
                if (rowDate.isValid() && (rowDate.isBefore(moment(mealOffStart)) || rowDate.isAfter(moment(mealOffEnd)))) {
                    return false;
                }
            }

            // Request Date Range (Column 7)
            if (requestStart && requestEnd && data[7]) {
                var rowDate = moment(data[7], 'DD-MM-YYYY HH:mm');
                if (rowDate.isValid() && (rowDate.isBefore(moment(requestStart)) || rowDate.isAfter(moment(requestEnd)))) {
                    return false;
                }
            }

            return true;
        });

        var table = $('#mealOffTable').DataTable({
            dom: 'lrtip',
            ordering: false,
            paging: true,
            pageLength: 10,
            lengthChange: true,
            drawCallback: function() {
                updateSummary();
            }
        });

        // Status filter
        $('#status_filter').on('change', function() {
            table.column(8).search(this.value).draw();
        });

        // Normal filters (text inputs)
        $('#mealOffTable thead tr:eq(1) th input[type="text"]').each(function() {
            var colIndex = $(this).data('col');
            if (colIndex !== undefined && [6, 7].indexOf(colIndex) === -1) {
                $(this).on('keyup change', function() {
                    table.column(colIndex).search(this.value).draw();
                });
            }
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
            mealOffStart = picker.startDate.format('YYYY-MM-DD');
            mealOffEnd = picker.endDate.format('YYYY-MM-DD');
            $(this).val(mealOffStart + ' - ' + mealOffEnd);
            table.draw();
        });

        $('#meal_off_date_range').on('cancel.daterangepicker', function() {
            mealOffStart = '';
            mealOffEnd = '';
            $(this).val('');
            table.draw();
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
            requestStart = picker.startDate.format('YYYY-MM-DD');
            requestEnd = picker.endDate.format('YYYY-MM-DD');
            $(this).val(requestStart + ' - ' + requestEnd);
            table.draw();
        });

        $('#request_date_range').on('cancel.daterangepicker', function() {
            requestStart = '';
            requestEnd = '';
            $(this).val('');
            table.draw();
        });

        // Update summary based on visible rows (filtered data)
        function updateSummary() {
            var total = 0;
            var active = 0;
            var used = 0;

            $('#mealOffTable tbody tr:visible').each(function() {
                total++;
                var statusCell = $(this).find('td:eq(8)');
                var statusText = statusCell.find('span').text().trim() || statusCell.text().trim();
                
                if (statusText === 'Active') {
                    active++;
                } else if (statusText === 'Used') {
                    used++;
                }
            });

            $('#totalRequests').text(total);
            $('#activeRequests').text(active);
            $('#usedRequests').text(used);
        }

        // Single Export Function - Exports ALL visible data (filtered or unfiltered)
        $('#exportExcel').on('click', function() {
            // Store current pagination settings
            var currentPage = table.page();
            var currentLength = table.page.len();

            // Show all records temporarily
            table.page.len(-1).draw();

            setTimeout(function() {
                var filteredData = [];
                
                // Get ALL visible rows (respects current filters)
                var rows = $('#mealOffTable tbody tr:visible');

                if (rows.length === 0) {
                    alert('No data available for export.');
                    table.page.len(currentLength).page(currentPage).draw();
                    return;
                }

                rows.each(function() {
                    var rowData = [];
                    $(this).find('td').each(function(index) {
                        var text = $(this).text().trim();
                        // For status column, get the text without extra spaces
                        if (index === 8) {
                            text = $(this).find('span').text().trim() || text;
                        }
                        rowData.push(text);
                    });
                    if (rowData.length > 0) {
                        filteredData.push(rowData);
                    }
                });

                // Headers
                var headers = [
                    'SL', 'Employee ID', 'Employee Name', 'Designation',
                    'Department', 'Factory', 'Meal Off Date', 'Request Date',
                    'Status', 'Remarks'
                ];

                var worksheetData = [headers];
                filteredData.forEach(function(row, index) {
                    row[0] = index + 1;
                    worksheetData.push(row);
                });

                // Create workbook
                var wb = XLSX.utils.book_new();
                var ws = XLSX.utils.aoa_to_sheet(worksheetData);

                // Set column widths
                ws['!cols'] = [
                    { wch: 6 }, { wch: 14 }, { wch: 20 }, { wch: 20 },
                    { wch: 20 }, { wch: 18 }, { wch: 15 }, { wch: 20 },
                    { wch: 12 }, { wch: 30 }
                ];

                XLSX.utils.book_append_sheet(wb, ws, 'Meal Off Requests');

                // Generate filename
                var today = new Date();
                var dateStr = today.getFullYear() + '-' + 
                             String(today.getMonth() + 1).padStart(2, '0') + '-' + 
                             String(today.getDate()).padStart(2, '0');
                var filename = 'meal_off_requests_' + dateStr + '.xlsx';

                // Download
                XLSX.writeFile(wb, filename);

                // Restore pagination
                table.page.len(currentLength).page(currentPage).draw();
            }, 100);
        });

        // Initial summary update
        setTimeout(function() {
            updateSummary();
        }, 500);
    });
</script>

<?php include('footer.php'); ?>