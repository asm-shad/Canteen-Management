<?php

    session_start();

    $employeeID     = $_SESSION['employeeID'];
    $username   = $_SESSION['user_name'];
    $name = $_SESSION['name'];
    $email          = $_SESSION['email'];

    require_once('cls_dbconfig.php');
    function __autoload($classname){
      require_once("$classname.class.php");
    }
    
    $db = new cls_dbconfig();
    
    $cls_meassage = new cls_meassage();
    
    $requiID = "$_POST[requit]";

     $refcod = "$_POST[refcod]";

     $vrfy_code = "$_POST[verifycode]";
    
    
    echo $cls_meassage->insert_application_approve($requiID,$refcod,$username,$employeeID,$vrfy_code);

 
?>