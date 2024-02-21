<?php
require 'dbconfig.php';
$db = db_connect();

$tag_name=mysqli_real_escape_string($db,$_REQUEST["tag_name"]);
$language_list=$_REQUEST["language_list"];

$sqlUniqueEmail="SELECT id FROM tags WHERE tag_name = '$tag_name' and language_id='$language_list'";
$exeEmail = $db->query($sqlUniqueEmail);

if($exeEmail->num_rows>0){
	$message="Tag already used.";
}
else
  {

     $sqlInsert = "INSERT INTO tags(tag_name,language_id,created_at)"." VALUES('$tag_name','$language_list',now())";


	$exeInsert = $db->query($sqlInsert);
	$last_id = $db->insert_id;
	if(!empty($last_id)){
		$status=1;
		$message="New Tag Created.";
	}else{
		$message="Tag did not Created.";
	}
}
$db->close(); 

$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);
?>