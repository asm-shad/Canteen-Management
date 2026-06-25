<?php 
include('header.php');



?>



<!-- END NAVBAR -->
            <!-- MAIN CONTENT -->
             <div class="main-content">
                <div class="container-fluid">
                    
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Waiting Application Approval</h3>
                        
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
                                        <th><center>Company</center></th>
                                      <!--   <th><center>Apply Date</center></th> -->
                                       <!--  <th><center>Status</center></th> -->
                                        <th><center>Action</center></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                               
                                    
                              <?php
                                
                                    while($app_data = $sql_application->fetch_assoc()){

                                     $appid = $app_data['id'];

                                     $depart = $app_data['department'];

                                     $sql_department = $db->query("select * from tbl_mdm_code where department_name='$depart'");

                                     $sql_department_mdm = $db->query("select * from tbl_mdm_code where department_name='$depart'");

                                      $sql_zohomail_id = $db->query("select * from tbl_zohomail where ap_id='$appid' and status='1'");

                                      $checkid = $sql_zohomail_id->fetch_assoc();
                
                                  ?>
                                        <tr>
                                         <td><center><?php echo $app_data['refcode']; ?></center></td>
                                    
                                        <td><center><?php echo $app_data['emp_name']; ?></center></td>
                                        <td><center><?php echo $app_data['employeeID']; ?></center></td>
                                        <td><center><?php echo $app_data['designation']; ?></center></td>
                                        <td><center><?php echo $app_data['department']; ?></center></td>
                                        <td><center><?php echo $app_data['section']; ?></center></td>

                                        <td><center><?php echo $app_data['costcenter']; ?></center></td>
                                        
                                       <!--  <td><center><?php echo $app_data['ruqest_date']; ?></center></td> -->

                                       <!--  <td><center>Active</center></td> -->

                                        <td><center><a href="application-view.php?view_id=<?php echo md5($app_data['id']); ?>" class="btn btn-primary btn-sm">VIEW</a>

                                         <?php if(!empty($checkid['ap_id'])) { ?>

                                           <?php if(!empty($checkid['mdm_code'])) { ?>

                                     <?php if ($tokenn==$token) { ?>

                                       <button class="btn btn-success btn-sm appapprovedSession" requitid="<?php echo $app_data['id']; ?>" refcod="<?php echo $app_data['refcode']; ?>" verify_code="<?php echo $verifycode; ?>" data-toggle="modal" data-target="#myModalapplication<?php echo $app_data['id']; ?>" >Approve <?php echo $tokenn; ?></button >

                                       <?php } else{ ?>

                                        <button class="btn btn-success btn-sm appapproved" requitid="<?php echo $app_data['id']; ?>" refcod="<?php echo $app_data['refcode']; ?>" toekndata="<?php echo $tokenn; ?>" data-toggle="modal" data-target="#myModalapplication<?php echo $app_data['id']; ?>" >Approve </button >

                                        <?php } ?>



                                       <a type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#myModalmdmedit<?php echo $app_data['id']; ?>"  style="color:#fff;"> Edit MDM</a>



                                        <?php }else{ ?>

                                           <button class="btn btn-success btn-sm mdmcheck" refid="<?php echo $app_data['id']; ?>"  refcod="<?php echo $app_data['refcode']; ?>" mdid="<?php echo md5($app_data['id']); ?>" >Approve </button >


                                            <a type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#myModalmdm<?php echo $app_data['id']; ?>"  style="color:#fff;"> Add MDM</a>


                                        <?php } ?>



                                     <?php }else{ ?>

                                     <?php if ($tokenn==$token) { ?>

                                      <button class="btn btn-success btn-sm appapprovedSession" requitid="<?php echo $app_data['id']; ?>" refcod="<?php echo $app_data['refcode']; ?>" verify_code="<?php echo $verifycode; ?>" data-toggle="modal" data-target="#myModalapplication<?php echo $app_data['id']; ?>" >Approve <?php echo $tokenn; ?></button >

                                      <?php } else{ ?>

                                         <button class="btn btn-success btn-sm appapproved" requitid="<?php echo $app_data['id']; ?>" refcod="<?php echo $app_data['refcode']; ?>" toekndata="<?php echo $tokenn; ?>" data-toggle="modal" data-target="#myModalapplication<?php echo $app_data['id']; ?>" >Approve </button >

                                     <?php } ?>

                                     <?php } ?>



                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModalapplicationreject<?php echo $app_data['id']; ?>">
                                         Reject
                                        </button> 


                                        </center>
                                        </td>
                                        
                                      </tr>



                                       <!-- Modal Edit MDM code-->
                                    <div class="modal fade" id="myModalmdmedit<?php echo $app_data['id']; ?>" role="dialog">
                                      <div class="modal-dialog" role="document">

                                     <form class="addMDM">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title"><?php echo  $checkid['refc_id']; ?></h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>

                                            <div class="modal-body">

                                             <div class="form-group">
                                             <label for="itemname" class="col-sm-3 col-form-label">Department </label>
                                                <div class="col-sm-9">                                             
                                                    <input type="text" readonly value="<?php echo $app_data['department']; ?>" class="form-control">
                                            </div>
                                            <br>
                                          </div>

                                          <div class="form-group">
                                             <label for="itemname" class="col-sm-3 col-form-label">Section </label>
                                                <div class="col-sm-9">  
                                             <input type="text" readonly value="<?php echo $app_data['section']; ?>" class="form-control">
                                            </div>
                                            <br>
                                          </div> 

                                          <div class="form-group">
                                             <label for="itemname" class="col-sm-3 col-form-label">Subsection </label>
                                                <div class="col-sm-9">
                                             <input type="text" readonly value="<?php echo $app_data['subsection']; ?>" class="form-control">
                                            </div>
                                            <br>
                                          </div>                     
                                          
                                             <div class="form-group">
                                                <label for="itemname" class="col-sm-3 col-form-label">MDM code </label>
                                                <div class="col-sm-9">

                                                 <select class="form-control" id="mdmcode" name="mdmcode" required>
                                              <option value="" >Select MDM Code</option>
                                                    <?php

                                                         while($mdm_cd_mdm = $sql_department_mdm->fetch_assoc()){ 

                                                            $mdm_cd_nd = $mdm_cd_mdm['mdm_full_name'];

                                                            ?>
                                        <option  <?php if($mdm_cd_nd== $app_data['subsection']) { ?> selected <?php } ?> value="<?php echo $mdm_cd_mdm['mdm_code']; ?>">


                                                   <?php echo $mdm_cd_mdm['mdm_full_name']; ?> (<?php echo $mdm_cd_mdm['mdm_code']; ?>)
                                                        

                                                    </option>


                                               <?php } ?>  

                                               </select>                                  
                                            </div>


                                             <input type="hidden" name="hidID" value="<?php echo $app_data['id']; ?>">
                                             <br>
                                          </div>
                                      </div>

                                         
                                          <div class="modal-footer">
                                            <a type="button" class="btn btn-secondary" data-dismiss="modal">Close</a>
                                            <button type="submit" class="btn btn-secondary" style=" background-color: #6c757d; border-color: #00a0f0;color:#fff; padding: 6px 12px;">Update</button>
                                          </div>

                                           

                                           </form>
                                      
                                        </div>
                                      </div>
                                    </div>
                                

                               


                                       <!-- Modal myModalapplication approve-->
                                    <div class="modal fade" id="myModalapplication<?php echo $app_data['id']; ?>" role="dialog">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                             <div class="modal-header">
                                            <h5 class="modal-title">Verification Code</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                                     <h5>Please check email for OTP</h5>
                                    <div class="errorr-meassage"> </div>
            
                                          </div>

                                         
                                        <form class="appverify">
                                          <div class="modal-body">

                                           <input type="text" name="verifycode" class="form-control" id="verifycode" placeholder="Enter valid verification code" required>

                                          

                                          <input type="hidden" name="hiddenID" value="<?php echo $app_data['id']; ?>">
                                             
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success confirm-section">Submit</button>
                                          </div>
                                      </form>

                                        </div>
                                      </div>
                                    </div> 


                                      <!-- Modal myModalapplicationreject -->
                                    <div class="modal fade" id="myModalapplicationreject<?php echo $app_data['id']; ?>" role="dialog">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title">Write reason for reject</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                        <form class="appreject">
                                          <div class="modal-body">

                                            <textarea class="form-control" name="reject" rows="2" placeholder="Write reason for reject" required></textarea>

                                             <input type="hidden" name="hiddenID" value="<?php echo $app_data['id']; ?>">
                                             

                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                          </div>
                                      </form>
                                        </div>
                                      </div>
                                    </div>


                                     <!-- Modal add MDM  add code-->
                                    <div class="modal fade" id="myModalmdm<?php echo $app_data['id']; ?>" role="dialog">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title"><?php echo  $checkid['refc_id']; ?> </h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                        <form class="addMDM">
                                          <div class="modal-body">  
                                          <div class="form-group">
                                             <label for="itemname" class="col-sm-3 col-form-label">Department </label>
                                                <div class="col-sm-9">                                             
                                                    <input type="text" readonly value="<?php echo $app_data['department']; ?>" class="form-control">
                                            </div>
                                            <br>
                                          </div>

                                          <div class="form-group">
                                             <label for="itemname" class="col-sm-3 col-form-label">Section </label>
                                                <div class="col-sm-9">  
                                             <input type="text" readonly value="<?php echo $app_data['section']; ?>" class="form-control">
                                            </div>
                                            <br>
                                          </div> 

                                          <div class="form-group">
                                             <label for="itemname" class="col-sm-3 col-form-label">Subsection </label>
                                                <div class="col-sm-9">
                                             <input type="text" readonly value="<?php echo $app_data['subsection']; ?>" class="form-control">
                                            </div>
                                            <br>
                                          </div>                    
                                          
                                             <div class="form-group">
                                                <label for="itemname" class="col-sm-3 col-form-label">MDM code </label>
                                                <div class="col-sm-9">

                                            <select class="form-control" name="mdmcode" required>
                                              <option value="">Select MDM Code</option>
                                                    <?php

                                                         while($mdm_cd = $sql_department->fetch_assoc()){ ?>

                                                

                                                 <option value="<?php echo $mdm_cd['mdm_code']; ?>"><?php echo $mdm_cd['mdm_full_name']; ?> (<?php echo $mdm_cd['mdm_code']; ?>)</option>


                                               <?php } ?>  

                                               </select>  

                                            </div>


                                             <input type="hidden" name="hidID" value="<?php echo $app_data['id']; ?>">
                                             <br>
                                          </div>
                                          </div>

                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-secondary" style="background-color: #6c757d; border-color: #00a0f0;color:#fff; padding: 6px 12px;">Save</button>
                                          </div>
                                      </form>
                                        </div>
                                      </div>
                                    </div>






                                    
                  <?php                               

                         echo ('<SCRIPT LANGUAGE="JavaScript">

                            $("#myModalapplication'.$app_data['id'].'").on("hidden.bs.modal", function () {
                            
                            window.location = window.location.href;

                            }); </SCRIPT>'); 


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