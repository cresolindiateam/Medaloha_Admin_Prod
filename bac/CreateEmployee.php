<?php
ini_set('date.timezone', 'Asia/Kolkata');

require 'dbconfig.php';

$empName=$_REQUEST["EmpName"];
$empMobile=$_REQUEST["EmpMobile"];
$empPassword=$_REQUEST["EmpPassword"];
$userType=$_REQUEST["UserType"];

$datetime = date("Y-m-d H:i:s");


$db1 = db_connect();


$sqlUniqueMobile="SELECT Id,DeleteStatus FROM `UserProfile` WHERE `Mobile_Number` = '$empMobile'";
$exe2 = $db1->query($sqlUniqueMobile);



if($empMobile==""){
	echo "mobile is required";
}
else if($empPassword==""){
	echo "password is required";
}
else if($exe2->num_rows > 0){
	$result = $exe2->fetch_all(MYSQLI_ASSOC);
	$deleteStatus = $result[0]['DeleteStatus'];
	$id = $result[0]['Id'];

	if($deleteStatus==1){
		$sqlUpdate = "UPDATE UserProfile SET `First_Name`='$empName',`Password`='".md5($empPassword)."', `UserType`='$userType',`Created_At`='".$datetime."',`FirebaseToken`='',`DeleteStatus`=0 WHERE `Mobile_Number`='$empMobile'";
		$exeUpdate = $db1->query($sqlUpdate);

		if($exeUpdate==1){
			echo "Employee Inserted";
		}else{
			echo "Employee not Inserted";
		}

	}else{
		echo "mobile is already registered";
	}

	//echo $deleteStatus;

	
}else{


		$sqlInsert = "insert into UserProfile(Mobile_Number,Password,Created_At,First_Name,UserType)"
							. " VALUES('$empMobile','".md5($empPassword)."','".$datetime."','$empName',$userType)";

					$exeInsert = $db1->query($sqlInsert);
					$last_id = $db1->insert_id;

					if(!empty($last_id)){

						$Usertoken	= md5(uniqid($last_id, true));
						$sql = "update UserProfile SET Token = '".$Usertoken."' WHERE Id = '".$last_id."'"; 
						$db1->query($sql);  
    					$db1 = null;

						echo "Employee Inserted";
					}
					else{
						echo "Employee not Inserted";
					}

}


//echo "success";

?>