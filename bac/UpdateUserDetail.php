<?php
require 'dbconfig.php';

$empName=$_REQUEST["UserName"];
$empMobile=$_REQUEST["UserMobile"];
$userId=$_REQUEST["UserId"];
$location=$_REQUEST["UserLocation"];

$db1 = db_connect();

$sqlUniqueMobile="SELECT Id FROM `UserProfile` WHERE `Id` = $userId";
$exe2 = $db1->query($sqlUniqueMobile);

if($empMobile==""){
	echo "Mobile is required";
}
else if($empName==""){
	echo "Name is required";
}
else if($exe2->num_rows > 0){
	
	$sqlUpdate = "UPDATE `UserProfile` SET `First_Name` ='$empName', `Mobile_Number` ='$empMobile',`Location` ='$location' WHERE `Id` = $userId";
	$exeUpdate = $db1->query($sqlUpdate);

					if($exeUpdate==1){

						echo "User updated";
					}
					else{
						echo "User not updated";
					}
}
else{
	echo "User not updated";
}

?>