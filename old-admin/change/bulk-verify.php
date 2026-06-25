<?php 
include('header.php');



?>



<!-- END NAVBAR -->
            <!-- MAIN CONTENT -->
             <div class="main-content">
                <div class="container-fluid">
                    
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Awaiting verification for bulk requisition</h3>
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
                                        <th><center>Name </center></th>
                                        <th><center>ID</center></th>
                                        <th><center>Department</center></th>
                                        <!--<th><center>Photo</center></th>-->
                                        <th><center>Cost-Center</center></th>
                                        <th><center>Apply Date</center></th>
                                       <!--  <th><center>Status</center></th> -->
                                        <th><center>Action</center></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                               
                                 
                                    
                                    <?php  

                                    while($requisition_department = $sql_requisition_only_bulk->fetch_assoc()){     
                                     ?>

                                        <tr>
                                         <td><center>
                                            <p style="color: #fff;background-color: #d9534f;border-color: #d43f3a;font-size: 11px; width: 50%;">Bulk</p>
                                            <?php echo $requisition_department['reference']; ?></center></td>
                                    
                                        <td><center><?php echo $requisition_department['emp_name']; ?></center></td>
                                        <td><center><?php echo $requisition_department['employeeID']; ?></center></td>
                                        <td><center><?php echo $requisition_department['department']; ?></center></td>
                                       
                                        <td><center><?php echo $requisition_department['costcenter']; ?></center></td>
                                        
                                        <td><center><?php echo $requisition_department['ruqest_date']; ?></center></td>

                                       <!--  <td><center>Active</center></td> -->

                                        <td><center><a href="bulk_requisition_view.php?view_id=<?php echo md5($requisition_department['id']); ?>" class="btn btn-primary btn-sm">Details</a>


                                              <!--  <button class="btn btn-success btn-sm bulkapproved" requit_id="<?php echo md5($requisition_department['id']); ?>" requitid="<?php echo $requisition_department['id']; ?>" data-toggle="modal" data-target="#blkmyModalbulk<?php echo $requisition_department['id']; ?>" > Verify</button >                                  
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#blkmyModaldepartmentreject<?php echo $requisition_department['id']; ?>">
                                              Reject
                                            </button>  -->


                                        </center>
                                        </td>
                                        
                                      </tr>



                                      <!-- Bulk Modal myModaldepartment approve-->
                                    <div class="modal fade" id="blkmyModalbulk<?php echo $requisition_department['id']; ?>" role="dialog">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                             <div class="modal-header">
                                            <h5 class="modal-title">Verification Code</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>

                                         
                                        <form class="bulkverify">
                                          <div class="modal-body">

                                           <input type="text" name="verifycode" class="form-control" id="verifycode" placeholder="Enter valid verification code" required>

                                          

                                          <input type="hidden" name="hiddenID" value="<?php echo $requisition_department['id']; ?>">
                                             
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary confirm-section">Submit</button>
                                          </div>
                                      </form>
                                        </div>
                                      </div>
                                    </div> 


                                      <!-- Modal myModaldepartmentreject -->
                                    <div class="modal fade" id="blkmyModaldepartmentreject<?php echo $requisition_department['id']; ?>" role="dialog">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title">Write reason for reject</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                        <form class="bulkreject">
                                          <div class="modal-body">

                                            <textarea class="form-control" name="reject" rows="2" placeholder="Write reason for reject" required></textarea>

                                             <input type="hidden" name="hiddenID" value="<?php echo $requisition_department['id']; ?>">
                                              <input type="hidden" name="stage" value="IT Verification">

                                               <input type="hidden" name="ename" value="<?php echo $requisition_department['emp_name']; ?>">

                                               <input type="hidden" name="sendEmail" value="<?php echo $requisition_department['email']; ?>">

                                               <input type="hidden" name="referencen" value="<?php echo $requisition_department['reference']; ?>">

                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                          </div>
                                      </form>
                                        </div>
                                      </div>
                                    </div>


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