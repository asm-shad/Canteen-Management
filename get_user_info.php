<?php

error_reporting(0);

// require_once('admin/cls_dbconfig.php');
// 	function __autoload($classname){
// 	  require_once("admin/$classname.class.php");
// 	}

require_once('admin/cls_dbconfig.php');
spl_autoload_register(function($classname) {
    require_once("admin/$classname.class.php");
});

	$cls_dbconfig = new cls_dbconfig();
	$db = $cls_dbconfig->connection();
	

	$employeeID = htmlspecialchars($_REQUEST['employeeID'], ENT_QUOTES, 'UTF-8');
    //$employeeID = $_GET['employeeID'];
	
	
	 $sql = $db->query("select * from employee_info where employeeID='$employeeID'");
	
     $user_r = $sql->fetch_assoc();

    // $department = $user_r['department'];

    //  $all_costcenter =  $db->query("select * from employee_info where department='$department' GROUP BY section");

     $unit = $user_r['units'];

     $company_info =  $db->query("select * from company_library where unit='$unit' and status='1'");

    $company = $company_info->fetch_assoc();

?>

        <div class="col-md-6 top-div">
      <div class="form-group">
            <label for="name" class="col-sm-4 col-form-label">Name:</label>
            <div class="col-sm-8">
               <input type="text" name="emp_name" readonly value="<?php echo $user_r['name'] ?>" class="f1-first-name form-control" id="f1-first-name">

                <input type="hidden" name="company" value="<?php echo $company['company_name']; ?>" >
            </div>
      </div>
   </div>
    <div class="col-md-6 top-div">
      <div class="form-group">
            <label for="designation" class="col-sm-4 col-form-label">Designation:</label>
            <div class="col-sm-8">
               <select class="f1-designation form-control" name="designation" id="f1-designation" required>
                  <!--   <option value="">Select Designation</option> -->
                    <option value="<?php echo $user_r['designation'] ?>" selected><?php echo $user_r['designation'] ?></option>
                 </select>
            </div>
      </div>
   </div>
   <div class="col-md-6 top-div">
      <div class="form-group">
            <label for="department" class="col-sm-4 col-form-label">Department:</label>
            <div class="col-sm-8">
                <select class="f1-department form-control" name="department" id="f1-department" required>
                    <!-- <option value="">Select Department</option> -->
                    <option value="<?php echo $user_r['department'] ?>" selected><?php echo $user_r['department'] ?></option>
                 </select>
            </div>
      </div>
   </div>

      <div class="col-md-6 top-div">
      <div class="form-group">
            <label for="section" class="col-sm-4 col-form-label">User Section:</label>
            <div class="col-sm-8">
               <select class="f1-department form-control" name="section" id="f1-department" required>
                       <!--  <option value="">Select User Section</option> -->
                        <option value="<?php echo $user_r['section'] ?>" selected><?php echo $user_r['section'] ?></option>       
                 </select>
            </div>
      </div>
   </div>
     <div class="col-md-6 top-div">
      <div class="form-group">
            <label for="name" class="col-sm-4 col-form-label">Contact Number:</label>
            <div class="col-sm-8">
               <input type="text" name="contact_number" placeholder="+880 " value="<?php echo $user_r['phone'] ?>" class="f1-contact_number form-control" id="f1-contact_number" required>
            </div>
      </div>
   </div>
     <div class="col-md-6 top-div">
      <div class="form-group">
            <label for="name" class="col-sm-4 col-form-label">Email:</label>
            <div class="col-sm-8">
              <input type="email" name="email" value="<?php echo $user_r['email'] ?>" class="form-control" id="email" required>

              <div id="alertMessage"></div>
            </div>
           <!--  disabled="disabled"  -->
      </div>
   </div>

     <div class="col-md-6 top-div">
      <div class="form-group">
            <label for="joindate" class="col-sm-4 col-form-label"> Join Date:</label>
            <div class="col-sm-8">
                <input type="text" name="joindate" readonly value="<?php echo $user_r['joiningdate'] ?>" class="f1-twitter form-control">
            </div>
      </div>
   </div>
<!--  <div class="col-md-8 top-div">
      <div class="form-group">
            <label for="joindate" class="col-sm-4 col-form-label"> Create New Email:</label>
            <div class="col-sm-8">
              <input class="form-check-input" type="checkbox" name="newemail" value="Yes"> <label class="form-check-label" for="flexRadioDefault1">Yes </label>
            </div>
      </div>
   </div>
 -->



	
   
