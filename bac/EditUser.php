<?php
require 'dbconfig.php';

$empName=$_REQUEST["UserName"];
$empMobile=$_REQUEST["UserMobile"];
$empEmail=$_REQUEST["UserEmail"];
$empPassword=$_REQUEST["UserPassword"];
$userId=$_REQUEST["UserId"];


$db1 = db_connect();


$sqlUniqueMobile="SELECT Id FROM `UserProfile` WHERE `Id` = $userId";
$exe2 = $db1->query($sqlUniqueMobile);




if($empMobile==""){
	echo "Mobile is required";
}
else if($empPassword==""){
	echo "Password is required";
}
else if($exe2->num_rows > 0){
	
	$sqlUpdate = "UPDATE `UserProfile` SET `First_Name` ='$empName', `Mobile_Number` ='$empMobile',`Email` ='$empEmail',`Password` ='".md5($empPassword)."' WHERE `Id` = $userId";
	$exeUpdate = $db1->query($sqlUpdate);

	$sqlUpdate1 = "UPDATE `RepairEnquery` SET `Phone` ='$empMobile' WHERE `UserId` = $userId";
	$exeUpdate1 = $db1->query($sqlUpdate1);

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