<?php

    session_start();

    $employeeID     =   $_SESSION['employeeID'];
    $username       =   $_SESSION['user_name'];
    $name           =   $_SESSION['name'];
    $email          =   $_SESSION['email'];

    require_once('cls_dbconfig.php');
    function __autoload($classname){
      require_once("$classname.class.php");
    }
    
    $db = new cls_dbconfig();
    
    $cls_meassage = new cls_meassage();
    
    $reject = "$_POST[reject]";
    $appid = "$_POST[hiddenID]";
   
   
    
    echo $cls_meassage->application_reject($appid,$username,$reject);

       echo $cls_meassage->application__zohomail_reject($appid);


    echo $cls_meassage->app_verify_reject($appid);
   


    
?>