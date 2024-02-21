<?php
require 'dbconfig.php';

$tagName=$_REQUEST["Tag"];
$tagId=$_REQUEST["TagId"];
$status=$_REQUEST["Status"];

$editcatdesc=$_REQUEST["editcat_desc"];


$language_list=$_REQUEST["language_list"];

$file='';
$name='';
/*$status=0;*/
$message='';
if($_FILES["file"]["name"] != '')
{
 $test = explode('.', $_FILES["file"]["name"]);
 $ext = end($test);
 $name = $_FILES["file"]["name"];
 $location = 'image/category/' . $name;  
 move_uploaded_file($_FILES["file"]["tmp_name"], $location);
  $file= 'image/category/' .$_FILES["file"]["name"];
}

/*$edit_form_data=$_REQUEST["edit_form_data"];*/


$db1 = db_connect();


$sqlUniqueMobile="SELECT id FROM `categories` WHERE `category_name` = '$tagName'";



$exe2 = $db1->query($sqlUniqueMobile);



if($tagName==""){
	$message= "Name is required";

}

else{


if($file!=''){

$sqlUpdate = "UPDATE `categories` SET `category_name` ='$tagName',
`language_id`= $language_list,`category_image`= '$name',`category_desc`= '$editcatdesc',`status`= $status,`updated_at`= now() WHERE `id` = $tagId";
}
else
{
	$sqlUpdate = "UPDATE `categories` SET `category_name` ='$tagName',
`language_id`= $language_list,`category_desc`= '$editcatdesc',`status`= $status,`updated_at`= now() WHERE `id` = $tagId";
}

					$exeUpdate = $db1->query($sqlUpdate);
	if($exeUpdate==1){

						$message= "Category updated";

$status=1;
					}
					else{
						$message= "Category not updated";
					
					}

					$data1= array("Status"=>1,"Message"=>$message);
echo json_encode($data1);
				
	
}

?>