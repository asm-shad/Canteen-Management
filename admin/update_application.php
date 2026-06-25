<?php

require_once('cls_dbconfig.php');

$db = new cls_dbconfig();

$conn = $db->connection();

$id                     = $_POST['id'];
$name                   = $_POST['name'];
$designation            = $_POST['designation'];
$phone                  = $_POST['phone'];
$joiningdate            = $_POST['joiningdate'];
$department             = $_POST['department'];
$company_name           = $_POST['company_name'];
$level                  = $_POST['level'];
$application_date       = $_POST['application_date'];
$category               = $_POST['category'];
$priority               = $_POST['priority'];
$location_distance      = $_POST['location_distance'];
$live_with_family       = $_POST['live_with_family'];
$remarks                = $_POST['remarks'];

$update = $conn->query("

    UPDATE canteen_application

    SET

    name='$name',
    designations='$designation',
    mobile='$phone',
    joining_date='$joiningdate',
    section_or_department='$department',
    employer_factory='$company_name',
    level='$level',
    application_date='$application_date',
    category='$category',
    priority='$priority',
    location_distance='$location_distance',
    live_with_family='$live_with_family',
    remarks='$remarks'

    WHERE id='$id'

");

if($update){

    echo 'success';

}else{

    echo 'error';
}