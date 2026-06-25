<?php
include('header.php');

?>

<style>
    .dataTables_filter {
        display: none !important;
    }

    #dataTables {
        table-layout: fixed !important;
        width: 100% !important;
    }

    #dataTables thead input {
        width: 90% !important;
        box-sizing: border-box !important;
        padding: 3px 6px;
        font-size: 12px;
        margin-left: 6px;
        margin: 4px;
    }

    #dataTables thead tr.search-row th {
        padding: 0 !important;
    }

    #dataTables th:nth-child(1),
    #dataTables td:nth-child(1) {
        width: 60px;
        padding: 0px !important;
        align-items: center;
        /* Reference */
    }

    #dataTables th:nth-child(2),
    #dataTables td:nth-child(2) {
        width: 60px;
        /* Name */
    }

    #dataTables th:nth-child(3),
    #dataTables td:nth-child(3) {
        width: 70px;
        /* ID */
    }

    #dataTables th:nth-child(4),
    #dataTables td:nth-child(4) {
        width: 50px;
        /* Designation */
    }

    #dataTables th:nth-child(5),
    #dataTables td:nth-child(5) {
        width: 70px;
        /* Department */
    }

    #dataTables th:nth-child(6),
    #dataTables td:nth-child(6) {
        width: 80px;
        /* cost company */
    }

    #dataTables th:nth-child(7),
    #dataTables td:nth-child(7) {
        width: 70px;
        /* cost center */
    }

    #dataTables th:nth-child(8),
    #dataTables td:nth-child(8) {
        width: 60px;
        /* Apply Date */
    }

    #dataTables th:nth-child(9),
    #dataTables td:nth-child(9) {
        width: 80px;
        /* Item List */
    }

    #dataTables th:nth-child(10),
    #dataTables td:nth-child(10) {
        width: 75px;
        /* Approved By */
    }

    #dataTables th:nth-child(11),
    #dataTables td:nth-child(11) {
        width: 80px;
        /* Action */
    }
</style>

<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="container-fluid">

        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Approved List</h3>
                <!--    <p class="panel-subtitle">
    
    <form method="post" action="inbox.php" align="center">  
        <input type="submit" name="export" value="CSV Export" class="btn btn-success" />  
    </form> 
    </p> -->
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Apply Date</center>
                                    </th>
                                    <th>
                                        <center>Reference </center>
                                    </th>
                                    <th>
                                        <center>Name </center>
                                    </th>
                                    <th>
                                        <center>ID</center>
                                    </th>
                                    <th>
                                        <center>Designation</center>
                                    </th>
                                    <th>
                                        <center>Department</center>
                                    </th>
                                    <th>
                                        <center>Cost Company</center>
                                    </th>
                                    <!--<th><center>Photo</center></th>-->
                                    <th>
                                        <center>Cost Center</center>
                                    </th>

                                    <th>
                                        <center>Item List</center>
                                    </th>
                                    <th>
                                        <center>Approved By</center>
                                    </th>
                                    <th>
                                        <center>Action</center>
                                    </th>

                                </tr>
                                <tr class="search-row">
                                    <!-- <th>Apply Date</th> -->
                                    <th>
                                        <input type="text" id="dateRange" class="form-control input-sm" placeholder="Select Date Range">
                                    </th>


                                    <th>Reference</th>
                                    <th>Name</th>
                                    <th>ID</th>
                                    <th>Designation</th>
                                    <th>Department</th>
                                    <th>Cost Company</th>
                                    <th>Cost Center</th>
                                    <th>Item List</th>
                                    <th>Approved By</th>
                                    <th></th> <!-- no search for Action column -->
                                </tr>
                            </thead>
                            <tbody>

                                <?php
$sql_requisition_depart_approve_log = $db->query(" 
    SELECT DISTINCT c.id,
    c.reference,
    c.requesterID,
    c.requesterName,
    c.designation,
    c.department,
    c.section,
    c.costDivision,
    c.PurchaseFor,
    c.ruqest_date,
    c.email,
    u.name AS approved_by
    FROM canteen_header c
    INNER JOIN approve_verify apvi
        ON c.reference = apvi.reference
    INNER JOIN user u
        ON apvi.userID = u.employeeID
    INNER JOIN user_role approver_role
        ON u.employeeID = approver_role.employeeID
        AND approver_role.companyID = c.costDivision
    WHERE
        c.status = '1'
        AND (
            (apvi.status = '1' AND apvi.processName = 'HR Head Approve')
            OR apvi.approvalType = 'Boss'
        )
        AND c.approvedStatus BETWEEN 2 AND 7
        -- Check if logged-in user has access to THIS company
        AND c.costDivision IN (
            SELECT companyID 
            FROM user_role 
            WHERE user_name = '$username'
        )
");


                                while ($requisition_data = $sql_requisition_depart_approve_log->fetch_assoc()) {


                                    $costcenterid = $requisition_data['costDivision'];
                                    // $approvedBy = $requisition_data['user_name'];


                                    $costsql = $db->query("SELECT * from company_library where companymdm ='$costcenterid'");

                                    $costsql_r = $costsql->fetch_assoc();


                                    $refid = $requisition_data['reference'];

                                    $sql_item_list = $db->query("SELECT GROUP_CONCAT(DISTINCT ItemName SEPARATOR ', ') AS itemname FROM canteen_line WHERE reference = '$refid'");

                                    $itemdata = $sql_item_list->fetch_assoc();


                                ?>
                                    <tr>
                                        <td>
                                            <center><?php echo $requisition_data['ruqest_date']; ?></center>
                                        </td>
                                        <td>
                                            <center><?php echo $requisition_data['reference']; ?></center>
                                        </td>

                                        <td>
                                            <center><?php echo $requisition_data['requesterName']; ?></center>
                                        </td>
                                        <td>
                                            <center><?php echo $requisition_data['requesterID']; ?></center>
                                        </td>
                                        <td>
                                            <center><?php echo $requisition_data['designation']; ?></center>
                                        </td>
                                        <td>
                                            <center><?php echo $requisition_data['department']; ?></center>
                                        </td>
                                        <td>
                                            <center><?php echo $costsql_r['company_name']; ?></center>
                                        </td>
                                        <td>
                                            <center><?php echo $requisition_data['PurchaseFor']; ?>
                                            </center>
                                        </td>


                                        <td>
                                            <center><?php echo $itemdata['itemname']; ?></center>
                                        </td>
                                        <td>
                                            <center><?php echo $requisition_data['approved_by']; ?></center>
                                        </td>

                                        <!--  <td><center>Active</center></td> -->

                                        <td>
                                            <center><a href="viewHRaproved.php?view_id=<?php echo md5($requisition_data['id']); ?>" class="btn btn-primary btn-sm">VIEW</a>



                                            </center>
                                        </td>

                                    </tr>

                                <?php

                                } ?>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MAIN CONTENT -->

<script>
    $(document).ready(function() {

        // Create search inputs (except column 0 → Apply Date)
        $('#dataTables thead tr.search-row th').each(function(i) {
            if (i === 0) return; // Skip Apply Date
            var title = $(this).text();
            if (title !== "") {
                $(this).html('<input type="text" class="form-control input-sm" placeholder="Search ' + title + '" />');
            }
        });

        // Initialize DataTable
        var table = $('#dataTables').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            autoWidth: false
        });

        // Column search (text inputs)
        table.columns().every(function(index) {
            if (index === 0) return; // Skip Apply Date column
            $('input', $('#dataTables thead tr.search-row th').eq(index)).on('keyup change', function() {
                table.column(index).search(this.value).draw();
            });
        });

        // --- DATE RANGE FILTER ---
        let minDate = null;
        let maxDate = null;

        $('#dateRange').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
            minDate = picker.startDate.format('YYYY-MM-DD');
            maxDate = picker.endDate.format('YYYY-MM-DD');
            $(this).val(minDate + ' - ' + maxDate);
            table.draw();
        });

        $('#dateRange').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            minDate = null;
            maxDate = null;
            table.draw();
        });

        $.fn.dataTable.ext.search.push(function(settings, data) {
            var date = data[0]; // Apply Date
            if (!date) return false;
            if (minDate === null && maxDate === null) return true;

            var d = moment(date, "YYYY-MM-DD");
            if (minDate && d.isBefore(minDate)) return false;
            if (maxDate && d.isAfter(maxDate)) return false;
            return true;
        });

    });
</script>



<?php include('footer.php'); ?>