<?php
require 'dbconfig.php';


$tempName = "user_list.csv";

$file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $tempName);
$fileName = mb_ereg_replace("([\.]{2,})", '', $file);

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=".$fileName);

$db=db_connect();
$sql = "SELECT * FROM `user`";

	$exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null; 


    foreach ($data as $key => $value){
    

    	
    	



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
 array('id','Name','City','Address','Join Date','Created_At')
 );

outputCSV($data, $csvHeader);



?>