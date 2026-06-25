<?php

	session_start();



	$employeeID 	= $_SESSION['employeeID'];
	$username 	= $_SESSION['user_name'];
	$name = $_SESSION['name'];
	$email 			= $_SESSION['email'];

	require_once('cls_dbconfig.php');
	function __autoload($classname){
	  require_once("$classname.class.php");
	}
	
	$db = new cls_dbconfig();
	
	$cls_meassage = new cls_meassage();

	//$_SESSION['token'] = "$_POST[toekndt]";

	$gentoken = "$_POST[toekndt]";
	
	$requiID = "$_POST[requit]";
	
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


	
echo $cls_meassage->insert_approve($requiID,$username,$employeeID,$vrfy_code);


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
								'<p style="font-size:19px;font-weight:normal;line-height:22px;margin:0 0 11px 0">Hi '.$name.'<p>'.
							'</span>'.
						'</td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td valign="top">'.
                               
                                '<p style="font-size:19px;font-weight:normal;line-height:22px;margin:0 0 11px 0">'.'verification code <b>'.$vrfy_code.' '.'</b></p>'.
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

$to=$email;             // give to email address 
$subject = "verification code";  //change subject of email 
// $from    = "shohagcse2@gmail.com";     // give from email address

// $headers  = "From: " . $from . "\r\n"; 
// $headers .= "Reply-To: ". $from . "\r\n"; 
// $headers .= "MIME-Version: 1.0\r\n"; 
// $headers .= "Content-Type: text/html; charset=UTF-8\r\n"; 

$headers = "From: system.support@lizfashion.com\r\n";

//$headers = "From: shohagcse2@gmail.com\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

 mail($to, $subject, $message, $headers);



echo $cls_meassage->generatetokenn_session($username,$gentoken,$vrfy_code);

	
?>