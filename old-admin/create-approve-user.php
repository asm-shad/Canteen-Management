<?php 


// error_reporting(E_ALL);
// ini_set('display_errors', 1);

include('header.php');


$sqldata = $db->query("SELECT DISTINCT id, section_name FROM section_library ORDER BY id DESC");


?>

<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
<div class="container-fluid">
    
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title">System Approve User</h3>
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
                    
                    <form id="addsystemuser" method="post">

                    <div class="form-group">
                        <label for="employeeID">Employee ID</label>
                        <input type="text" class="form-control" name="employeeID" id="employeeID" placeholder="Enter Employee ID">
                      </div>

                      <div id="getuserdata">

                      <div class="form-group">
                        <label for="empname">Name</label>
                        <input type="text" class="form-control" name="empname" id="empname" placeholder="Enter Name">
                      </div>


                      <div class="form-group">
                        <label for="empname">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
                      </div>

                      <div class="form-group">
                        <label for="designation">Designation</label>
                        <input type="text" class="form-control" name="designation" id="designation" placeholder="Enter designation">
                      </div>

                      <div class="form-group">
                        <label for="companyID">Company </label>
                       
                         <select class="form-control" id="syscompanyID" name="companyID">
                              <option value="">Select Company</option>
                               <?php 
                                   while($companydata = $all_company->fetch_assoc( )){
                               ?>
                              <option value="<?php echo $companydata['companymdm']; ?>"><?php echo $companydata['company_name']; ?></option>

                              <?php } ?>

                            </select>                                       
                      </div>

                      <div class="form-group">
                        <label for="department">Department</label>
                        <select class="form-control" id="departmentname" name="department">
                              <option value="">Select Department</option>
                         </select>   
                      </div>

                      <div class="form-group">
                        <label for="section">Section</label>
                        <select class="form-control" id="sectionname" name="section">
                              <option value="">Select Section</option>
                              <?php while($section_r = $sqldata->fetch_assoc()){ ?>

                                <option value="<?php echo $section_r['section_name'] ?>"><?php echo $section_r['section_name'] ?></option>  


                            <?php } ?>
                         </select>   
                      </div>

                       <div class="form-group">
                        <label for="userid">User Name</label>
                        <input type="text" class="form-control" name="userid" id="userid" placeholder="Enter user name">
                      </div>

                  </div>


                       <div class="form-group">
                        <label for="pass">Password</label>
                        <input type="password" class="form-control" name="pass" id="pass" placeholder="Enter Password">
                      </div>

                   <div class="form-group">
                        <label for="imgsignature">Upload Signature </label>
                        <input type="file" class="form-control" name="imgsignature" id="imgsignature" title="Upload Signature"  onchange="return logoloadValidation()">

                        <div id="image-photo"></div>
                                                             
                      </div>


                      <button type="submit" class="btn btn-primary">Save</button>
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