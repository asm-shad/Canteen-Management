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
                                <th style="width:50px">SL</th>
                                <th style="width:80px">Employee ID</th>
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
                                <th><input type="hidden" class="filter-input"></th>
                                <th><input type="text" class="filter-input"></th>
                                <th><input type="text" class="filter-input"></th>
                                <th><input type="text" class="filter-input"></th>
                                <th><input type="text" class="filter-input"></th>
                                <th><input type="date" class="filter-input"></th>
                                <th><input type="text" class="filter-input"></th>
                                <th><input type="text" class="filter-input"></th>
                                <th><input type="date" class="filter-input"></th>

                                <th>
                                    <select class="filter-input">
                                        <option value="">All</option>
                                        <option value="Accepted">Accepted</option>
                                        <option value="Requested">Requested</option>
                                        <option value="Transfer">Transfer</option>
                                        <option value="Not Accepted">Not Accepted</option>
                                    </select>
                                </th>

                                <th><input type="text" class="filter-input"></th>
                                <th><input type="text" class="filter-input"></th>
                                <th><input type="text" class="filter-input"></th>
                                <th><input type="date" class="filter-input"></th>

                                <th>
                                    <select class="filter-input">
                                        <option value="">All</option>
                                        <option value="Priority-1">Priority-1</option>
                                        <option value="Priority-2">Priority-2</option>
                                        <option value="Priority-3">Priority-3</option>
                                    </select>
                                </th>

                                <th><input type="text" class="filter-input"></th>
                                <th><input type="text" class="filter-input"></th>
                            </tr>
                        </thead>

                        <tbody style="font-size:12px;">
                            <?php $i = 1;
                            while ($data = $all_application->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $data['employee_id']; ?></td>
                                    <td><?= $data['name']; ?></td>
                                    <td><?= $data['designations']; ?></td>
                                    <td><?= $data['mobile']; ?></td>
                                    <td><?= $data['joining_date']; ?></td>
                                    <td><?= $data['section_or_department']; ?></td>
                                    <td><?= $data['employer_factory']; ?></td>
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



                                    <td><?= $data['category_type']; ?></td>
                                    <td><?= $data['allotted_seat']; ?></td>
                                    <td><?= $data['living_status']; ?></td>
                                    <td><?= $data['status_changes_date']; ?></td>
                                    <td><?= $data['priority']; ?></td>
                                    <td><strong><?= round($data['total_point'], 2); ?></strong></td>
                                    <td><?= $data['location_distance']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        var statusFilterValue = '';
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {

            if (!statusFilterValue) {
                return true;
            }

            // Get the row node
            var row = settings.aoData[dataIndex].nTr;

            // Status column index = 9
            var rowStatus = $('td:eq(9)', row).data('status');

            return rowStatus === statusFilterValue;
        });

        var table = $('#canteenTable').DataTable({
            dom: 'lrtip', // removes global search box only
            ordering: false,
            paging: true,
            pageLength: 10,
            lengthChange: true
        });


        // Normal filters for all columns EXCEPT status
        $('#canteenTable thead tr:eq(1) th').each(function(colIndex) {

            $('input', this).on('keyup change', function() {
                table.column(colIndex).search(this.value).draw();
            });

        });

        // Status dropdown (exact match)
        $('#canteenTable thead tr:eq(1) th:eq(9) select').on('change', function() {
            statusFilterValue = this.value;
            table.draw();
        });

    });
</script>


<?php include('footer.php'); ?>