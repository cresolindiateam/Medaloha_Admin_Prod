<?php
require 'dbconfig.php';

$check=$_REQUEST["Check"];
$specId=$_REQUEST["Specialist_id"];
$order=$_REQUEST["Order"];

$db1 = db_connect();
$status=0;


$sqlUpdateexist = "select featured_order from `specialist_private`  where 1 and featured_order>0";
$exeUpdate1 = $db1->query($sqlUpdateexist);

$ordernumber=array();
if ($exeUpdate1->num_rows > 0) {
  

  while($row = $exeUpdate1->fetch_assoc()) {
    $ordernumber[]= $row['featured_order'];
  }
}





$sqlUpdate = "select featured_order from `specialist_private`  where  `featured_order` =$order";



					$exeUpdate = $db1->query($sqlUpdate);
	if ($exeUpdate->num_rows > 0) {

						$message= "This Order Number Already Assign To Specialist Please Select Another Order Sequence From [".implode(",",$ordernumber)."]";

$status=2;
$data1= array("Status"=>$status,"Message"=>$message,"Value"=>$specId);
echo json_encode($data1);

exit();
					}

					else{
				


$sqlUpdate = "UPDATE `specialist_private` SET `mark_featured_spec` ='$check',`featured_order` ='$order'
 WHERE `id` = $specId";



					$exeUpdate = $db1->query($sqlUpdate);
	if($exeUpdate==1){

						$message= "Specialist Mark As Featured Specialist";

$status=1;
$data1= array("Status"=>$status,"Message"=>$message,"Value"=>$specId);
echo json_encode($data1);

					}
					else{
						$message= "Data not updated";
					$status=0;

					$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);
					}

	
				
}
				
	


?>