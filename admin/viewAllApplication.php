<?php
include('header.php');
$all_application = $cls_meassage->getAllApplications($username);
?>

<style>
    #canteenTable {
        table-layout: fixed;
        width: 100%;
    }

    #canteenTable th,
    #canteenTable td {
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
        padding: 6px 15px;
        border-radius: 4px;
        margin-left: 10px;
        cursor: pointer;
        font-size: 13px;
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
</style>

<div class="main-content">
    <div class="container-fluid">
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Canteen Application Information</h3>
            </div>

            <div class="panel-body">
                <div class="table-responsive">

                    <table class="table table-striped table-bordered table-hover text-center" id="canteenTable" autocomplete="off">
                        <thead>
                            <!-- COLUMN HEADERS (WIDTH CONTROLS HERE) -->
                            <tr>
                                <th style="width:90px">Employee ID</th>
                                <th style="width:120px">Name</th>
                                <th style="width:110px">Designation</th>
                                <th style="width:100px">Mobile</th>
                                <th style="width:95px">Joining Date</th>
                                <th style="width:120px">Department</th>
                                <th style="width:120px">Factory</th>
                                <th style="width:95px">Application Date</th>
                                <th style="width:90px">Status</th>
                                <th style="width:75px">Category</th>
                                <th style="width:90px">Allotted Seat</th>
                                <th style="width:95px">Living Status</th>
                                <th style="width:120px">Status Changing Date</th>
                                <th style="width:80px">Priority</th>
                                <th style="width:80px">Total</th>
                                <th style="width:90px">Distance</th>
                            </tr>

                            <!-- FILTER ROW -->
                            <tr style="background:#f9f9f9">                              
                                <th><input type="text" class="filter-input" data-col="0"></th>
                                <th><input type="text" class="filter-input" data-col="1"></th>
                                <th><input type="text" class="filter-input" data-col="2"></th>
                                <th><input type="text" class="filter-input" data-col="3"></th>
                                <th>
                                    <input type="text"
                                        id="joining_date_range"
                                        class="filter-input"
                                        placeholder="Date Range"
                                        readonly
                                        data-col="4">
                                </th>
                                <th><input type="text" class="filter-input" data-col="5"></th>
                                <th><input type="text" class="filter-input" data-col="6"></th>
                                <th>
                                    <input type="text"
                                        id="application_date_range"
                                        class="filter-input"
                                        placeholder="Date Range"
                                        readonly
                                        data-col="7">
                                </th>
                                <th>
                                    <select class="filter-input" id="status_filter" data-col="8">
                                        <option value="">All</option>
                                        <option value="Accepted">Accepted</option>
                                        <option value="Requested">Requested</option>
                                        <option value="Transfer">Transfer</option>
                                        <option value="Not Accepted">Not Accepted</option>
                                    </select>
                                </th>

                                <th>
                                    <select class="filter-input" id="category_filter" data-col="9">
                                        <option value="">All</option>
                                        <option value="VIP">VIP</option>
                                        <option value="General">General</option>
                                    </select>
                                </th>
                                <th><input type="text" class="filter-input" data-col="10"></th>
                                <th><input type="text" class="filter-input" data-col="11"></th>
                                <th>
                                    <input type="text"
                                        id="status_date_range"
                                        class="filter-input"
                                        placeholder="Date Range"
                                        readonly
                                        data-col="12">
                                </th>

                                <th>
                                    <select class="filter-input" id="priority_filter" data-col="13">
                                        <option value="">All</option>
                                        <option value="Priority-1">Priority-1</option>
                                        <option value="Priority-2">Priority-2</option>
                                        <option value="Priority-3">Priority-3</option>
                                    </select>
                                </th>

                                <th><input type="text" class="filter-input" data-col="14"></th>
                                <th><input type="text" class="filter-input" data-col="15"></th>
                            </tr>
                        </thead>

                        <tbody style="font-size:12px;">
                            <?php $i = 1;
                            while ($data = $all_application->fetch_assoc()) { ?>
                                <tr>
                                    
                                    <td><?= htmlspecialchars($data['employee_id']); ?></td>
                                    <td><?= htmlspecialchars($data['name']); ?></td>
                                    <td><?= htmlspecialchars($data['designations']); ?></td>
                                    <td><?= htmlspecialchars($data['mobile']); ?></td>
                                    <td><?= $data['joining_date']; ?></td>
                                    <td><?= htmlspecialchars($data['section_or_department']); ?></td>
                                    <td><?= htmlspecialchars($data['employer_factory']); ?></td>
                                    <td><?= $data['application_date']; ?></td>

                                    <td data-status="<?= $data['status']; ?>">
                                        <?php
                                        $status = $data['status'];
                                        $color = 'black';

                                        if ($status === 'Accepted') {
                                            $color = 'green';
                                        } elseif ($status === 'Requested') {
                                            $color = 'orange';
                                        } elseif ($status === 'Transfer') {
                                            $color = 'blue';
                                        } elseif ($status === 'Not Accepted') {
                                            $color = 'red';
                                        }
                                        ?>
                                        <span style="color:<?= $color ?>; font-weight:bold;">
                                            <?= $status ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($data['category_type']); ?></td>
                                    <td><?= htmlspecialchars($data['allotted_seat']); ?></td>
                                    <td><?= htmlspecialchars($data['living_status']); ?></td>
                                    <td><?= $data['status_changes_date']; ?></td>
                                    <td><?= htmlspecialchars($data['priority']); ?></td>
                                    <td><strong><?= round($data['total_point'], 2); ?></strong></td>
                                    <td><?= htmlspecialchars($data['location_distance']); ?></td>
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

        var statusFilterValue = '';
        var priorityFilterValue = '';
        var categoryFilterValue = '';
        var joiningStart = '';
        var joiningEnd = '';
        var applicationStart = '';
        var applicationEnd = '';
        var statusStart = '';
        var statusEnd = '';

        // Custom filtering function for DataTable
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            // Status filter
            if (statusFilterValue) {
                var row = settings.aoData[dataIndex].nTr;
                var rowStatus = $('td:eq(8)', row).data('status');
                if (rowStatus !== statusFilterValue) {
                    return false;
                }
            }

            // Priority filter
            if (priorityFilterValue) {
                var rowPriority = data[13];
                if (rowPriority !== priorityFilterValue) {
                    return false;
                }
            }
            // Category filter
            if (categoryFilterValue) {
                var rowCategory = data[9];
                if (rowCategory !== categoryFilterValue) {
                    return false;
                }
            }

            // Joining Date (Column 4)
            if (joiningStart && joiningEnd && data[4]) {
                var rowDate = moment(data[4], 'YYYY-MM-DD');
                if (rowDate.isValid() && (rowDate.isBefore(moment(joiningStart)) || rowDate.isAfter(moment(joiningEnd)))) {
                    return false;
                }
            }

            // Application Date (Column 7)
            if (applicationStart && applicationEnd && data[7]) {
                var rowDate = moment(data[7], 'YYYY-MM-DD');
                if (rowDate.isValid() && (rowDate.isBefore(moment(applicationStart)) || rowDate.isAfter(moment(applicationEnd)))) {
                    return false;
                }
            }

            // Status Change Date (Column 12)
            if (statusStart && statusEnd && data[12]) {
                var rowDate = moment(data[12], 'YYYY-MM-DD');
                if (rowDate.isValid() && (rowDate.isBefore(moment(statusStart)) || rowDate.isAfter(moment(statusEnd)))) {
                    return false;
                }
            }

            return true;
        });

        var table = $('#canteenTable').DataTable({
            dom: '<"table-controls"<"export-area">>lrtip',
            ordering: false,
            paging: true,
            pageLength: 10,
            lengthChange: true
        });

        // Add export button
        $('.table-controls .export-area').html('<button class="export-btn" id="exportExcel"><i class="fa fa-file-excel-o"></i> Export to Excel</button>');
        $('.table-controls').css('text-align', 'right');

        // Normal filters except date columns and select filters
        $('#canteenTable thead tr:eq(1) th input[type="text"]').each(function() {
            var colIndex = $(this).data('col');
            if (colIndex !== undefined && [4, 7, 12].indexOf(colIndex) === -1) {
                $(this).on('keyup change', function() {
                    table.column(colIndex).search(this.value).draw();
                });
            }
        });

        // Status filter
        $('#status_filter').on('change', function() {
            statusFilterValue = this.value;
            table.draw();
        });

        // Priority filter
        $('#priority_filter').on('change', function() {
            priorityFilterValue = this.value;
            table.draw();
        });

        // Category filter
        $('#category_filter').on('change', function() {
            categoryFilterValue = this.value;
            table.draw();
        });

        // Joining Date Range
        $('#joining_date_range').daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Clear'
            }
        });

        $('#joining_date_range').on('apply.daterangepicker', function(ev, picker) {
            joiningStart = picker.startDate.format('YYYY-MM-DD');
            joiningEnd = picker.endDate.format('YYYY-MM-DD');
            $(this).val(joiningStart + ' - ' + joiningEnd);
            table.draw();
        });

        $('#joining_date_range').on('cancel.daterangepicker', function() {
            joiningStart = '';
            joiningEnd = '';
            $(this).val('');
            table.draw();
        });

        // Application Date Range
        $('#application_date_range').daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Clear'
            }
        });

        $('#application_date_range').on('apply.daterangepicker', function(ev, picker) {
            applicationStart = picker.startDate.format('YYYY-MM-DD');
            applicationEnd = picker.endDate.format('YYYY-MM-DD');
            $(this).val(applicationStart + ' - ' + applicationEnd);
            table.draw();
        });

        $('#application_date_range').on('cancel.daterangepicker', function() {
            applicationStart = '';
            applicationEnd = '';
            $(this).val('');
            table.draw();
        });

        // Status Change Date Range
        $('#status_date_range').daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Clear'
            }
        });

        $('#status_date_range').on('apply.daterangepicker', function(ev, picker) {
            statusStart = picker.startDate.format('YYYY-MM-DD');
            statusEnd = picker.endDate.format('YYYY-MM-DD');
            $(this).val(statusStart + ' - ' + statusEnd);
            table.draw();
        });

        $('#status_date_range').on('cancel.daterangepicker', function() {
            statusStart = '';
            statusEnd = '';
            $(this).val('');
            table.draw();
        });

        // Excel Export Functionality - EXPORT ALL PAGES
        $('#exportExcel').on('click', function() {
            // Get ALL rows from the original table (not just current page)
            // We need to get data from the original data source

            // Store current pagination settings
            var currentPage = table.page();
            var currentLength = table.page.len();

            // Temporarily set to show all records
            table.page.len(-1).draw();

            // Small delay to ensure the table has rendered all rows
            setTimeout(function() {
                var filteredData = [];

                // Get ALL visible rows after filters are applied (this gives us all pages combined)
                var allRows = $('#canteenTable tbody tr:visible');

                // Collect data from all filtered rows
                allRows.each(function() {
                    var rowData = [];
                    $(this).find('td').each(function() {
                        // Get text content, remove HTML tags if any
                        //var text = $(this).clone().children().remove().end().text().trim();
                        var text = $(this).text().trim();
                        rowData.push(text);
                    });
                    if (rowData.length > 0) {
                        filteredData.push(rowData);
                    }
                });

                // If no filtered data, show alert
                if (filteredData.length === 0) {
                    alert('No data available for export with current filters.');
                    // Restore pagination
                    table.page.len(currentLength).page(currentPage).draw();
                    return;
                }

                // Define headers
                var headers = [
                    'Employee ID', 'Name', 'Designation', 'Mobile',
                    'Joining Date', 'Department', 'Factory', 'Application Date',
                    'Status', 'Category', 'Allotted Seat', 'Living Status',
                    'Status Changing Date', 'Priority', 'Total', 'Distance'
                ];

                // Prepare worksheet data
                var worksheetData = [headers];

                // Re-number SL for filtered data
                filteredData.forEach(function(row, index) {
                    row[0] = index + 1; // Update SL number
                    worksheetData.push(row);
                });

                // Create workbook and worksheet
                var wb = XLSX.utils.book_new();
                var ws = XLSX.utils.aoa_to_sheet(worksheetData);

                // Adjust column widths (optional)
                // ws['!cols'] = [{
                //         wch: 6
                //     }, {
                //         wch: 12
                //     }, {
                //         wch: 20
                //     }, {
                //         wch: 20
                //     }, {
                //         wch: 15
                //     },
                //     {
                //         wch: 12
                //     }, {
                //         wch: 20
                //     }, {
                //         wch: 15
                //     }, {
                //         wch: 12
                //     }, {
                //         wch: 15
                //     },
                //     {
                //         wch: 12
                //     }, {
                //         wch: 12
                //     }, {
                //         wch: 12
                //     }, {
                //         wch: 15
                //     }, {
                //         wch: 10
                //     },
                //     {
                //         wch: 10
                //     }, {
                //         wch: 10
                //     }
                // ];

                // Add worksheet to workbook
                XLSX.utils.book_append_sheet(wb, ws, 'All Applications');

                // Generate filename with current date
                var today = new Date();
                var dateStr = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
                var filename = 'canteen_applications_' + dateStr + '.xlsx';

                // Export file
                XLSX.writeFile(wb, filename);

                // Restore original pagination
                table.page.len(currentLength).page(currentPage).draw();

                // Show success message
                //alert('Exported ' + filteredData.length + ' records successfully!');
            }, 100);
        });

    });
</script>

<?php include('footer.php'); ?>