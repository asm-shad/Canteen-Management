<?php


require_once('cls_dbconfig.php');
    function __autoload($classname){
      require_once("$classname.class.php");
    }
	$cls_dbconfig = new cls_dbconfig();
	$db = $cls_dbconfig->connection();
	

	$section = htmlspecialchars($_REQUEST['section'], ENT_QUOTES, 'UTF-8');
    //$companyID = $_GET['companyID'];	

    $sectionIDsqldata = $db->query("select * from section_library where sectionID ='$section'");	
    $section_r = $sectionIDsqldata->fetch_assoc();
    

    
?>




<input type="hidden" class="form-control" name="sectionname" id="sectionname" value="<?php echo $section_r['section_name']; ?>">

       


	
   
