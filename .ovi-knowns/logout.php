<?php
   session_start();
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);

   echo 
$url = "http://".$_SERVER['HTTP_HOST'].'/admin_login.php';
  	echo "<script> window.location = '".$url."'</script>";
?>