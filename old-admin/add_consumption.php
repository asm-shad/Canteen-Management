<?php

	session_start();

	$username 	= $_SESSION['user_name'];


	require_once('cls_dbconfig.php');
	spl_autoload_register(function($classname) {
	require_once("$classname.class.php");
	});
		
	$db = new cls_dbconfig();
	
	$cls_meassage = new cls_meassage();

	$canteenName = htmlspecialchars($_REQUEST['canteenName'], ENT_QUOTES, 'UTF-8');

	$itemName = htmlspecialchars($_REQUEST['itemName'], ENT_QUOTES, 'UTF-8');
	
	$DailyConsumption = htmlspecialchars($_REQUEST['DailyConsumption'], ENT_QUOTES, 'UTF-8');

	$WeeklyConsumption = htmlspecialchars($_REQUEST['WeeklyConsumption'], ENT_QUOTES, 'UTF-8');

	$MonthlyConsumption = htmlspecialchars($_REQUEST['MonthlyConsumption'], ENT_QUOTES, 'UTF-8');
	$ConsumptionUOM = htmlspecialchars($_REQUEST['ConsumptionUOM'], ENT_QUOTES, 'UTF-8');
	
	
	
	echo $cls_meassage->add_consumption($canteenName, $itemName, $DailyConsumption, $WeeklyConsumption, $MonthlyConsumption, $ConsumptionUOM, $username);
	
?>