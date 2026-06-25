<?php 
include('header.php');


$cls_meassage = new cls_meassage();

$sql_application_approved = $cls_meassage->all_application_list();





?>



<!-- END NAVBAR -->
            <!-- MAIN CONTENT -->
             <div class="main-content">
                <div class="container-fluid">
                    
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">All Application Requisition List With Current Status</h3>
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
                                         <!--  <th><center>Designation</center></th> -->
                                        <th><center>Department</center></th>
                                        <th><center>Cost-Center</center></th>
                                        <!--<th><center>Photo</center></th>-->
                                        <th><center>Comapny</center></th>
                                        <th><center>Apply Date</center></th>
                                        <th><center>Status</center></th>
                                        <th><center>Action</center></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                               
                                    
                                    <?php


                                
                                    while($app_data = $sql_application_approved->fetch_assoc()){

                                         


                                          

                                    ?>
                                        <tr>
                                        <td><center><?php echo $app_data['refcode']; ?></center></td>
                                        <td><center><?php echo $app_data['employeeID']; ?></center></td>
                                        <td><center><?php echo $app_data['emp_name']; ?></center></td>
                                        <!-- 
                                        <td><center><?php echo $app_data['designation']; ?></center></td> -->
                                        <td><center><?php echo $app_data['department']; ?></center></td>
                                        <td><center><?php echo $app_data['section']; ?></center></td>
                                        <!--<td><center><img src="../upload/</?php echo $messageview['certificate']; ?>" height="50" width="100">
                                        
                                        </center></td>-->
                                        <td><center><?php echo $app_data['costcenter']; ?></center></td>
                                        
                                        <td><center><?php echo $app_data['ruqest_date']; ?></center></td>

                                        <td><center>
                                            
                                            <?php if($app_data['approved_status'] == '0') {
                                                    echo "Waiting for Approval";
                                                } elseif($app_data['approved_status'] == '2'){
                                                    echo "Approved";
                                                }
                                                elseif($app_data['approved_status'] == '5'){
                                                    echo "Rejected";
                                                }

                                                ?>
                                        </center></td>

                                        <td><center>

                                            <a href="applicationview-data.php?urlid=<?php echo md5($app_data['id']); ?>" class="btn btn-primary btn-sm">View </a>

                                          <!--   <button class="btn btn-success btn-sm crcapex">Done</button> -->


                                           
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