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

	$employeeID = htmlspecialchars($_REQUEST['employeeID'], ENT_QUOTES, 'UTF-8');

	$companyID = htmlspecialchars($_REQUEST['companyID'], ENT_QUOTES, 'UTF-8');

	$department = htmlspecialchars($_REQUEST['department'], ENT_QUOTES, 'UTF-8');

	$departmentname = $_REQUEST['departmentname'];

	$companyname = $_REQUEST['companyname'];
	$hiddenID = $_REQUEST['hiddenID'];
	
	
	
	
	echo $cls_meassage->edit_assign_application($roleusername,$employeeID,$companyID,$companyname,$department,$departmentname,$username,$hiddenID);
	
?>