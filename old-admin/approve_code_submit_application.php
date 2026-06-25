<?php

	session_start();

	$employeeID 	= $_SESSION['employeeID'];
	$username 	= $_SESSION['user_name'];


	require_once('cls_dbconfig.php');
	function __autoload($classname){
	  require_once("$classname.class.php");
	}
	
	$db = new cls_dbconfig();
	
	$cls_meassage = new cls_meassage();
	
	$verifycode = $_REQUEST['verifycode'];
	$hiddenID = $_REQUEST['hiddenID'];
	//$tid = $_REQUEST['tid'];
	
	
	
	
	echo $cls_meassage->approve_application_submit_access($hiddenID,$verifycode,$username,$employeeID);
	
?>