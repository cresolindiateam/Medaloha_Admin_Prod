<?php
require 'dbconfig.php';


$db = db_connect();

$url="";


$sql="SELECT * FROM `AdminNotification` WHERE ViewStatus=0 ORDER BY `Created_At` DESC LIMIT 10"; 
$exe = $db->query($sql);
$Notificationdata = $exe->fetch_all(MYSQLI_ASSOC);
$count=0;
$lisist='';
foreach ($Notificationdata as $key => $item){
  if($item['ViewStatus']==0){
    $count=$count+1;
  }

  if($item['NotificationType']==1){
    $url="index.php";
  }else if($item['NotificationType']==2){
    $url="approved_inquiries.php";
  }else if($item['NotificationType']==3){
    $url="approved_inquiries.php";
  }else if($item['NotificationType']==4){
    $url="case_status.php";
  }else{
  	$url="#";
  }


$lisist.= '<li>
                    <a href="'.$url.'" onClick="setNotificationSeen("'.$id.'");">
                      <i class="fa fa-warning text-yellow"></i>'.$item['CaseId']." - ".$item['Description'].'</a></li>';                  

}

function setNotificationSeen($id){

  $sqlUpdate = "UPDATE AdminNotification SET `ViewStatus`=1 WHERE `Id`=$id";
  $exeUpdate = $db->query($sqlUpdate);
}


echo $lisist;
?>