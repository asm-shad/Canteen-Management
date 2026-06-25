<?php 
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
    $mail->Username = 'alomshohag312@gmail.com';  
    $mail->Password = 'qgkl zzpe iseg gpqo '; // <-- Your App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
    $mail->Port = 587;  

    // Sender info
    $mail->setFrom('alomshohag312@gmail.com', 'Shohag'); 
    $mail->addAddress('shohag.mia@lizfashion.com');  

    // Content
    $mail->isHTML(true);  
    $mail->Subject = 'Email from Localhost';  
    $mail->Body    = '<h1>Send Email from Localhost</h1>
                      <p>This HTML email is sent from localhost server using PHP by <b>Shohag</b></p>';  

    $mail->send();  
    echo 'Message has been sent.';  
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
