<?php
require 'dbconfig.php';


$tempName = "all_enquiry.csv";

$file = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $tempName);
$fileName = mb_ereg_replace("([\.]{2,})", '', $file);

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=".$fileName);

$db=db_connect();


$sql = "SELECT `RepairEnquery`.`Id`,`RepairEnquery`.`CaseId`,`RepairEnquery`.`UserId`,`RepairingStatus`.`EmployeeId`,`RepairEnquery`.`Brand`,`RepairEnquery`.`Model`,`RepairEnquery`.`Description`,`RepairEnquery`.`IMEI_Number`,`RepairEnquery`.`Remarks`,`RepairEnquery`.`Location`,`RepairEnquery`.`Phone`,`PriceEstimateStatus`.`RepairAmount`,`RepairingStatus`.`PartAmount`,`RepairingStatus`.`WorkStatus`,`RepairingStatus`.`CloseStatus`,`RepairEnquery`.`PickAndDrop`,`RepairEnquery`.`Created_At`,`RepairingStatus`.`RepairDetail`,`RepairingStatus`.`PendingReason`,`RepairingStatus`.`CancelReason`,`CaseHistory`.`Created_At` AS `CloseTime` FROM `RepairEnquery` LEFT JOIN `RepairingStatus` ON `RepairingStatus`.`CaseId` = `RepairEnquery`.`CaseId` LEFT JOIN `CaseHistory` ON `CaseHistory`.`CaseId` = `RepairingStatus`.`CaseId` LEFT JOIN `PriceEstimateStatus` ON `PriceEstimateStatus`.`CaseId` = `RepairingStatus`.`CaseId` ORDER BY `RepairEnquery`.`Created_At` DESC";
  $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_ASSOC);
  $db = null; 



  foreach ($data as $key => $value){
      $workStatus = "";
      $deliveryType = "";
      $closeStatus = "";
      
      if($value['WorkStatus']==0){
        $workStatus="NA";
      }else if($value['WorkStatus']==1){
        $workStatus="Working";
      }else if($value['WorkStatus']==2){
        $workStatus="Pending";
      }else if($value['WorkStatus']==3){
        $workStatus="Completed";
      }else if($value['WorkStatus']==4){
        $workStatus="Delivered";
      }else if($value['WorkStatus']==5){
        $workStatus="Cancelled";
      }

      if($value['PickAndDrop']==0){
        $deliveryType="NA";
      }else if($value['PickAndDrop']==1){
        $deliveryType="Pick";
      }else if($value['PickAndDrop']==2){
        $deliveryType="Drop";
      }else if($value['PickAndDrop']==3){
        $deliveryType="Pick and Drop";
      }


      if($value['CloseStatus']==0){
        $closeStatus="Not Closed";
      }else if($value['CloseStatus']==1){
        $closeStatus="Closed";
      }

      $data[$key]['WorkStatus']= $workStatus;
      $data[$key]['PickAndDrop']= $deliveryType;
      $data[$key]['CloseStatus']= $closeStatus;
    
    }



function outputCSV($data, $csvHeader) {
	$output = fopen("php://output", "w");  
	foreach ($csvHeader as $rowheader)
	fputcsv($output, $rowheader);  
	foreach ($data as $row)
	fputcsv($output, $row); // here you can change delimiter/enclosure
	fclose($output);
}


$csvHeader = array(			
 array('Id','CaseId','UserId','Engineer Id','Brand','Model','Description','IMEI_Number','Remarks','Location','Phone','Repair Amount','Part Amount','Case Type','Close Status','Delivery Type','Created_At','Repair Detail','Pending Reason','CancelReason','CloseTime')
 );

outputCSV($data, $csvHeader);



?>