<?php 
include('header.php');

?>

<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
<div class="container-fluid">

<div class="panel panel-headline">
<div class="panel-heading">
    <h3 class="panel-title">Requisition List</h3>
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
                <th><center>Refe. </center></th>
                <th><center>Name</center></th>
                <th><center>ID</center></th>
                <th><center>Desig</center></th>
                <th><center>Depart</center></th>
                <th><center>Cost Company</center></th>
                <th><center>Cost Center</center></th>
                <th><center>Apply Date</center></th>
                <th><center>Item List</center></th>
                <th><center>Status</center></th>
                
            </tr>
        </thead>
        <tbody>
                
<?php

    $sql_requisition_depart_approve_log = $db->query("SELECT c.id,  c.reference, c.requesterID, c.requesterName, c.designation, c.department, c.section, c.costDivision, c.PurchaseFor, c.ruqest_date, c.email, c.approvedStatus, c.rejectUser
      FROM canteen_header c
      LEFT JOIN user_role r
      ON c.PurchaseFor = r.category and c.costDivision=r.companyID LEFT JOIN canteen_line a ON c.reference =a.reference where r.user_name='$username' and c.status='1' and c.approvedStatus BETWEEN 0 and 7 GROUP BY c.id");

        
            while($requisition_data = $sql_requisition_depart_approve_log->fetch_assoc()){

                 $costcenterid = $requisition_data['costDivision'];

                 $costsql = $db->query("SELECT * from company_library where companymdm ='$costcenterid'");

                  $costsql_r = $costsql->fetch_assoc();


                $refid = $requisition_data['reference'];

                $sql_item_list = $db->query("SELECT GROUP_CONCAT(DISTINCT ItemName SEPARATOR ', ') AS itemname FROM canteen_line WHERE reference = '$refid'");
                  
                $itemdata = $sql_item_list->fetch_assoc();


            ?>
                <tr>
                 <td><center><?php echo $requisition_data['reference']; ?></center></td>
            
                <td><center><?php echo $requisition_data['requesterName']; ?></center></td>
                <td><center><?php echo $requisition_data['requesterID']; ?></center></td>
                <td><center><?php echo $requisition_data['designation']; ?></center></td>
                <td><center><?php echo $requisition_data['department']; ?></center></td>
                <td><center><?php echo $costsql_r['company_name']; ?></center></td>
                <td><center><?php echo $requisition_data['PurchaseFor']; ?>               
                </center></td>
                <td><center><?php echo $requisition_data['ruqest_date']; ?></center></td>
                
                <td><center><?php echo $itemdata ['itemname']; ?></center></td>

                <td><center>
                        
                          <?php if($requisition_data['approvedStatus'] == '0') {
                                    echo "Waiting for Admin Approval";
                                } elseif($requisition_data['approvedStatus'] == '1'){
                                    echo "Waiting for HR Head/Admin Head Approval";
                                }  elseif($requisition_data['approvedStatus'] == '2'){
                                    echo "Waiting for Price Update";
                                }  elseif($requisition_data['approvedStatus'] == '3'){
                                    echo "Waiting for Boss Approval";
                                } elseif($requisition_data['approvedStatus'] == '4'){
                                    echo "Waiting for HR Head/Admin Head(Bill Approval)";
                                } elseif($requisition_data['approvedStatus'] == '5'){
                                    echo "Waiting for Internal Audit Approval";
                                } elseif($requisition_data['approvedStatus'] == '6'){
                                    echo "Internal Audit Bill Pass";
                                } elseif($requisition_data['approvedStatus'] == '7'){
                                    echo "Waiting for Admin Approval for the Bill";
                                } elseif($requisition_data['approvedStatus'] == '9'){
                                    echo "Rejected from ".$requisition_data['rejectUser'];
                                } 

                    ?> </center></td>

                <!-- <td><center><a href="viewaproved.php?view_id=</?php echo md5($requisition_data['id']); ?>" class="btn btn-primary btn-sm">VIEW</a> -->

            <!-- 
                </center>
                </td> -->
                
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