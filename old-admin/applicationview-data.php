<?php 

error_reporting(0);

include('header.php');

$requestid = $_GET['urlid'];

 $sql_application_q = $db->query("select * from tbl_application where md5(id)='$requestid'");
    
 $app_data = $sql_application_q->fetch_assoc();

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
                        <div class="panel-heading">
                            <h3 class="panel-title"><a href="applicationstatus.php" class="btn btn-defualt btn-sm">Back</a> 
                            </h3>

                               
                         <fieldset style="border: 1px solid #B7B7B7; border-radius:5px; margin-bottom:10px; padding-left: 5px;">

                            <legend style="border: 1px solid #B7B7B7; padding: 5px; border-radius:5px; font-weight: bold; padding: 5px; margin: 15px; color:black;width: 400px;">Application # <?php echo $app_data['refcode']; ?></legend>

                            <table  border="0" id="tbl_1" class="no_border" align="left" style="width: 320px; margin-right:100px">

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
                                    <th height="25">company</th>
                                    <td height="25">:</td>
                                    <td height="25"><?php echo $app_data['costcenter']; ?></td>
                                </tr>

                                <tr>
                                    <th height="25">Cost Center</th>
                                    <td height="25">:</td>
                                    <td height="25"><?php echo $app_data['section']; ?></td>
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


                            <table  border="0" id="tbl_1" class="no_border" align="left" style="width: 320px; margin-right:100px">

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
                                            <h5 class="modal-title"><?php echo  $mdm_data['refc_id']; ?></h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          </div>
                                        <form class="addMDM">
                                          <div class="modal-body">                     
                                          
                                             <div class="form-group">
                                                <label for="itemname" class="col-sm-3 col-form-label">MDM code </label>
                                                <div class="col-sm-9">

                                                <input class="form-control" name="mdmcode" id="mdmcode" autofocus="off"  value="<?php echo $mdm_data['mdm_code']; ?>">                                
                                            </div>


                                             <input type="hidden" name="hiddenID" value="<?php echo $mdm_data['id']; ?>">
                                             <br><br>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success">Save</button>
                                          </div>
                                      </form>
                                        </div>
                                      </div>
                                    </div>

                                    

			
<?php include('footer.php'); ?>