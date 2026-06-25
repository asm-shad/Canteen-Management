<?php 
include('header.php');





?>



<!-- END NAVBAR -->
            <!-- MAIN CONTENT -->
             <div class="main-content">
                <div class="container-fluid">
                    
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Role User Signature</h3>
                        <!--    <p class="panel-subtitle">
                            
                            <form method="post" action="inbox.php" align="center">  
                                <input type="submit" name="export" value="CSV Export" class="btn btn-success" />  
                            </form> 
                            </p> -->
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">

                                <?php
                                 if($_SESSION['user_role']=="Admin"){
                                    ?>
                                    
                                    <form id="uploadSignature" method="post">

                                      <div class="form-group">
                                        <label for="user_name">Role User</label>
                                        <select class="form-control" id="roleusername" name="username">
                                              <option value="">Select Role User</option>

                                               <?php 
                                                   while($role_user = $all_assign_role_user->fetch_assoc( )){
                                               ?>
                                              <option value="<?php echo $role_user['username']; ?>"><?php echo $role_user['username']; ?></option>

                                              <?php } ?>

                                            </select>
                                         
                                      </div>

                                     <div class="form-group">
                                        <label for="departmentID">Employee ID</label>

                                        <p id="username">
                                        
                                        <input type="text" class="form-control" name="employeeID" id="employeeID" placeholder="Enter Employee ID">
                                        <small id="Help" class="form-text text-muted"></small>

                                         </p>

                                      </div>                                      


                                      <div class="form-group">
                                        <label for="companyID">Upload Signature </label>
                                        <input type="file" class="form-control" name="imgsignature" id="imgsignature" title="Upload Signature"  onchange="return logoloadValidation()">

                                        <div id="image-photo"></div>


                                                                             
                                      </div>


                                      <button type="submit" class="btn btn-primary">Save</button>
                                    </form>

                                    <br>

                                    <h3>Role User Signature List</h3>


                                     <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th><center>SL No </center></th>
                                        <th><center>Employee ID</center></th>
                                        <th><center>Name</center></th>
                                        <th><center>Signature</center></th>
                                        <th><center>Status</center></th>
                                        <th><center>Action</center></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                  
                                    while($role_data = $all_role_user_signature->fetch_assoc()){

                                       

                                    ?>
                                        <tr>
                                    
                                        <td><center><?php echo $role_data['id']; ?></center></td>

                                        <td><center><?php echo $role_data['employeeID']; ?></center></td>
                                        
                                        <td><center><?php echo $role_data['username']; ?></center></td>

                                        <td><center><img src="<?php echo $role_data['signature']; ?>" width="250" height="85" /></center></td>

                                        <td><center><?php echo $role_data['status']; ?></center></td>

                                        <td><center><a href="#=<?php echo md5($role_data['id']); ?>" class="btn btn-primary"></a></center></td>
                                        
                                      </tr>                                  
                                    
                                    
                                 <?php
                                      }

                                  }

                                    ?>

                                    
                                </div>
                            </div>
                        </div>
                    </div>              
                </div>
            </div>
            <!-- END MAIN CONTENT -->



			
<?php include('footer.php'); ?>