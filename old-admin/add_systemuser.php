<?php

	session_start();

	$username 	= $_SESSION['user_name'];


	require_once('cls_dbconfig.php');
	spl_autoload_register(function($classname) {
    require_once("$classname.class.php");
});
	
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

	$pass =  md5($_REQUEST['pass']);

	
	$file = $_FILES['imgsignature']['name'];

  $tmp = $_FILES["imgsignature"]["tmp_name"];  
  
    
	$imgdate =  date("Y-m-d");;

	 $rrrr = rand('111','999');
	
	  $rttr = md5($rrrr);
	
	 $rrr = uniqid();

	 $rr = $imgdate. "-" . $rrr. "" .$rttr;
	
    $imgges = "$rr.jpg";
    $pic = "uploads/$rr.jpg";
    $destinations = "uploads/$imgges";
      move_uploaded_file($tmp,$destinations);
	
	
	
	
	echo $cls_meassage->add_systemuser($employeeID,$empname,$email,$designation,$companyID,$department,$section,$userid,$pass,$pic,$username);





	


	 // $image_base64 = file_get_contents($_FILES['imgsignature']['tmp_name']);

	 // $pic = base64_encode($image_base64);


	 // 	echo $cls_meassage->add_systemuser($employeeID,$empname,$email,$designation,$companyID,$department,$section,$userid,$pass,$pic,$username);


	
?>