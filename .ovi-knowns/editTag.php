<?php
require 'dbconfig.php';





$tagId=$_REQUEST["TagId"];
$language=$_REQUEST["Language"];
$status=$_REQUEST["Status"];


$db1 = db_connect();

$tagName=mysqli_real_escape_string($db1,$_REQUEST["Tag"]);

$sqlUniqueMobile="SELECT id FROM `tags` WHERE `tag_name` = '$tagName' and `language_id`=$language  and  `status`=$language ";


$exe2 = $db1->query($sqlUniqueMobile);



if($tagName==""){
	echo "tag is required";
}

else{
$sqlUpdate = "UPDATE `tags` SET `tag_name` ='$tagName', `language_id` =$language,`status`= $status,updated_at=now() WHERE `id` = $tagId";
	
	

					$exeUpdate = $db1->query($sqlUpdate);

					if($exeUpdate==1){

						echo "Tag has been updated";
					}
					else{
						echo "Tag not updated";
					}
	
}

?>