<?php
//ini_set('date.timezone', 'Asia/Kolkata');

require 'dbconfig.php';


 
//echo json_encode($_FILES);
//upload.php
/*$file='';*/
/*if($_FILES["file"]["name"] != '')
{
 $test = explode('.', $_FILES["file"]["name"]);
 $ext = end($test);
 $name = $_FILES["file"]["name"];
 $location = 'company_logo/' . $name;  
 move_uploaded_file($_FILES["file"]["tmp_name"], $location);
  $file= 'company_logo/' .$_FILES["file"]["name"];
}*/
$tag_name=$_REQUEST["tag_name"];
$tag_code=$_REQUEST["tag_code"];
$tag_code_number=$_REQUEST["tag_code_number"];
//$language_list=$_REQUEST["language_list"];
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
$db = db_connect();

$sqlUniqueEmail="SELECT id FROM countries WHERE country_name = '$tag_name'";
$exeEmail = $db->query($sqlUniqueEmail);

/*$sqlUniqueMobile="SELECT id FROM companies WHERE phone = '$phone'";
$exeMobile = $db->query($sqlUniqueMobile);
*/
if($exeEmail->num_rows>0){
	$message="Country Name already used.";
}/*else if($exeMobile->num_rows>0){
	$message="Phone already used.";
}*/else{
	

$sqlInsert = "INSERT INTO countries(country_name,country_code,country_code_number,created_at)"." VALUES('$tag_name','$tag_code','$tag_code_number',now())";


	$exeInsert = $db->query($sqlInsert);
	$last_id = $db->insert_id;
	if(!empty($last_id)){
		$status=1;
		$message="New Country Created.";
	}else{
		$message="Country did not Created.";
	}
}
$db->close(); 

$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);
?>