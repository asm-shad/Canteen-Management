<?php


require_once('cls_dbconfig.php');
   spl_autoload_register(function($classname) {
            require_once("$classname.class.php");
        });

	$cls_dbconfig = new cls_dbconfig();
	$db = $cls_dbconfig->connection();
	

	$companyID = htmlspecialchars($_REQUEST['companyID'], ENT_QUOTES, 'UTF-8');
    //$companyID = $_GET['companyID'];	
	
	 $data_canteen = $db->query("Select * From canteen_library Where companyName='$companyID'");	
     

    
?>
 <option value="">Select Category</option>

    <?php while($canteen = $data_canteen->fetch_assoc()){ ?>

        <option value="<?php echo $canteen['name']; ?>"><?php echo $canteen['name']; ?></option>
 
   <?php } ?>

       


	
   
