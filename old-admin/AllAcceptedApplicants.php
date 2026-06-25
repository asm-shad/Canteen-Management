<?php

include('header.php');

$all_accepted = $cls_meassage->all_accepted_applicants($username);


?>

<style>
    .btn-mini {
        padding: 4px 8px !important;
        font-size: 12px;
        line-height: 1;
    }

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

<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="container-fluid">
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Allotted applicants</h3>
            </div>
            <div class="panel-body">

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover text-center" id="canteenTable">
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
                                    <th style="width:110px">Action</th>
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
                                            <option value="Transfer">Transfer</option>

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
                                    <th><input type="hidden" class="filter-input"></th>
                                </tr>
                            </thead>

                            <tbody style="font-size:12px;">
                                <?php $i = 1;
                                while ($data = $all_accepted->fetch_assoc()) { ?>
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

                                        <td>
                                            <?php
                                            $status = $data['status'];
                                            $color = 'black';

                                            if ($status == 'Accepted') {
                                                $color = 'green';
                                            } elseif ($status == 'Requested') {
                                                $color = 'orange';
                                            } elseif ($status == 'Transfer') {
                                                $color = 'blue';
                                            } elseif ($status == 'Not Accepted') {
                                                $color = 'red';
                                            }

                                            ?>
                                            <span style="color:<?= $color ?>;font-weight:bold">
                                                <?= $data['status']; ?>
                                            </span>
                                        </td>

                                        <td><?= $data['category_type']; ?></td>
                                        <td><?= $data['allotted_seat']; ?></td>
                                        <td><?= $data['living_status']; ?></td>
                                        <td><?= $data['status_changes_date']; ?></td>
                                        <td><?= $data['priority']; ?></td>
                                        <td><strong><?= round($data['total_point'], 2); ?></strong></td>
                                        <td><?= $data['location_distance']; ?></td>
                                        <td>
                                            <!-- <div style="display: inline-flex; gap: 4px; margin-bottom:4px;">
                                                <button class="btn btn-primary btn-sm" onclick="openTransferModal(<?php echo $data['id']; ?>, '<?php echo $data['name']; ?>')">Transfer</button>
                                            </div> -->
                                            <button class="btn btn-primary btn-sm" style="margin-bottom:4px;"
                                                onclick="openTransferModal(
                                                                    <?php echo $data['id']; ?>,
                                                                    '<?php echo $data['name']; ?>',
                                                                    '<?php echo $data['allotted_seat']; ?>'
                                                                )">
                                                Transfer
                                            </button>


                                            <button class="btn btn-success btn-sm" style="padding-left: 4px !important;"
                                                onclick="openLivingStatusModal(<?php echo $data['id']; ?>, '<?php echo $data['name']; ?>', '<?php echo $data['living_status']; ?>')">
                                                Living Status
                                            </button>

                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT -->

<div id="transferModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Transfer Application</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label><strong>Current Allotted Seat:</strong></label>
                    <input type="text" id="currentAllottedSeat" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label><strong>Select New Allotted Seat:</strong></label>
                    <select id="transferSeatType" class="form-control">
                        <option value="">-- Select Seat --</option>
                        <option value="VIP">VIP</option>
                        <option value="General">General</option>
                    </select>
                </div>
                <div id="transferSeatWarning" class="alert alert-warning" style="display:none;">
                    Please select a seat type.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="confirmTransfer()">Transfer</button>
            </div>
        </div>
    </div>
</div>

<!-- Change Living Status -->
<div id="livingStatusModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Change Living Status</h4>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label><strong>Current Living Status</strong></label>
                    <input type="text" id="currentLivingStatus" class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label><strong>Change Living Status</strong></label>
                    <select id="newLivingStatus" class="form-control">
                        <option value="">-- Select Status --</option>
                        <option value="Regular">Regular</option>
                        <option value="Inactive">Inactive</option>
                        <option value="Resign">Resign</option>
                        <option value="Lefty">Lefty</option>
                        <option value="Drop Out">Drop Out</option>
                    </select>
                </div>

                <div id="livingStatusWarning" class="alert alert-warning" style="display:none;">
                    Please select a living status.
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button class="btn btn-success" onclick="confirmLivingStatus()">Update</button>
            </div>

        </div>
    </div>
</div>



<script>
    let currentApplicationId = null;

    function openTransferModal(appId, appName, currentSeat) {
        currentApplicationId = appId;

        document.getElementById('currentAllottedSeat').value = currentSeat;
        document.getElementById('transferSeatType').value = '';
        document.getElementById('transferSeatWarning').style.display = 'none';

        $('#transferModal').modal('show');
    }


    // function confirmTransfer() {
    //     const seatType = document.getElementById('transferSeatType').value;

    //     if (!seatType) {
    //         document.getElementById('transferSeatWarning').style.display = 'block';
    //         return;
    //     }

    //     // Send AJAX request to process the transfer
    //     $.ajax({
    //         type: 'POST',
    //         url: 'process_transfer.php',
    //         data: {
    //             application_id: currentApplicationId,
    //             allotted_seat: seatType,
    //             action: 'transfer'
    //         },
    //         success: function(response) {
    //             try {
    //                 const result = JSON.parse(response);
    //                 if (result.success) {
    //                     alert('Application transferred successfully!');
    //                     location.reload();
    //                 } else {
    //                     alert('Error: ' + result.message);
    //                 }
    //             } catch (e) {
    //                 alert('Application transferred successfully!');
    //                 location.reload();
    //             }
    //         },
    //         error: function() {
    //             alert('Error processing request');
    //         }
    //     });

    //     $('#transferModal').modal('hide');
    // }

    function confirmTransfer() {
        const seatType = document.getElementById('transferSeatType').value;

        if (!seatType) {
            document.getElementById('transferSeatWarning').style.display = 'block';
            return;
        }

        $.ajax({
            type: 'POST',
            url: 'process_transfer.php',
            dataType: 'json',
            data: {
                application_id: currentApplicationId,
                allotted_seat: seatType,
                action: 'transfer'
            },
            success: function(result) {
                if (result.success) {
                    alert(result.message);
                    location.reload();
                } else {
                    alert(result.message);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    alert(xhr.responseJSON.message);
                } else {
                    alert('Error processing request');
                }
            }
        });

        $('#transferModal').modal('hide');
    }




    //Filter and Pagination Script
    $(document).ready(function() {

        var table = $('#canteenTable').DataTable({
            //searching: true,
            dom: 'lrtip',
            ordering: false,
            paging: true,
            pageLength: 10,
            lengthChange: true
        });

        // Column-wise filtering
        $('#canteenTable thead tr:eq(1) th').each(function(colIndex) {

            $('input, select', this).on('keyup change', function() {

                let value = this.value;

                // STATUS COLUMN (index = 9)
                if (colIndex === 18 && value !== '') {
                    // Match whole word only (Accepted ≠ Not Accepted)
                    table
                        .column(colIndex)
                        .search('\\b' + value + '\\b', true, false)
                        .draw();
                } else {
                    table
                        .column(colIndex)
                        .search(value)
                        .draw();
                }
            });

        });

    });

    // Living Status Modal Scripts
    let livingApplicationId = null;

    function openLivingStatusModal(appId, name, currentStatus) {
        livingApplicationId = appId;

        document.getElementById('currentLivingStatus').value = currentStatus;
        document.getElementById('newLivingStatus').value = '';
        document.getElementById('livingStatusWarning').style.display = 'none';

        $('#livingStatusModal').modal('show');
    }

    function confirmLivingStatus() {
        const status = document.getElementById('newLivingStatus').value;

        if (!status) {
            document.getElementById('livingStatusWarning').style.display = 'block';
            return;
        }

        $.ajax({
            type: 'POST',
            url: 'process_living_status.php',
            dataType: 'json',
            data: {
                application_id: livingApplicationId,
                living_status: status
            },
            success: function(result) {
                if (result.success) {
                    alert(result.message);
                    location.reload();
                } else {
                    alert(result.message);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Error processing request');
            }
        });

        $('#livingStatusModal').modal('hide');
    }
</script>

<?php include('footer.php'); ?>