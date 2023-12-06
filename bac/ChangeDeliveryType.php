<?php
require 'dbconfig.php';
$id=$_REQUEST["Id"];
$type=$_REQUEST["Type"];
$deliveryOptions=0;

if($type=="Pick"){
	$deliveryOptions=1;
}else if($type=="Drop"){
	$deliveryOptions=2;
}else if($type=="Pick and Drop"){
	$deliveryOptions=3;
}


$db = db_connect();
	$sql="SELECT Id FROM `RepairingStatus` WHERE `Id`=$id"; 
	$exe = $db->query($sql); 

    if($exe->num_rows > 0){
    	$sqlUpdate="UPDATE RepairingStatus SET `DeliveryOptions`=$deliveryOptions WHERE `Id`=$id";
		$exe = $db->query($sqlUpdate);
		if($exe==1){
			echo "Changed Successfully";
		}else{
				echo "Not Changed";
		}
    }
?>