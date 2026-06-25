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
        width: 80px;
        /* Reference */
    }

    #dataTables th:nth-child(2),
    #dataTables td:nth-child(2) {
        width: 80px;
        /* Name */
    }

    #dataTables th:nth-child(3),
    #dataTables td:nth-child(3) {
        width: 50px;
        /* ID */
    }

    #dataTables th:nth-child(4),
    #dataTables td:nth-child(4) {
        width: 80px;
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
                <th><center>Reference</center></th>
                <th><center>Name</center></th>
                <th><center>ID</center></th>
                <th><center>Cost Company</center></th>
                <th><center>Cost Center</center></th>
                <th><center>Item Name</center></th>
                <th><center>Total Amount BDT</center></th>
                <th><center>Action</center></th>
            </tr>
             <tr class="search-row">
                                    <th>Reference</th>
                                    <th>Name</th>
                                    <th>ID</th>
                                 
                                    <th>Cost Company</th>
                                    <th>Cost Center</th>
                                    <th>Item List</th>
                                    <th>Total Amount BDT</th>
                                
                                    <th></th> <!-- no search for Action column -->
                                </tr>
        </thead>
        <tbody>
                
<?php

    $sql_requisition_depart_approve_log = $db->query("SELECT 
    c.id, 
    c.reference, 
    c.requesterID, 
    c.requesterName, 
    c.designation, 
    c.department, 
    c.costDivision, 
    c.PurchaseFor, 
    c.email,
    cl.items,
    cl.total_amount
FROM canteen_header c
LEFT JOIN user_role r 
    ON c.PurchaseFor = r.category 
   AND c.costDivision = r.companyID
INNER JOIN approve_verify apvi 
    ON c.reference = apvi.reference
   AND apvi.approvalType = 'Head of HR'
   AND apvi.status = '1'
   AND apvi.processName = 'Bill HRM'
LEFT JOIN (
    SELECT 
        canteenHeaderID,
        reference,
        GROUP_CONCAT(DISTINCT ItemName SEPARATOR ', ') AS items,
        SUM(PurTotalPrice) AS total_amount
    FROM canteen_line 
    GROUP BY canteenHeaderID, reference
) cl 
    ON c.id = cl.canteenHeaderID 
   AND c.reference = cl.reference
WHERE c.approvedStatus BETWEEN 5 AND 6
                            AND EXISTS (
                                            SELECT 1 
                                            FROM user_role ur 
                                            WHERE ur.user_name = '$username'
                                            AND ur.companyID = c.costDivision
                                            -- Optional: AND ur.category = c.PurchaseFor
                                        )
 GROUP BY c.id, c.reference, c.requesterID, c.requesterName, c.designation, c.department, c.costDivision, c.PurchaseFor, c.email,cl.items, cl.total_amount");

        
    while($requisition_data = $sql_requisition_depart_approve_log->fetch_assoc()){

        $costcenterid = $requisition_data['costDivision'];
        $costsql = $db->query("SELECT * from company_library where companymdm ='$costcenterid'");
        $costsql_r = $costsql->fetch_assoc();

?>
                <tr>
                    <td><center><?php echo $requisition_data['reference']; ?></center></td>
                    <td><center><?php echo $requisition_data['requesterName']; ?></center></td>
                    <td><center><?php echo $requisition_data['requesterID']; ?></center></td>
                    <td><center><?php echo $costsql_r['company_name']; ?></center></td>
                    <td><center><?php echo $requisition_data['PurchaseFor']; ?></center></td>
                     <td><center><?php echo $requisition_data['items'] ?? 'No items'; ?></center></td>
                    <td><center><?php echo number_format($requisition_data['total_amount'] ?? 0, 2); ?> BDT</center></td>
                    <td><center>
                        <a href="viewHRbillaproved.php?view_id=<?php echo md5($requisition_data['id']); ?>" class="btn btn-primary btn-sm">VIEW</a>
                    </center></td>
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