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
    
    $db = new cls_dbconfig();
    
    $cls_meassage = new cls_meassage();
    
    $reject = "$_POST[reject]";
    $requisitionid = "$_POST[hiddenID]";
    $stage = "$_POST[stage]";

    $ename = "$_POST[ename]";
    $sendEmail = "$_POST[sendEmail]";

     $referencen = "$_POST[referencen]";

    
    echo $cls_meassage->it_reject($requisitionid,$username,$stage,$reject);
    echo $cls_meassage->it_approve_verify_reject($requisitionid);



 $message = '<!DOCTYPE HTML>'. 
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
                                '<p style="font-size:19px;font-weight:normal;line-height:22px;margin:0 0 11px 0">Hi '.$ename.'<p>'.
                            '</span>'.
                        '</td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td valign="top">'.
                               
                                '<p style="font-size:19px;font-weight:normal;line-height:22px;margin:0 0 11px 0">'.'Your Bulk Requisition Rejected'.'</p>'.

                                '<p style="font-size:19px;font-weight:normal;line-height:22px;margin:0 0 11px 0">'.'Reference No: '.$referencen.'</p>'.
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
/*EMAIL TEMPLATE ENDS*/ 

$to=$sendEmail;             // give to email address 
$subject = "Reject IT Requisition";  //change subject of email 


// $headers  = "From: " . $from . "\r\n"; 
// $headers .= "Reply-To: ". $from . "\r\n"; 
// $headers .= "MIME-Version: 1.0\r\n"; 
// $headers .= "Content-Type: text/html; charset=UTF-8\r\n"; 

$headers = "From: system.support@lizfashion.com\r\n";


$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

 mail($to, $subject, $message, $headers);




    
?>