<?php

include('header.php');


$id = $_GET['assign_id'];

 $sqluserrole = $db->query("select * from user_role where md5(id)='$id'");
    

$assign_r = $sqluserrole->fetch_assoc();

$companyID = $assign_r['companyID'];

 $sqldepartment = $db->query("select * from department_library where companyID='$companyID'");


?>



<!-- END NAVBAR -->
            <!-- MAIN CONTENT -->
             <div class="main-content">
                <div class="container-fluid">
                    
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Application Approval Department Role Assign Update</h3>
                        
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">

                                <?php
                                 if($_SESSION['user_role']=="Admin"){
                                    ?>
                                    
                                    <form id="UpdtassignApplication" method="post">

                                      <div class="form-group">
                                        <label for="user_name">Application Approval Department Head</label>
                                        <select class="form-control" id="roleusername" name="username">
                                              <option value="">Select</option>

                                               <?php 
                                                   while($role_user = $all_assign_role_user->fetch_assoc( )){

                                                       $userid = $role_user['username'];
                                               ?>
                                            <option  <?php if($userid==$assign_r['user_name']) { ?> selected <?php } ?> value="<?php echo $userid; ?>">

                                            <?php if(!empty($userid)) { ?><?php echo $role_user['username']; } ?>

                                            </option>

                                              <?php } ?>

                                            </select>

                                      </div>

                                    
                                     <div class="form-group">
                                        <label for="departmentID">Employee ID</label>
                                         <input type="hidden" name="hiddenID" value="<?php echo $assign_r['id']; ?>" readonly>

                                        <p id="username">
                                        
                                        <input type="text" class="form-control" name="employeeID" id="employeeID" value="<?php echo $assign_r['employeeID']; ?>" readonly>

                                         </p>

                                      </div>                                      

                                      <div class="form-group">
                                        <label for="companyID">Company </label>
                                       
                                         <select class="form-control" id="companyID" name="companyID">
                                              <option value="">Select Company</option>

                                              <?php
                                                   while($companydata = $all_company->fetch_assoc( )){

                                                     $companyid = $companydata['Code'];

                                               ?>
                                              <option  <?php if($companyid==$assign_r['companyID']) { ?> selected <?php } ?> value="<?php echo $companyid; ?>">

                                                <?php if(!empty($companyid)) { ?><?php echo $companydata['Description']; } ?>

                                                </option>

                                              <?php } ?>

                                            </select>                                       
                                      </div>

                                       <div id="getdata">

                                         <input type="hidden" name="companyname" value="<?php echo $assign_r['companyname']; ?>" readonly>

                                        </div>

                                         <div id="getdatadepartment">

                                             <input type="hidden" name="departmentname" value="<?php echo $assign_r['departmentname']; ?>" readonly>
                                        </div>

                                      <div class="form-group">
                                        <label for="department">Department</label>
                                            <select class="form-control department" id="department" name="department">
                                              <option value="">Select Department</option>

                                                 <?php while($deprt_dr = $sqldepartment->fetch_assoc()){ 

                                                    $deprtid = $deprt_dr['departmentID'];

                                                    ?>

                                                <option  <?php if($deprtid==$assign_r['departmentID']) { ?> selected <?php } ?> value="<?php echo $deprtid; ?>">

                                                <?php if(!empty($deprtid)) { ?><?php echo $deprt_dr['department_Name']; } ?>

                                                </option> 


                                            <?php } ?>      

                                            </select>



                                      </div>

                                      <button type="submit" class="btn btn-primary">Update</button>
                                    </form>
                                                                    
                                    
                                    
                                 <?php
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