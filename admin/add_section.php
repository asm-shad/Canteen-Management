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

	$department = htmlspecialchars($_REQUEST['department'], ENT_QUOTES, 'UTF-8');

	$sectionID = htmlspecialchars($_REQUEST['sectionID'], ENT_QUOTES, 'UTF-8');

	$section = $_REQUEST['section'];

	$sectioncode = htmlspecialchars($_REQUEST['sectioncode'], ENT_QUOTES, 'UTF-8');
	
	
	
	
	echo $cls_meassage->add_section($companyID,$department,$sectionID,$section,$sectioncode,$username);
	
?>