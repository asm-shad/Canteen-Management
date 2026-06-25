<?php

// session_start();
// if(!isset($_SESSION['login_id'])){

// echo "<script>location.href='login.php';</script>";
// }

session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit;
}


error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', 0);

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$userID         = $_SESSION['login_id'];
$employeeID     = $_SESSION['employeeID'];
$username       = $_SESSION['user_name'];
$email      = $_SESSION['email'];



function generateTokenn($expirySecondss) {
// Check if token already exists in the session
if (!isset($_SESSION['tokenn']) || !isset($_SESSION['expiryTimee']) || $_SESSION['expiryTimee'] < time()) {
$timestamp = time();
$tokenn = uniqid('', true); // Generate a unique ID

// Calculate the expiry time
$expiryTimee = $timestamp + $expirySecondss;

// Store the token and expiry time in the session
$_SESSION['tokenn'] = $tokenn;
$_SESSION['expiryTimee'] = $expiryTimee;
}

return $_SESSION['tokenn'];
}

function isTokenExpired($tokenn) {
// Check if token exists and has expired
return (!isset($_SESSION['tokenn']) || $_SESSION['tokenn'] !== $tokenn || $_SESSION['expiryTimee'] < time());
}

$expirySecondss = 3000; 
$tokenn = generateTokenn($expirySecondss);



 function random_strings($length_of_string)
  {     
      // String of all alphanumeric character
      $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
   
      // Shuffle the $str_result and returns substring
      // of specified length
      return substr(str_shuffle($str_result),
                         0, $length_of_string);
  }
  // This function will generate
  // Random string of length 6

  $vrfy_code = random_strings(6).$mdate = date("s"); 
        

 function convertToBaseUnit($value, $uom) {
    $conversion = [
        'kg' => 1000,   // 1 kg = 1000 grams
        'gram' => 1,
        'liter' => 1000, // 1 liter = 1000 ml
        'Piece' => 1,
        'ml' => 1,
        'packet' => 1   // if no conversion, assume 1
    ];

        return $value * ($conversion[$uom] ?? 1);
    }


require_once('cls_dbconfig.php');
spl_autoload_register(function($classname) {
require_once("$classname.class.php");
});

$cls_dbconfig = new cls_dbconfig();
$db = $cls_dbconfig->connection();


$cls_meassage = new cls_meassage();

$all_company = $cls_meassage->show_all_company();

$all_category = $cls_meassage->show_all_cagetory();

$all_department = $cls_meassage->show_all_department();
$all_section = $cls_meassage->show_all_section();

$all_assign_role_user = $cls_meassage->show_all_role_user();

$all_category_role = $cls_meassage->show_all_category_role();


$all_department_role = $cls_meassage->show_all_department_role();
$all_section_role = $cls_meassage->show_all_section_role();

$all_role_user_signature = $cls_meassage->show_all_role_user_signature();

$all_message = $cls_meassage->all_show_meassge_notifaction();

$it_approve_for_waiting = $cls_meassage->all_show_approve_for_waiting($username);

$store_process_waiting = $cls_meassage->show_approved_waitine_edit($username);


$sql_requisition_approved = $cls_meassage->sql_requisition_alreadyapproved();


$all_department_application_role = $cls_meassage->show_all_department_application_role();

//$all_data = $all_message->fetch_assoc();


// Bulk requisition

// $all_bulk_role = $cls_meassage->show_all_bulk_role();

// $it_approve_for_bulk_waiting = $cls_meassage->all_show_approve_for_bulk_waiting();

// $sql_requisition_bulk_approved = $cls_meassage->sql_requisition_bulk_alreadyapproved();

$all_items_name = $cls_meassage->items_name();


$sql_get_token = $db->query("SELECT * FROM tbl_generatetokenn WHERE username='$username ' and gen_token='$tokenn' and actionStatus='2'");

$tokendata = $sql_get_token->fetch_assoc();

$token = $tokendata['gen_token'];
$verifycode = $tokendata['verifycode'];

// if ($tokenn==$token) {
//     echo $tokenn."----".$token;
// }else{
//      echo $tokenn;
//      echo "<br>";
//     echo "no";
// }



$sql_requisition_derpt_approve_wating = $cls_meassage->sql_requisition_derpt_waiting_approved($username);

$total_deprt_waiting = $sql_requisition_derpt_approve_wating->fetch_assoc();

$sql_requisition_section_approve_wating = $cls_meassage->sql_requisition_section_waiting_approved($username);

$total_section_waiting = $sql_requisition_section_approve_wating->fetch_assoc();

$sql_Bill_approve_wating = $cls_meassage->sql_Bill_approve_waiting_approved($username);

$total_bill_waiting = $sql_Bill_approve_wating->fetch_assoc();


$sql_Admin_Bill_approve_wating = $cls_meassage->sql_admin_Bill_approve_waiting_approved($username);

$total_admin_bill_waiting = $sql_Admin_Bill_approve_wating->fetch_assoc();


$sql_requisition_Boss_approve_wating = $cls_meassage->sql_requisition_Boss_waiting_approved($username);

$total_Boss_waiting = $sql_requisition_Boss_approve_wating->fetch_assoc();


$sql_Bill_Audit_wating = $cls_meassage->sql_Bill_approve_Audit($username);

$total_Audit_bill_waiting = $sql_Bill_Audit_wating->fetch_assoc();


$sql_Bill_tore_wating = $cls_meassage->sql_Bill_approve_store($username);

$total_store_bill_waiting = $sql_Bill_tore_wating->fetch_assoc();



$all_it_requisition_for_role = $cls_meassage->show_it_requisition_for_role($username);

$requisition_for_role_user = $cls_meassage->show_it_requisition_for_role_user($username);


//error_reporting(0);

//Approval User HR Admin

// $sql_canteen_requisition = $db->query("SELECT c.id,  c.reference, c.requesterID, c.requesterName, c.designation, c.department, c.section, c.costDivision, c.PurchaseFor, c.ruqest_date, c.email
// FROM canteen_header c
// LEFT JOIN user_role r
// ON c.PurchaseFor = r.category and c.costDivision=r.companyID LEFT JOIN canteen_line a ON c.reference = a.reference where r.user_name='$username' and c.approvedStatus='0' and c.status='1' and r.user_type='Approval User'  GROUP BY c.id");


$sql_canteen_requisition = $db->query("SELECT c.id, MIN(c.reference) AS reference, MIN(c.requesterID) AS requesterID, MIN(c.requesterName) AS requesterName, MIN(c.designation) AS designation, MIN(c.department) AS department, MIN(c.section) AS section, MIN(c.costDivision) AS costDivision, MIN(c.PurchaseFor) AS PurchaseFor, MIN(c.ruqest_date) AS ruqest_date, MIN(c.email) AS email FROM canteen_header c LEFT JOIN user_role r ON c.PurchaseFor = r.category AND c.costDivision = r.companyID LEFT JOIN canteen_line a ON c.reference = a.reference WHERE r.user_name='$username' AND c.approvedStatus='0' AND c.status='1' AND r.user_type='Approval User' GROUP BY c.id");


//department notify

// $sql_requisition_notify = $db->query("SELECT c.id,  c.reference, c.requesterID, c.requesterName, c.designation, c.department, c.section, c.costDivision, c.PurchaseFor, c.ruqest_date
// FROM canteen_header c
// LEFT JOIN user_role r
// ON c.PurchaseFor = r.category and c.costDivision=r.companyID where r.user_name='$username' and c.approvedStatus='0' and c.status='1' and r.user_type='Approval User' GROUP BY c.id");


$sql_requisition_notify = $db->query("SELECT c.id, MIN(c.reference) AS reference, MIN(c.requesterID) AS requesterID, MIN(c.requesterName) AS requesterName, MIN(c.designation) AS designation, MIN(c.department) AS department, MIN(c.section) AS section, MIN(c.costDivision) AS costDivision, MIN(c.PurchaseFor) AS PurchaseFor, MIN(c.ruqest_date) AS ruqest_date FROM canteen_header c LEFT JOIN user_role r ON c.PurchaseFor = r.category AND c.costDivision = r.companyID WHERE r.user_name='$username' AND c.approvedStatus='0' AND c.status='1' AND r.user_type='Approval User' GROUP BY c.id ORDER BY c.id ASC");


//Admin Bill

$sql_requisition_Admin_bill = $db->query("SELECT c.id, MIN(c.reference) AS reference, MIN(c.requesterID) AS requesterID, MIN(c.requesterName) AS requesterName, MIN(c.designation) AS designation, MIN(c.department) AS department, MIN(c.section) AS section, MIN(c.costDivision) AS costDivision, MIN(c.PurchaseFor) AS PurchaseFor, MIN(c.ruqest_date) AS ruqest_date, MIN(c.email) AS email FROM canteen_header c LEFT JOIN user_role r ON c.PurchaseFor = r.category AND c.costDivision = r.companyID LEFT JOIN canteen_line a ON c.reference = a.reference WHERE r.user_name='$username' AND c.approvedStatus='7' AND c.status='1' AND r.user_type='Approval User' GROUP BY c.id ORDER BY c.id ASC");


//HR head

// $sql_requisition_HRHD = $db->query("SELECT c.id,  c.reference, c.requesterID, c.requesterName, c.designation, c.department, c.section, c.costDivision, c.PurchaseFor, c.ruqest_date, c.email
// FROM canteen_header c
// LEFT JOIN user_role r
// ON c.PurchaseFor = r.category and c.costDivision=r.companyID LEFT JOIN canteen_line a ON c.reference = a.reference where r.user_name='$username' and c.approvedStatus='1' and c.status='1' and r.user_type='Head of HR'  GROUP BY c.id");


$sql_requisition_HRHD = $db->query("SELECT c.id, MIN(c.reference) AS reference, MIN(c.requesterID) AS requesterID, MIN(c.requesterName) AS requesterName, MIN(c.designation) AS designation, MIN(c.department) AS department, MIN(c.section) AS section, MIN(c.costDivision) AS costDivision, MIN(c.PurchaseFor) AS PurchaseFor, MIN(c.ruqest_date) AS ruqest_date, MIN(c.email) AS email FROM canteen_header c LEFT JOIN user_role r ON c.PurchaseFor = r.category AND c.costDivision = r.companyID   LEFT JOIN canteen_line a ON c.reference = a.reference WHERE r.user_name='$username' AND c.approvedStatus='1' AND c.status='1' AND r.user_name = '$username' AND r.user_type='Head of HR' GROUP BY c.id ORDER BY c.id ASC");

//requisition for only  HR Head 

// $sql_requisition_only_HRHD = $db->query("SELECT c.id,  c.reference, c.requesterID, c.requesterName, c.designation, c.department, c.section, c.costDivision, c.PurchaseFor, c.ruqest_date
// FROM canteen_header c
// LEFT JOIN user_role r
// ON c.PurchaseFor = r.category and c.costDivision=r.companyID where r.user_name='$username' and c.approvedStatus='1' and c.status='1' and r.user_type='Head of HR' GROUP BY c.id ");

$sql_requisition_only_HRHD = $db->query("SELECT c.id, MIN(c.reference) AS reference, MIN(c.requesterID) AS requesterID, MIN(c.requesterName) AS requesterName, MIN(c.designation) AS designation, MIN(c.department) AS department, MIN(c.section) AS section, MIN(c.costDivision) AS costDivision, MIN(c.PurchaseFor) AS PurchaseFor, MIN(c.ruqest_date) AS ruqest_date FROM canteen_header c LEFT JOIN user_role r ON c.PurchaseFor = r.category AND c.costDivision = r.companyID WHERE r.user_name='$username' AND c.approvedStatus='1' AND c.status='1' AND r.user_type='Head of HR' GROUP BY c.id ORDER BY c.id ASC ");


//HR head Bill

// $sql_requisition_HRHD_bill = $db->query("SELECT c.id,  c.reference, c.requesterID, c.requesterName, c.designation, c.department, c.section, c.costDivision, c.PurchaseFor, c.ruqest_date, c.email
// FROM canteen_header c
// LEFT JOIN user_role r
// ON c.PurchaseFor = r.category and c.costDivision=r.companyID LEFT JOIN canteen_line a ON c.reference = a.reference where r.user_name='$username' and c.approvedStatus='4' and c.status='1' and r.user_type='Head of HR'  GROUP BY c.id");

$sql_requisition_HRHD_bill = $db->query("SELECT c.id, MIN(c.reference) AS reference, MIN(c.requesterID) AS requesterID, MIN(c.requesterName) AS requesterName, MIN(c.designation) AS designation, MIN(c.department) AS department, MIN(c.section) AS section, MIN(c.costDivision) AS costDivision, MIN(c.PurchaseFor) AS PurchaseFor, MIN(c.ruqest_date) AS ruqest_date, MIN(c.email) AS email FROM canteen_header c LEFT JOIN user_role r ON c.PurchaseFor = r.category AND c.costDivision = r.companyID LEFT JOIN canteen_line a ON c.reference = a.reference WHERE r.user_name='$username' AND c.approvedStatus='4' AND c.status='1' AND r.user_type='Head of HR' GROUP BY c.id ORDER BY c.id ASC");

// HR Bill Notifaction

// $sql_requisition_Bill_notify = $db->query("SELECT c.id,  c.reference, c.requesterID, c.requesterName, c.designation, c.department, c.section, c.costDivision, c.PurchaseFor, c.ruqest_date, c.email
// FROM canteen_header c
// LEFT JOIN user_role r
// ON c.PurchaseFor = r.category and c.costDivision=r.companyID LEFT JOIN canteen_line a ON c.reference = a.reference where r.user_name='$username' and c.approvedStatus='4' and c.status='1' and r.user_type='Head of HR'  GROUP BY c.id");


$sql_requisition_Bill_notify = $db->query("SELECT c.id, MIN(c.reference) AS reference, MIN(c.requesterID) AS requesterID, MIN(c.requesterName) AS requesterName, MIN(c.designation) AS designation, MIN(c.department) AS department, MIN(c.section) AS section, MIN(c.costDivision) AS costDivision, MIN(c.PurchaseFor) AS PurchaseFor, MIN(c.ruqest_date) AS ruqest_date, MIN(c.email) AS email FROM canteen_header c LEFT JOIN user_role r ON c.PurchaseFor = r.category AND c.costDivision = r.companyID LEFT JOIN canteen_line a ON c.reference = a.reference WHERE r.user_name='$username' AND c.approvedStatus='4' AND c.status='1' AND r.user_type='Head of HR' GROUP BY c.id ORDER BY c.id ASC");

//Aduit Bill

// $sql_requisition_audit_bill = $db->query("SELECT c.id,  c.reference, c.requesterID, c.requesterName, c.designation, c.department, c.section, c.costDivision, c.PurchaseFor, c.ruqest_date, c.email
// FROM canteen_header c
// LEFT JOIN user_role r
// ON c.PurchaseFor = r.category and c.costDivision=r.companyID LEFT JOIN canteen_line a ON c.reference = a.reference where r.user_name='$username' and c.approvedStatus='5' and c.status='1' and r.user_type='Internal Audit'  GROUP BY c.id");

$sql_requisition_audit_bill = $db->query("SELECT c.id, MIN(c.reference) AS reference, MIN(c.requesterID) AS requesterID, MIN(c.requesterName) AS requesterName, MIN(c.designation) AS designation, MIN(c.department) AS department, MIN(c.section) AS section, MIN(c.costDivision) AS costDivision, MIN(c.PurchaseFor) AS PurchaseFor, MIN(c.ruqest_date) AS ruqest_date, MIN(c.email) AS email FROM canteen_header c LEFT JOIN user_role r ON c.PurchaseFor = r.category AND c.costDivision = r.companyID LEFT JOIN canteen_line a ON c.reference = a.reference WHERE r.user_name='$username' AND c.approvedStatus='5' AND c.status='1' AND r.user_type='Internal Audit' GROUP BY c.id ORDER BY c.id ASC");

//Aduit Bill

// $sql_requisition_audit_bill_notify = $db->query("SELECT c.id,  c.reference, c.requesterID, c.requesterName, c.designation, c.department, c.section, c.costDivision, c.PurchaseFor, c.ruqest_date, c.email
// FROM canteen_header c
// LEFT JOIN user_role r
// ON c.PurchaseFor = r.category and c.costDivision=r.companyID LEFT JOIN canteen_line a ON c.reference = a.reference where r.user_name='$username' and c.approvedStatus='5' and c.status='1' and r.user_type='Internal Audit'  GROUP BY c.id");


$sql_requisition_audit_bill_notify = $db->query("SELECT c.id, MIN(c.reference) AS reference, MIN(c.requesterID) AS requesterID, MIN(c.requesterName) AS requesterName, MIN(c.designation) AS designation, MIN(c.department) AS department, MIN(c.section) AS section, MIN(c.costDivision) AS costDivision, MIN(c.PurchaseFor) AS PurchaseFor, MIN(c.ruqest_date) AS ruqest_date, MIN(c.email) AS email FROM canteen_header c LEFT JOIN user_role r ON c.PurchaseFor = r.category AND c.costDivision = r.companyID LEFT JOIN canteen_line a ON c.reference = a.reference WHERE r.user_name='$username' AND c.approvedStatus='5' AND c.status='1' AND r.user_type='Internal Audit' GROUP BY c.id ORDER BY c.id ASC");


// requisition for only  Boss

// $sql_requisition_Boss = $db->query("SELECT c.id,  c.reference, c.requesterID, c.requesterName, c.designation, c.department, c.section, c.costDivision, c.PurchaseFor, c.ruqest_date, c.email
// FROM canteen_header c
// LEFT JOIN user_role r
// ON c.PurchaseFor = r.category and c.costDivision=r.companyID LEFT JOIN canteen_line a ON c.reference = a.reference where r.user_name='$username' and c.approvedStatus='3' and c.status='1' and r.user_type='Boss'  GROUP BY c.id");

$sql_requisition_Boss = $db->query("SELECT c.id, MIN(c.reference) AS reference, MIN(c.requesterID) AS requesterID, MIN(c.requesterName) AS requesterName, MIN(c.designation) AS designation, MIN(c.department) AS department, MIN(c.section) AS section, MIN(c.costDivision) AS costDivision, MIN(c.PurchaseFor) AS PurchaseFor, MIN(c.ruqest_date) AS ruqest_date, MIN(c.email) AS email FROM canteen_header c LEFT JOIN user_role r ON c.PurchaseFor = r.category AND c.costDivision = r.companyID LEFT JOIN canteen_line a ON c.reference = a.reference WHERE r.user_name='$username' AND c.approvedStatus='3' AND c.status='1' AND r.user_type='Boss' GROUP BY c.id ORDER BY c.id ASC");



// $sql_requisition_only_Boss = $db->query("SELECT c.id,  c.reference, c.requesterID, c.requesterName, c.designation, c.department, c.section, c.costDivision, c.PurchaseFor, c.ruqest_date
// FROM canteen_header c
// LEFT JOIN user_role r
// ON c.PurchaseFor = r.category and c.costDivision=r.companyID where r.user_name='$username' and c.approvedStatus='3' and c.status='1' and r.user_type='Boss' GROUP BY c.id ");

$sql_requisition_only_Boss = $db->query("SELECT c.id, MIN(c.reference) AS reference, MIN(c.requesterID) AS requesterID, MIN(c.requesterName) AS requesterName, MIN(c.designation) AS designation, MIN(c.department) AS department, MIN(c.section) AS section, MIN(c.costDivision) AS costDivision, MIN(c.PurchaseFor) AS PurchaseFor, MIN(c.ruqest_date) AS ruqest_date FROM canteen_header c LEFT JOIN user_role r ON c.PurchaseFor = r.category AND c.costDivision = r.companyID WHERE r.user_name='$username' AND c.approvedStatus='3' AND c.status='1' AND r.user_type='Boss' GROUP BY c.id ORDER BY c.id ASC");


// section notify

// $sql_requisition_section_approve_notify = $db->query("SELECT c.id, c.reference, c.requesterID, c.requesterName, c.designation, c.department, c.section, c.costDivision, c.ruqest_date
// FROM canteen_header c
// CROSS JOIN user_role r
// ON c.department = r.departmentname AND c.section = r.scetionname AND c.costDivision = r.companyname where r.user_name='$username' and c.approvedStatus='0' and c.status='1' and r.user_type='Head of section' GROUP BY c.id");


$sql_requisition_section_approve_notify = $db->query("SELECT DISTINCT c.id, c.reference, c.requesterID, c.requesterName, c.designation, c.department, c.section, c.costDivision, c.ruqest_date FROM canteen_header c INNER JOIN user_role r ON c.department = r.departmentname AND c.section = r.scetionname AND c.costDivision = r.companyname WHERE r.user_name='$username' AND c.approvedStatus='0' AND c.status='1' AND r.user_type='Head of section' ORDER BY c.id ASC");


// section

// $sql_requisition_section_approve = $db->query("SELECT c.id, c.reference, c.requesterID, c.requesterName, c.designation, c.department, c.section, c.costDivision, c.ruqest_date, c.email
// FROM canteen_header c
// CROSS JOIN user_role r
// ON c.department = r.departmentname AND c.section = r.scetionname AND c.costDivision = r.companyname where r.user_name='$username' and c.approvedStatus='0' and c.status='1' and r.user_type='Head of section' GROUP BY c.id ");


$sql_requisition_section_approve = $db->query("SELECT DISTINCT c.id, c.reference, c.requesterID, c.requesterName, c.designation, c.department, c.section, c.costDivision, c.ruqest_date, c.email FROM canteen_header c INNER JOIN user_role r ON c.department = r.departmentname AND c.section = r.scetionname AND c.costDivision = r.companyname WHERE r.user_name='$username' AND c.approvedStatus='0' AND c.status='1' AND r.user_type='Head of section' ORDER BY c.id ASC");


// application notify

?>


<!doctype html>
<html lang="en">

<head>
<title>LDC Group</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<!-- CSS -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/vendor/icon-sets.css">
<link rel="stylesheet" href="assets/css/main.min.css">
<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
<link rel="stylesheet" href="assets/css/demo.css">
<!-- GOOGLE FONTS -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
<!-- ICONS -->
<link rel="apple-touch-icon" sizes="76x76" href="assets/img/aapple-icon.png">
<link rel="icon" type="image/png" sizes="96x96" href="assets/img/afavicon.png">

<link rel="stylesheet" href="alert/alertify.min.css">
<link rel="stylesheet" href="alert/default.min.css">


<!-- DataTables Responsive CSS -->
    <link href="vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Daterangepicker CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <!-- JS: Load in correct order -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <!-- Other JS -->
    <script src="https://docraptor.com/docraptor-1.0.0.js"></script>


<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> -->

<script>


function printDiv(printableArea) {
var printContents = document.getElementById(printableArea).innerHTML;
var originalContents = document.body.innerHTML;

document.body.innerHTML = printContents;

window.print();

document.body.innerHTML = originalContents;
}
var downloadPDF = function() {
DocRaptor.createAndDownloadDoc("#printableArea", {
test: true, // test documents are free, but watermarked
type: "pdf",
document_content: document.querySelector('html').innerHTML, // use this page's HTML
// document_content: "<h1>Hello world!</h1>",               // or supply HTML directly
// document_url: "http://example.com/your-page",            // or use a URL
// javascript: true,                                        // enable JavaScript processing
// prince_options: {
//   media: "screen",                                       // use screen styles instead of print styles
// }
})
}
</script>
<style type="text/css">

.btn-sm{
padding: 5px 11px !important;
width: 75px !important;
}
.ref{
padding-top: 23px;

}

.btn-secondary {
color: #fff;
background-color: #6c757d;
border-color: #6c757d;
}
.table{
font-size: 13px;
}


</style>

</head>

<body>
<!-- WRAPPER -->
<div id="wrapper">
<!-- SIDEBAR -->
<div class="sidebar">
<div class="brand">
    <a href="index.php"><?php echo $_SESSION['name']; ?></a>
</div>
<div class="sidebar-scroll">
    <nav>
        <ul class="nav">
            <li><a href="index.php" class="active"><i class="lnr lnr-home"></i> <span>Dashboard </span></a></li>


<?php

      if($_SESSION['user_role']=="Admin"){

        
?>
            <li>
            <a href="#subPagelist" data-toggle="collapse" class="collapsed"><i class="lnr lnr-layers"></i> <span>Requisition</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
            <div id="subPagelist" class="collapse ">
                <ul class="nav">

                <li><a href="it-service-list.php" class="">Requisition List</a></li>
                
            </ul>
            </div>
          </li>

           <!-- Suppliers -->
            <li>
                <a href="#subPagesprSupplier" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Supplier</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                <div id="subPagesprSupplier" class="collapse ">
                    <ul class="nav">
                        <li><a href="create_supplier.php" class="">All Supplier</a></li>
                    </ul>
                </div>
            </li>

            <li>
            <a href="#subPagesection" data-toggle="collapse" class="collapsed"><i class="lnr lnr-rocket"></i> <span>Add Msater Data</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
            <div id="subPagesection" class="collapse ">
                <ul class="nav">

                <li><a href="Category.php" class=""><i class="lnr lnr-code"></i> <span>Category</span></a></li>

                <li><a href="department.php" class=""><i class="lnr lnr-code"></i> <span>Department</span></a></li>
                
                <li><a href="section.php" class=""><i class="lnr lnr-code"></i> <span>Section</span></a></li>

                </ul>
                </div>
            </li>

            <li>
                <a href="#subPagesadmin" data-toggle="collapse" class="collapsed"><i class="lnr lnr-user"></i> <span>System Approval user</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                <div id="subPagesadmin" class="collapse ">
                    <ul class="nav">
                        <li><a href="create-approve-user.php" class="">Create Approve User</a></li>
                        <li><a href="list-approve-user.php" class="">List Approve User</a></li>
                        <!-- <li><a href="role-user-signature.php" class="">Signature</a></li> -->
                    </ul>
                </div>
            </li>


            <li>
                <a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-cog"></i> <span>Permission</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                <div id="subPages" class="collapse ">
                    <ul class="nav">
                        <li><a href="assign-category.php" class="">Category Role Assign</a></li>
                        <!-- <li><a href="assign-department.php" class="">department Role Assign</a></li> -->
                        <!-- <li><a href="assign-section.php" class="">Section Role Assign</a></li> -->
                        
                    </ul>
                </div>
            </li>

                <li>
                <a href="#subPagesadminm" data-toggle="collapse" class="collapsed"><i class="lnr lnr-store"></i> <span> Consumption</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                <div id="subPagesadminm" class="collapse ">
                    <ul class="nav">
                        <li><a href="consumptionAdd.php" class="">Consumption Add</a></li>

                        <li><a href="consumptionList.php" class="">Consumption List</a></li>

                        <!-- <li><a href="role-user-signature.php" class="">Signature</a></li> -->
                    </ul>
                </div>
            </li>

        <?php }elseif($_SESSION['user_role']=="Store"){  ?>

            

                <li>
                <a href="#subPagespro" data-toggle="collapse" class="collapsed"><i class="lnr lnr-dice"></i> <span>Requisition Process ffff</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                <div id="subPagespro" class="collapse ">
                    <ul class="nav">
                        <li><a href="create-pr.php" class=""><i class=""></i> <span>Receipts</span></a></li>
                    <!-- <li><a href="alreadyapproved.php" class=""><i class=""></i> <span>Create PO</span></a></li> -->
                    </ul>
                </div>
            </li>

            <li>
                <a href="#subPagesprr" data-toggle="collapse" class="collapsed"><i class="lnr lnr-chart-bars"></i> <span>Requisition</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                <div id="subPagesprr" class="collapse ">
                    <ul class="nav">
                        <li><a href="requisition-status.php" class="">All Requisition Status</a></li>
                    </ul>
                </div>
            </li>

            <li>
                <a href="#subPagesprc" data-toggle="collapse" class="collapsed"><i class="lnr lnr-chart-bars"></i> <span>Consumption</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                <div id="subPagesprc" class="collapse ">
                    <ul class="nav">
                        <li><a href="consumption.php" class="">Consumption Add</a></li>
                    </ul>
                </div>
            </li>

            
        
    <?php }else{ ?>

        <?php   

            while($role_for_requisition = $all_it_requisition_for_role->fetch_assoc()){

            ?>

        <?php if($role_for_requisition['user_type']=='Approval User'){ ?>

        <li>
            <a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-rocket"></i> <span>Approval</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
            <div id="subPages" class="collapse ">
                <ul class="nav">

        <li><a href="approve-purrequi.php" class="">Requisition</a></li>

        <!-- <?php  if ($tokenn==$token){ ?>

             <script>
                function autoRefresh() {
                    window.location = window.location.href;
                }
                setInterval('autoRefresh()', 500000);
            </script>

        <?php }else{ ?>

            <script>
                function autoRefresh() {
                    window.location = window.location.href;
                }
                setInterval('autoRefresh()', 80000);
            </script>

        <?php } ?> -->

        </ul>
    </li>

      <li>
            <a href="#subPageshrbil" data-toggle="collapse" class="collapsed"><i class="lnr lnr-briefcase"></i> <span>Bill Approval</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                <div id="subPageshrbil" class="collapse ">
                    <ul class="nav">
                        <li><a href="approve-admin-bill.php" class="">Bill</a></li>
                    </ul>
        </li>

        <li>
            <a href="#subPagesprr" data-toggle="collapse" class="collapsed"><i class="lnr lnr-chart-bars"></i> <span>Requisition</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                <div id="subPagesprr" class="collapse ">
                    <ul class="nav">
                        <li><a href="current-status.php" class="">All Requisition Status</a></li>
                    </ul>
                </div>
        </li>

    <?php }elseif($role_for_requisition['user_type']=='Head of HR'){ ?>

    <li>
        <a href="#subPageshr" data-toggle="collapse" class="collapsed"><i class="lnr lnr-rocket"></i> <span>Approval</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
        <div id="subPageshr" class="collapse ">
            <ul class="nav">

            <li><a href="approve-hrd.php" class="">Requisition</a></li>

            <!-- <?php  if ($tokenn==$token){ ?>

                 <script>
                    function autoRefresh() {
                        window.location = window.location.href;
                    }
                    setInterval('autoRefresh()', 500000);
                </script>

            <?php }else{ ?>

                <script>
                    function autoRefresh() {
                        window.location = window.location.href;
                    }
                    setInterval('autoRefresh()', 80000);
                </script>

            <?php } ?> -->

            </ul>
    </li>
    <li>
        <a href="#subPageshrbil" data-toggle="collapse" class="collapsed"><i class="lnr lnr-briefcase"></i> <span>Bill Approval</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
        <div id="subPageshrbil" class="collapse ">
        <ul class="nav">

            <li><a href="approve-hrd-bill.php" class="">Bill</a></li>

        
        </ul>
    </li>

    <?php }elseif($role_for_requisition['user_type']=='Boss'){ ?>

    <li>
        <a href="#subPagesboss" data-toggle="collapse" class="collapsed"><i class="lnr lnr-rocket"></i> <span>Approval</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
        <div id="subPagesboss" class="collapse ">
        <ul class="nav">

        <li><a href="approve-bo.php" class="">Requisition</a></li>

        <!-- <?php  if ($tokenn==$token){ ?>

             <script>
                function autoRefresh() {
                    window.location = window.location.href;
                }
                setInterval('autoRefresh()', 500000);
            </script>

        <?php }else{ ?>

            <script>
                function autoRefresh() {
                    window.location = window.location.href;
                }
                setInterval('autoRefresh()', 80000);
            </script>

        <?php } ?> -->

        </ul>
        </li>


     <?php }elseif($role_for_requisition['user_type']=='Internal Audit'){ ?>

        <li>
            <a href="#subPagesi" data-toggle="collapse" class="collapsed"><i class="lnr lnr-rocket"></i> <span>Audit</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                <div id="subPagesi" class="collapse ">
                    <ul class="nav">

                    <li><a href="approve-duit.php" class="">Bill</a></li>
                    <!-- 
                    <script>
                        function autoRefresh() {
                            window.location = window.location.href;
                        }
                        setInterval('autoRefresh()', 80000);
                    </script> -->
                </ul>

        </li>

         <?php } elseif($role_for_requisition['user_type']=='Store'){ ?>


                <li>
                <a href="#subPagespro" data-toggle="collapse" class="collapsed"><i class="lnr lnr-dice"></i> <span>Requisition Process</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                <div id="subPagespro" class="collapse ">
                    <ul class="nav">
                        <li><a href="create-pr.php" class=""><i class=""></i> <span>Receipts</span></a></li>
                    <!-- <li><a href="alreadyapproved.php" class=""><i class=""></i> <span>Create PO</span></a></li> -->
                    </ul>
                </div>
            </li>

            <li>
                <a href="#subPagesprr" data-toggle="collapse" class="collapsed"><i class="lnr lnr-chart-bars"></i> <span>Requisition</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                <div id="subPagesprr" class="collapse ">
                    <ul class="nav">
                        <li><a href="requisition-status.php" class="">All Requisition Status</a></li>
                    </ul>
                </div>
            </li>
            

            <li>
            <a href="#subPagesApplication" data-toggle="collapse" class="collapsed"><i class="lnr lnr-dinner"></i>                                              <span> Canteen Booking</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
            <div id="subPagesApplication" class="collapse ">
                <ul class="nav">
                    <li><a href="createApplication.php" class="">Create Application</a></li>
                    <li><a href="viewAllApplication.php" class="">All Application Information</a></li>
                    <!-- <li><a href="eligibleGeneral.php" class=""> Eligible Applicants General</a></li> -->
                    <?php
                    $companyID = trim(strtoupper($role_for_requisition['companyID']));
                    ?>

                    <?php if ($companyID != 'GFP') { ?>
                        <li>
                            <a href="eligibleGeneral.php" class="">Waiting Applicants General</a>
                        </li>
                    <?php } ?>
                    <li><a href="eligibleVIP.php" class=""> Waiting Applicants VIP</a></li>
                    <li><a href="AllAcceptedApplicants.php" class=""> Eligible Applicants</a></li>
                </ul>
            </div>
            </li>       

            <li>
                <a href="#subPagesprc" data-toggle="collapse" class="collapsed"><i class="lnr lnr-chart-bars"></i> <span>Consumption</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                <div id="subPagesprc" class="collapse ">
                    <ul class="nav">
                        <li><a href="consumption.php" class="">Consumption Add</a></li>
                    </ul>
                </div>
            </li>

    <?php } } } ?>


        <!-- Reports -->
            <li>
              <a href="#subPagesprrpt" data-toggle="collapse" class="collapsed"><i class="lnr lnr-file-empty"></i> <span>Reports</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
              <div id="subPagesprrpt" class="collapse ">
                 <ul class="nav">
                <li><a href="item_purchase_history.php" class="">Item wise Purchase History</a></li>
                <li><a href="yearly_purchase_history.php" class="">Yearly Purchase History</a></li>
                 </ul>
              </div>
            </li>
            
        <!-- Settings -->
            <li>
                <a href="#subPagespr" data-toggle="collapse" class="collapsed"><i class="lnr lnr-cog"></i> <span>Settings</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                <div id="subPagespr" class="collapse ">
                    <ul class="nav">
                        <li><a href="profile.php" class="">Profile</a></li>
                        <li><a href="password_change.php" class="">Password Change</a></li>
                    </ul>
                </div>
            </li>
              <?php
      if($_SESSION['user_role']=="Admin"){
        ?>
        

  <?php } ?>
            

        </ul>
    </nav>
</div>

</div>
<!-- END SIDEBAR -->



<!-- MAIN -->
<div class="main">
<!-- NAVBAR -->
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-btn">
            <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-text-align-justify"></i></button>
        </div>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-menu">
                <span class="sr-only">Toggle Navigation</span>
                <i class="fa fa-bars icon-nav"></i>
            </button>
        </div>
        <div id="navbar-menu" class="navbar-collapse collapse">
        
            <ul class="nav navbar-nav navbar-right">

           <?php 

            $store = $requisition_for_role_user->fetch_assoc();

            if($store['user_type']=='Store'){  ?>   

                        <li><a href="http://innmanager.liz.com/can" target="_blank" style="background-color:#5bc0de;color: white;">Request Now</a></li> 
                <?php  }else{}?>

    
    <li class="dropdown">

    <?php 

        if($_SESSION['user_role']=="Admin" || $_SESSION['user_role']=="Store"){  }else{?>       

    <a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
        <i class="lnr lnr-alarm"></i>
        <span class="badge bg-danger"> <?php if(!empty($total_deprt_waiting['dept_total_waiting_approve'] +  $total_section_waiting['section_total_waiting_approve'] + $total_Boss_waiting['Boss_total_waiting_approve'] + $total_bill_waiting['bill_total_waiting_approve'] + $total_Audit_bill_waiting['bill_total_waiting_Audit'] + $total_store_bill_waiting['bill_total_waiting_store'])) { 

        echo $total_deprt_waiting['dept_total_waiting_approve'] + $total_section_waiting['section_total_waiting_approve'] + $total_Boss_waiting['Boss_total_waiting_approve'] + $total_bill_waiting['bill_total_waiting_approve'] + $total_Audit_bill_waiting['bill_total_waiting_Audit'] +  $total_store_bill_waiting['bill_total_waiting_store'];

         ?><?php } else { ?>0<?php }
    
         ?>  </span>
    </a>

    <ul class="dropdown-menu notifications">

    <?php   

    while($role_user = $requisition_for_role_user->fetch_assoc()){
    ?>

    <?php if($role_user['user_type']=='Approval User'){ ?>

    <?php

    while($requisition_data_r = $sql_requisition_notify->fetch_assoc()){?>

    <li><a href="rquview.php?view_id=<?php echo md5($requisition_data_r['id']); ?>" class="more">View requisition <?php echo $requisition_data_r['reference']; ?></a></li>


    <?php } ?>


    <?php }elseif($role_user['user_type']=='Head of HR'){ ?>

    <?php
               
        while($requisition_HRHD_data_r = $sql_requisition_only_HRHD->fetch_assoc()){?>

            <li><a href="rquhrdview.php?view_id=<?php echo md5($requisition_HRHD_data_r['id']); ?>" class="more">View Requisition <?php echo $requisition_HRHD_data_r['reference']; ?></a></li>

        <?php 
            }
            
            while($bill_data_r = $sql_requisition_Bill_notify->fetch_assoc()){?>

    <li><a href="rquhrdBillview.php?view_id=<?php echo md5($bill_data_r['id']); ?>" class="more">View Bill <?php echo $bill_data_r['reference']; ?></a></li>


    <?php } ?>

    <?php }elseif($role_user['user_type']=='Boss'){ ?>

    <?php
               
        while($requisition_Boss_data_r = $sql_requisition_only_Boss->fetch_assoc()){?>

            <li><a href="rqubodview.php?view_id=<?php echo md5($requisition_Boss_data_r['id']); ?>" class="more">View Requisition <?php echo $requisition_Boss_data_r['reference']; ?></a></li>

        <?php } ?>


    <?php }elseif($role_user['user_type']=='Internal Audit'){ ?>

    <?php
               
        while($requisition_Adiut_data_r = $sql_requisition_audit_bill_notify->fetch_assoc()){?>

            <li><a href="rquauditdview.php?view_id=<?php echo md5($requisition_Adiut_data_r['id']); ?>" class="more">View Requisition <?php echo $requisition_Adiut_data_r['reference']; ?></a></li>

        <?php } ?>


    <?php  } } ?>

                
        </ul>

    <?php } ?>

        </li>
            
            <li><a href="#" id="signouts"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>                     
            </ul>
        </div>
    </div>
</nav>