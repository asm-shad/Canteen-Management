<?php

	session_start();

	$username 	= $_SESSION['user_name'];


	require_once('cls_dbconfig.php');
	function __autoload($classname){
	  require_once("$classname.class.php");
	}
	
	$db = new cls_dbconfig();
	
	$cls_meassage = new cls_meassage();

	$employeeID = $_REQUEST['employeeID'];
	$empname = $_REQUEST['empname'];
	$email = $_REQUEST['email'];
	$designation = $_REQUEST['designation'];
	$companyID = $_REQUEST['companyID'];

	
	$department = $_REQUEST['department'];

	$section = $_REQUEST['section'];

	$userid = $_REQUEST['userid'];

	
	$file = $_FILES['imgsignature']['name'];

 	 $pic = $_FILES["imgsignature"]["tmp_name"];  
  
  //    $image_base64 = file_get_contents($_FILES['imgsignature']['tmp_name']);

	 // $pic = base64_encode($image_base64);
	
	
		$hiddenID =  $_REQUEST['hiddenID'];
	
	
	echo $cls_meassage->edit_systemuser($employeeID,$empname,$email,$designation,$companyID,$department,$section,$userid,$pic,$username,$hiddenID);
	
?>