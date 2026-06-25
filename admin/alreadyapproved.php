<?php 
include('header.php');





?>



<!-- END NAVBAR -->
            <!-- MAIN CONTENT -->
             <div class="main-content">
                <div class="container-fluid">
                    
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Waiting For Send To PO </h3>
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
                                        <th><center>Reference </center></th>
                                        <th><center>ID</center></th>
                                        <th><center>Name </center></th>
                                        <!-- <th><center>ID</center></th>
                                        <th><center>Designation</center></th> -->
                                        <th><center>Department</center></th>
                                        <th><center>Cost-Center</center></th>
                                        <!--<th><center>Photo</center></th>-->
                                        <th><center>Company</center></th>
                                        <th><center>Apply Date</center></th>
                                        <th><center>Action</center></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                               
                                    
                                    <?php
                                
                                    while($requisition_data = $sql_requisition_approved->fetch_assoc()){

                                    ?>
                                        <tr>
                                        <td><center><?php echo $requisition_data['reference']; ?></center></td>
                                          <td><center><?php echo $requisition_data['employeeID']; ?></center></td>
                                        <td><center><?php echo $requisition_data['emp_name']; ?></center></td>
                                        <td><center><?php echo $requisition_data['department']; ?></center></td>
                                        <td><center><?php echo $requisition_data['section']; ?></center></td>
                                        <td><center><?php echo $requisition_data['costcenter']; ?></center></td>
                                        
                                        <td><center><?php echo $requisition_data['ruqest_date']; ?></center></td>

                                        <td><center>

                                            <a target="_blank" href="purchase_requisition.php?urlid=<?php echo md5($requisition_data['id']); ?>" class="btn btn-secondary btn-sm">Print PR  </a>

                                            <a href="approved-requisition-edit.php?req_id=<?php echo md5($requisition_data['id']); ?>" class="btn btn-info btn-sm">Edit</a>

                                          
                                          <a target="_blank" href="printview.php?view_id=<?php echo md5($requisition_data['id']); ?>&user=<?php echo $userID;?>" class="btn btn-secondary btn-sm"style="width: 98px !important;">Print Requisition</a>

                                         
                                            <button type="button" class="btn btn-success btn-sm pocreate" refn="<?php echo $requisition_data['reference']; ?>">Send to PO</button>

                                        </center>
                                        </td>
                                        
                                      </tr>
                                    
                                    <?php                               
    
                                        } 
                                
                                    while($requisition_bulk_data = $sql_requisition_bulk_approved->fetch_assoc()){

                                    ?>
                                        <tr>
                                        <td><center>
                                            <p style="color: #fff;background-color: #d9534f;border-color: #d43f3a;font-size: 11px; width: 50%;">Bulk</p>

                                            <?php echo $requisition_bulk_data['reference']; ?></center></td>
                                          <td><center><?php echo $requisition_bulk_data['employeeID']; ?></center></td>
                                        <td><center><?php echo $requisition_bulk_data['emp_name']; ?></center></td>
                                        <td><center><?php echo $requisition_bulk_data['department']; ?></center></td>
                                        <td><center><?php echo $requisition_bulk_data['department']; ?></center></td>
                                        <td><center><?php echo $requisition_bulk_data['costcenter']; ?></center></td>
                                        
                                        <td><center><?php echo $requisition_bulk_data['ruqest_date']; ?></center></td>

                                        <td><center>

                                            <a target="_blank" href="purchase_bulk_requisition.php?urlid=<?php echo md5($requisition_bulk_data['id']); ?>" class="btn btn-secondary btn-sm">Print PR  </a>

                                            <a href="requisition-bulk-edit.php?req_id=<?php echo md5($requisition_bulk_data['id']); ?>" class="btn btn-info btn-sm">Edit</a>

                                          
                                          <a href="bulk_requisition.php?view_id=<?php echo md5($requisition_bulk_data['id']); ?>" class="btn btn-secondary btn-sm"style="width: 98px !important;">BulK Requisition</a>

                                         
                                            <button type="button" class="btn btn-success btn-sm pocreate" refn="<?php echo $requisition_bulk_data['reference']; ?>">Send to PO</button>

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