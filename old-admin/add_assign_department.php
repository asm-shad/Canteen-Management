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

	$department = htmlspecialchars($_REQUEST['department'], ENT_QUOTES, 'UTF-8');

	$departmentname = $_REQUEST['departmentname'];

	$companyname = $_REQUEST['companyname'];
	
	
	
	
	echo $cls_meassage->add_assign_department($roleusername,$employeeID,$companyID,$companyname,$department,$departmentname,$username);
	
?>