<?php
ini_set('date.timezone', 'Asia/Kolkata');

require 'dbconfig.php';

$caseId=$_REQUEST["CaseId"];
$repairAmount=$_REQUEST["RepairAmount"];

$db1 = db_connect();

$payableAmount=0;



$sqlUnique="SELECT RepairAmount FROM `PriceEstimateStatus` WHERE `CaseId` = '$caseId'";
$exe2 = $db1->query($sqlUnique);

$sqlTotalAmount="SELECT TotalAmount,PickDropAmount,PickDropAmountStatus FROM `RepairingStatus` WHERE `CaseId` = '$caseId'";
$exe3 = $db1->query($sqlTotalAmount);

if($exe2->num_rows > 0){
    $data1 = $exe2->fetch_all(MYSQLI_ASSOC);
    $data2 = $exe3->fetch_all(MYSQLI_ASSOC);

    $pickingAmount=$data2[0]['PickDropAmount'];
    $pickingAmountStatus=$data2[0]['PickDropAmountStatus'];

    $oldAmount=$data1[0]['RepairAmount'];
    $oldTotalAmount=$data2[0]['TotalAmount'];
    $newAmount=$repairAmount;

    $a=$oldTotalAmount-$oldAmount;
    $newTotalAmount=$a+$newAmount;



    if($pickingAmountStatus==1){
          $payableAmount = $newTotalAmount - $pickingAmount;
        }else{
          $payableAmount = $newTotalAmount;
          
        }




	$updatesql="UPDATE `PriceEstimateStatus` SET `RepairAmount` = '$repairAmount' WHERE `CaseId` = '$caseId'";
	$exe1 = $db1->query($updatesql);


	$updatesql1="UPDATE `RepairingStatus` SET `TotalAmount` = '$newTotalAmount' WHERE `CaseId` = '$caseId'";
	$exe4 = $db1->query($updatesql1);

    if($exe1==1){
        //echo "Amount Updated";

        $data1= array("TotalAmount"=>$newTotalAmount,"PayableAmount"=>$payableAmount,"Message"=>"Amount Updated");
        echo json_encode($data1);

    }else{
        $data1= array("TotalAmount"=>0,"PayableAmount"=>0,"Message"=>"Amount not Updated");
        echo json_encode($data1);
    }

	

	$db1=null;
}
else{
	$data1= array("TotalAmount"=>0,"PayableAmount"=>0,"Message"=>"Job not Found");
        echo json_encode($data1);
	
}

 

//echo "success";

?>