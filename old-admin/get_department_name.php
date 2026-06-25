<?php


require_once('cls_dbconfig.php');
    function __autoload($classname){
      require_once("$classname.class.php");
    }
	$cls_dbconfig = new cls_dbconfig();
	$db = $cls_dbconfig->connection();
	

	$companyID = htmlspecialchars($_REQUEST['companyID'], ENT_QUOTES, 'UTF-8');
    //$companyID = $_GET['companyID'];	
	
	 $sqldata = $db->query("select * from department_library where companyID='$companyID'");	
     

    
?>
 <option value="">Select Department</option>

 <?php while($deparment_r = $sqldata->fetch_assoc()){ ?>

    <option value="<?php echo $deparment_r['department_Name'] ?>"><?php echo $deparment_r['department_Name'] ?></option>  


<?php } ?>

       


	
   
