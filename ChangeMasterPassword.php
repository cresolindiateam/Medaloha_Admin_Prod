<?php
require 'dbconfig.php';

$newPass=$_REQUEST["NewPAss"];


$db = db_connect();

if($newPass!="")
{


	$sql="SELECT password,id FROM `master_password`"; 
	$exe = $db->query($sql); 
    $result = $exe->fetch_all(MYSQLI_ASSOC);


	if($result){
		$password = $result[0]['password'];
		$id = $result[0]['id'];

		$sqlUpdate="UPDATE master_password SET `password`='".$newPass."' WHERE `id`='".$id."'";

		$exe = $db->query($sqlUpdate);

		if($exe==1){
			echo "Password Changed";
		}else{
				echo "Password Not Changed";
		}

	}else{
				$sqlUpdate="insert into master_password(`password`) values ('".$newPass."')";

		$exe = $db->query($sqlUpdate);
		if($exe==1){
			echo "Password Changed";
		}else{
				echo "Password Not Changed";
		}


	}


}


else
{
	echo "Password Should Not be Empty!";
}

?>