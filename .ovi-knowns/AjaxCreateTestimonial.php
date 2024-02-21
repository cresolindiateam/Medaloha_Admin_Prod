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
$text_author=$_REQUEST["text_author"];
$text_comment=$_REQUEST["text_comment"];
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

$sqlUniqueEmail="SELECT id FROM testimonial WHERE text_author = '$text_author' and text_comment='$text_comment'";
$exeEmail = $db->query($sqlUniqueEmail);

/*$sqlUniqueMobile="SELECT id FROM companies WHERE phone = '$phone'";
$exeMobile = $db->query($sqlUniqueMobile);
*/
if($exeEmail->num_rows>0){
	$message="Testimonial already used.";
}/*else if($exeMobile->num_rows>0){
	$message="Phone already used.";
}*/else{
	/*$sqlInsert = "INSERT INTO companies(company_name,first_name,last_name,email,phone,password,postal_code,work_rate,mileage_rate,due_date_range,created_at,status,logo,role)"." VALUES('$company_name','$first_name','$last_name','$email','$phone','$password','$postal_code','$work_rate','$mileage_rate','$due_date_range',now(),$status_data,'$file',2)";*/

$sqlInsert = "INSERT INTO testimonial(text_author,text_comment,created_at)"." VALUES('$text_author','$text_comment',now())";


	$exeInsert = $db->query($sqlInsert);
	$last_id = $db->insert_id;
	if(!empty($last_id)){
		$status=1;
		$message="New Testimonial Created.";
	}else{
		$message="Testimonial did not Created.";
	}
}
$db->close(); 

$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);
?>