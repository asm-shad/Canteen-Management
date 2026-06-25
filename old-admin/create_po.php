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
    
    $cls_dbconfig = new cls_dbconfig();

    $db = $cls_dbconfig->connection();
    
    $cls_meassage = new cls_meassage();
    
    $refn = "$_POST[refn]";


    $result = $db->query("SELECT 
    'NPO' AS itemtype,
    'ICT-13' AS project,
    '0' AS linestatus,
    '0' AS docstatus,
    'PR' AS doctype,
    'PR' AS formtype,
    r.reference AS docnumber,
    r.section,
    r.costcenter,
    r.costdepartment,
    a.accessories AS itemname,
    a.quantity AS orderqty,
    a.uom AS iduom,
    a.brand AS brand,
    a.itemcolor AS color,
    a.sizemesur AS sizeormeasurement,
    a.description AS itemdescription,
    a.item_nature AS itemnature
FROM
    tbl_accessories AS a
        LEFT JOIN
    it_requisition AS r ON a.reference_id = r.reference
WHERE
    a.reference_id = '$refn' AND a.status='1' AND r.approved_status='3' ");

  $date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

  $nowdate =  $date->format('Y-m-d');

$line = 1;

while($row = $result->fetch_assoc()){
  

 //var_dump($row);

  $linecount = $line++;

  $itemtype = $row['itemtype'];
  $itemnature = $row['itemnature'];
  $project = $row['project'];
  $linestatus = $row['linestatus'];
  $docstatus = $row['docstatus'];
  $doctype = $row['doctype'];
  $formtype = $row['formtype'];
  $docnumber = $row['docnumber'];  
  $sectioncostcenter = $row['section'];
  $costcenter = $row['costcenter'];
  $costdept = $row['costdepartment'];
  $itemname  = $row['itemname'];
  $orderqty = $row['orderqty'];
  $iduom = $row['iduom'];
  $brand = $row['brand'];
  $color = $row['color'];
  $sizeormeasurement = $row['sizeormeasurement'];
  $itemdescription  = $row['itemdescription'];



  $comapymdm = $db->query("SELECT CODE FROM mrd_library WHERE LibraryName = 'company' AND Description = '$costcenter'");

  $companycode = $comapymdm->fetch_assoc();
  $cmmdmcode = $companycode['CODE'];


$doclinenumber = $docnumber.'-'.$linecount;


 $db->query("INSERT INTO `po-from-pr` (linestatus, docnumber, linenumber, doclinenumber, docstatus, doctype, docdate, formtype, company, costcenter, costdept, itemname, itemdescription, brand, color,sizeormeasurement, orderqty, iduom, itemtype, project, itemnature) VALUES ('$linestatus', '$docnumber', '$linecount', '$doclinenumber', '$docstatus', '$doctype', '$nowdate', '$formtype', '$cmmdmcode', '$sectioncostcenter', '$costdept', '$itemname', '$itemdescription', '$brand', '$color', '$sizeormeasurement', '$orderqty', '$iduom', '$itemtype', '$project', '$itemnature')");




}




   
    
    echo $cls_meassage->change_it_requst_status($refn);


    
?>