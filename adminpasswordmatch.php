<?php
require 'dbconfig.php';
$newPass=$_REQUEST["password"];
$db = db_connect();

if($newPass!="")
{


	$sql="SELECT password,id FROM `admin`"; 
	$exe = $db->query($sql); 
    $result = $exe->fetch_all(MYSQLI_ASSOC);


	if($result){
		$password = $result[0]['password'];
		$id = $result[0]['id'];

		

		if($password==md5($newPass)){
			
          echo	$status=1;
          	
		}

	else{
				
      echo	$status=0;


	}


}
}

else
{
	echo	$status=0;
}

?>