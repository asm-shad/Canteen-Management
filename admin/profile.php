<?php 
include('header.php');


 $profilesql = $db->query("SELECT * FROM user WHERE username='$username'");

    $profile_data = $profilesql->fetch_assoc();


?>



<!-- END NAVBAR -->
            <!-- MAIN CONTENT -->
             <div class="main-content">
                <div class="container-fluid">
                    
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">My Profile</h3>
                        <!--    <p class="panel-subtitle">
                            
                            <form method="post" action="inbox.php" align="center">  
                                <input type="submit" name="export" value="CSV Export" class="btn btn-success" />  
                            </form> 
                            </p> -->
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">

                                    <table class="table table-striped table-bordered">
                                        <tr>

                                            <td style="width:170px;">Name</td> 

                                              <td><?php echo $profile_data['name']; ?></td> 

                                        </tr>
                                        <tr>

                                            <td>Employee ID</td> 

                                              <td><?php echo $profile_data['employeeID']; ?></td> 

                                        </tr>
                                        <tr>
                                            <td>Company</td>
                                            <td><?php echo $profile_data['costcenter']; ?></td> 
                                        </tr>
                                         <tr>
                                            <td>Designation</td>
                                             <td><?php echo $profile_data['designation']; ?></td> 
                                        </tr>
                                         <tr>
                                            <td>Department</td>
                                            <td><?php echo $profile_data['department']; ?></td> 
                                        </tr>

                                         <tr>
                                            <td>Section</td>
                                            <td><?php echo $profile_data['section']; ?></td> 
                                        </tr>  
                                        <tr>
                                            <td>Email</td>
                                            <td><?php echo $profile_data['email']; ?></td> 
                                        </tr> 
                                         <tr>
                                            <td>Signature</td>
                                           <!--  <td></?php echo '<img src="data:image/png;base64,' . $profile_data['signature'] . ' " height="60px" />'; ?> </td>  -->
                                            <td><img src="<?php echo $profile_data['signature']; ?> " height="60px" /></td> 
                                        </tr>  

                                        <tr>
                                            <td>Login Username</td>
                                            <td><?php echo $profile_data['username']; ?></td> 
                                        </tr> 


                                                                          

                                         
                                    
                                  </table>

                                    
                                </div>
                            </div>
                        </div>
                    </div>              
                </div>
            </div>
            <!-- END MAIN CONTENT -->



			
<?php include('footer.php'); ?>