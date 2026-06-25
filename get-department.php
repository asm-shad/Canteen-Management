<?php

// error_reporting(0);

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
	

	$division = htmlspecialchars($_REQUEST['division'], ENT_QUOTES, 'UTF-8');
    //$division = $_GET['division'];
	
	
	 // $sql = $db->query("select * from company_library where company_name='$division'");
	
  //    $data_r = $sql->fetch_assoc();

  //   $companymdm = $data_r['companymdm'];

     $all_department =  $db->query("select * from department_library where companyID='$division'");

?>

  
   <option value="">Select</option>
    <?php while($department = $all_department->fetch_assoc()){ ?>

        <option value="<?php echo $department['department_Name']; ?>"><?php echo $department['department_Name']; ?></option>
 
   <?php } ?>