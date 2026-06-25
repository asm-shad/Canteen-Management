<?php

session_start();

$employeeID 	= $_SESSION['employeeID'];
$username 		= $_SESSION['user_name'];
$name 			= $_SESSION['name'];
$email 			= $_SESSION['email'];


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';



 require_once('cls_dbconfig.php');
	spl_autoload_register(function($classname) {
	require_once("$classname.class.php");
	});
	
	// $db = new cls_dbconfig();

	$cls_dbconfig = new cls_dbconfig();
	$db = $cls_dbconfig->connection();
	
	$cls_meassage = new cls_meassage();
	
	$verifycode = $_REQUEST['verifycode'];
	$hiddenID = $_REQUEST['hiddenID'];
	//$tid = $_REQUEST['tid'];
	
	
	
echo $cls_meassage->approve_depart_submit_access($hiddenID,$verifycode,$username,$employeeID);


$get_data_canteen = $db->query("SELECT * FROM canteen_header where id='$hiddenID'");

$canteen_data = $get_data_canteen->fetch_assoc();

$reference 		= $canteen_data['reference'];
$company 		= $canteen_data['company'];
$requisitionFor = $canteen_data['PurchaseFor'];

     
$approval_user = $db->query("SELECT ur.employeeID, ur.user_name, u.name, u.email, u.employeeID, u.username  FROM user_role ur LEFT JOIN user u ON ur.employeeID=u.employeeID AND ur.user_name=u.username  where ur.companyname='$company' AND ur.category='$requisitionFor' AND ur.user_type='Head of HR' AND u.mail_status='1'");

$approval_data = $approval_user->fetch_assoc();


$upName  = $approval_data['name'];
$upEmail = $approval_data['email'];

$mid = md5($hiddenID);

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
                           
                            '<a href="http://localhost/canteen-management/admin/login.php?redirect=rquhrdview.php?view_id='.$mid.'" style="font-size:19px;font-weight:normal;line-height:22px;margin:0 0 11px 0">'.'Waiting for Approval <b>'.$reference.' '.'</b></a>'.
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
	
?>