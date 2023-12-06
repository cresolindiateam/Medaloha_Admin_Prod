<?php
require 'dbconfig.php';

$empName=$_REQUEST["EmpName"];
$empMobile=$_REQUEST["EmpMobile"];
$empPassword=$_REQUEST["EmpPassword"];
$userType=$_REQUEST["UserType"];
$userId=$_REQUEST["EmpId"];


$db1 = db_connect();


$sqlUniqueMobile="SELECT Id FROM `UserProfile` WHERE `Id` = $userId";
$exe2 = $db1->query($sqlUniqueMobile);



if($empMobile==""){
	echo "mobile is required";
}
else if($empPassword==""){
	echo "password is required";
}
else if($exe2->num_rows > 0){
	
	$sqlUpdate = "UPDATE `UserProfile` SET `First_Name` ='$empName', `Mobile_Number` ='$empMobile',`Password` ='".md5($empPassword)."',`UserType` ='$userType' WHERE `Id` = $userId";

					$exeUpdate = $db1->query($sqlUpdate);

					if($exeUpdate==1){

						echo "employee updated";
					}
					else{
						echo "employee not updated";
					}


}else{

	echo "employee not updated";
}

?>