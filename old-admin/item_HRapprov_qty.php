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
    
    $ApprovQTY           = "$_POST[ApprovQTY]";
    $itemremarks        =  "$_POST[HRremarks]";


    $hdnid  = "$_POST[hiddenID]";
      
   
    
    echo $cls_meassage->item_qty_add_by_hr($ApprovQTY,$itemremarks,$hdnid,$username);


    
?>