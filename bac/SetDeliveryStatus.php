<?php
require 'dbconfig.php';

$caseid=$_REQUEST["CaseId"];
$myTokenArray = array();
$mobile="";
$message="your mobile is delivered";


$db1 = db_connect();


$sqlUnique="SELECT DeliveryStatus FROM `RepairingStatus` WHERE `CaseId` = '$caseid'";
$exe2 = $db1->query($sqlUnique);


if($exe2->num_rows > 0){
	$data = $exe2->fetch_all(MYSQLI_ASSOC);

	if($data[0]['DeliveryStatus']==0){
		$updatesql="UPDATE `RepairingStatus` SET `DeliveryStatus` =1,`WorkStatus` =4 WHERE `CaseId` = '$caseid'";
		$exe1 = $db1->query($updatesql);

		echo "status updated";
		

			$sql="SELECT `UserProfile`.`FirebaseToken`,`UserProfile`.`First_Name`,`UserProfile`.`Mobile_Number` FROM `RepairEnquery` INNER JOIN UserProfile ON `UserProfile`.`Id`=`RepairEnquery`.`UserId` where `RepairEnquery`.`CaseId`='$caseid'"; 
			$exe2 = $db1->query($sql);
			$result1 = $exe2->fetch_all(MYSQLI_ASSOC);
			$firebase = $result1[0]['FirebaseToken'];
            $mobile = $result1[0]['Mobile_Number'];

			array_push($myTokenArray, $firebase);

			sendNotification($message,$myTokenArray,$caseid);
            sendSMS($mobile,$message);
	}else{
		$updatesql="UPDATE `RepairingStatus` SET `DeliveryStatus` =0 WHERE `CaseId` = '$caseid'";
		$exe1 = $db1->query($updatesql);
		echo "status updated";
	}
	
}
else{
	echo "status not updated";
}


function sendNotification($mymessage,$tokens,$caseid){

    $DEFAULT_URL = 'https://fcm.googleapis.com/fcm/send';



$registrationIds = $tokens;
$message = array
       (
        'message'   => $mymessage,
        'vibrate'   => 1,
        'sound'     => 1,
        'CaseId' => $caseid
        );

$title="my message";
$serverKey = "AAAAIkLZlmI:APA91bGSHRFX_eDQDWfTkFxoKlvgBxOUHFcLVoGhI_3iCtfO2BEF-bS_bCXqSSoYjGyAHaqAOIYcH0dcf0ej3RiD4YkMhHo4rXxp0FtQZ3tSnVRj46WhNkoj4-5KjRtglwD4_7QzL5a7";

$headers = array(
    'Authorization:key=AAAAIkLZlmI:APA91bGSHRFX_eDQDWfTkFxoKlvgBxOUHFcLVoGhI_3iCtfO2BEF-bS_bCXqSSoYjGyAHaqAOIYcH0dcf0ej3RiD4YkMhHo4rXxp0FtQZ3tSnVRj46WhNkoj4-5KjRtglwD4_7QzL5a7',
    'Content-Type:application/json');

    $fields = array('registration_ids'=>$registrationIds,
        'data'=>$message);

    $payload = json_encode($fields);

    $curl_session = curl_init();
    curl_setopt($curl_session, CURLOPT_URL, $DEFAULT_URL);
    curl_setopt($curl_session, CURLOPT_POST, true);
    curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_session, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($curl_session, CURLOPT_POSTFIELDS,$payload);

    $result = curl_exec($curl_session);
        
    if ($result === FALSE) {
            die('Curl failed: ' . curl_error($curl_session));
        }
        curl_close($curl_session);
        //echo $result;

 }


 function sendSMS($mobile,$mymessage){
    $message= $mymessage.". For any query call- 9755669222";

        $sms_url="http://sms.bulksmsserviceproviders.com/api/send_http.php?authkey=462bd2f551e80e2ce456991e6466c7cc&mobiles=".urlencode($mobile)."&message=".urlencode($message)."&sender=PRATIK&route=4";

        $token = file_get_contents($sms_url);

        return "";
 }



//echo "success";

?>