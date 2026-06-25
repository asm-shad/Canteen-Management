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


	$mailid = "$_POST[mailid]";


	echo $cls_meassage->approve_mail_status_change($name,$mailid);
	


?>