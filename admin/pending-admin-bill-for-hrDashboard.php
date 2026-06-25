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
        width: 50px;
        /* Reference */
    }

    #dataTables th:nth-child(2),
    #dataTables td:nth-child(2) {
        width: 64px;
        /* Name */
    }

    #dataTables th:nth-child(3),
    #dataTables td:nth-child(3) {
        width: 40px;
        /* ID */
    }

    #dataTables th:nth-child(4),
    #dataTables td:nth-child(4) {
        width: 70px;
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
        width: 90px;
        /* Apply Date */
    }

   
</style>
<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="container-fluid">

        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Pending Bill Approval List.</h3>
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
                                        <center>Reference </center>
                                    </th>
                                    <th>
                                        <center>Name </center>
                                    </th>
                                    <th>
                                        <center>ID</center>
                                    </th>
                                    <th>
                                        <center>Cost Company</center>
                                    </th>
                                    <th>
                                        <center>Cost Center</center>
                                    </th>
                                    <th>
                                        <center>Item Name</center>
                                    </th>
                                    <th>
                                        <center>Total Amount BDT</center>
                                    </th>

                                </tr>
                                <tr class="search-row">
                                    <th>Reference</th>
                                    <th>Name</th>
                                    <th>ID</th>
                                    <th>Cost Company</th>
                                    <th>Cost Center</th>
                                    <th>Item Name</th>
                                    <th>Total Amount BDT</th>
                                </tr>
                            </thead>
                            <tbody>


                                <?php

                                $sql_requisition_Admin_bill_HRDashboard = $db->query("SELECT c.id, MIN(c.reference) AS reference, MIN(c.requesterID) AS requesterID, MIN(c.requesterName) AS requesterName, MIN(c.designation) AS designation, MIN(c.department) AS department, MIN(c.section) AS section, MIN(c.costDivision) AS costDivision, MIN(c.PurchaseFor) AS PurchaseFor, MIN(c.ruqest_date) AS ruqest_date, MIN(c.email) AS email FROM canteen_header c LEFT JOIN user_role r ON c.PurchaseFor = r.category AND c.costDivision = r.companyID AND r.user_type='Approval User' LEFT JOIN canteen_line a ON c.reference = a.reference WHERE c.approvedStatus='7' AND c.status='1' AND EXISTS (
                                            SELECT 1 
                                            FROM user_role ur 
                                            WHERE ur.user_name = '$username'
                                            AND ur.companyID = c.costDivision
                                            -- Optional: AND ur.category = c.PurchaseFor
                                        )  GROUP BY c.id ORDER BY c.id ASC");

                                while ($bill_data = $sql_requisition_Admin_bill_HRDashboard->fetch_assoc()) {

                                    $costcenterid = $bill_data['costDivision'];

                                    $costsql = $db->query("select * from company_library where companymdm ='$costcenterid'");

                                    $costsql_r = $costsql->fetch_assoc();

                                    $refid = $bill_data['reference'];

                                    $sql_item_list = $db->query("SELECT GROUP_CONCAT(DISTINCT ItemName SEPARATOR ', ') AS itemname FROM canteen_line WHERE reference = '$refid'");

                                    $itemdata = $sql_item_list->fetch_assoc();

                                    $HR_Approve_Bill = $db->query("SELECT sum(PurTotalPrice) as totalamount FROM canteen_line WHERE reference='$refid' AND status='2' ");
                                    $billamount = $HR_Approve_Bill->fetch_assoc();

                                ?>
                                    <tr>
                                        <td><?php echo $bill_data['reference']; ?></td>

                                        <td><?php echo $bill_data['requesterName']; ?></td>
                                        <td><?php echo $bill_data['requesterID']; ?></td>
                                        <td><?php echo $costsql_r['company_name']; ?></td>

                                        <td><?php echo $bill_data['PurchaseFor']; ?></td>


                                        <td><?php echo $itemdata['itemname']; ?></td>

                                        <td><?php echo $billamount['totalamount']; ?> </td>

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

        // Add search inputs only once
        $('#dataTables thead tr.search-row th').each(function() {
            var title = $(this).text();
            if (title !== "") {
                $(this).html('<input type="text" class="form-control input-sm" placeholder="Search ' + title + '" />');
            }
        });

        // Initialize DataTable only if not already initialized
        var table;
        if (!$.fn.dataTable.isDataTable('#dataTables')) {
            table = $('#dataTables').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                autoWidth: false,

            });
        } else {
            table = $('#dataTables').DataTable();
        }

        // Column search
        table.columns().every(function(index) {
            $('input', $('#dataTables thead tr.search-row th').eq(index)).on('keyup change', function() {
                if (table.column(index).search() !== this.value) {
                    table.column(index).search(this.value).draw();
                }
            });
        });

    });
</script>



<?php include('footer.php'); ?>