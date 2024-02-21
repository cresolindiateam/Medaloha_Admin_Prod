<?php 
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 
 

 
  require 'PHPMailer/PHPMailerAutoload.php';
require 'PHPMailer/src/Exception.php'; 
require 'PHPMailer/src/PHPMailer.php'; 
require 'PHPMailer/src/SMTP.php'; 
 
$mail = new PHPMailer(); 
 
$mail->isSMTP();                      // Set mailer to use SMTP 
$mail->Host = 'smtp.gmail.com';       // Specify main and backup SMTP servers 
$mail->SMTPDebug = 1;
$mail->Mailer = "smtp"; 
$mail->SMTPAuth = true;               // Enable SMTP authentication 
$mail->Username = 'ajay@cresol.in';   // SMTP username 
$mail->Password = 'petipa@#$';   // SMTP password 
$mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted 
$mail->Port = 587;                    // TCP port to connect to 
 
// Sender info 
$mail->setFrom('ajay@cresol.in', 'Medaloha Admin'); 

 
// Add a recipient 
$mail->addAddress('ajaysoni9039@gmail.com'); 
 
 
 
// Set email format to HTML 
$mail->isHTML(true); 
 
// Mail subject 
$mail->Subject = 'Email from Localhost by CodexWorld'; 
 
// Mail body content 
$bodyContent = '<h1>How to Send Email from Localhost using PHP by CodexWorld</h1>'; 
$bodyContent .= '<p>This HTML email is sent from the localhost server using PHP by <b>CodexWorld</b></p>'; 
$mail->Body    = $bodyContent; 
 
// Send email 
if(!$mail->send()) { 
    echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo; 
} else { 
    echo 'Message has been sent.'; 
} 

?>