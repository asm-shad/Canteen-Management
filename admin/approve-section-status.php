<?php 
include('header.php');





?>



<!-- END NAVBAR -->
            <!-- MAIN CONTENT -->
             <div class="main-content">
                <div class="container-fluid">
                    
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Section Approved List</h3>
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
                                        <th><center>Request Date</center></th>
                                        <!-- <th><center>Status</center></th> -->
                                        <th><center>Action</center></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                               
                                    
                                    <?php



                              $sql_requisition_section_approve_log = $db->query("SELECT c.id, c.reference, c.employeeID, c.emp_name, c.designation, c.department, c.section, c.costcenter, c.ruqest_date FROM it_requisition c CROSS JOIN user_role r ON c.department = r.departmentname and c.section = r.scetionname and c.costcenter = r.companyname LEFT JOIN tbl_accessories a ON c.reference =a.reference_id  where r.user_name='$username' and r.user_type='Head of section' and a.bulk_id = '' and approved_status BETWEEN 1 and 7 GROUP BY c.id ");

                                
                                    while($requisition_log_data = $sql_requisition_section_approve_log->fetch_assoc()){

                                         // $costcenterid = $requisition_data['costcenter'];

                                         // $costsql = $db->query("SELECT * FROM mrd_library WHERE LibraryName='company' and Description='$costcenterid'");

                                         //  $costsql_r = $costsql->fetch_assoc();


                                          

                                    ?>
                                        <tr>
                                    
                                        <td><center><?php echo $requisition_log_data['reference']; ?></center></td>
                                         <td><center><?php echo $requisition_log_data['emp_name']; ?></center></td>
                                        <td><center><?php echo $requisition_log_data['employeeID']; ?></center></td>
                                       <!--  <td><center></?php echo $requisition_data['designation']; ?></center></td> -->
                                        <td><center><?php echo $requisition_log_data['department']; ?></center></td>
                                        <td><center><?php echo $requisition_log_data['section']; ?></center></td>
                                        <!--<td><center><img src="../upload/</?php echo $messageview['certificate']; ?>" height="50" width="100">
                                        
                                        </center></td>-->
                                        <td><center><?php echo $requisition_log_data['costcenter']; ?></center></td>
                                        
                                        <td><center><?php echo $requisition_log_data['ruqest_date']; ?></center></td>

                                       <!--  <td><center>Active</center></td> -->

                                        <td><center><a href="viewaproved.php?view_id=<?php echo md5($requisition_log_data['id']); ?>" class="btn btn-primary btn-sm">VIEW</a> 
                                          

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