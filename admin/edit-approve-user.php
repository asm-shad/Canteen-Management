<?php 
include('header.php');

$id = $_GET['user_id'];

$sqluser = $db->query("select * from user where md5(id)='$id'");

$user_r = $sqluser->fetch_assoc();

$sqldepartment = $db->query("SELECT DISTINCT department_Name, id, companyID FROM department_library");

$all_section = $db->query("SELECT DISTINCT id, section_name FROM section_library ORDER BY id DESC ");

?>

<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
<div class="container-fluid">
    
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title">System Approve User Update</h3>
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
                    
                    <form id="Updystemuser" method="post">

                    <div class="form-group">
                        <label for="employeeID">Employee ID</label>
                        <input type="text" class="form-control" name="employeeID" id="employeeID" value="<?php echo $user_r['employeeID']; ?>">

                         <input type="hidden" name="hiddenID" value="<?php echo $user_r['id']; ?>">
                      </div>

                      <div id="getuserdata-not">

                      <div class="form-group">
                        <label for="empname">Name</label>
                        <input type="text" class="form-control" name="empname" id="empname" value="<?php echo $user_r['name']; ?>">
                      </div>


                      <div class="form-group">
                        <label for="empname">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?php echo $user_r['email']; ?>">
                      </div>

                      <div class="form-group">
                        <label for="designation">Designation</label>
                        <input type="text" class="form-control" name="designation" id="designation" value="<?php echo $user_r['designation']; ?>">
                      </div>

                      <div class="form-group">
                        <label for="companyID">Company </label>
                       
                         <select class="form-control" id="syscompanyID" name="companyID">
                              <option value="">Select Company</option>
                               

                               <?php while($companydata = $all_company->fetch_assoc()){ 

                                    $companyid = $companydata['companymdm'];

                                    ?>

                                <option  <?php if($companyid==$user_r['costcenter']) { ?> selected <?php } ?> value="<?php echo $companydata['companymdm']; ?>">

                                <?php if(!empty($companyid)) { ?><?php echo $companydata['company_name']; } ?>

                                </option> 


                            <?php } ?>  


                            </select>                                       
                      </div>

                      <div class="form-group">
                        <label for="department">Department</label>
                        <select class="form-control" id="departmentname" name="department">
                              <option value="">Select Department</option>

                                <?php while($deprt_dr = $sqldepartment->fetch_assoc()){ 

                                    $deprtid = $deprt_dr['department_Name'];

                                    ?>

                                <option  <?php if($deprtid==$user_r['department']) { ?> selected <?php } ?> value="<?php echo $deprtid; ?>">

                                <?php if(!empty($deprtid)) { ?><?php echo $deprt_dr['department_Name']; } ?>

                                </option> 


                            <?php } ?>  

                         </select>   
                      </div>

                      <div class="form-group">
                        <label for="section">Section</label>
                        <select class="form-control" id="sectionname" name="section">
                              <option value="">Select Section</option>

                               <?php while($section_r = $all_section->fetch_assoc()){ 

                                    $sectionid = $section_r['section_name'];

                                    ?>

                                <option  <?php if($sectionid==$user_r['section']) { ?> selected <?php } ?> value="<?php echo $sectionid; ?>">

                                <?php if(!empty($sectionid)) { ?><?php echo $section_r['section_name']; } ?>

                                </option> 

                            <?php } ?>      
                         </select>   
                      </div>

                       <div class="form-group">
                        <label for="userid">User Name</label>
                        <input type="text" class="form-control" name="userid" id="userid" value="<?php echo $user_r['username']; ?>">
                      </div>

                  </div>

                     <!--   <div class="form-group">
                        <label for="pass">Password</label>
                        <input type="text" class="form-control" name="pass" id="pass" placeholder="Enter Password">
                      </div> -->

                   <div class="form-group">
                        <label for="imgsignature">Upload Signature </label>
                        <input type="file" value="<?php echo $user_r['signature']; ?>" class="form-control" name="imgsignature" id="imgsignature" title="Upload Signature"  onchange="return logoloadValidation()" >

                        <!-- <div id="image-photo"></div> -->

                        <img src="<?php echo $user_r['signature']; ?>" width="120" height="65" id="image-photo" />
                                                             
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