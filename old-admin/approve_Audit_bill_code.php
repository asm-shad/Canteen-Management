<?php

	session_start();



	$employeeID 	= $_SESSION['employeeID'];
	$username 		= $_SESSION['user_name'];
	$name 			= $_SESSION['name'];
	$email 			= $_SESSION['email'];
	// $userRole       = $_SESSION['user_role'];

	 require_once('cls_dbconfig.php');
	    spl_autoload_register(function($classname) {
	    require_once("$classname.class.php");
	    });
	
	$db = new cls_dbconfig();
	
	$cls_meassage = new cls_meassage();

	//$_SESSION['token'] = "$_POST[toekndt]";

	$vrfy_code = "$_POST[verifycode]";
	
	$requiID = "$_POST[requit]";
	$reqrefer = "$_POST[reqrefer]";
	


 echo $cls_meassage->insert_audit_bill_approve($requiID, $reqrefer, $username, $employeeID, $vrfy_code);




	
?>