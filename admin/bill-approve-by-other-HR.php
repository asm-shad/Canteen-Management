<?php
// Turn on all error reporting
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

include('header.php');

?>

<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="container-fluid">

        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Bill Approved by Others</h3>
                <!--    <p class="panel-subtitle">
    
    <form method="post" action="inbox.php" align="center">  
        <input type="submit" name="export" value="CSV Export" class="btn btn-success" />  
    </form> 
    </p> -->
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>
                                        <center>Reference</center>
                                    </th>
                                    <th>
                                        <center>Name</center>
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
                                    <th>
                                        <center>Approved By</center>
                                    </th>
                                    <th>
                                        <center>Action</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                           

$sql = "SELECT 
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
    cl.total_amount,
    u.name AS approved_by
FROM canteen_header c
INNER JOIN approve_verify apvi ON c.reference = apvi.reference
INNER JOIN user_role approver_role ON apvi.username = approver_role.user_name AND LOWER(approver_role.user_type) = 'head of hr'
INNER JOIN user u ON approver_role.employeeID = u.employeeID AND approver_role.user_name = u.username
LEFT JOIN (
    SELECT 
        canteenHeaderID,
        reference,
        GROUP_CONCAT(DISTINCT ItemName ORDER BY ItemName SEPARATOR ', ') AS items,
        SUM(PurTotalPrice) AS total_amount
    FROM canteen_line
    GROUP BY canteenHeaderID, reference
) cl ON c.id = cl.canteenHeaderID AND c.reference = cl.reference
WHERE LOWER(apvi.username) != LOWER('$username')
  AND apvi.status = '1'
  AND LOWER(apvi.approvalType) = 'head of hr'
  AND LOWER(apvi.processName) = 'bill hrm'
  AND c.approvedStatus BETWEEN 5 AND 6
  AND c.PurchaseFor = approver_role.category
  AND EXISTS (
      SELECT 1 
      FROM user_role loggedin_role
      WHERE loggedin_role.user_name = '$username'
        AND loggedin_role.companyname = approver_role.companyname
        AND loggedin_role.category = approver_role.category
  )
GROUP BY c.id, c.reference, c.requesterID, c.requesterName, c.designation, c.department, 
         c.costDivision, c.PurchaseFor, c.email, cl.items, cl.total_amount, u.name";

 $db->set_charset("utf8mb4");

$sql_requisition_depart_approve_log = $db->query($sql);

if (!$sql_requisition_depart_approve_log) {
    die("<b>SQL Error:</b> " . $db->error . "<br><b>Query:</b><pre>$sql</pre>");
}

while ($requisition_data = $sql_requisition_depart_approve_log->fetch_assoc()) {

    $costcenterid = $requisition_data['costDivision'];

    $costsql = $db->query("SELECT * FROM company_library WHERE companymdm ='$costcenterid'");

    if (!$costsql) {
        die("SQL Error (company_library query): " . $db->error);
    }

    $costsql_r = $costsql->fetch_assoc();
                                ?>
                                    <tr>
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
                                            <center><?php echo $costsql_r['company_name']; ?></center>
                                        </td>
                                        <td>
                                            <center><?php echo $requisition_data['PurchaseFor']; ?></center>
                                        </td>
                                        <td>
                                            <center><?php echo $requisition_data['items'] ?? 'No items'; ?></center>
                                        </td>
                                        <td>
                                            <center><?php echo number_format($requisition_data['total_amount'] ?? 0, 2); ?> BDT</center>
                                        </td>
                                        <td><center><?php echo $requisition_data['approved_by']; ?></center></td>
                                        <td>
                                            <center>
                                                <a href="viewOthersHRbillaproved.php?view_id=<?php echo md5($requisition_data['id']); ?>" class="btn btn-primary btn-sm">VIEW</a>
                                            </center>
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

<?php include('footer.php'); ?>