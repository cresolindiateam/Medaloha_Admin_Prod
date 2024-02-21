<?php
require 'dbconfig.php';

$tagName=$_REQUEST["Tag"];
$tagCode=$_REQUEST["Tagcode"];
$tagNumber=$_REQUEST["Tagnumber"];
$tagId=$_REQUEST["TagId"];
$status=$_REQUEST["Status"];


$db1 = db_connect();




$sqlUniqueMobile="SELECT id FROM `countries` WHERE `country_name` = '$tagName' ";


$exe2 = $db1->query($sqlUniqueMobile);



if($tagName==""){
	echo "Name is required";
}

else{
$sqlUpdate = "UPDATE `countries` SET `country_name` ='$tagName',`country_code` ='$tagCode',`country_code_number` ='$tagNumber',`status`= $status,updated_at=now() WHERE `id` = $tagId";
	

					$exeUpdate = $db1->query($sqlUpdate);

					if($exeUpdate==1){

						echo "Country updated";
					}
					else{
						echo "Country not updated";
					}

	
}

?>