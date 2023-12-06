<?php
require 'dbconfig.php';

$caseId=$_REQUEST["CaseId"];


$db1 = db_connect();

$sql="SELECT Brand,Model,Description,IMEI_Number FROM `RepairEnquery`  WHERE `CaseId` = '$caseId'";
$exe1 = $db1->query($sql);
$result = $exe1->fetch_all(MYSQLI_ASSOC);
$db1=null;

$data1= array("Brand"=>$result[0]['Brand'],"Model"=>$result[0]['Model'],"Description"=>$result[0]['Description'],"IMEI_Number"=>$result[0]['IMEI_Number']);
echo json_encode($data1);

//echo "success";

?>