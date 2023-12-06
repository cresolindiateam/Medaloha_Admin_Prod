<?php
require 'dbconfig.php';


$tempName = "approved_enquiries.csv";

$file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $tempName);
$fileName = mb_ereg_replace("([\.]{2,})", '', $file);

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=".$fileName);




$db=db_connect();
$sql = "SELECT `RepairingStatus`.`Id`,`RepairingStatus`.`CaseId`,`RepairingStatus`.`UserId`,`RepairingStatus`.`TotalAmount`,`RepairingStatus`.`UserSubmitStatus`,`RepairingStatus`.`DeliveryOptions`,`RepairEnquery`.`Description`,`RepairEnquery`.`Location`,`RepairEnquery`.`Brand`,`RepairEnquery`.`Model`,`RepairEnquery`.`Phone`,`RepairEnquery`.`IMEI_Number`,`RepairEnquery`.`Remarks`,`UserProfile`.`First_Name` FROM `RepairingStatus` LEFT JOIN `RepairEnquery` ON `RepairingStatus`.`CaseId` = `RepairEnquery`.`CaseId` LEFT JOIN `UserProfile` ON `RepairingStatus`.`UserId` = `UserProfile`.`Id`  WHERE `RepairingStatus`.`EmployeeId`=0 && `RepairingStatus`.`UserSubmitStatus`!=0 ORDER BY `RepairingStatus`.`Created_At` DESC";

	$exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    //$db = null; 

    foreach ($data as $key => $value){
    	$deliveryType = "";
    	$userSbmission = "";

    	if($value['DeliveryOptions']==0){
    		$deliveryType="NA";
    	}else if($value['DeliveryOptions']==1){
    		$deliveryType="Pick";
    	}else if($value['DeliveryOptions']==2){
    		$deliveryType="Drop";
    	}else if($value['DeliveryOptions']==3){
    		$deliveryType="Pick and Drop";
    	}



    	if($value['UserSubmitStatus']==0){
    		$userSbmission="NA";
    	}else if($value['UserSubmitStatus']==1){
    		$userSbmission="Approved";
    	}else if($value['UserSubmitStatus']==2){
            $userSbmission="Cancelled";
        }

    	$data[$key]['DeliveryOptions']= $deliveryType;
    	$data[$key]['UserSubmitStatus']= $userSbmission;



    }



function outputCSV($data, $csvHeader) {
	$output = fopen("php://output", "w");  
	foreach ($csvHeader as $rowheader)
	fputcsv($output, $rowheader);  
	foreach ($data as $row)
	fputcsv($output, $row); // here you can change delimiter/enclosure
	fclose($output);
}

$csvHeader = array(			
 array('Id','CaseId','UserId','Total Amount','User Submission','Delivery Type','Problem','Location','Brand','Model','Mobile','IMEI','Remarks','Name')
 );

outputCSV($data, $csvHeader);



?>