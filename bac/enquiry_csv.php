<?php
require 'dbconfig.php';


$tempName = "enquiry_list.csv";

$file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $tempName);
$fileName = mb_ereg_replace("([\.]{2,})", '', $file);

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=".$fileName);

$db=db_connect();
$sql = "SELECT Id,CaseId,UserId,Brand,Model,Phone,Created_At,Description,Location,PickAndDrop,PriceEstimateStatus FROM `RepairEnquery`";

	$exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    //$db = null; 

    foreach ($data as $key => $value){
    	$deliveryType = "";
    	$priceEstimate = "";

    	if($value['PickAndDrop']==0){
    		$deliveryType="NA";
    	}else if($value['PickAndDrop']==1){
    		$deliveryType="Pick";
    	}else if($value['PickAndDrop']==2){
    		$deliveryType="Drop";
    	}else if($value['PickAndDrop']==3){
    		$deliveryType="Pick and Drop";
    	}



    	if($value['PriceEstimateStatus']==0){
    		$priceEstimate="Not Submitted";
    	}else if($value['PriceEstimateStatus']==1){
    		$priceEstimate="Submitted";
    	}

    	$data[$key]['PickAndDrop']= $deliveryType;
    	$data[$key]['PriceEstimateStatus']= $priceEstimate;



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
 array('Id','CaseId','UserId','Brand','Model','Phone','Created_At','Description','Location','PickAndDrop','PriceEstimateStatus')
 );

outputCSV($data, $csvHeader);



?>