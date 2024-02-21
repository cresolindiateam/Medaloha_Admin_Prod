<?php
require 'dbconfig.php';

$tagName=$_REQUEST["Tag"];
$tagId=$_REQUEST["TagId"];
$status=$_REQUEST["Status"];
$language_list=$_REQUEST["language_list"];

$file='';
$name='';

$message='';


$db1 = db_connect();


$sqlUniqueMobile="SELECT id FROM `cities` WHERE `city_name` = '$tagName'";



$exe2 = $db1->query($sqlUniqueMobile);



if($tagName==""){
	$message= "Name is required";

}

else{
$sqlUpdate = "UPDATE `cities` SET `city_name` ='$tagName',
`country_id`= $language_list,

`status`= $status,updated_at= now() WHERE `id` = $tagId";

/*echo $sqlUpdate;die;*/



					$exeUpdate = $db1->query($sqlUpdate);
	if($exeUpdate==1){

						$message= "City updated";

$status=1;
					}
					else{
						$message= "City not updated";
					
					}

					$data1= array("Status"=>1,"Message"=>$message);
echo json_encode($data1);
				
	
}

?>