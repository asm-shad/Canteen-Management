<?php

	session_start();

	$username 	= $_SESSION['user_name'];


	require_once('cls_dbconfig.php');
	spl_autoload_register(function($classname) {
	require_once("$classname.class.php");
	});
	
	$db = new cls_dbconfig();
	
	$cls_meassage = new cls_meassage();
	
	$userid = "$_POST[userdataid]";
	
	$old_password = md5($_REQUEST['old_password']);
	$new_password = md5($_REQUEST['new_password']);
	$retype_pass = md5($_REQUEST['retype_pass']);
	
	$q7 = $cls_meassage->check_password($userid);
	
		$r7 = $q7->fetch_assoc();
		$password = $r7['password'];
		//print_r($password);
	  //  die();
	
		if($old_password == $password)
	{
		$cls_meassage->update_password_data($new_password,$userid);
	echo '1';

	} else {
			echo '0';
		}
	
?>