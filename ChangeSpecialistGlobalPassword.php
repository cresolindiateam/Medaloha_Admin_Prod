<?php
require 'dbconfig.php';

$newPass=$_REQUEST["NewPAss"];
$newPassConfirm=$_REQUEST["NewPAssConfirm"];

$db = db_connect();

if($newPass!=""){

if(strlen($newPass)>10 && strlen($newPass)<12)
{


if($newPass===$newPassConfirm){

	$sql="SELECT password,id FROM `specialist_global_password`"; 
	$exe = $db->query($sql); 
    $result = $exe->fetch_all(MYSQLI_ASSOC);

    



    

	if($result){
		$password = $result[0]['password'];
		$id = $result[0]['id'];

		$sqlUpdate="UPDATE specialist_global_password SET `password`='".md5($newPass)."' WHERE `id`='".$id."'";

		$exe = $db->query($sqlUpdate);

		if($exe==1){
			echo "Password Changed";
		}else{
				echo "Password Not Changed11";
		}

	}else{
				$sqlUpdate="insert into specialist_global_password(`password`) values ('".md5($newPass)."')";

		$exe = $db->query($sqlUpdate);
		if($exe==1){
			echo "Password Changed";
		}else{
				echo "Password Not Changed12";
		}


	}

}else{
	echo "Password Not Matched!";
}
}
else{
	echo "Password should be greater than 10 charcaters and less than 12 characters";
}
}
else
{
	echo "Password Should Not be Empty!";
}

?>