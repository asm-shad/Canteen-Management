<?php


require_once('cls_dbconfig.php');

    spl_autoload_register(function($classname) {
            require_once("$classname.class.php");
        });


	$cls_dbconfig = new cls_dbconfig();
	$db = $cls_dbconfig->connection();
	

	$companyID = htmlspecialchars($_REQUEST['companyID'], ENT_QUOTES, 'UTF-8');
    //$companyID = $_GET['companyID'];	

    $companyIDsqldata = $db->query("SELECT * FROM company_library WHERE companymdm='$companyID'");	
    $company_r = $companyIDsqldata->fetch_assoc();
    

    
?>




<input type="hidden" class="form-control" name="companyname" id="companyname" value="<?php echo $company_r['company_name']; ?>">

       


	
   
