<?php
require 'dbconfig.php';

$brand=$_REQUEST["Brand"];
$model=$_REQUEST["Model"];
$description=$_REQUEST["Description"];
$imei_number=$_REQUEST["IMEI_Number"];
$caseid=$_REQUEST["CaseId"];

$db1 = db_connect();


$sqlUnique="SELECT CaseId FROM `RepairEnquery` WHERE `CaseId` = '$caseid'";
$exeUnique = $db1->query($sqlUnique);


if($exeUnique->num_rows > 0){
	//$data = $exe2->fetch_all(MYSQLI_ASSOC);

        $updatesql="UPDATE `RepairEnquery` SET `Brand` ='$brand',`Model` ='$model',`Description` ='$description',`IMEI_Number` ='$imei_number' WHERE `CaseId` = '$caseid'";
        $exe1 = $db1->query($updatesql);

        if($exe1==1){
            echo "Job Updated";
        }else{
            echo "Job not Updated";
        }
	
}
else{
	echo "Job not Found";
}






//echo "success";

?>