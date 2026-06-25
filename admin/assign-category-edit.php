<?php

include('header.php');


$id = $_GET['assign_id'];

$sqluserrole = $db->query("select * from user_role where md5(id)='$id'");


$assign_r = $sqluserrole->fetch_assoc();

$companyID = $assign_r['companyID'];

$sqlcategory = $db->query("select * from canteen_library where companyName='$companyID'");


?>



<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
<div class="container-fluid">
    
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title">User Role Assign Update</h3>
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
                    
                    <form id="Updassigncategory" method="post">

                      <div class="form-group">
                        <label for="user_name">Approval User</label>
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
                        <label for="employeeID">Employee ID</label>
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

                                     $companyid = $companydata['companymdm'];

                               ?>
                              <option  <?php if($companyid==$assign_r['companyID']) { ?> selected <?php } ?> value="<?php echo $companyid; ?>">

                                <?php if(!empty($companyid)) { ?><?php echo $companydata['company_name']; } ?>

                                </option>

                              <?php } ?>

                            </select>                                       
                      </div>

                       <div id="getdata">

                         <input type="hidden" name="companyname" value="<?php echo $assign_r['companyname']; ?>" readonly>

                        </div>

                      <div class="form-group">
                        <label for="Category">Category</label>
                            <select class="form-control" id="category" name="category">
                              <option value="">Select Category</option>

                                 <?php while($category_dr = $sqlcategory->fetch_assoc()){ 

                                    $category = $category_dr['name'];

                                    ?>

                                <option <?php if($category==$assign_r['category']) { ?> selected <?php } ?> value="<?php echo $category; ?>">

                                <?php if(!empty($category)) { ?><?php echo $category_dr['name']; } ?>

                                </option> 


                            <?php } ?>      

                            </select>



                      </div>

             <div class="form-group">
                    
                    <label for="user_type">User Role</label>
                    
                    <select class="form-control" id="user_type" name="user_type">
                        <option value="">Select User Role</option>


                        <option <?php if("Approval User"==$assign_r['user_type']) { ?> selected <?php } ?>  value="Approval User">Approval User</option>
                        <option <?php if("Internal Audit"==$assign_r['user_type']) { ?> selected <?php } ?>  value="Internal Audit">Internal Audit</option>
                        
                         <option <?php if("Head of HR"==$assign_r['user_type']) { ?> selected <?php } ?>  value="Head of HR">Head of HR</option>
                        <option <?php if("Store"==$assign_r['user_type']) { ?> selected <?php } ?> value="Store">Requisition Controller</option>
                         <option <?php if("Boss"==$assign_r['user_type']) { ?> selected <?php } ?> value="Boss">Boss</option>

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