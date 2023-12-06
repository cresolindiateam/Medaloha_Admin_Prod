<?php
require 'dbconfig.php';

$mobile=$_REQUEST["MobileNumber"];
$lastVisit="";
$caseid="";
$brand="";
$model="";
$problem="";


$db1 = db_connect();

$updatesql="SELECT Id,First_Name,Location FROM `UserProfile`  WHERE `Mobile_Number` = '$mobile'";
$exe1 = $db1->query($updatesql);
$result = $exe1->fetch_all(MYSQLI_ASSOC);


if($exe1->num_rows > 0){
	$sql2="SELECT CaseId,Brand,Model,Description,Created_At FROM `RepairEnquery`  WHERE `UserId` = '".$result[0]['Id']."' ORDER BY `Created_At` DESC";
	$exe2 = $db1->query($sql2);

	if($exe2->num_rows > 0){
		$result2 = $exe2->fetch_all(MYSQLI_ASSOC);
		$lastVisit = $result2[0]['Created_At'];
		$caseid = $result2[0]['CaseId'];
		$brand = $result2[0]['Brand'];
		$model = $result2[0]['Model'];
		$problem = $result2[0]['Description'];
	}
}



$data1= array("First_Name"=>$result[0]['First_Name'],"Location"=>$result[0]['Location'],"LastVisit"=>$lastVisit,"CaseId"=>$caseid,"Brand"=>$brand,"Model"=>$model,"Problem"=>$problem);
echo json_encode($data1);

//echo $updatesql;

?>