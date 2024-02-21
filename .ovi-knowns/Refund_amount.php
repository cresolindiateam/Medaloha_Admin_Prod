
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'dbconfig.php';
require 'function.php';
require_once('stripe-php/init.php'); 
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 
require 'PHPMailer/PHPMailerAutoload.php';
require 'PHPMailer/src/Exception.php'; 
require 'PHPMailer/src/PHPMailer.php'; 
require 'PHPMailer/src/SMTP.php'; 

$url = "http://".$_SERVER['HTTP_HOST'].'/Admin/admin_login.php';
session_start();
if($_SESSION['username']==""){
	echo "<script> window.location = '".$url."'</script>";
}
$db=db_connect();
//set stripe secret key and publishable key
$stripe = array(
	"secret_key"      => "sk_test_1LHuYRF7KNv2C7oU3y3a7b3Y",
	"publishable_key" => "pk_test_dpbFidCDzQDGz85BRrqlGhJD"
);    

  \Stripe\Stripe::setApiKey($stripe['secret_key']);   
// $charges = \Stripe\Charge::all();
/*echo "<pre>";
print_r($charges);die;
*/
$bookingid='';
if(isset($_POST['bookingid']))
{
	$bookingid=$_POST['bookingid'];
}


echo $sql = "SELECT users.email as u_email,booking_price,payment_intent_id FROM booking_histories 
left join users on users.id=booking_histories.user_id
where booking_histories.id=".$bookingid;
$exe = $db->query($sql);
$data = $exe->fetch_all(MYSQLI_ASSOC);

//refund amount
$ramount=$data[0]['booking_price'];

$recipient_email =$data[0]['u_email'];

//20-% less amount
$percentage = 20;
$newramount = ($percentage / 100) * $ramount;
 
//intent id
 echo  $payment_inetent_id=$data[0]['payment_intent_id'];

//refund amount random
// $rramount=$charges->data[0]['amount'];
// $charge_id=$charges->data[0]['id'];
 

 $refund = \Stripe\Refund::create(['payment_intent' => $payment_inetent_id]);


if(isset($refund->id)){
    $sql2 = "update booking_histories set booking_status =7 where id=".$bookingid;
    $db->query($sql2);
    
    echo $inserSql  = "insert into refund (refund_id,amount,balance_transaction,charge,create,currency,status) values('".$refund->id."','".$refund->amount."','".$refund->balance_transaction."','".$refund->charge."','".$refund->created."','".$refund->currency."','".$refund->status."')";
    $db->query($inserSql);
    
    

$recemail=$recipient_email;
$subject = "Send Email To User For Amount Refund by Admin."; 
 
$mail = new PHPMailer(); 
$mail->isSMTP();                      // Set mailer to use SMTP 
$mail->Host = 'smtp.gmail.com';   // Specify main and backup SMTP servers 

$mail->Mailer = "smtp"; 
$mail->SMTPAuth = true;               // Enable SMTP authentication 
$mail->Username = 'ajay@cresol.in';   // SMTP username 
$mail->Password = 'petipa@#$';   // SMTP password 
$mail->SMTPSecure = 'tls';   // Enable TLS encryption, `ssl` also accepted 
$mail->Port = 587;                    // TCP port to connect to 
 // Sender info 
$mail->setFrom('ajay@cresol.in', 'Medaloha Admin'); 
// Add a recipient 
$mail->addAddress($recemail); 
// Set email format to HTML 
$mail->isHTML(true); 
// Mail subject 
$mail->Subject = 'Send Email To User For Amount Refund By Admin.'; 
 
// Mail body content 
$bodyContent = ' 
    <html> 
    <head> 
        <title>Missing Things in Profie</title> 
    </head> 
    <body> 
        <h1>Thanks you for joining with us!</h1> 
          Hello User, i am here to Inform that Your Booking Cancel Amount'.$ramount.' has been refunded It will come after some times For Further Details Please contact with Admin  
        <table cellspacing="0" style="border: 2px dashed #FB4314; width: 100%;"> 
            <tr> 
                <th>Name:</th><td>Medaloha Admin</td> 
            </tr> 
            <tr style="background-color: #e0e0e0;"> 
                <th>Email:ajay@cresol.in</th><td></td> 
            </tr> 
            <tr> 
                <th>Website:</th><td><a href="#">Medaloha Admin</a></td> 
            </tr> 
        </table> 
    </body> 
    </html>';  
$mail->Body    = $bodyContent; 
 
// Send email 
if(!$mail->send()) { 
   echo "<script>alert('Message could not be sent. Mailer Error:  $mail->ErrorInfo');</script>";
   //echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo; 
} else { 
  echo "<script>alert('Message has been sent.');</script>";
    //echo 'Message has been sent.'; 
} 


}
 

?>