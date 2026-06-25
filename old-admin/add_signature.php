<?php

	session_start();

	$username 	= $_SESSION['user_name'];


	require_once('cls_dbconfig.php');
spl_autoload_register(function($classname) {
    require_once("admin/$classname.class.php");
});
	
	$db = new cls_dbconfig();
	
	$cls_meassage = new cls_meassage();
	
	$roleusername = htmlspecialchars($_REQUEST['username'], ENT_QUOTES, 'UTF-8');

	$employeeID = htmlspecialchars($_REQUEST['employeeID'], ENT_QUOTES, 'UTF-8');

	//$imgsignature = htmlspecialchars($_REQUEST['imgsignature'], ENT_QUOTES, 'UTF-8');


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


	
	
	echo $cls_meassage->add_roleuser_signature($roleusername,$employeeID,$pic,$username);
	
?>