<?php
require 'dbconfig.php';
$db = db_connect();


$sql="UPDATE AdminNotification SET ViewStatus=1 WHERE ViewStatus=0;"; 
$exe = $db->query($sql);

if($exe==1){
  echo "Success";
}else{
  echo "Failed";
}
?>