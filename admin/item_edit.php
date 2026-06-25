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
    
    $PurchaseQTY        = "$_POST[PurchaseQTY]";
    $PurUnitPrice       = "$_POST[PurUnitPrice]";
    $description        = "$_POST[description]";
    $PurTotalPrice      = "$_POST[PurTotalPrice]";
    $itemremarks        = "$_POST[itemremarks]";
    $supplier_code      = $_POST['supplier_code']; 


    $hdnid  = "$_POST[hiddenID]";
      
   
    
    echo $cls_meassage->item_edit_by_it($PurchaseQTY,$description,$PurUnitPrice,$PurTotalPrice,$itemremarks,$supplier_code,$username,$hdnid);


    
?>