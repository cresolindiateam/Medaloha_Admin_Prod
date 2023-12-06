<?php
require 'dbconfig.php';

$userId=$_REQUEST['UserId'];

 $db1 = db_connect();

 $sqlUnique="SELECT Id FROM `UserProfile` WHERE `Id` = $userId";
 $exe2 = $db1->query($sqlUnique);


if($exe2->num_rows > 0){

	$updatesql="UPDATE `UserProfile` SET `DeleteStatus`=1 WHERE `Id` = '$userId'";
	$exe1 = $db1->query($updatesql);	


	if($exe1==1){
		echo "user deleted";
	}
	else{
		echo "user not deleted";
	}

}
else{
	echo "user not deleted";
}



//echo $sqlUnique;

?>