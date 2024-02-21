<?php
require 'dbconfig.php';

$tagName=$_REQUEST["textauthor"];

$tagId=$_REQUEST["TagId"];
$language=$_REQUEST["textcomment"];
$status=$_REQUEST["Status"];


$db1 = db_connect();


$sqlUniqueMobile="SELECT id FROM `tags` WHERE `text_author` = '$tagName' and `text_comment`=$language  and  `status`=$language ";


$exe2 = $db1->query($sqlUniqueMobile);



if($tagName==""){
	echo "Text Author is required";
}

if($language==""){
	echo "Text Comment is required";
}

else{
$sqlUpdate = "UPDATE `testimonial` SET `text_author` ='$tagName', `text_comment` ='$language',`status`= $status,updated_at=now() WHERE `id` = $tagId";
	

					$exeUpdate = $db1->query($sqlUpdate);

					if($exeUpdate==1){

						echo "Testimonial has been updated";
					}
					else{
						echo "Testimonial not updated";
					}
	
}

?>