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

    #dataTables th:nth-child(9),
    #dataTables td:nth-child(9) {
        width: 90px;
        /* Item Name */
    }

   
</style>
<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="container-fluid">

        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">List of Requisitions You Approved</h3>
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
                                        <center>Refe. </center>
                                    </th>
                                    <th>
                                        <center>Name</center>
                                    </th>
                                    <th>
                                        <center>ID</center>
                                    </th>
                                    <th>
                                        <center>Desig</center>
                                    </th>
                                    <th>
                                        <center>Depart</center>
                                    </th>
                                    <th>
                                        <center>Cost Company</center>
                                    </th>
                                    <th>
                                        <center>Cost Center</center>
                                    </th>
                                    
                                    <th>
                                        <center>Item List</center>
                                    </th>

                                </tr>
                                 <tr class="search-row">
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
                                  
                                    <th>Item Name</th>
                                    
                                </tr>
                            </thead>
                            <tbody>

                                <?php


 
$sql_requisition_depart_approve_log = $db->query("
    SELECT a.*, ch.*
    FROM approve_verify a 
    INNER JOIN canteen_header ch 
        ON a.reference = ch.reference 
    WHERE a.status='1' 
        AND a.processName='Admin Concern Approve Bill'
        AND EXISTS (
            SELECT 1 
            FROM user_role ur 
            WHERE ur.user_name = '$username'
            AND ur.companyID = ch.costDivision
        )
");



                                while ($requisition_data = $sql_requisition_depart_approve_log->fetch_assoc()) {

                                    $costcenterid = $requisition_data['costDivision'];

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

                                        <!--  <td><center>Active</center></td> -->

                                       
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