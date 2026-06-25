<?php 
include('header.php');



?>



<!-- END NAVBAR -->
            <!-- MAIN CONTENT -->
             <div class="main-content">
                <div class="container-fluid">
                    
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Waiting Department Approval</h3>
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
                                        <th><center>Designation</center></th>
                                        <th><center>Department</center></th>
                                        <th><center>Section</center></th>
                                        <!--<th><center>Photo</center></th>-->
                                        <th><center>Cost-Center</center></th>
                                        <th><center>Request Date</center></th>
                                         <th><center>Item Name</center></th>
                                        <th><center>Action</center></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                               
                                    
                                    <?php


                                
                                    while($requisition_data = $sql_requisition->fetch_assoc()){

                                         // $costcenterid = $requisition_data['costcenter'];

                                         // $costsql = $db->query("SELECT * FROM mrd_library WHERE LibraryName='company' and Description='$costcenterid'");

                                         //  $costsql_r = $costsql->fetch_assoc();

                                         $refid = $requisition_data['reference'];

                                        $sql_item_list = $db->query("SELECT GROUP_CONCAT(DISTINCT accessories SEPARATOR ', ') AS itemname FROM tbl_accessories WHERE reference_id = '$refid'");
                                          
                                        $itemdata = $sql_item_list->fetch_assoc();

                                          

                                    ?>
                                        <tr>
                                         <td><?php echo $requisition_data['reference']; ?></td>
                                    
                                        <td><?php echo $requisition_data['emp_name']; ?></td>
                                        <td><?php echo $requisition_data['employeeID']; ?></td>
                                        <td><?php echo $requisition_data['designation']; ?></td>
                                        <td><?php echo $requisition_data['department']; ?></td>
                                        <td><?php echo $requisition_data['section']; ?></td>
                                       
                                        <td><?php echo $requisition_data['costcenter']; ?></td>
                                        
                                        <td><?php echo $requisition_data['ruqest_date']; ?></td>

                                       <td><?php echo $itemdata ['itemname']; ?></td>


                                        <td><center>

                                            <table>
                                                <tr>
                                                <td colspan="2" style="text-align: center;padding-bottom: 2px;">
                                          <a href="departviewaproved.php?view_id=<?php echo md5($requisition_data['id']); ?>" class="btn btn-primary btn-sm">VIEW</a>

                                                    </td>
                                                </tr>
                                                <tr>
                                                
                                                 <?php if ($tokenn==$token) { ?>

                                                <td style="padding-right: 2px;"> 
                                               <button class="btn btn-success btn-sm deprtheadSession" verify_code="<?php echo $verifycode; ?>" requitid="<?php echo $requisition_data['id']; ?>" data-toggle="modal" data-target="#myModaldepartment<?php echo $requisition_data['id']; ?>" >Approve</button >
                                                  </td>

                                              <?php } else{ ?>

                                                  <td style="padding-right: 2px;"> 
                                               <button class="btn btn-success btn-sm deprtheadapproved" requit_id="<?php echo md5($requisition_data['id']); ?>" requitid="<?php echo $requisition_data['id']; ?>" toekndata="<?php echo $tokenn; ?>" data-toggle="modal" data-target="#myModaldepartment<?php echo $requisition_data['id']; ?>" >Approve</button >
                                                  </td>


                                              <?php } ?>

                                            <td>

                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModaldepartmentreject<?php echo $requisition_data['id']; ?>">
                                              Reject
                                            </button> 

                                            </td>
                                          </tr>
                                      </table>

                                        </center>
                                        </td>
                                        
                                      </tr>

                                      

                                       <!-- Modal myModaldepartment approve-->
                                    <div class="modal fade" id="myModaldepartment<?php echo $requisition_data['id']; ?>" role="dialog">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                             <div class="modal-header">
                                            <h5 class="modal-title">Verification Code</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h5>Please check email for OTP</h5>
                                            <div class="errorr-meassage"> </div>
                                          </div>

                                         
                                        <form class="departverify">
                                          <div class="modal-body">

                                           <input type="text" name="verifycode" class="form-control" id="verifycode" placeholder="Enter valid verification code" required>

                                          

                                          <input type="hidden" name="hiddenID" value="<?php echo $requisition_data['id']; ?>">
                                             
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
                                    <div class="modal fade" id="myModaldepartmentreject<?php echo $requisition_data['id']; ?>" role="dialog">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title">Write reason for reject</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                        <form class="itreject">
                                          <div class="modal-body">

                                            <textarea class="form-control" name="reject" rows="2" placeholder="Write reason for reject" required></textarea>

                                             <input type="hidden" name="hiddenID" value="<?php echo $requisition_data['id']; ?>">
                                              <input type="hidden" name="stage" value="Department">

                                               <input type="hidden" name="ename" value="<?php echo $requisition_data['emp_name']; ?>">

                                               <input type="hidden" name="sendEmail" value="<?php echo $requisition_data['email']; ?>">

                                               <input type="hidden" name="referencen" value="<?php echo $requisition_data['reference']; ?>">

                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                          </div>
                                      </form>
                                        </div>
                                      </div>
                                    </div>


                          <?php                               

                            echo ('<SCRIPT LANGUAGE="JavaScript">

                                $("#myModaldepartment'.$requisition_data['id'].'").on("hidden.bs.modal", function () {
                                
                                window.location = window.location.href;

                                }); </SCRIPT>');                             

                                        } 

                                    while($requisition_department = $sql_requisition_only_department->fetch_assoc()){ 

                                        $drefid = $requisition_department['reference'];

                                        $sql_derpt_item_list = $db->query("SELECT GROUP_CONCAT(DISTINCT accessories SEPARATOR ', ') AS itemlist FROM tbl_accessories WHERE reference_id = '$drefid'");
                                          
                                        $deprtitemdata = $sql_derpt_item_list->fetch_assoc();



                                     ?>

                                        <tr>
                                         <td>
                                            <p style="color: #fff;background-color: #d9534f;border-color: #d43f3a;font-size: 11px; width: 50%;text-align: center;">Bulk</p>
                                            <?php echo $requisition_department['reference']; ?></td>
                                    
                                        <td><?php echo $requisition_department['emp_name']; ?></td>
                                        <td><?php echo $requisition_department['employeeID']; ?></td>
                                        <td>Department Requisition</td>
                                        <td><?php echo $requisition_department['department']; ?></td>
                                        <td> Department Requisition </td>
                                       
                                        <td><?php echo $requisition_department['costcenter']; ?></td>
                                        
                                        <td><?php echo $requisition_department['ruqest_date']; ?></td>

                                        <td><?php echo $deprtitemdata ['itemlist']; ?></td>

                                        <td><center>

                                        <table>
                                            <tr>
                                            <td colspan="2" style="text-align: center;padding-bottom: 2px;">

                                              <a href="depart_requisition.php?view_id=<?php echo md5($requisition_department['id']); ?>" class="btn btn-primary btn-sm">VIEW</a>

                                                    </td>
                                                </tr>
                                                <tr>
                                          <?php if ($tokenn==$token) { ?>
                                               
                                                <td style="padding-right: 2px;"> 
                                               <button class="btn btn-success btn-sm deprtheadbulkSession" verify_code="<?php echo $verifycode; ?>" blkrequitid="<?php echo $requisition_department['id']; ?>" data-toggle="modal" data-target="#blkmyModaldepartment<?php echo $requisition_department['id']; ?>" >Approve</button >
                                                    
                                                </td>
                                            <?php } else{ ?>

                                                 <td style="padding-right: 2px;"> 
                                               <button class="btn btn-success btn-sm deprtheadapprovedbulk" blkrequit_id="<?php echo md5($requisition_department['id']); ?>" blkrequitid="<?php echo $requisition_department['id']; ?>" toekndata="<?php echo $tokenn; ?>" data-toggle="modal" data-target="#blkmyModaldepartment<?php echo $requisition_department['id']; ?>" >Approve</button >
                                                    
                                                </td>

                                            <?php } ?>

                                                    <td>
                                           
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#blkmyModaldepartmentreject<?php echo $requisition_department['id']; ?>">
                                              Reject
                                            </button> 

                                                  </td>
                                                </tr>
                                            </table>
                                            
                                        </center>
                                        </td>
                                        
                                      </tr>



                                      <!-- Bulk Modal myModaldepartment approve-->
                                    <div class="modal fade" id="blkmyModaldepartment<?php echo $requisition_department['id']; ?>" role="dialog">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                             <div class="modal-header">
                                            <h5 class="modal-title">Verification Code</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>

                                         
                                        <form class="departverify">
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
                                        <form class="itreject">
                                          <div class="modal-body">

                                            <textarea class="form-control" name="reject" rows="2" placeholder="Write reason for reject" required></textarea>

                                             <input type="hidden" name="hiddenID" value="<?php echo $requisition_department['id']; ?>">
                                              <input type="hidden" name="stage" value="Department">

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


                         <?php 


                              echo ('<SCRIPT LANGUAGE="JavaScript">

                                $("#blkmyModaldepartment'.$requisition_department['id'].'").on("hidden.bs.modal", function () {
                                
                                window.location = window.location.href;

                                }); </SCRIPT>'); 


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