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
    
    $generateprid = "$_POST[generateprid]";
   
    
    echo $cls_meassage->generate_purchase_requisition($generateprid);


    
?>