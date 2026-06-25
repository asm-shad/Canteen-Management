<?php

	session_start();

	$username 	= $_SESSION['user_name'];


	require_once('cls_dbconfig.php');
	function __autoload($classname){
	  require_once("$classname.class.php");
	}
	
	$db = new cls_dbconfig();
	
	$cls_meassage = new cls_meassage();
	
	$companyID = htmlspecialchars($_REQUEST['companyID'], ENT_QUOTES, 'UTF-8');

	$departmentID = htmlspecialchars($_REQUEST['departmentID'], ENT_QUOTES, 'UTF-8');

	$department = $_REQUEST['department'];

	$departmentcode = htmlspecialchars($_REQUEST['departmentcode'], ENT_QUOTES, 'UTF-8');

	$status = htmlspecialchars($_REQUEST['status'], ENT_QUOTES, 'UTF-8');
	
	$hiddenID = $_REQUEST['hiddenID'];
	
	
	echo $cls_meassage->edit_department($companyID,$departmentID,$department,$departmentcode,$status,$username,$hiddenID);
	
?>