<?php
require 'dbconfig.php';


$tempName = "history_list.csv";

$file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $tempName);
$fileName = mb_ereg_replace("([\.]{2,})", '', $file);

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=".$fileName);

$db=db_connect();
$sql = "SELECT Id,CaseId,UserId,EmployeeId,TotalAmount,StartDate,DeliveryDate,EmpStartTime,EmpEndTime,RepairDetail,Rating,ProblemDescription,DeliveryOptions,Accessories,Created_At FROM `CaseHistory`";

	$exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null; 


    foreach ($data as $key => $value){
    	$deliveryType = "";
    	

    	if($value['DeliveryOptions']==0){
    		$deliveryType="NA";
    	}else if($value['DeliveryOptions']==1){
    		$deliveryType="Pick";
    	}else if($value['DeliveryOptions']==2){
    		$deliveryType="Drop";
    	}else if($value['DeliveryOptions']==3){
    		$deliveryType="Pick and Drop";
    	}


    	$data[$key]['DeliveryOptions']= $deliveryType;
    
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
 array('Id','CaseId','UserId','EmployeeId','TotalAmount','StartDate','DeliveryDate','EmpStartTime','EmpEndTime','RepairDetail','Rating','ProblemDescription','DeliveryOptions','Accessories','Created_At')
 );

outputCSV($data, $csvHeader);



?>