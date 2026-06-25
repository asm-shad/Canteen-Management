<?php

	session_start();

	$username 	= $_SESSION['user_name'];


	require_once('cls_dbconfig.php');
	function __autoload($classname){
	  require_once("$classname.class.php");
	}
	
	$db = new cls_dbconfig();
	
	$cls_meassage = new cls_meassage();
	
	$roleusername = $_REQUEST['username'];

	$employeeID = $_REQUEST['employeeID'];

	$companyID = $_REQUEST['companyID'];

	$usermodule = $_REQUEST['usermodule'];

	$companyname = $_REQUEST['companyname'];
	
	
	
	
	echo $cls_meassage->add_assign_module($roleusername,$employeeID,$companyID,$companyname,$usermodule,$username);
	
?>