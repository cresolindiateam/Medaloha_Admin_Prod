<?php
/*require 'dbconfig.php';


$db = db_connect();


$sql="SELECT * FROM `AdminNotification` WHERE ViewStatus=0 ORDER BY `Created_At` DESC"; 
$exe = $db->query($sql);
$Notificationdata = $exe->fetch_all(MYSQLI_ASSOC);
$count=0;


foreach ($Notificationdata as $key => $item){
  if($item['ViewStatus']==0){
    $count=$count+1;
  }              

}


echo $count;*/
?>