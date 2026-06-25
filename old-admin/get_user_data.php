<?php

error_reporting(0);

    require_once('cls_dbconfig.php');
    spl_autoload_register(function($classname) {
            require_once("$classname.class.php");
        });

	$cls_dbconfig = new cls_dbconfig();
	$db = $cls_dbconfig->connection();
	
 

	$employeeID = htmlspecialchars($_REQUEST['employeeID'], ENT_QUOTES, 'UTF-8');
    //$companyID = $_GET['companyID'];	
	
	 $sqldata = $db->query("select * from employee_info where employeeID='$employeeID'");	
     $userdata_r = $sqldata->fetch_assoc();


      $unit = $userdata_r['units'];

     $company_info =  $db->query("select * from company_library where unit='$unit' and status='1'");

    $company = $company_info->fetch_assoc();


      // $sqldepartment = $db->query("select * from department_library Group by department_Name");

       $sqldepartment = $db->query("SELECT DISTINCT department_Name, id, companyID FROM department_library");

   	 // $all_company  = $db->query("SELECT * FROM company_library Group BY companymdm");

         $all_company  = $db->query("SELECT c.* FROM company_library c JOIN ( SELECT companyID, MAX(id) AS max_id FROM company_library WHERE status='1' GROUP BY companyID ) t ON c.companyID = t.companyID AND c.id = t.max_id ORDER BY c.id ASC");

   	 // $all_section = $db->query("select * from section_library Group by section_name ");

      $all_section = $db->query("SELECT DISTINCT section_name, id FROM section_library");
?>


<div class="form-group">
    <label for="empname">Name</label>
    <input type="text" class="form-control" name="empname" id="empname" value="<?php echo $userdata_r['name']; ?>" >
  </div>


  <div class="form-group">
    <label for="empname">Email</label>
    <input type="email" class="form-control" name="email" id="email" value="<?php echo $userdata_r['email']; ?>" >
  </div>

  <div class="form-group">
    <label for="designation">Designation</label>
    <input type="text" class="form-control" name="designation" id="designation" value="<?php echo $userdata_r['designation']; ?>">
  </div>

     <div class="form-group">
        <label for="companyID">Company </label>
       
         <select class="form-control" id="companyID" name="companyID">
              <option value="">Select Company</option>
             

               <?php while($companydata = $all_company->fetch_assoc()){ 

	                $companyid = $companydata['companymdm'];

	                ?>

	            <option  <?php if($companyid==$company['companymdm']) { ?> selected <?php } ?> value="<?php echo $companydata['companymdm']; ?>">

	            <?php if(!empty($companyid)) { ?><?php echo $companydata['company_name']; } ?>

	            </option> 


	        <?php } ?>  

            </select>                                       
      </div>

      <div class="form-group">
        <label for="department">Department</label>
        <select class="form-control" id="department" name="department">
              <option value="">Select Department</option>




               <?php while($deprt_dr = $sqldepartment->fetch_assoc()){ 

	                $deprtid = $deprt_dr['department_Name'];

	                ?>

	            <option  <?php if($deprtid==$userdata_r['department']) { ?> selected <?php } ?> value="<?php echo $deprtid; ?>">

	            <?php if(!empty($deprtid)) { ?><?php echo $deprt_dr['department_Name']; } ?>

	            </option> 


	        <?php } ?>  

         </select>   
      </div>

      <div class="form-group">
        <label for="section">Section</label>
        <select class="form-control" id="section" name="section">
              <option value="">Select Section</option>
             

                     <?php while($section_r = $all_section->fetch_assoc()){ 

                        $sectionid = $section_r['section_name'];

                        ?>

                    <option  <?php if($sectionid==$userdata_r['section']) { ?> selected <?php } ?> value="<?php echo $sectionid; ?>">

                    <?php if(!empty($sectionid)) { ?><?php echo $section_r['section_name']; } ?>

                    </option> 

                <?php } ?>  


         </select>   
      </div>

   <div class="form-group">
        <label for="userid">User Name</label>
        <input type="text" class="form-control" name="userid" id="userid">
      </div>


       


	
   
