<?php


include('header.php');

?>

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

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
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
                                        <center>Apply Date</center>
                                    </th>
                                    <th>
                                        <center>Item List</center>
                                    </th>code
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

                                // $sql_requisition_depart_approve_log = $db->query("SELECT c.id,  c.reference, c.requesterID, c.requesterName, c.designation, c.department, c.section, c.costDivision, c.PurchaseFor, c.ruqest_date, c.email
                                //   FROM canteen_header c
                                //   LEFT JOIN user_role r
                                //   ON c.PurchaseFor = r.category and c.costDivision=r.companyID LEFT JOIN canteen_line a ON c.reference =a.reference LEFT JOIN approve_verify apvi ON c.reference = apvi.reference where r.user_name='$username' and c.status='1' and r.user_type='Head of HR' and apvi.status = '1' and apvi.processName='HR Head Approve' and c.approvedStatus BETWEEN 2 and 7 GROUP BY c.id");

$sql_requisition_depart_approve_log = $db->query("SELECT
    c.id,
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
LEFT JOIN canteen_line a 
    ON c.reference = a.reference
LEFT JOIN approve_verify apvi 
    ON c.reference = apvi.reference
INNER JOIN user_role approver_role 
    ON apvi.username = approver_role.user_name
INNER JOIN user u
    ON approver_role.employeeID = u.employeeID
    AND approver_role.user_name = u.username
WHERE 
    apvi.status = '1'
    AND apvi.processName = 'HR Head Approve'
    AND apvi.approvalType = 'Head of HR'
    AND approver_role.user_type = 'Head of HR'
    AND c.PurchaseFor = approver_role.category
    AND EXISTS (
        SELECT 1 
        FROM user_role loggedin_role 
        WHERE loggedin_role.user_name = '$username'
          AND loggedin_role.companyname = approver_role.companyname
          AND loggedin_role.category = approver_role.category
    )
    AND apvi.username != '$username'
    AND c.status = '1'
    AND c.approvedStatus BETWEEN 2 AND 7 GROUP BY c.id, c.reference, c.requesterID, c.requesterName, c.designation,
         c.department, c.section, c.costDivision, c.PurchaseFor, c.ruqest_date,
         c.email, u.name

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
                                            <center><?php echo $requisition_data['ruqest_date']; ?></center>
                                        </td>

                                        <td>
                                            <center><?php echo $itemdata['itemname']; ?></center>
                                        </td>
                                        <td>
                                            <center><?php echo $requisition_data['approved_by']; ?></center>
                                        </td>

                                        <!--  <td><center>Active</center></td> -->

                                        <td>
                                            <center><a href="viewOthersHRaproved.php?view_id=<?php echo md5($requisition_data['id']); ?>" class="btn btn-primary btn-sm">VIEW</a>
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

<?php include('footer.php'); ?>