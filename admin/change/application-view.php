<?php 

//error_reporting(0);

include('header.php');

$requestid = $_GET['view_id'];

 $sql_application_q = $db->query("select * from tbl_application where md5(id)='$requestid'");
    
$app_data = $sql_application_q->fetch_assoc();



$depart = $app_data['costdepartment'];


 $sql_department = $db->query("select * from tbl_mdm_code where department_name='$depart'");



  $sql_zohomail = $db->query("select * from tbl_zohomail where md5(ap_id)='$requestid'");

  $sql_zohomail_mdm = $db->query("select * from tbl_zohomail where md5(ap_id)='$requestid' and status='1'");

  $mdm_data = $sql_zohomail_mdm->fetch_assoc();

  $sql_accessories = $db->query("select * from tbl_application_line where md5(app_id)='$requestid'");

    $sql_zohomail_id = $db->query("select * from tbl_zohomail where md5(ap_id)='$requestid' and status='1'");

     $checkid = $sql_zohomail_id->fetch_assoc();


?>



<!-- END NAVBAR -->
            <!-- MAIN CONTENT -->
             <div class="main-content">
                <div class="container-fluid">

                
                    
                    <div class="panel panel-headline">
                        <table >
                        <tr>
                             <td><a href="approve-application.php" class="btn btn-defualt btn-sm">Back</a> </td>
                            <td style="padding-left: 30px;">

                            <?php if(!empty($checkid['ap_id'])) { ?>

                                   <?php if(!empty($checkid['mdm_code'])) { ?>

                                 <?php if ($tokenn==$token) { ?>


                               <button class="btn btn-success btn-sm appapprovedSession" requitid="<?php echo $app_data['id']; ?>" refcod="<?php echo $app_data['refcode']; ?>" verify_code="<?php echo $verifycode; ?>" data-toggle="modal" data-target="#myModalapplication<?php echo $app_data['id']; ?>" >Approve </button >

                                 <?php } else{ ?>


                                      <button class="btn btn-success btn-sm appapproved" requitid="<?php echo $app_data['id']; ?>" refcod="<?php echo $app_data['refcode']; ?>" toekndata="<?php echo $tokenn; ?>" data-toggle="modal" data-target="#myModalapplication<?php echo $app_data['id']; ?>" >Approve </button >

                                    <?php } ?>

                                <?php }else{ ?>

                                   <button class="btn btn-success btn-sm viewmdmcheck" refid="<?php echo $app_data['id']; ?>"  refcod="<?php echo $app_data['refcode']; ?>" mdid="<?php echo md5($app_data['id']); ?>" >Approve </button >


                                <?php } ?>


                             <?php }else{ ?>

                                 <?php if ($tokenn==$token) { ?>

                              <button class="btn btn-success btn-sm appapprovedSession" requitid="<?php echo $app_data['id']; ?>" refcod="<?php echo $app_data['refcode']; ?>" verify_code="<?php echo $verifycode; ?>" data-toggle="modal" data-target="#myModalapplication<?php echo $app_data['id']; ?>" >Approve </button >

                               <?php } else{ ?>

                                 <button class="btn btn-success btn-sm appapproved" requitid="<?php echo $app_data['id']; ?>" refcod="<?php echo $app_data['refcode']; ?>" toekndata="<?php echo $tokenn; ?>" data-toggle="modal" data-target="#myModalapplication<?php echo $app_data['id']; ?>" >Approve</button >

                                  <?php } ?>

                             <?php } ?>

                        </td>
                        <td style="padding-left: 30px;">

                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModalapplicationreject<?php echo $app_data['id']; ?>">
                             Reject
                            </button> 

                        </td>
                        </tr>
                        </table>

                        <div class="panel-heading">

                            <h3 class="panel-title">

                            </h3>
                          <!--  <p class="panel-subtitle">
                              
                            </p> -->
                         <fieldset style="border: 1px solid #B7B7B7; border-radius:5px; margin-bottom:10px; padding-left: 5px;">

                            <legend style="border: 1px solid #B7B7B7; padding: 5px; border-radius:5px; font-weight: bold; padding: 5px; margin: 15px; color:black;width: 400px;">Application # <?php echo $app_data['refcode']; ?></legend>

                            <table  border="0" id="tbl_1" class="no_border" align="left" style="width: 320px; margin-right:50px">

                                <tr>
                                    <th height="25">Date</th>
                                    <td style="width:20px;height: 25px;">:</td>
                                    <td height="25"><?php echo $app_data['ruqest_date']; ?></td>
                                </tr>
                                <tr>
                                    <th height="25">Reference No</th>
                                    <td height="25">:</td>
                                    <td height="25"><?php echo $app_data['refcode']; ?></td>
                                </tr>
                                <tr>
                                    <th height="25">Cost Center</th>
                                    <td height="25">:</td>
                                    <td height="25"><?php echo $app_data['costcenter']; ?></td>
                                </tr>
                                <tr>
                                    <th height="25">Cost Depart</th>
                                    <td height="25">:</td>
                                    <td height="25"><?php echo $app_data['costdepartment']; ?></td>
                                </tr>

                                <tr>
                                    <th height="25">Email</th>
                                    <td height="25">:</td>
                                    <td height="25"><?php echo $app_data['email']; ?></td>
                                </tr>
                                 <tr>
                                    <th height="25">MDM Code</th>
                                    <td height="25">:</td>
                                    <td height="25"><span style="color:green;font-weight: bold;"><?php  echo $mdm_data['mdm_code']; ?></span></td>
                                </tr>

                          </table>


                            <table  border="0" id="tbl_1" class="no_border" align="left" style="width: 320px; margin-right:50px">

                                <tr>
                                    <th height="25">Name</th>
                                    <td style="width:20px;height: 25px;">:</td>
                                    <td height="25"><?php echo $app_data['emp_name']; ?></td>
                                </tr>
                                <tr>
                                    <th height="25">Employee ID</th>
                                    <td height="25">:</td>
                                    <td height="25"><?php echo $app_data['employeeID']; ?></td>
                                </tr>
                                <tr>
                                    <th height="25">Designation</th>
                                    <td height="25">:</td>
                                    <td height="25"><?php echo $app_data['designation']; ?></td>
                                </tr>
                                <tr>
                                    <th height="25">Department</th>
                                    <td height="25">:</td>
                                    <td height="25"><?php echo $app_data['department']; ?></td>
                                </tr>
                                <tr>
                                    <th height="25">User Section</th>
                                    <td height="25">:</td>
                                    <td height="25"><?php echo $app_data['section']; ?></td>
                                </tr>
                                 <tr>
                                    <th height="25">Contact Number</th>
                                    <td height="25">:</td>
                                    <td height="25"><?php echo $app_data['contact_number']; ?></td>
                                </tr>

                          </table>

                            <table  border="0" id="tbl_1" class="no_border" align="right" style="width: 120px; margin-right:30px">

                                <tr>

                                    <?php if(!empty($checkid['ap_id'])) { ?>

                                        <?php if(!empty($checkid['mdm_code'])) { ?>

                                    <th height="25">    <a type="button" class="btn btn-secondary" data-toggle="modal" data-target="#myModalmdmedit<?php echo $mdm_data['id']; ?>"  style="color:#fff;"> Edit MDM</a></th>


                                       <!-- Modal Edit MDM code-->
                                    <div class="modal fade" id="myModalmdmedit<?php echo $mdm_data['id']; ?>" role="dialog">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title"><?php echo  $mdm_data['refc_id']; ?></h5>
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

                                                 <select class="form-control" id="mdmcode" name="mdmcode" required>
                                              <option value="" >Select MDM Code</option>
                                                    <?php

                                                         while($mdm_cd = $sql_department->fetch_assoc()){ 

                                                            $mdm_cd_n = $mdm_cd['mdm_full_name'];

                                                            ?>
                                        <option  <?php if($mdm_cd_n== $app_data['subsection']) { ?> selected <?php } ?> value="<?php echo $mdm_cd['mdm_code']; ?>">


                                                   <?php echo $mdm_cd['mdm_full_name']; ?> (<?php echo $mdm_cd['mdm_code']; ?>)
                                                        

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


                                     <?php }else{ ?>

                                          <th height="25">    <a type="button" class="btn btn-secondary" data-toggle="modal" data-target="#myModalmdm<?php echo $mdm_data['id']; ?>"  style="color:#fff;"> Add MDM</a></th>

                                          <?php } ?>

                                     <?php }else{ ?>

                                           <th height="25"> </th>

                                     <?php } ?>
                                    
                                </tr>
                            </table>

                        </fieldset>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">

                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th><center>SL </center></th>
                                        <th><center>App Name</center></th> 
                                        <th><center>Status</center></th> 
                                        <th><center>Action</center></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>

                                  <?php

                                    $ii =1; 

                                    while($item_zohomail = $sql_zohomail->fetch_assoc()){

                                    ?>
                                        <tr>
                                    <td><center><?php echo $ii++; ?></center></td>
                                        <td><center><?php echo $item_zohomail['mail_type']; ?></center></td>
                                       
                                        <td><center>
                                             <?php if ($item_zohomail['status'] == '2') {
                                            echo "Declined";
                                        }else{
                                            echo "Active";
                                        }      

                                         ?></center></td>

                                        <td><center>



                                         <!--     <button type="button" class="btn btn-primary btn-sm e" data-toggle="modal" data-target="#myModalmdm<?php echo $item_zohomail['id']; ?>"  style="width: 100px !important;"> Add MDM code</button> -->



                                              <?php if ($item_zohomail['status'] == '2') { ?>

                                                <button class="btn btn-info btn-sm canceldeclinedmail" style="width: 100px !important;" mailcancelid="<?php echo $item_zohomail['id']; ?>">Cancel Declined</button>

                                              <?php }else {?>
                                                <button type="button" class="btn btn-danger btn-sm declinedmail" style="width: 100px !important;" applinemailid="<?php echo $item_zohomail['id']; ?>">Declined</button>

                                                 <?php }?>

                                        </center>
                                        </td>
                                        
                                      </tr>

                                    
                                    <?php                               
                                            } 

                                    ?>
                                    

                                    <?php

                                    $i =1; 

                                    while($item_data = $sql_accessories->fetch_assoc()){

                                    ?>
                                        <tr>
                                    <td><center><?php echo $i++; ?></center></td>
                                        <td><center><?php echo $item_data['app_name']; ?></center></td>
                                       
                                        <td><center>
                                             <?php if ($item_data['status'] == '2') {
                                            echo "Declined";
                                        }else{
                                            echo "Active";
                                        }      

                                         ?></center></td>

                                        <td><center>

                                            <!--  <button type="button" class="btn btn-primary btn-sm e" data-toggle="modal" data-target="#myModalapp</?php echo $item_data['id']; ?>">Edit</button>               -->                              

                                              <?php if ($item_data['status'] == '2') { ?>

                                                <button class="btn btn-info btn-sm canceldeclined" style="width: 100px !important;" cancelid="<?php echo $item_data['id']; ?>">Cancel Declined</button>

                                              <?php }else {?>
                                                <button type="button" class="btn btn-danger btn-sm declinedapp" style="width: 100px !important;" applineid="<?php echo $item_data['id']; ?>">Declined</button>

                                                 <?php }?>

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

                                
                                 <!-- Modal add MDM  add code-->
                                    <div class="modal fade" id="myModalmdm<?php echo $mdm_data['id']; ?>" role="dialog">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title"><?php echo  $mdm_data['refc_id']; ?> </h5>
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

                                            <select class="form-control" id="mdmcode" name="mdmcode" required>
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


               <!-- Modal myModalapplication approve-->
            <div class="modal fade" id="myModalapplication<?php echo $app_data['id']; ?>" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                     <div class="modal-header">
                    <h5 class="modal-title">Verification Code</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
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
                                    

			
<?php 


                         echo ('<SCRIPT LANGUAGE="JavaScript">

                            $("#myModalapplication'.$app_data['id'].'").on("hidden.bs.modal", function () {
                            
                            window.location = window.location.href;

                            }); </SCRIPT>'); 


include('footer.php'); ?>