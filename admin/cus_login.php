<?php
session_start();

require_once('cls_dbconfig.php');

spl_autoload_register(function($classname) {
    require_once("$classname.class.php");
});

$cls_user_login = new cls_user_login();

// Get POST data safely
$uname = trim($_POST['uname'] ?? '');
$pass  = trim($_POST['password'] ?? '');
$redirect = $_POST['redirect'] ?? '';

// Login check
$result = $cls_user_login->user_access($uname, $pass);

if ($result == "yes") {

    // Send redirect URL back to AJAX
    if (!empty($redirect) && strpos($redirect, 'http') === false) {
        echo $redirect;
    } else {
        echo "index.php";
    }

} else {

	exit();

   // echo "login.php";
}
?>