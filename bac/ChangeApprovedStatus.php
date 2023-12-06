<?php
require 'dbconfig.php';
$caseId=$_REQUEST["CaseId"];
$type=$_REQUEST["Type"];




$db = db_connect();
	$sql="SELECT CaseId FROM `RepairingStatus` WHERE `CaseId`='$caseId'"; 
	$exe = $db->query($sql); 

	

    if($exe->num_rows > 0){
    	$sqlUpdate="UPDATE RepairingStatus SET `UserSubmitStatus`='$type' WHERE `CaseId`='$caseId'";
		$exe = $db->query($sqlUpdate);
		if($exe==1){
			echo "Status Updated";
		}else{
				echo "Status not Updated";
		}
    }else{
    	echo "Case not Found";
    }
?>