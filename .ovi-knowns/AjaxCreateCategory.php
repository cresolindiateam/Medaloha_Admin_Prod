<?php
//ini_set('date.timezone', 'Asia/Kolkata');

require 'dbconfig.php';


 
//echo json_encode($_FILES);
//upload.php
$file='';
$name='';
if($_FILES["file"]["name"] != '')
{
 $test = explode('.', $_FILES["file"]["name"]);
 $ext = end($test);
 $name = $_FILES["file"]["name"];
 $location = 'image/category/' . $name;  
 move_uploaded_file($_FILES["file"]["tmp_name"], $location);
  $file= 'image/category/' .$_FILES["file"]["name"];
}

$db = db_connect();

$tag_name= mysqli_real_escape_string($db,$_REQUEST["tag_name"]);
$language_list=$_REQUEST["language_list"];

$cat_desc=mysqli_real_escape_string($db,$_REQUEST['cat_desc']);
/*$last_name="";
$email=$_REQUEST["email"];
$phone=$_REQUEST["phone"];

$password= $_REQUEST["password"];
$password = md5($password);*/

/*$file= $file;*/
/*$status_data=1;*/
/*$postal_code=$_REQUEST["postal_code"];*/
/*$work_rate=$_REQUEST["work_rate"];
$mileage_rate=$_REQUEST["mileage_rate"];
$due_date_range=$_REQUEST["due_date_range"];*/

/*$datetime = date("Y-m-d H:i:s");
$data1= array();
$status=0;
$message="";*/


$sqlUniqueEmail="SELECT id FROM categories WHERE category_name = '$tag_name' and language_id='$language_list'";
$exeEmail = $db->query($sqlUniqueEmail);

/*$sqlUniqueMobile="SELECT id FROM companies WHERE phone = '$phone'";
$exeMobile = $db->query($sqlUniqueMobile);
*/
if($exeEmail->num_rows>0){
	$message="Category already exist.";
}/*else if($exeMobile->num_rows>0){
	$message="Phone already used.";
}*/else{
	/*$sqlInsert = "INSERT INTO companies(company_name,first_name,last_name,email,phone,password,postal_code,work_rate,mileage_rate,due_date_range,created_at,status,logo,role)"." VALUES('$company_name','$first_name','$last_name','$email','$phone','$password','$postal_code','$work_rate','$mileage_rate','$due_date_range',now(),$status_data,'$file',2)";*/

$sqlInsert = "INSERT INTO categories(category_name,language_id,category_image,category_desc,created_at)"." VALUES('$tag_name','$language_list','$name','$cat_desc',now())";


	$exeInsert = $db->query($sqlInsert);
	$last_id = $db->insert_id;
	if(!empty($last_id)){
		$status=1;
		$message="New Category Created.";
	}else{
		$message="Category did not Created.";
	}
}
$db->close(); 

$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);
?>