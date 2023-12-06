<?php
require 'dbconfig.php';

$id=$_REQUEST["Id"];
$db = db_connect();


$sql="SELECT Id FROM `AdminNotification` WHERE `Id`=$id"; 
$exe = $db->query($sql);

if($exe->num_rows > 0){

  $sqlUpdate = "UPDATE AdminNotification SET `ViewStatus`=1 WHERE `Id`=$id";
  $exeUpdate = $db->query($sqlUpdate);

  if($exeUpdate==1){
    echo "success";
  }else{
    echo "failed";
  }

}else{
  echo "not found";
}




?>