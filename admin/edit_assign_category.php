<?php

	session_start();

	$username 	= $_SESSION['user_name'];


	require_once('cls_dbconfig.php');
  	 spl_autoload_register(function($classname) {
            require_once("$classname.class.php");
        });
	$db = new cls_dbconfig();
	
	$cls_meassage = new cls_meassage();
	
	$roleusername = $_REQUEST['username'];

	$employeeID = htmlspecialchars($_REQUEST['employeeID'], ENT_QUOTES, 'UTF-8');

	$companyID = htmlspecialchars($_REQUEST['companyID'], ENT_QUOTES, 'UTF-8');

	$category = htmlspecialchars($_REQUEST['category'], ENT_QUOTES, 'UTF-8');


	$companyname = $_REQUEST['companyname'];

	$user_type = $_REQUEST['user_type'];

	$hiddenID = $_REQUEST['hiddenID'];
	
	
	
	
	echo $cls_meassage->edit_assign_category($roleusername,$employeeID,$companyID,$companyname,$category,$user_type,$username,$hiddenID);
	
?>