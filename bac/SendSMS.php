<?php
require 'dbconfig.php';

$mobile=$_REQUEST["Mobile"];
$message=$_REQUEST["Message"];


$sms_url="http://sms.bulksmsserviceproviders.com/api/send_http.php?authkey=462bd2f551e80e2ce456991e6466c7cc&mobiles=".$mobile."&message=".urlencode($message)."&sender=PRATIK&route=4";

    $token = file_get_contents($sms_url);

    $s=isJSON($token);

    if($s==""){
    	echo "SMS Sent";
    }else{
    	echo "SMS not Sent";
    }



function isJSON($string){
   return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
}

?>