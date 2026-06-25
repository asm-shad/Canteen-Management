<?php 
include('header.php');

$id = $_GET['dpart_id'];

$sqldepartment = $db->query("select * from department_library where md5(id)='$id'");

$depart_r = $sqldepartment->fetch_assoc();


?>

<!-- END NAVBAR -->
<!-- MAIN CONTENT -->
<div class="main-content">
<div class="container-fluid">

<div class="panel panel-headline">
<div class="panel-heading">
    <h3 class="panel-title">Department</h3>
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
            
            <form id="editdepartment" method="post">

              <div class="form-group">
                <label for="companyID">Company </label>
               
                 <select class="form-control" id="companyID" name="companyID">
                      <option value="">Select Company</option>
                       <?php
                           while($companydata = $all_company->fetch_assoc( )){

                             $companyid = $companydata['companymdm'];

                       ?>
                      <option  <?php if($companyid==$depart_r['companyID']) { ?> selected <?php } ?> value="<?php echo $companyid; ?>">

                        <?php if(!empty($companyid)) { ?><?php echo $companydata['company_name']; } ?>

                        </option>

                      <?php } ?>

                    </select>                                       
              </div>

             <div class="form-group">
                <label for="departmentID">Department ID</label>
                <input type="text" class="form-control" name="departmentID" id="departmentID" value="<?php echo $depart_r['departmentID']; ?>">
                    <input type="hidden" name="hiddenID" value="<?php echo $depart_r['id'];?>">
              </div>

              <div class="form-group">
                <label for="department">Department</label>
                <input type="text" class="form-control" name="department" id="department"value="<?php echo $depart_r['department_Name']; ?>">
              </div>

              <div class="form-group">
                <label for="departmentcode">Department Code</label>
                <input type="text" class="form-control" name="departmentcode" id="departmentcode" value="<?php echo $depart_r['department_code']; ?>">
              </div>

               <div class="form-group">
                <label for="companyID">Status </label>
                 <select class="form-control" id="status" name="status">
                      <option value="">Select </option>
                       <?php

                           $status = $depart_r['status'];

                       ?>
                      <option <?php if('1'==$depart_r['status']) { ?> selected <?php } ?>  value="1">Active </option>
                      <option <?php if('0'==$depart_r['status']) { ?> selected <?php } ?> value="0">Dactive </option>

                    </select>                                       
              </div>
              <button type="submit" class="btn btn-primary">Update</button>
            </form>

        <?php } ?>
            
        </div>
    </div>
</div>
</div>              
</div>
</div>
<!-- END MAIN CONTENT -->



<?php include('footer.php'); ?>