<?php 
include('header.php');



?>



<!-- END NAVBAR -->
            <!-- MAIN CONTENT -->
             <div class="main-content">
                <div class="container-fluid">
                    
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Waiting Section Approval</h3>
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
                                        <!-- <th><center>Designation</center></th> -->
                                        <th><center>Department</center></th>
                                        <th><center>Section</center></th>
                                        <!--<th><center>Photo</center></th>-->
                                        <th><center>Company</center></th>
                                       <!--  <th><center>Request Date</center></th> -->
                                        <th><center>Item Name</center></th>
                                        <th><center>Action</center></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                               
                                    
                                    <?php


                                
                                    while($requisition_data = $sql_requisition_section_approve->fetch_assoc()){

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
                                        <td><?php echo $requisition_data['department']; ?></td>
                                        <td><?php echo $requisition_data['section']; ?></td>
                                        
                                        <td><?php echo $requisition_data['costcenter']; ?></td>
                                        
                                       <!--  <td><?php echo $requisition_data['ruqest_date']; ?></td> -->

                                        <td><?php echo $itemdata ['itemname']; ?></td>

                                        <td><center>

                                            <table>
                                                <tr>
                                                <td colspan="2" style="text-align: center;padding-bottom: 2px;">
                                                        <a href="sectionviewaproved.php?view_id=<?php echo md5($requisition_data['id']); ?>" class="btn btn-primary btn-sm">VIEW</a> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                <?php if ($tokenn==$token) { ?>
                                                 <td style="padding-right: 2px;"> 
                                                        <button class="btn btn-success btn-sm approvedSession" verify_code="<?php echo $verifycode; ?>" requitid="<?php echo $requisition_data['id']; ?>" data-toggle="modal" data-target="#myModalsection<?php echo $requisition_data['id']; ?>" >Approve</button>
                                                    </td>

                                                  <?php  }else{ ?>

                                                      <td style="padding-right: 2px;"> 
                                                        <button class="btn btn-success btn-sm approvedID" requit_id="<?php echo md5($requisition_data['id']); ?>" requitid="<?php echo $requisition_data['id']; ?>" toekndata="<?php echo $tokenn; ?>" data-toggle="modal" data-target="#myModalsection<?php echo $requisition_data['id']; ?>" >Approve</button>
                                                    </td>

                                                      <?php }  ?>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModalsectionreject<?php echo $requisition_data['id']; ?>">
                                                        Reject
                                                        </button> 
                                                    </td>
                                                </tr>
                                            </table>

                                            </center>
                                       
                                        </td>
                                        
                                      </tr>


                                      
                                       <!-- Modal myModalsection approve-->
                                    <div class="modal fade" id="myModalsection<?php echo $requisition_data['id']; ?>" role="dialog">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                             <div class="modal-header">
                                            <h5 class="modal-title">Verification Code</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                             <h5>Please check email for OTP</h5>
                                            <div class="errorr-meassage"> </div>
                                          </div>

                                         
                                        <form class="verify">
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


                                      <!-- Modal myModalsectionreject -->
                                    <div class="modal fade" id="myModalsectionreject<?php echo $requisition_data['id']; ?>" role="dialog">
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
                                              <input type="hidden" name="stage" value="Section">

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

        $("#myModalsection'.$requisition_data['id'].'").on("hidden.bs.modal", function () {
        
        window.location = window.location.href;

        }); </SCRIPT>');
        
        }   ?>


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