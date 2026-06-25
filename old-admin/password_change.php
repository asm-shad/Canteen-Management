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
                            <h3 class="panel-title">Password Change</h3>
                        <!--    <p class="panel-subtitle">
                            
                            <form method="post" action="inbox.php" align="center">  
                                <input type="submit" name="export" value="CSV Export" class="btn btn-success" />  
                            </form> 
                            </p> -->
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">

                                     <form id="password" method="post">

                                      <div class="form-group">
                                        


                                     <div class="form-group">
                                        <label for="departmentID">Old Password </label>
                                        <input class="form-control" name="old_password" type="password" id="old_password" placeholder="Old Password">

                                       <input type="hidden" value="<?php echo $username; ?>" name="userdataid">
                                      </div>

                                      <div class="form-group">

                                        <label for="department">New Password</label>
                                        <input class="form-control" name="new_password" type="password" id="new_password" placeholder="New Password">

                                      </div>
                                      <div class="form-group">
                                        <label for="departmentcode">Retype New Password</label>
                                         <input class="form-control" name="retype_pass" type="password" class="textfield" id="retype_pass" placeholder="Retype New Password">
                                      </div>

                                      <button type="submit" class="btn btn-primary">Change</button>
                                    </form>

                                    
                                </div>
                            </div>
                        </div>
                    </div>              
                </div>
            </div>
            <!-- END MAIN CONTENT -->



			
<?php include('footer.php'); ?>