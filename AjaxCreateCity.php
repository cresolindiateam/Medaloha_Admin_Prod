<?php
//ini_set('date.timezone', 'Asia/Kolkata');

require 'dbconfig.php';



$tag_name=$_REQUEST["city_name"];
$country_id=$_REQUEST["countryId"];

$db = db_connect();

$sqlUniqueEmail="SELECT id FROM cities WHERE city_name = '$tag_name'";
$exeEmail = $db->query($sqlUniqueEmail);


if($exeEmail->num_rows>0){
	$status=0;
	echo "City Name already used.";
}/*else if($exeMobile->num_rows>0){
	$message="Phone already used.";
}*/else{
	

$sqlInsert = "INSERT INTO cities(city_name,country_id)"." VALUES('$tag_name',$country_id)";



	$exeInsert = $db->query($sqlInsert);
	$last_id = $db->insert_id;
	if(!empty($last_id)){
		$status=1;
		echo "New City Created.";
	}else{
		echo "City did not Created.";
	}
}
$db->close(); 


?>