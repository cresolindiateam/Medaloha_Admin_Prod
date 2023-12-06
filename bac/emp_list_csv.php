<?php
require 'dbconfig.php';


$tempName = "emp_list.csv";

$file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $tempName);
$fileName = mb_ereg_replace("([\.]{2,})", '', $file);

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=".$fileName);

$db=db_connect();
$sql = "SELECT Id,First_Name,Mobile_Number,Location,Created_At FROM `UserProfile` WHERE UserType=2 OR UserType=3 && `DeleteStatus`=0";

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
 array('Id','First_Name','Mobile_Number','Location','Created_At')
 );

outputCSV($data, $csvHeader);



?>