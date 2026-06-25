<?php


require_once('cls_dbconfig.php');

  spl_autoload_register(function($classname) {
            require_once("$classname.class.php");
        });

	$cls_dbconfig = new cls_dbconfig();
	$db = $cls_dbconfig->connection();
	

	$department = htmlspecialchars($_REQUEST['department'], ENT_QUOTES, 'UTF-8');
    //$companyID = $_GET['companyID'];	

    $departmentIDsqldata = $db->query("select * from department_library where departmentID='$department'");	
    $department_r = $departmentIDsqldata->fetch_assoc();
    

    
?>




<input type="hidden" class="form-control" name="departmentname" id="departmentname" value="<?php echo $department_r['department_Name']; ?>">

       


	
   
