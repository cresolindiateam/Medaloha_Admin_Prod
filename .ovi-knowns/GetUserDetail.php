<?php
require 'dbconfig.php';

$userId=$_REQUEST["UserId"];


$db1 = db_connect();

$updatesql="SELECT First_Name,Location,Mobile_Number FROM `UserProfile`  WHERE `Id` = '$userId'";
$exe1 = $db1->query($updatesql);
$result = $exe1->fetch_all(MYSQLI_ASSOC);
$db1=null;

$data1= array("First_Name"=>$result[0]['First_Name'],"Location"=>$result[0]['Location'],"Mobile_Number"=>$result[0]['Mobile_Number']);
echo json_encode($data1);

//echo $updatesql;

?>