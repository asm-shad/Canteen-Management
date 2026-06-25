<?php


require_once('cls_dbconfig.php');
    function __autoload($classname){
      require_once("$classname.class.php");
    }
	$cls_dbconfig = new cls_dbconfig();
	$db = $cls_dbconfig->connection();
	

	$department = htmlspecialchars($_REQUEST['department'], ENT_QUOTES, 'UTF-8');
    //$companyID = $_GET['companyID'];	
	
	 $sqldata = $db->query("select * from section_library where departmentID='$department'");	
     

    
?>
 <option value="">Select Section</option>

 <?php while($section_r = $sqldata->fetch_assoc()){ ?>

    <option value="<?php echo $section_r['sectionID'] ?>"><?php echo $section_r['section_name'] ?></option>  


<?php } ?>

       


	
   
