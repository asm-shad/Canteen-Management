<?php 
include('header.php');

$cls_meassage = new cls_meassage();

$sql_requisition_statuss = $cls_meassage->sql_requisition_status($username);


?>



<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
<div class="container-fluid">
    
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title"> All Requisition List With Current Status</h3>
        <!--   <p class="panel-subtitle">
            
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
                        <th><center>Reference </center></th>
                        <th><center>Name </center></th>
                        <th><center>Department</center></th>
                        <th><center>Section</center></th>
                        <th><center>Company</center></th>
                        <th><center>Apply Date</center></th>
                        <th><center>Status</center></th>
                        <th><center>Action</center></th>
                        
                    </tr>
                </thead>
                <tbody>
               

                    <?php

                
                    while($reqdata = $sql_requisition_statuss->fetch_assoc()){                                  
                                          ?>
                        <tr>
                        <td><center><?php echo $reqdata['reference']; ?></center></td>
                    
                        <td><center><?php echo $reqdata['requesterName']; ?></center></td>
                      
                        <td><center><?php echo $reqdata['department']; ?></center></td>
                        <td><center><?php echo $reqdata['section']; ?></center></td>
                                                             
                       
                        <td><center><?php echo $reqdata['company']; ?></center></td>
                        
                        <td><center><?php echo $reqdata['ruqest_date']; ?></center></td>

                        <td><center>
                                 <?php if($reqdata['approvedStatus'] == '0') {
                                    echo "Waiting for Admin Approval";
                                } elseif($reqdata['approvedStatus'] == '1'){
                                    echo "Waiting for HR Head/Admin Head Approval";
                                }  elseif($reqdata['approvedStatus'] == '2'){
                                    echo "Waiting for Price Update";
                                }  elseif($reqdata['approvedStatus'] == '3'){
                                    echo "Waiting for Boss Approval";
                                } elseif($reqdata['approvedStatus'] == '4'){
                                    echo "Waiting for HR Head/Admin Head(Bill Approval)";
                                } elseif($reqdata['approvedStatus'] == '5'){
                                    echo "Waiting for Internal Audit Approval";
                                } elseif($reqdata['approvedStatus'] == '6'){
                                    echo "Internal Audit Bill Pass";
                                } elseif($reqdata['approvedStatus'] == '7'){
                                    echo "Waiting for Admin Approval for the Bill";
                                } elseif($reqdata['approvedStatus'] == '9'){
                                    echo "Rejected from ".$reqdata['reject_from'];
                                }                                           
                                   
                                   ?>

                        </center></td>

                        <td><center>
                              <?php if($reqdata['approvedStatus'] == '0') {
                                ?>

                                <a href="storeview.php?req_id=<?php echo md5($reqdata['id']); ?>" class="btn btn-primary btn-sm">View</a>

                                <?php }elseif($reqdata['approvedStatus'] == '9') {
                                ?>

                                <a href="storeview.php?req_id=<?php echo md5($reqdata['id']); ?>" class="btn btn-primary btn-sm">View</a>


                             <?php } elseif($reqdata['approvedStatus'] >= 0 && $reqdata['approvedStatus'] <= 8) { ?>
                                   
                               <!--  <a target="_blank" href="purchase_requisition.php?urlid=<?php echo md5($reqdata['id']); ?>" class="btn btn-secondary btn-sm">Bill Print</a> -->

                               
                           <a href="adminview.php?req_id=<?php echo md5($reqdata['id']); ?>" class="btn btn-primary btn-sm">View</a>

                             <?php 
                                    }
                                ?>

                           </center>
                        </td>
                        
                      </tr>
                    
                    <?php                               
                            } 
                                     
                    ?>







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