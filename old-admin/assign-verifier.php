<?php


include('header.php');



?>



<!-- END NAVBAR -->
            <!-- MAIN CONTENT -->
             <div class="main-content">
                <div class="container-fluid">
                    
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Bulk Verifier Role Assign</h3>
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
                                    
                                    <form id="assignmodule" method="post">

                                      <div class="form-group">
                                        <label for="user_name">Verifier</label>
                                        <select class="form-control" id="roleusername" name="username">
                                              <option value="">Select</option>

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
                                        
                                        <input type="text" class="form-control" name="employeeID" id="employeeID" placeholder="Enter Employee ID" readonly> 

                                         </p>

                                      </div>                                      


                                      <div class="form-group">
                                        <label for="companyID">Company </label>
                                       
                                         <select class="form-control" id="companyID" name="companyID">
                                              <option value="">Select Company</option>
                                               <?php 
                                                   while($companydata = $all_company->fetch_assoc( )){
                                               ?>
                                              <option value="<?php echo $companydata['Code']; ?>"><?php echo $companydata['Description']; ?></option>

                                              <?php } ?>

                                            </select>                                       
                                      </div>

                                       <div id="getdata">

                                        </div>

                                      <div class="form-group">
                                        <label for="usermodule">Access Module</label>
                                            <select class="form-control" id="usermodule" name="usermodule">
                                              <option value="">Select Module</option>
                                              <option value="IT Verify">IT Module</option>

                                            </select>

                                      </div>

                                      <button type="submit" class="btn btn-primary">Assign</button>
                                    </form>

                                    <br>

                                    <h3>Bulk Verifier List</h3>


                                     <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th><center>SL No </center></th>
                                        <th><center>Employee ID</center></th>
                                        <th><center>Name</center></th>
                                        <th><center>Company</center></th>
                                        <th><center>Role Type</center></th>
                                        <th><center>Status</center></th>
                                        <th><center>Action</center></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                <?php


                                    $i=1;

                                  
                                    while($role_data = $all_bulk_role->fetch_assoc()){



                                    ?>
                                        <tr>
                                    
                                        <td><center><?php echo $i++; ?></center></td>

                                        <td><center><?php echo $role_data['employeeID']; ?></center></td>
                                        
                                        <td><center><?php echo $role_data['user_name']; ?></center></td>

                                        <td><center><?php echo $role_data['companyname']; ?></center></td>

                                        <td><center><?php echo $role_data['user_type']; ?></center></td>

                                        <td><center>
                                             <?php if ($role_data['status'] == '1') {
                                            echo "Active";
                                        }else{
                                            echo "Deactive";
                                        }                                        
                                            ?></center></td>

                                        <td><center>
                                            <a href="assign-verifier-edit.php?assign_id=<?php echo md5($role_data['id']); ?>" class="btn btn-primary">Edit</a>
                                        </center></td>
                                        
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