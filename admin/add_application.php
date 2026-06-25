<?php
session_start();
require_once('cls_dbconfig.php');

spl_autoload_register(function($classname) {
    require_once("$classname.class.php");
});

$username = $_SESSION['user_name'];

$cls_message = new cls_meassage();

$employee_id       = htmlspecialchars($_POST['employee_id']);
$name              = htmlspecialchars($_POST['name']);
$designations       = htmlspecialchars($_POST['designation']);
$mobile             = htmlspecialchars($_POST['phone']);
$joiningdate_raw = htmlspecialchars($_POST['joiningdate']);
$joining_date = date('Y-m-d', strtotime($joiningdate_raw));
$section_or_department     = htmlspecialchars($_POST['department']);
$employer_factory  = trim($_POST['company_name']);
$level             = htmlspecialchars($_POST['level']);
$application_date  = htmlspecialchars($_POST['application_date']);
$status            = htmlspecialchars($_POST['status']);
// Store the canteen name instead of the code
$category          = htmlspecialchars($_POST['canteen_name']);
$living_status     = htmlspecialchars($_POST['living_status']);
$priority          = htmlspecialchars($_POST['priority']);
$location_distance = htmlspecialchars($_POST['location_distance']);
$live_with_family  = htmlspecialchars($_POST['live_with_family']);
$remarks           = htmlspecialchars($_POST['remarks']);

echo $cls_message->add_application(
   $employee_id,
   $name,
   $designations,
   $mobile,
   $joining_date,
   $section_or_department,
   $employer_factory,
   $level,
   $application_date,
   $status,
   $category,
   $living_status,
   $priority,
   $location_distance,
   $live_with_family,
    $remarks,
    $username
);

