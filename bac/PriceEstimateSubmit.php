<?php
ini_set('date.timezone', 'Asia/Kolkata');

require 'dbconfig.php';

$caseId=$_REQUEST["CaseId"];
$rAmount=$_REQUEST["RAmount"];
$pAmount=$_REQUEST["PAmount"];
$dAmount=$_REQUEST["DAmount"];
$pdAmount=$_REQUEST["PDAmount"];

$totalAmount=$rAmount+$pAmount+$dAmount+$pdAmount;

$db1 = db_connect();
$myTokenArray = array();
$message="your mobile repairing estimate is: ".$totalAmount.". Please confirm";
$datetime = date("Y-m-d H:i:s");
$mobile="";




$sqlUnique="SELECT Id,UserId FROM `PriceEstimateStatus` WHERE `CaseId` = '$caseId'";
$exe2 = $db1->query($sqlUnique);

if($exe2->num_rows > 0){
    $data1 = $exe2->fetch_all(MYSQLI_ASSOC);

	$updatesql="UPDATE `PriceEstimateStatus` SET `RepairAmount` = '$rAmount', `PickAndDropAmount` = '$pdAmount', `PickAmount` = '$pAmount', `DropAmount` = '$dAmount', `AdminResponse` = '1' WHERE `PriceEstimateStatus`.`CaseId` = '$caseId'";
	$exe1 = $db1->query($updatesql);

	$updatesql1="UPDATE `RepairEnquery` SET `PriceEstimateStatus` = '1' WHERE `CaseId` = '$caseId'";
	$exe3 = $db1->query($updatesql1);

	if($exe3==1){
		echo "Price estimate submitted";


		$sql="SELECT `UserProfile`.`FirebaseToken`,`UserProfile`.`First_Name`,`UserProfile`.`Mobile_Number` FROM `RepairEnquery` INNER JOIN UserProfile ON `UserProfile`.`Id`=`RepairEnquery`.`UserId` where `RepairEnquery`.`CaseId`='$caseId'"; 
			$exe2 = $db1->query($sql);
			$result1 = $exe2->fetch_all(MYSQLI_ASSOC);
			$firebase = $result1[0]['FirebaseToken'];
            $mobile = $result1[0]['Mobile_Number'];

			array_push($myTokenArray, $firebase);


            $sqlInsert1 = "insert into UserNotifications(CaseId,UserId,Description,Created_At)". " VALUES('$caseId','".$data1[0]['UserId']."','$message','$datetime')";
            $exeInsert1 = $db1->query($sqlInsert1);

			sendNotification($message,$myTokenArray,$caseId);
            sendSMS($mobile,$message);
	}else{
		echo "not submitted";
	}

	$db1=null;
}
else{
	echo "case not found";
	
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