<?php

    session_start();

    $employeeID     =   $_SESSION['employeeID'];
    $username       =   $_SESSION['user_name'];
    $name           =   $_SESSION['name'];
    $email          =   $_SESSION['email'];

    require_once('cls_dbconfig.php');
    spl_autoload_register(function($classname) {
    require_once("$classname.class.php");
    });
 
    $db = new cls_dbconfig();
    
    $cls_meassage = new cls_meassage();
    
    $requitid = $_POST['requitid'];
    $reqrefer = $_POST['reqrefer'];

    echo $cls_meassage->escalate_to_boss($requitid,$reqrefer,$username);
    echo $cls_meassage->approve_verify_remove($requitid,$reqrefer,$username);

    
?>