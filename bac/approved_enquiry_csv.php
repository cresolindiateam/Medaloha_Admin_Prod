<?php
require 'dbconfig.php';


$tempName = "history_list.csv";

$file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $tempName);
$fileName = mb_ereg_replace("([\.]{2,})", '', $file);

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=".$fileName);

$db=db_connect();
$sql = "SELECT Id,CaseId,TotalAmount,PickDropAmount,Accessories,DelBoyStartTime,DelBoyEndTime,PickDropStatus,UserId,EmployeeId,DelBoyId,DeliveryOptions,Created_At FROM `RepairingStatus` WHERE `UserSubmitStatus`=1";

	$exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null; 



function outputCSV($data, $csvHeader) {
	$output = fopen("php://output", "w");  
	foreach ($csvHeader as $rowheader)
	fputcsv($output, $rowheader);  
	foreach ($data as $row)
	fputcsv($output, $row); // here you can change delimiter/enclosure
	fclose($output);
}

$csvHeader = array(			
 array('Id','CaseId','TotalAmount','PickDropAmount','Accessories','DelBoyStartTime','DelBoyEndTime','PickDropStatus','UserId','EmployeeId','DelBoyId','DeliveryOptions','Created_At')
 );

outputCSV($data, $csvHeader);



?>