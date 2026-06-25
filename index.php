<?php

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// $val = '22222';

//   $rowtt = '<span style="color: red;">' . $val . '</span>';


//   echo $rowtt; 

error_reporting(0);

// require_once('admin/cls_dbconfig.php');
//        function __autoload($classname){
//          require_once("$classname.class.php");
//        }

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'admin/PHPMailer/Exception.php';
require 'admin/PHPMailer/PHPMailer.php';
require 'admin/PHPMailer/SMTP.php';

require_once('admin/cls_dbconfig.php');
spl_autoload_register(function($classname) {
require_once("$classname.class.php");
});

$cls_dbconfig = new cls_dbconfig();
$connect = $cls_dbconfig->connection();

if(isset($_POST["submit"]))
{


// $devicename = isset($_POST['device_name']) ? $_POST['device_name'] : '';

$my_array = isset($_POST['itemName']) ? $_POST['itemName'] : array();

$is_empty = false;
foreach($my_array as $element) {
if(empty($element)) {
 $is_empty = true;
 break;
}
}


if(!$is_empty) {


$it_rq_last_id =  $connect->query("SELECT id from canteen_header ORDER by id DESC");

$last_id = $it_rq_last_id->fetch_assoc();

$lstid = $last_id['id'];

$todate = date("Y-m-d");

$mdate = date("s");
$ddate = date("Y");
$rand = rand('111','999');

// $reference = "REF-".$ddate.$rand.$mdate;

 $reference = "REF-".$ddate."00".$lstid;


// $reference       = $connect->real_escape_string($_POST['reference']);
$employeeID  = $connect->real_escape_string(strtoupper($_POST['employeeID']));
$emp_name = $connect->real_escape_string($_POST['emp_name']);
$designation = $connect->real_escape_string($_POST['designation']);
$company = $connect->real_escape_string($_POST['company']);
$department = $connect->real_escape_string($_POST['department']);
$section = $connect->real_escape_string($_POST['section']);
$contact_number = $connect->real_escape_string($_POST['contact_number']);
// $joindate         = $connect->real_escape_string($_POST['joindate']);

$ruqest_date = $connect->real_escape_string(date('Y-m-d', strtotime($_POST['ruqest_date'])));

$email = $connect->real_escape_string($_POST['email']);


$costdivision = $connect->real_escape_string($_POST['costdivision']);
// $costdepartment = $connect->real_escape_string($_POST['cost-depart']);

$category = $connect->real_escape_string($_POST['cost-category']);

$requisitionFor = $connect->real_escape_string($_POST['requisitionFor']);

$itemRemarks = $connect->real_escape_string($_POST['itemRemarks']);


// $linecounter = $connect->real_escape_string($_POST['linecounter']);


// insert

$query = "INSERT INTO canteen_header (reference, requesterID, requesterName, designation, department, section, company, contact, ruqest_date, email, costDivision, category, PurchaseFor, remarks, approvedStatus, status) VALUES ('$reference','$employeeID', '$emp_name', '$designation', '$department', '$section', '$company', '$contact_number', '$ruqest_date', '$email', '$costdivision', '$category', '$requisitionFor', '$itemRemarks', '0', '1')";



$connect->query("UPDATE employee_info SET phone='$contact_number', email=' $email' WHERE employeeID='$employeeID'");




if(mysqli_query($connect, $query))
{
    
     $id = mysqli_insert_id($connect);
     
     $data_url = array_filter($_POST['uom']);

     if (sizeof($data_url)!=0) {

     $line = 1;

 foreach($_POST["itemName"] as $row=>$itemNamet){

    $itemName = $itemNamet;

     $refline = $line++;

    // $refline = $reference.'-'.$linecount;


     $quantity          = $_POST["requidQty"][$row];
     $uom               = $_POST["uom"][$row];
     $ConsumptionType   = $_POST["ConsumptionType"][$row];
     $Reason            = $_POST["itemReason"][$row];

$querysitemnature = $connect->query("SELECT * FROM item_library where LibraryName='CNT-ITEMS' AND ItemName='$itemName'");

$item_data = $querysitemnature->fetch_assoc();
$PurchaseType = $item_data['PurchaseType'];


$queryConsumption = $connect->query("SELECT * FROM consumption where canteenName='$requisitionFor' AND ItemName='$itemName'");

$consumption_data = $queryConsumption->fetch_assoc();

$DailyConsumption      = $consumption_data['DailyConsumption'];
$WeeklyConsumption     = $consumption_data['WeeklyConsumption'];
$MonthlyConsumption    = $consumption_data['MonthlyConsumption'];
$ConsumptionUOM        = $consumption_data['ConsumptionUOM'];

$querys = "INSERT INTO canteen_line (canteenHeaderID, reference, referenceLine, ItemName, quantity, uom, ConsumptionType, ConsumptionUOM, DailyConsumption, WeeklyConsuption, MonthlyConsumption, Reason, PurchaseType, status) VALUES ('$id', '$reference', '$refline', '$itemName', '$quantity', '$uom', '$ConsumptionType', '$ConsumptionUOM', '$DailyConsumption', '$WeeklyConsumption', '$MonthlyConsumption','$Reason', '$PurchaseType', '1')";
        mysqli_query($connect, $querys);



}
}  else {

echo 'false';

}

$mid = md5($id);

echo ('<SCRIPT LANGUAGE="JavaScript">
window.alert("Form submission successfully")
window.location.href="rqprint.php?print=' . $mid . '";
</SCRIPT>');

// echo '<a href="orderprint.php?print=' . $mid . '">Save and Print </a>';   



     
$approval_user = $connect->query("SELECT ur.employeeID, ur.user_name, u.name, u.email, u.employeeID, u.username  FROM user_role ur LEFT JOIN user u ON ur.employeeID=u.employeeID AND ur.user_name=u.username  where companyname='$company' AND category='$requisitionFor' AND user_type='Approval User'");

$approval_data = $approval_user->fetch_assoc();


$upName = $approval_data['name'];
$upEmail = $approval_data['email'];

$mail = new PHPMailer(true); 

try {
// Server settings
$mail->isSMTP();  
// $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Or 0 for no debug
$mail->Host = 'smtp.gmail.com';  
$mail->SMTPAuth = true;  
$mail->Username = 'no.reply.ldc.24@gmail.com';  
$mail->Password = 'fkhp pjdo rxxo gchu '; // <-- Your App Password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
$mail->Port = 587;  

// Sender info
$mail->setFrom('no.reply.ldc.24@gmail.com', 'Canteen System'); 
$mail->addAddress($upEmail);  

// Content
$mail->isHTML(true);  
$mail->Subject = 'Waiting for Approval';  
$mail->Body    = '<!DOCTYPE HTML>'. 
'<head>'. 
'<meta http-equiv="content-type" content="text/html">'.
'<title>Waiting for Approval</title>'. 
'</head>'. 
'<body>'.
'<div style="background:#f6f6f6;color:#383838">'.
'<div class="adM">'.
  '</div>'.
    '<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">'.
       '<tbody>'.
        '<tr>'.
           '<td style="padding:20px 0 20px 0" align="center" valign="top">'.
               '<table style="border:1px solid #e0e0e0" bgcolor="FFFFFF" border="0" cellpadding="10" cellspacing="0" width="650">'.
                    
                '<tbody>'.
                '<tr>'.
                   ' <td valign="top">'.
                        
                        '<span>'.
                            '<p style="font-size:19px;font-weight:normal;line-height:22px;margin:0 0 11px 0">Hi '.$upName.'<p>'.
                        '</span>'.
                    '</td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td valign="top">'.
                           
                            '<a href="http://localhost/canteen-management/admin/login.php?redirect=rquview.php?view_id='.$mid.'" style="font-size:19px;font-weight:normal;line-height:22px;margin:0 0 11px 0">'.'Waiting for Approval <b>'.$reference.' '.'</b></a>'.
                        '</td>'.
                    '</tr>'.
                    '<tr>'.
                      '<td>'.
                     '<p style="font-size:11px;font-weight:normal;line-height:22px;margin:0 0 11px 0">'.'This email has been generated automatically, Please DO NOT reply to this email'.'</p>'.
                      '</td>'.
                    '</tr>'.
                    '</tbody>'.
                    '</table>'.
                '</td>'.
            '</tr>'.
        '</tbody>'.
    '</table>'.
    '<div class="yj6qo">'.'</div>'.
    '<div class="adL">'.
    '</div>'.
'</div>'.

'</body>';   

$mail->send();  
   // echo 'Message has been sent.';  
} catch (Exception $e) {
// echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}




}
else{
echo ('<SCRIPT LANGUAGE="JavaScript">
window.alert("Please your data")
</SCRIPT>');
}
} else{

$color = 'red';
 $font = '20px';

echo "<script>              

    document.addEventListener('DOMContentLoaded', function() {
      

       var element = document.getElementById('emptyMessage');
       element.innerHTML = '<span>You cannot submit an empty form. Please select at least one item.</span>';
        element.style.color = '$color';
       element.style['font-size'] = '$font';
      return false;
    });
</script>";
}




}

$todate = date("Y-m-d");


$itemnamesOption = '<option value="">Select</option>';
$result = $connect->query("SELECT ItemName FROM item_library WHERE LibraryName = 'CNT-ITEMS'");
//$result = $dbConn1->query($sql);

while($row = $result->fetch_assoc()){
$itemnames = $row["ItemName"];
$itemnamesOption .= '<option value="'. $itemnames .'">'. $itemnames .'</option>';
}


$uomnamesOption = '<option value="">Select</option>';
$results = $connect->query("SELECT * FROM item_library WHERE LibraryName = 'UOM'");
//$result = $dbConn1->query($sql);

while($rowr = $results->fetch_assoc()){
$uomnames = trim($rowr["ItemName"]);

$uomnamesOption .= '<option value="'. $uomnames .'">'. $uomnames .'</option>';
}

$company_result = $connect->query("SELECT c.* FROM company_library c JOIN ( SELECT companyID, MAX(id) AS max_id FROM company_library WHERE status='1' GROUP BY companyID ) t ON c.companyID = t.companyID AND c.id = t.max_id ORDER BY c.id ASC");

?>
<html lang="en">

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>LDC Group</title>
<style type="text/css">
<head>
body{
background-color:;
}
body{ font-size:12px;}
#printableArea{
margin: 0 auto;

}
table{
font-size:12px;
}
.top-div{
padding-top: 5px;
}

.form-control{
height: 29px !important;
padding: 4px 6px !important;
}
#equipment{
max-height: 440px;
margin-top: -348px;
}
#equipments{
height: 702px;
}
.col-sm-8 {
width: 64.666667%;
margin-left: -28px;
}
.col-form-label{
padding-top: 5px;
}
#additional{
width: 172px;
}
#f1-group_name{
width: 172px;
}
.header{
font-size: 19px;
}
.input-header{
width: 16px;
height: 16px;
}
.input-laptop{
width: 16px;
height: 16px;
}
.header-title {
font-family: fantasy;
font-size: 230%;
padding: 1px 5px 2px 5px;
}
.sub-title {
font-family: sans-serif;
font-size: 136%;
padding: 1px 5px 2px 5px;
margin-top: -5px;
}
/*#email:required {
background-color: yellow;
}*/

#cke_1_top{
display: none;
}
#cke_1_bottom{
display: none;
}
#cke_2_top{
display: none;
}
#cke_2_bottom{
display: none;
}
#cke_1_contents{
height: 120px !important;
}
#cke_2_contents{
height: 120px !important;
}

</style>



<!-- CSS -->
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
<!--  <link rel="stylesheet" href="assets/css/form-elements.css"> -->

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Favicon and touch icons -->
<link rel="shortcut icon" href="assets/ico/lizlogo.png">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/lizlogo.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/lizlogo.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/lizlogo.png">
<link rel="apple-touch-icon-precomposed" href="assets/ico/lizlogo.png">

</head>
<body>
<div class="container">  
<div id="printableArea">
<div id="cname"> <center><h2 class="header-title">LDC Group</h2></center> </div>
<center><h4 class="sub-title">Request For Purchase</h4></center>

<div style="display: flex; gap: 10px; align-items: center; margin-bottom: 7px;">
                <div>
                    <a href="createApplicationByEmployee.php">
                        <button type="button" class="btn btn-small btn-primary">
                            Book Canteen
                        </button>
                    </a>
                </div>

                <div>
                    <a href="viewAllEmployeePosition.php" target="_blank">
                        <button type="button" class="btn btn-small btn-primary">
                            Eligible Positions
                        </button>
                    </a>
                </div>
            </div>

<form role="form" id="multiphase" enctype="multipart/form-data" action="" method="post">
<table border="1" align="center" cellpadding="0" cellspacing="0" class="shawdow">
<tr>

<td style="padding-left: 5px;">


<div id="equipment">
<div id="getcostinfo">

<div class="row" style="padding-right: 5px;" >

<div class="col-md-10 offset-md-1">
<table width="325" border="0" cellspacing="0" cellpadding="0">

<tr>
<td height="22" style="width:90px;"><b>Date:</b> </td>
<td style="padding-top:3px">
<input type="date" name="ruqest_date" value="<?php echo $todate; ?>" placeholder="yyyy-mm-dd" class="f1-ruqest_date form-control" id="f1-ruqest_date">

</td>
</tr>

<!--   <tr>
 <td height="22"><b>Reference No:</b></td>
 <td style="padding-top:3px"> <input type="text" name="reference" readonly class="f1-refe form-control" id="f1-refe"></td>
</tr> -->
<tr>
<td height="22"><label for="section" class="col-form-label">Cost Division:</label>  

</td>
<td style="padding-top:3px">
 <select class="f1-division form-control" name="costdivision" id="division" required>
      <option value="">Select Cost Division</option>
     <?php while($division = $company_result->fetch_assoc()){ ?>

            <option value="<?php echo $division['companymdm']; ?>"><?php echo $division['company_name']; ?></option>
     
       <?php } ?>
 </select>   
</td>
</tr>
<tr>
  <td height="22" ><label for="section" class="col-form-label">Category:</label>             
 </td>
 <td style="padding-top:3px">                              
     <select class="cost-category form-control" name="cost-category" id="cost-category" required>
        <option value="">Select Category</option>
        <option value="Canteen">Canteen</option>
        <option value="Entertainment">Entertainment</option>
        <option value="Stationary">Stationary</option>
     </select>
 </td>
</tr>
<tr>
  <td height="22" ><label for="requisitionFor" class="col-form-label">Purchase for:</label>             
 </td>
 <td style="padding-top:3px">
     
     <select class="cost-requisitionFor form-control" name="requisitionFor" id="requisitionFor" required>
        <option value="">Select Purchase for</option>
              
     </select>

 </td>
</tr>




</table>

</div>
</div>

</div>
<hr style="margin-left: -7px;">

<table>



<tr>
<!-- 
<td style="padding-top: 5px;"><label> Building </label></td>

<td style="padding-top: 5px;padding-left: 10px;"> -->
   

    <!-- <textarea name="devicelocation" class="f1-devicelocation" style="width: 265px" id="devicelocation" rows="2"></textarea> -->

     <!-- <select class="f1-devicelocation form-control" name="devicelocation" id="devicelocation" style="width: 265px">
      <option value="">Select Building</option>

      </?php while($bulding = $resultLocation->fetch_assoc()){ ?>

            <option value="</?php echo $bulding['Building']; ?>"></?php echo $bulding['Building']; ?></option>
     
       </?php } ?>
 </select> -->


</td>
</tr>

<tr>
<!-- 
<td style="padding-top: 5px;"><label> Location </label></td>

<td style="padding-top: 5px;padding-left: 10px;"> -->
   

    <!-- <textarea name="devicelocation" class="f1-devicelocation" style="width: 265px" id="devicelocation" rows="2"></textarea> -->

<!--   <select class="f1-location form-control" name="location" id="location" style="width: 265px">
      <option value="">Select Location</option>

 </select>


</td> -->
</tr>



</table>


<hr style="margin-left: -7px;">

<table border="0" cellspacing="0" cellpadding="0" style="width: 310px;">

<tr>
<!--  <td height="40"></td> -->
<td colspan="2">
 <div class="form-group">
    <label for="f1-additional">  Remarks </label>
   
    <textarea name="itemRemarks" style="width: 310px;height: ;" placeholder="Enter Remarks" class="itemRemarks" id="itemRemarks" rows="4"></textarea>
                                        
</div>
</td>
</tr>


</table>

</div>
</td>

<td style="padding-left: 10px;">

<div id="equipments">

<div class="row">



<div class="col-md-6 top-div">
<div class="form-group">
<label for="Employee" class="col-sm-4 col-form-label">Employee ID:</label>
<div class="col-sm-8">
  <input type="text" name="employeeID" placeholder="Enter Employee ID" class="employee-id form-control" id="employeeID" style="text-transform:uppercase" required>
</div>
</div>
</div>

<div id="getuserinfo">

<div class="col-md-6 top-div">
<div class="form-group">
<label for="name" class="col-sm-4 col-form-label">Name:</label>
<div class="col-sm-8">
   <input type="text" name="emp_name" placeholder="Enter name..." class="f1-first-name form-control" id="f1-first-name">
</div>
</div>
</div>
<div class="col-md-6 top-div">
<div class="form-group">
<label for="designation" class="col-sm-4 col-form-label">Designation:</label>
<div class="col-sm-8">
   <select class="f1-designation form-control" name="designation" id="f1-designation">
        <option value="">Select Designation</option>
     </select>
</div>
</div>
</div>
<div class="col-md-6 top-div">
<div class="form-group">
<label for="department" class="col-sm-4 col-form-label">Department:</label>
<div class="col-sm-8">
    <select class="f1-department form-control" name="department" id="f1-department">
        <option value="">Select Department</option>
     </select>
</div>
</div>
</div>

<div class="col-md-6 top-div">
<div class="form-group">
<label for="section" class="col-sm-4 col-form-label">User Section:</label>
<div class="col-sm-8">
   <select class="f1-department form-control" name="section" id="f1-department">
            <option value="">Select User Section</option>
                            
     </select>
</div>
</div>
</div>
<div class="col-md-6 top-div">
<div class="form-group">
<label for="name" class="col-sm-4 col-form-label">Contact Number:</label>
<div class="col-sm-8">
  <input type="text" name="contact_number" placeholder="+880" class="f1-contact_number form-control" id="f1-contact_number">
</div>
</div>
</div>
<div class="col-md-6 top-div">
<div class="form-group">
<label for="name" class="col-sm-4 col-form-label">Email:</label>
<div class="col-sm-8">
  <input type="email" name="email" id="email" placeholder="email@example.com" class="form-control" id="email">
</div>
</div>
</div>

<div class="col-md-6 top-div">
<div class="form-group">
<label for="joindate" class="col-sm-4 col-form-label"> Join Date:</label>
<div class="col-sm-8">
   <input type="text" name="joindate" readonly placeholder="dd-mm-yyyy" class="f1-twitter form-control" id="f1-joindate">
</div>
</div>
</div>


</div>
<div class="col-md-8 top-div">
<div class="form-group">
<label for="joindate" class="col-sm-4 col-form-label"> I have No Email:</label>
<div class="col-sm-8">
  <input class="form-check-input" id="newemail" type="checkbox" name="newemail" value="Yes"> <label class="form-check-label" for="flexRadioDefault1"></label>
</div>
</div>
</div>

</div>




<hr style="margin-left: -10px;">
<div id="emptyMessage"></div>


<table border="0" cellspacing="0" cellpadding="0" style="">

<tr>
<td height="24" colspan="2"><b class="header">Purchase Items</b> </td>
</tr>
<tr>
<td colspan="2">Items name</td>        
<td>QTY</td>
<td>Uom</td>
<td>Consumption Type</td>
<td>Reason</td>
</tr>
<tr id="rows">

<td>                            
<div class="input-group-prepend">
    <button class="btn btn-danger"
        id="DeleteRow" type="button">
        <i class="fa fa-trash"></i>
    </button>
</div>
</td>
<td>

 <input list="itemnames" class="f1-itemName form-control" name="itemName[]" id="itemName" placeholder="Select Item" autocomplete="off" required>

    <datalist id = "itemnames">
            <?php echo $itemnamesOption; ?>
        </datalist>

</td>

<td style="width: 90px;padding-left: 2px;"><input type="number" class="form-control requidQty" id="requidQty" name="requidQty[]" placeholder="QTY" step="any" required></td>

<td style="width: 90px;padding-left: 2px;padding-right: 2px;">

 <input list="uomnames" class="form-control uom" name="uom[]" id="uom" placeholder="UOM" autocomplete="off" required>

    <datalist id = "uomnames">
            <?php echo $uomnamesOption; ?>
        </datalist>

</td>
<td style="width: 148px;padding-left: 2px;">
<select class="cost-requisitionFor form-control" name="ConsumptionType[]" id="ConsumptionType">
    <option value="">Select</option>
     <option value="Daily Consumption">Daily Consumption</option>
     <option value="Weekly Consumption">Weekly Consumption</option>
     <option value="Monthly Consumption">Monthly Consumption</option>
          
</select> 
</td>   
<td style="width: 229px;padding-left: 2px;padding-right: 2px;">
 <textarea class="form-control" name="itemReason[]" id="itemReason" rows="2" placeholder="Write Reason"></textarea>
</td>


</tr>


</table>
<div id="rowS">
</div>
<table>
<tr>
<td colspan="2">
<div id="newinput"></div>
<button id="rowAdder" type="button"
    class="btn btn-dark">
    <i class="fa fa-plus"></i> ADD
</button>            
</td>
</tr>



</table>


</div>




</td>
</tr>
</table><br>
<span style="float: right;padding-bottom: 15px;">

<button type="submit" name="submit" id="btnSubmit" class="btn btn-success" data-toggle="modal" data-target="#myModal">Submit</button>

</span>
</form>
</div>
<!-- <div id="editor"></div>
<table width="705" border="0" cellspacing="0" cellpadding="0" style="">

<tr>
<td height="30" align="right" valign="middle"><button id="btnPrint">Print</button>&nbsp;&nbsp;&nbsp;&nbsp;   </td>

</tr>
</table> -->

</div>      

<!-- Javascript -->
<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.backstretch.min.js"></script>
<script src="assets/js/retina-1.1.0.min.js"></script>
<!-- <script src="assets/js/scripts.js"></script> -->
<!-- Isolated Version of Bootstrap, not needed if your site already uses Bootstrap -->
<link rel="stylesheet" href="assets/bootstrap-iso.css" />
<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />

<!-- Bootstrap Date-Picker Plugin -->
<script type="text/javascript" src="assets/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="assets/bootstrap-datepicker3.css"/>
<script src="http://cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>

<script type="text/javascript">

$(document).ready(function() {
    $('#employeeID').on('change', function() {
        var employeeID = this.value;

     // alert(employeeID);
        $.ajax({
            url: "get_user_info.php",
            type: "POST",
            data: {
                employeeID: employeeID
            },
            cache: false,
            success: function(result) {
                $("#getuserinfo").html(result);
            }
        });
    });
});
$(document).ready(function() {
    $('#employeeID').on('change', function() {
        var employeeID = this.value;

     // alert(employeeID);
        $.ajax({
            url: "get_cost_info.php",
            type: "POST",
            data: {
                employeeID: employeeID
            },
            cache: false,
            success: function(result) {
                $("#getcostinfo").html(result);
            }
        });
    });
});

$('#multiphase').on('keyup keypress', function(e) {
var keyCode = e.keyCode || e.which;
if (keyCode === 13) { 
e.preventDefault();
return false;
}
});


$(document).ready(function () {
$("#newemail").click(function () {
$('#email').attr("disabled", $(this).is(":checked"));
//document.getElementById("email").value = "";
});
});

$(document).ready(function () {
$("#btnSubmit").click(function () {
    var email = $("#email").val();

     var alertDiv = document.getElementById("alertMessage");
   
    var emailRegex = /^([a-zA-Z0-9_\.\-])+\@(goodnfast\.net|lizfashion\.com)$/;
    if (!emailRegex.test(email) && $("#email").is(':enabled')) {
       
        alertDiv.innerHTML= "<span style='color: red;'>If you do not have a valid email, click Yes</span>";

         const input = document.getElementById("email");

        input.style.border = "1px solid #e10b0b";

         return false;
    }
    else if ($("#email").is(':enabled')) {
       // alert("Email address is valid");
    } else {
        //alert("Email field is disabled");
    }
});
$("#checkbox").click(function () {
    if ($(this).is(':checked')) {
        $("#email").val("");
        $("#email").attr("disabled", true);
    } else {
        $("#email").removeAttr("disabled");
    }
});
});

$(document).ready(function () {


$(".f1-itemName").change(function () {

if ('.f1-itemName' !=null){

 $(".requidQty").attr("required", true);
 $(".uom").attr("required", true);

//  alert('Enter Quantity');
     
    } else {
           $(".requidQty").removeAttr("required");
            $(".uom").removeAttr("required");
    }
   //  console.log($(this).val());
});


});


$(document).ready(function() {
   $('#division').on('change', function() {
        var division = this.value;

      //alert(division);
        $.ajax({
            url: "get-department.php",
            type: "POST",
            data: {
                division: division
            },
            cache: false,
            success: function(result) {
                $("#cost-depart").html(result);
            }
        });
    });
});

$(document).ready(function() {
   $('#division').on('change', function() {
        var division = this.value;

      //alert(division);
        $.ajax({
            url: "get-canteen.php",
            type: "POST",
            data: {
                division: division
            },
            cache: false,
            success: function(result) {
                $("#requisitionFor").html(result);
            }
        });
    });
});


</script>


<script type="text/javascript">


$("#rowAdder").click(function () {
newRowAdd =
'<div id="rows"><table style="margin-top: 3px"> <tr><td>'+
'<div class="input-group-prepend">'+
'<button class="btn btn-danger" id="DeleteRow" type="button">'+
'<i class="fa fa-trash"></i></button> </div> </td>'+
'<td>    <input list="itemnames" class="f1-itemName form-control" name="itemName[]" id="itemName" placeholder="Select Item" autocomplete="off" required>'+
    '<datalist id = "itemnames">'+
            '<?php echo $itemnamesOption; ?>'+
        '</datalist></td>'+
        '<td style="width:90px;padding-left: 2px;"><input type="number" class="form-control requidQty" name="requidQty[]" placeholder="QTY" step="any" required></td><td style="width: 90px;padding-left: 2px;padding-right: 2px;"><input list="uomnames" class="form-control uom" name="uom[]" id="uom" placeholder="UOM" autocomplete="off" required>'+
        '<datalist id = "uomnames">'+
            '<?php echo $uomnamesOption; ?>'+
        '</datalist></td>'+
        ' <td style="width: 148px;padding-left: 2px;"><select class="cost-requisitionFor form-control" name="ConsumptionType[]" id="ConsumptionType"><option value="">Select</option><option value="Daily Consumption">Daily Consumption</option><option value="Weekly Consumption">Weekly Consumption</option> <option value="Monthly Consumption">Monthly Consumption</option> </select></td>'+
        '<td style="width: 229px;padding-left: 2px;padding-right: 2px;"> <textarea class="form-control" name="itemReason[]" id="itemReason" rows="2" placeholder="Write Reason"></textarea> </td></tr></table> </div>';


$('#newinput').append(newRowAdd);
});

$("body").on("click", "#DeleteRow", function () {
$(this).parents("#rows").remove();
})
</script>
<script>
CKEDITOR.replace( 'company_benefits' );
CKEDITOR.replace( 'economic_benefits' );
</script>


<script>
function shouldReloadBecauseOfBack() {
try {
// If page was restored from bfcache
if (performance.getEntriesByType) {
  const navEntries = performance.getEntriesByType('navigation');
  if (navEntries && navEntries.length) {
    // type may be "back_forward" in some browsers
    if (navEntries[0].type === 'back_forward') return true;
  }
}
} catch (e) {
// ignore
}
// event.persisted will be checked in pageshow handler
return false;
}

// This runs when page becomes visible (including when returning via back/forward)
window.addEventListener('pageshow', function (event) {
// If the page was loaded from BFCache or navigation type indicates back,
// OR if the view page set our session flag, then reload.
const fromViewFlag = sessionStorage.getItem('cameFromViewPage');
if (event.persisted || shouldReloadBecauseOfBack() || fromViewFlag) {
// remove flag so reload happens only once
sessionStorage.removeItem('cameFromViewPage');

// optionally: a small debounce to avoid double reloads
setTimeout(function () {
  // Use location.replace to avoid adding a new entry in history (optional)
  // location.replace(location.href);
  location.reload(true); // force reload from server when possible
}, 50);
}
});
</script>

<body>
</html>