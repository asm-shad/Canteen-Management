<?php

	session_start();

	$username 	= $_SESSION['user_name'];


	require_once('cls_dbconfig.php');
	  spl_autoload_register(function($classname) {
            require_once("$classname.class.php");
        });
	
	$db = new cls_dbconfig();
	
	$cls_meassage = new cls_meassage();
	
	$companyID = htmlspecialchars($_REQUEST['companyID'], ENT_QUOTES, 'UTF-8');

	$category = $_REQUEST['category'];

	$categorycode = htmlspecialchars($_REQUEST['categorycode'], ENT_QUOTES, 'UTF-8');
	
	
	
	
	echo $cls_meassage->add_category($companyID,$category,$categorycode,$username);
	
?>