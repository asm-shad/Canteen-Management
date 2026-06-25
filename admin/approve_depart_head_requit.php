<?php

    session_start();

    $employeeID     = $_SESSION['employeeID'];
    $username       = $_SESSION['user_name'];
    $name           = $_SESSION['name'];
    $email          = $_SESSION['email'];
    // $userRole       = $_SESSION['user_role'];

    require_once('cls_dbconfig.php');
    spl_autoload_register(function($classname) {
    require_once("$classname.class.php");
    });
    
    $db = new cls_dbconfig();
    
    $cls_meassage = new cls_meassage();

    $gentoken = $_POST['toekndt'];
    
    $requiID = $_POST['requit'];

     $reqrefer = $_POST['reqrefer'];

     $vrfy_code = "$_POST[vrfycode]";
    
        
    echo $cls_meassage->insert_head_of_deprtment_approve($requiID, $reqrefer, $username, $employeeID, $vrfy_code);


//  $message = '<!DOCTYPE HTML>'. 
// '<head>'. 
// '<meta http-equiv="content-type" content="text/html">'.
// '<title>Confirm Registration</title>'. 
// '</head>'. 
// '<body>'.
// '<div style="background:#f6f6f6;color:#383838">'.
//     '<div class="adM">'.
//       '</div>'.
//         '<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">'.
//            '<tbody>'.
//             '<tr>'.
//                '<td style="padding:20px 0 20px 0" align="center" valign="top">'.
//                    '<table style="border:1px solid #e0e0e0" bgcolor="FFFFFF" border="0" cellpadding="10" cellspacing="0" width="650">'.
                        
//                     '<tbody>'.
//                     '<tr>'.
//                        ' <td valign="top">'.
                            
//                             '<span>'.
//                                 '<p style="font-size:19px;font-weight:normal;line-height:22px;margin:0 0 11px 0">Hi '.$name.'<p>'.
//                             '</span>'.
//                         '</td>'.
//                         '</tr>'.
//                         '<tr>'.
//                             '<td valign="top">'.
                               
//                                 '<p style="font-size:19px;font-weight:normal;line-height:22px;margin:0 0 11px 0">'.'Verification code <b>'.$vrfy_code.' '.'</b></p>'.
//                             '</td>'.
//                         '</tr>'.
//                         '<tr>'.
//                           '<td>'.
//                          '<p style="font-size:11px;font-weight:normal;line-height:22px;margin:0 0 11px 0">'.'This email has been generated automatically, Please DO NOT reply to this email'.'</p>'.
//                           '</td>'.
//                         '</tr>'.
//                         '</tbody>'.
//                         '</table>'.
//                     '</td>'.
//                 '</tr>'.
//             '</tbody>'.
//         '</table>'.
//         '<div class="yj6qo">'.'</div>'.
//         '<div class="adL">'.
//         '</div>'.
//     '</div>'.

// '</body>'; 
/*EMAIL TEMPLATE ENDS*/ 



// $to=$email;             // give to email address 
// $subject = "verification code";  //change subject of email 

// $headers = "From: Canteen System<my.noc.backup@gmail.com>\r\n";

// $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

//  mail($to, $subject, $message, $headers);



use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\SMTP; 
use PHPMailer\PHPMailer\Exception; 

require 'PHPMailer/Exception.php'; 
require 'PHPMailer/PHPMailer.php'; 
require 'PHPMailer/SMTP.php'; 

$mail = new PHPMailer(true); 

try {
    // Server settings
    $mail->isSMTP();  
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Or 0 for no debug
    $mail->Host = 'smtp.gmail.com';  
    $mail->SMTPAuth = true;  
   $mail->Username = 'no.reply.ldc.24@gmail.com';  
$mail->Password = 'fkhp pjdo rxxo gchu '; // <-- Your App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
    $mail->Port = 587;  

    // Sender info
    $mail->setFrom('no.reply.ldc.24@gmail.com', 'Canteen System'); 
    $mail->addAddress($email);  

    // Content
    $mail->isHTML(true);  
    $mail->Subject = 'Verification code';  
    $mail->Body    = '<!DOCTYPE HTML>'. 
'<head>'. 
'<meta http-equiv="content-type" content="text/html">'.
'<title>Confirm Registration</title>'. 
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
                                '<p style="font-size:19px;font-weight:normal;line-height:22px;margin:0 0 11px 0">Hi '.$name.'<p>'.
                            '</span>'.
                        '</td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td valign="top">'.
                               
                                '<p style="font-size:19px;font-weight:normal;line-height:22px;margin:0 0 11px 0">'.'Verification code <b>'.$vrfy_code.' '.'</b></p>'.
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
       echo 'Message has been sent.';  
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


 

echo $cls_meassage->generatetokenn_session($username,$gentoken,$vrfy_code);

    
?>