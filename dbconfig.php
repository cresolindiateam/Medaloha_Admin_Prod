
<?php
function db_connect(){ 
$server = '103.171.181.11:3306'; // this may be an ip address instead
    $user = 'medalohaapi_dgoud';
    $pass = 'Dgoud123!@#';
    $database = 'medalohaapi_medalohadb';

      // Create connection
  $conn= mysqli_connect($server,$user,$pass,$database);
  return $conn;
  if(!$conn){
  die("Connection failed: " . mysqli_connect_error());
}
}

/*function db_connect(){ 
$server = 'localhost'; // this may be an ip address instead
    $user = 'root';
    $pass = '';
    $database = 'medalohadb';

      // Create connection
  $conn= mysqli_connect($server,$user,$pass,$database);
  return $conn;
  if(!$conn){
  die("Connection failed: " . mysqli_connect_error());
}
}*/


  
?>
