<?php
require 'dbconfig.php';
$oldPass=$_REQUEST["OldPAss"];
$newPass=$_REQUEST["NewPAss"];
$newPassConfirm=$_REQUEST["NewPAssConfirm"];

$db = db_connect();

if($newPass==$newPassConfirm){

	$sql="SELECT password FROM `admin` WHERE `username`='admin'"; 
	$exe = $db->query($sql); 
    $result = $exe->fetch_all(MYSQLI_ASSOC);
    $password = $result[0]['password'];

    $old1=md5($oldPass);

    

	if($password == md5($oldPass)){

		$sqlUpdate="UPDATE admin SET `password`='".md5($newPass)."' WHERE `username`='admin'";

		$exe = $db->query($sqlUpdate);

		if($exe==1){
			echo "Password Changed";
		}else{
				echo "Password Not Changed";
		}

	}else{
				echo "You Entered Wrong Password";
	}

}else{
	echo "Password Not Matched!";
}



?>