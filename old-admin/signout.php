<?php
	session_start();

	$_SESSION = [];
	session_unset();
	session_destroy();
	echo "1";

	exit;
?>

