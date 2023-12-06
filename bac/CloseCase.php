<?php
ini_set('date.timezone', 'Asia/Kolkata');

require 'dbconfig.php';

$caseid=$_REQUEST["CaseId"];
$remarks=$_REQUEST["Remarks"];

$myTokenArray = array();
$datetime = date("Y-m-d H:i:s");
$message="Thanks for choosing us. Please give us your valuable feedback. For any query call- 9755669222";
$db1 = db_connect();
$mobile="";



$sqlUnique="SELECT CaseId,TotalAmount,StartDate,DeliveryDate,EmpStartTime,EmpEndTime,UserId,EmployeeId,RepairDetail,DeliveryOptions,Accessories,Rating FROM `RepairingStatus` WHERE `CaseId` = '$caseid'";
$exe2 = $db1->query($sqlUnique);


if($exe2->num_rows > 0){
	$updatesql="UPDATE `RepairingStatus` SET `CloseStatus` =1 WHERE `CaseId` = '$caseid'";
	$exe1 = $db1->query($updatesql);

    $updatesql2="UPDATE `RepairEnquery` SET `Remarks` ='$remarks' WHERE `CaseId` = '$caseid'";
    $exe3 = $db1->query($updatesql2);

	$data = $exe2->fetch_all(MYSQLI_ASSOC);


$sql="SELECT Description FROM `RepairEnquery` WHERE `CaseId` = '$caseid'";
$exe3 = $db1->query($sql);
$data2 = $exe3->fetch_all(MYSQLI_ASSOC);

	$sqlInsert = "insert into CaseHistory(UserId,CaseId,EmployeeId,TotalAmount,StartDate,DeliveryDate,EmpStartTime,EmpEndTime,ProblemDescription,RepairDetail,DeliveryOptions,Rating,Accessories,Created_At)"
							. " VALUES('".$data[0]['UserId']."','".$data[0]['CaseId']."','".$data[0]['EmployeeId']."','".$data[0]['TotalAmount']."','".$data[0]['StartDate']."','".$data[0]['DeliveryDate']."','".$data[0]['EmpStartTime']."','".$data[0]['EmpEndTime']."','".$data2[0]['Description']."','".$data[0]['RepairDetail']."','".$data[0]['DeliveryOptions']."','".$data[0]['Rating']."','".$data[0]['Accessories']."','".$datetime."')";

					$exeInsert = $db1->query($sqlInsert);
					$last_id = $db1->insert_id;

					if(!empty($last_id)){
						echo "case closed";
					}
					else{
						echo "case  not closed";
					}

					$sql="SELECT `UserProfile`.`FirebaseToken`,`UserProfile`.`Mobile_Number` FROM `UserProfile`  where `Id`='".$data[0]['UserId']."'"; 
					$exe2 = $db1->query($sql);
					$result1 = $exe2->fetch_all(MYSQLI_ASSOC);
					$firebase = $result1[0]['FirebaseToken'];
					$mobile = $result1[0]['Mobile_Number'];

					array_push($myTokenArray, $firebase);

            		$sqlInsert1 = "insert into UserNotifications(CaseId,UserId,Description,Type,Created_At)". " VALUES('".$data[0]['CaseId']."','".$data[0]['UserId']."','$message',1,'$datetime')";
            		$exeInsert1 = $db1->query($sqlInsert1);

					sendNotification($message,$myTokenArray,$caseid);
					sendSMS($mobile,$message);

	
}
else{
	echo "case  not closed";
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
        //echo "status updated";
 }

 function sendSMS($mobile,$mymessage){
    $message= $mymessage;
    
        $sms_url="http://sms.bulksmsserviceproviders.com/api/send_http.php?authkey=462bd2f551e80e2ce456991e6466c7cc&mobiles=".urlencode($mobile)."&message=".urlencode($message)."&sender=PRATIK&route=4";

        $token = file_get_contents($sms_url);

        return "";
 }



//echo "success";

?>