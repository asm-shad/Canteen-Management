<?php

	session_start();



	$employeeID 	= $_SESSION['employeeID'];
	$username 	= $_SESSION['user_name'];
	$name = $_SESSION['name'];
	$email 			= $_SESSION['email'];

	require_once('cls_dbconfig.php');
	function __autoload($classname){
	  require_once("$classname.class.php");
	}
	
	$db = new cls_dbconfig();
	
	$cls_meassage = new cls_meassage();

	//$_SESSION['token'] = "$_POST[toekndt]";

	$vrfy_code = "$_POST[verifycode]";
	
	$requiID = "$_POST[requit]";
	
	  


	
echo $cls_meassage->insert_approve($requiID,$username,$employeeID,$vrfy_code);



	
?>