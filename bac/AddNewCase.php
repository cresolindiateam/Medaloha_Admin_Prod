<?php
ini_set('date.timezone', 'Asia/Kolkata');

require 'dbconfig.php';

$brandName=$_REQUEST["BrandName"];
$modelName=$_REQUEST["ModelName"];
$location=$_REQUEST["Location"];
$mobileNumber=$_REQUEST["MobileNumber"];
$deliveryOptions=$_REQUEST["DeliveryOptions"];
$repairAmount=$_REQUEST["RepairAmount"];
$pickAmount=$_REQUEST["PickAmount"];
$dropAmount=$_REQUEST["DropAmount"];
$pickDropAmount=$_REQUEST["PickDropAmount"];
$problemDescription=$_REQUEST["ProblemDescription"];
$accessories=$_REQUEST["Accessories"];
$customername=$_REQUEST["CustomerName"];
$imei_number=$_REQUEST["IMEINumber"];
$remarks=$_REQUEST["Remarks"];

$totalAmount=0;
$userId=0;
$datetime = date("Y-m-d H:i:s");


if($deliveryOptions==0){
	$totalAmount=$repairAmount;
}else if($deliveryOptions==1){
	$totalAmount=$repairAmount+$pickAmount;
}else if($deliveryOptions==2){
	$totalAmount=$repairAmount+$dropAmount;
}else if($deliveryOptions==3){
	$totalAmount=$repairAmount+$pickDropAmount;
}else{
	$totalAmount=0;
}




$db = db_connect();

		$sqlUniqueMobile="SELECT Id FROM `UserProfile` WHERE `Mobile_Number` = '$mobileNumber'";
		$exe2 = $db->query($sqlUniqueMobile);

		if($exe2->num_rows > 0){
			$result = $exe2->fetch_all(MYSQLI_ASSOC);
			$userId = $result[0]['Id'];
		}else{
			$sqlInsertUser = "insert into UserProfile(First_Name,Mobile_Number,Created_At,Location,UserType)". " VALUES('$customername','$mobileNumber','".$datetime."','$location',4)";
			$exeInsertUser = $db->query($sqlInsertUser);
			$userId = $db->insert_id;
		}

		

	$sqlInsert = "insert into RepairEnquery(Brand,Model,IMEI_Number,Phone,Description,Location,Remarks,PickAndDrop,UserId,PriceEstimateStatus,Created_At)"
							. " VALUES('".$brandName."','".$modelName."','".$imei_number."','".$mobileNumber."','".$problemDescription."','".$location."','".$remarks."','".$deliveryOptions."',$userId,1,'".$datetime."')";
	$exeInsert = $db->query($sqlInsert);
	$last_id = $db->insert_id;

	$caseid = "JOB".$last_id;

	if(!empty($last_id)){

    	 $sqlUpdate = "UPDATE RepairEnquery SET `CaseId`='$caseid' WHERE `Id`=$last_id";
    	 $exeUpdate = $db->query($sqlUpdate);

    	$sqlInsert = "insert into PriceEstimateStatus(CaseId,UserId,DeliveryOptions,RepairAmount,PickAndDropAmount,PickAmount,DropAmount,AdminResponse,UserSubmitStatus,Created_At)"
							. " VALUES('$caseid',$userId,'".$deliveryOptions."','".$repairAmount."','".$pickDropAmount."','".$pickAmount."','".$dropAmount."',1,1,'".$datetime."')";
		$exeInsert = $db->query($sqlInsert);

		$sqlInsert1 = "insert into RepairingStatus(CaseId,UserId,UserSubmitStatus,Accessories,TotalAmount,DeliveryOptions,Created_At)"
							. " VALUES('$caseid',$userId,1,'$accessories','$totalAmount','$deliveryOptions','".$datetime."')";
		$exeInsert1 = $db->query($sqlInsert1);

    	 $data1= array('status'=>true ,"message"=>"Enquiry Submitted", "CaseId"=>$caseid);
		 echo "Enquiry Submitted_".$caseid;
	}



//echo "success";

?>