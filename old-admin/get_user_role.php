<?php


	require_once('cls_dbconfig.php');
	
    spl_autoload_register(function($classname) {
            require_once("$classname.class.php");
        });

	$cls_dbconfig = new cls_dbconfig();
	$db = $cls_dbconfig->connection();
	

	$username = htmlspecialchars($_REQUEST['username'], ENT_QUOTES, 'UTF-8');
    //$companyID = $_GET['companyID'];	
	
	 $sqldata = $db->query("SELECT * FROM user where username='$username'");	
     
	$deparment_r = $sqldata->fetch_assoc();
    
?>
<input type="text" class="form-control" name="employeeID" id="employeeID" value="<?php echo $deparment_r['employeeID']; ?>" readonly>

       


	
   
