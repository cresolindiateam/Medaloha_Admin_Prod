<?php
ini_set('date.timezone', 'Asia/Kolkata');

require 'dbconfig.php';
require 'admin.php';


session_start();
if($_SESSION['username']==""){
  echo "<script> window.location = 'http://prateekmobile.justevent.in/admin_login.php'</script>";
}

  $db=db_connect();


  $sql="SELECT `RepairingStatus`.`Id`,`RepairingStatus`.`CaseId`,`RepairingStatus`.`UserId`,`RepairingStatus`.`EmployeeId`,`RepairingStatus`.`TotalAmount`,`RepairingStatus`.`StartDate`,`RepairingStatus`.`DeliveryDate`,`RepairingStatus`.`WorkStatus`,`RepairingStatus`.`DeliveryOptions`,`RepairingStatus`.`DeliveryStatus`,`RepairingStatus`.`DDateChangeReason`,`RepairingStatus`.`DDateChangeCount`,`RepairingStatus`.`PendingReason`,`RepairingStatus`.`EmpStartTime`,`RepairingStatus`.`EmpEndTime`,`RepairingStatus`.`PickDropStatus`,`RepairingStatus`.`DelBoyStartTime`,`RepairingStatus`.`DelBoyEndTime`,`RepairingStatus`.`DelBoyId`,`RepairingStatus`.`Accessories`,`RepairingStatus`.`PickDropAmount`,`RepairingStatus`.`PickDropAmountStatus`,`RepairingStatus`.`RepairDetail`,`RepairEnquery`.`Brand`,`RepairEnquery`.`Model`,`RepairEnquery`.`Location`,`RepairEnquery`.`Phone`,`RepairEnquery`.`Description`,`RepairEnquery`.`IMEI_Number`,`RepairEnquery`.`Remarks`,`UserProfile`.`First_Name`,`UserProfile`.`First_Name` AS `Emp_Name`,`UserProfile`.`Mobile_Number` AS `Emp_Mobile`,`UserProfile`.`Location` AS `Emp_Location`,`PriceEstimateStatus`.`RepairAmount` FROM `RepairingStatus` LEFT JOIN `RepairEnquery` ON `RepairingStatus`.`CaseId` = `RepairEnquery`.`CaseId` LEFT JOIN `UserProfile` ON `UserProfile`.`Id` = `RepairingStatus`.`UserId` LEFT JOIN `PriceEstimateStatus` ON `PriceEstimateStatus`.`CaseId` = `RepairingStatus`.`CaseId` WHERE `RepairingStatus`.`CloseStatus`=0 && `RepairingStatus`.`UserSubmitStatus`!=2 && `RepairingStatus`.`EmployeeId`!=0 ORDER BY `RepairingStatus`.`Id` DESC";


 



  // $sql = "SELECT Id,CaseId,UserId,EmployeeId,TotalAmount,StartDate,DeliveryDate,WorkStatus,DeliveryOptions,DeliveryStatus,DDateChangeReason,DDateChangeCount,PendingReason,EmpStartTime,EmpEndTime,PickDropStatus,DelBoyStartTime,DelBoyEndTime,DelBoyId,Accessories,PickDropAmount,PickDropAmountStatus,RepairDetail FROM `RepairingStatus` WHERE `CloseStatus`=0 && `UserSubmitStatus`!=2 && `EmployeeId`!=0 ORDER BY `Id` DESC";

  
  $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_ASSOC);

  // foreach ($data as $key => $value){
  //     $caseId=$value['CaseId'];
  //     $userId=$value['UserId'];
  //     $empId=$value['EmployeeId'];

  //     $sqldescription="SELECT Brand,Model,Location,Phone,Description,IMEI_Number,Remarks FROM `RepairEnquery` where `CaseId`='$caseId'";
  //       $exe1 = $db->query($sqldescription);

  //       if($exe1->num_rows > 0){
  //         $result1 = $exe1->fetch_all(MYSQLI_ASSOC);
  //          foreach ($result1 as $key1 => $value1){
            
  //           $data[$key]['Brand']= $value1['Brand'];
  //           $data[$key]['Model']= $value1['Model'];
  //           $data[$key]['Location']= $value1['Location'];
  //           $data[$key]['Phone']= $value1['Phone'];
  //           $data[$key]['Description']= $value1['Description'];
  //           $data[$key]['IMEI_Number']= $value1['IMEI_Number'];
  //           $data[$key]['Remarks']= $value1['Remarks'];
  //       }
  //     }
  //     else{
          
  //           $data[$key]['Location']= "";
  //           $data[$key]['Brand']= "";
  //           $data[$key]['Model']= "";
  //           $data[$key]['Phone']= "";
  //           $data[$key]['Description']= "";
  //           $data[$key]['IMEI_Number']= "";
  //           $data[$key]['Remarks']= "";
  //     }




  //     $sqlName="SELECT First_Name,Mobile_Number,Location FROM `UserProfile` where `Id`='$userId'";
  //     $exe2 = $db->query($sqlName);

  //     if($exe2->num_rows > 0){
  //         $result2 = $exe2->fetch_all(MYSQLI_ASSOC);
  //          foreach ($result2 as $key2 => $value2){
  //           $data[$key]['First_Name']= $value2['First_Name'];
  //         }
  //     }
  //     else{
  //           $data[$key]['First_Name']= "";
  //     }






  //     $sqlEmp="SELECT First_Name,Mobile_Number,Location FROM `UserProfile` where `Id`='$empId'";
  //     $exe3 = $db->query($sqlEmp);

  //     if($exe3->num_rows > 0){
  //         $result3 = $exe3->fetch_all(MYSQLI_ASSOC);
  //          foreach ($result3 as $key3 => $value3){
  //           $data[$key]['Emp_Name']= $value3['First_Name'];
  //           $data[$key]['Emp_Mobile']= $value3['Mobile_Number'];
  //           $data[$key]['Emp_Location']= $value3['Location'];
  //         }
  //     }
  //     else{
  //           $data[$key]['Emp_Name']= "";
  //           $data[$key]['Emp_Mobile']= "";
  //           $data[$key]['Emp_Location']= "";
  //     }


  //     $sqlAmount="SELECT RepairAmount FROM `PriceEstimateStatus` where `CaseId`='$caseId'";
  //     $exe3 = $db->query($sqlAmount);

  //     if($exe3->num_rows > 0){
  //         $result3 = $exe3->fetch_all(MYSQLI_ASSOC);
  //          foreach ($result3 as $key3 => $value3){
  //           $data[$key]['RepairAmount']= $value3['RepairAmount'];
  //         }
  //     }
  //     else{
  //           $data[$key]['RepairAmount']= "";
  //     }



  //   }


  $sqlDelBoy = "SELECT Id,First_Name FROM `UserProfile` WHERE `UserType`=3 && `DeleteStatus`=0";
  $exeDelBoy = $db->query($sqlDelBoy);
  $dataDelBoy = $exeDelBoy->fetch_all(MYSQLI_ASSOC);

  $sqlEng = "SELECT Id,First_Name FROM `UserProfile` WHERE `UserType`=2 && `DeleteStatus`=0";
  $exeEng = $db->query($sqlEng);
  $dataEng = $exeEng->fetch_all(MYSQLI_ASSOC);

  $sqlAdmin="SELECT First_Name,Last_Name FROM `Admin_Info`";
  $exeAdmin = $db->query($sqlAdmin);
  $dataAdmin = $exeAdmin->fetch_all(MYSQLI_ASSOC);

?>







<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Prateek Mobile</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
</head>

<style>
  body{
    padding: 0px !important;
  }

  .printHeading{
  font-size: 1.5em;
}




</style>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include('header.php');?>

 
  <?php include('left_side_bar.php');?>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Case Status
      </h1>
     
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="user-info-modal">
      <div class="container">
  <div class="modal fade" id="user-info-modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">User Information</h4>
        </div>
        <div class="modal-body">
         <div class="user-info-area">
        <div class="row ">
          <div class="col-md-1"><i class="fa fa-user"></i></div>

          <div class="col-md-9">
          <div class="personal-info-label">Name</div>
          <input type="text" class="form-control" id="name"/>
          <input type="hidden" class="form-control" id="userid1"/>
        
          </div>

        </div>
        <hr/>
         <div class="row ">
          <div class="col-md-1"><i class="fa fa-phone"></i></div>

          <div class="col-md-9">
          <div class="personal-info-label">Mobile</div>
          <input type="text" class="form-control" id="mobile"/>
          </div>
          
        </div>
        <hr/>
         <div class="row ">
          <div class="col-md-1"><i class="fa fa-envelope"></i></div>

          <div class="col-md-9">
          <div class="personal-info-label">Address</div>
          <input type="text" class="form-control" id="email"/>
          </div>

          
        </div>
        <hr/>
        </div>
        </div>
         <div class="modal-footer">
          <button type="button" class="btn theme-btn " data-dismiss="modal" onclick="updateUserInfo();">Update</button>
        </div>
      
      </div>
      
    </div>
  </div>
</div>
</div>

<div class="case-detail-modal">
      <div class="container">
  <div class="modal fade" id="case-detail-modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Case Detail</h4>
        </div>
        <div class="modal-body">
         <div class="user-info-area">
        <div class="row ">
          <div class="col-md-1"><i class="fa fa-mobile"></i></div>
          <div class="col-md-9">
          <div class="personal-info-label">Brand Name</div>
          <input type="text" class="form-control" id="brand"/>
          </div>
        </div>
        <hr/>
         <div class="row ">
          <div class="col-md-1"><i class="fa fa-mobile"></i></div>
          <div class="col-md-9">
              <div class="personal-info-label">Modal Name</div>
              <input type="text" class="form-control" id="model"/>
          </div>
        </div>
        <hr/>
        <div class="row ">
          <div class="col-md-1"><i class="fa fa-mobile"></i></div>
          <div class="col-md-9">
              <div class="personal-info-label">Repairing Detail</div>
              <input type="text" class="form-control" id="description"/>
              <input type="hidden" class="form-control" id="caseid"/>
          </div>
        </div>
        </div>
        </div>
         <div class="modal-footer">
          <button type="button" class="btn theme-btn " data-dismiss="modal" onclick="updateCaseDetail();">Update</button>
        </div>
      
      </div>
      
    </div>
  </div>
</div>
</div>

<div class="employee-info-modal">
      <div class="container">
  <div class="modal fade" id="employee-info-modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Employee Information</h4>
        </div>
        <div class="modal-body">
         <div class="user-info-area">
        <div class="row ">
          <div class="col-md-1"><i class="fa fa-user"></i></div>
          <!-- <div class="col-md-9"><span id="empname"></span></div> -->

          <div class="col-md-9">
                    <select class="form-control" id="select_empname" name="select_empname">  
                         <?php foreach($dataEng as $k2 => $v2){?>
                         <option value="<?php echo $v2['Id'];?>"><?php echo $v2['Id'];?> - <?php echo $v2['First_Name'];?></option>
                         <?php } ?>
                    </select>
        </div>

        </div>
        <hr/>
         <div class="row ">
          <div class="col-md-1"><i class="fa fa-phone"></i></div>
          <div class="col-md-9"><span id="empmobile"></span></div>
          <input type="hidden" id="caseid2">
        </div>
        <hr/>
        <div class="row ">
          <div class="col-md-1"><i class="fa fa-envelope"></i></div>
          <div class="col-md-9"><span id="empemail"></span></div>
        </div>
        <hr>
        </div>
        </div>
         <div class="modal-footer">
          <button type="button" class="btn theme-btn " data-dismiss="modal" id="assign_btn1" onClick="changeEmp();">Change</button>
        </div>
      
      </div>
      
    </div>
  </div>
</div>
</div>



<div class="repair_amount_change_modal">
      <div class="container">
  <div class="modal fade" id="repair_amount_change_modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Repair Amount</h4>
        </div>
        <div class="modal-body">
         <div class="user-info-area">
        
        
         <div class="row ">
          <div class="col-md-1"><i class="fa fa-phone"></i></div>
          <input type="text" id="repair_amount">
          <input type="hidden" id="caseid_amount">
          <input type="hidden" id="row_id">
        </div>
        
        
        </div>
        </div>
         <div class="modal-footer">
          <button type="button" class="btn theme-btn " data-dismiss="modal" id="assign_btn1" onClick="updateRepairAmount();">Update</button>
        </div>
      
      </div>
      
    </div>
  </div>
</div>
</div>



<div class="change_remarks_modal">
      <div class="container">
  <div class="modal fade" id="change_remarks_modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Remarks</h4>
        </div>
        <div class="modal-body">
         <div class="user-info-area">
        
        
         <div class="row ">
          <div class="col-md-1"><i class="fa fa-phone"></i></div>
          <input type="text" id="remarks_input">
          <input type="hidden" id="caseid_remarks">
          <input type="hidden" id="td_id">
        </div>
        
        
        </div>
        </div>
         <div class="modal-footer">
          <button type="button" class="btn theme-btn " data-dismiss="modal" id="assign_btn1" onClick="closeCase();">Update</button>
        </div>
      
      </div>
      
    </div>
  </div>
</div>
</div>










<div class="print-case-detail-modal">

      <div class="container">
  <div class="modal fade" id="print-case-detail-modal" role="dialog" style="background: black;">
    <div class="modal-dialog">
      <div class="modal-content">
        



        <div >
        

          <center>
          <div >Job Sheet</div>
          <h2>
          <img src="dist/img/prateek_icon_black.png" style="width:13%;">
          <br/>
          <b>PRATEEK MOBILE</b><br>
          <small>2nd Floor Rajeev Plaza</small><br/>
          <small>Jayendra Ganj Gwalior</small><br/>
          <small>9755669222, 7354995571</small>
          </h2>
          
          <hr/>
          
          <table align="center" >
            <tr><td class="printHeading"><b>Date: </b></td> <td id="date1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>Job No: </b></td> <td id="caseid1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>Name: </b></td> <td id="name1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>Address: </b></td> <td id="address1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>Mobile: </b></td> <td id="mobile1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>Brand: </b></td> <td id="brand1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>Model: </b></td> <td id="model1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>IMEI Number: </b></td> <td id="imei_number1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>Problem: </b></td> <td id="problem1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>Amount: </b></td> <td id="totalAmount1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>Assessories: </b></td> <td id="assessories1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>Remarks: </b></td> <td id="remarks1" class="printHeading"></td></tr>
          </table>
          
          <hr/>
          <div><b><i>Download prateek mobile app from  </i></b> <br><br><img src="dist/img/google_play.png" style="width:30%" /><br><br>
           <b><i>& enjoy home pick and drop services</b></i>
              

          </div>
         

          </center>
          <!-- <div>Exe Name</div> -->
          <div>

            <h5 class="pull-right">Customer's Signature</h5>
          </div>

        </div>






      </div>
      
    </div>
  </div>
</div>

</div>



<div class="case-delivery-boy-model">
      <div class="container">
  <div class="modal fade" id="case-delivery-boy-model" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Mobile Picking Information</h4>
        </div>
        <div class="modal-body">
         <div class="user-info-area">
         <div class="row ">
          <div class="col-md-1"><i class="fa fa-user"></i></div>
          <div class="col-md-9"><span id="caseid"></span></div>
        </div>
        <hr/>

        <div class="row ">
          <div class="col-md-1"><i class="fa fa-envelope"></i></div>
          <div class="col-md-9"><span id="location"></span></div>
        </div>
        <hr/>

        <div class="row ">
          <div class="col-md-1"><i class="fa fa-envelope"></i></div>
          <div class="col-md-9">
                    <select class="form-control" id="select_deliveryBoy" name="select_deliveryBoy">  
                         <?php foreach($dataDelBoy as $k2 => $v2){?>
                         <option value="<?php echo $v2['Id'];?>"><?php echo $v2['Id'];?> - <?php echo $v2['First_Name'];?></option>
                         <?php } ?>
                    </select>
        </div>
        
        </div>
        <hr/>


        <div class="row ">
          <div class="col-md-1"><i class="fa fa-envelope"></i></div>
          <div class="col-md-9"><span id="pick_status"></span></div>
        </div>
        <hr/>

        <div class="row ">
          <div class="col-md-1"><i class="fa fa-envelope"></i></div>
          <div class="col-md-9"><label>Start Time: &nbsp;&nbsp;</label><span id="startTime"></span></div>
        </div>

        <div class="row ">
          <div class="col-md-1"><i class="fa fa-envelope"></i></div>
          <div class="col-md-9"><label>End Time: &nbsp;&nbsp;</label><span id="endTime"></span></div>
        </div>

        


        </div>
         <div class="modal-footer">
          <button type="button" class="btn theme-btn" data-dismiss="modal" id="assign_btn2" onClick="assignCaseDelBoy1();">Assign</button>
        </div>
      
      </div>
      
    </div>
  </div>
</div>
</div>
</div>




<div class="send-approval-modal">
      <div class="container">
  <div class="modal fade" id="send-approval-modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Send Price Estimate To Customer</h4>
        </div>
        <div class="modal-body">
        <div class="user-info-area">
        <div class="theme-form">
          <form>
          <div class="row">
            <div class="col-md-12">
             <label>Repairing Amount</label>
             <i class="fa fa-inr form-inner-icon" ></i>
             <input type="text" class="form-control" id="repairing_amount" name="repairing_amount"/>
            </div>
            <div class="col-md-12">
             <label>Pick And Drop Amount</label>
             <i class="fa fa-car form-inner-icon" ></i>
             <input type="text" class="form-control" id="pick_drop_amount" name="pick_drop_amount"/>
            </div>
            <div class="col-md-6">
             <label>Pic Amount</label>
             <i class="fa fa-car form-inner-icon" ></i>
             <input type="text" class="form-control" id="pick_amount" name="pick_amount"/>
            </div>
            <div class="col-md-6">
             <label>Drop Amount</label>
             <i class="fa fa-car form-inner-icon" ></i>
             <input type="text" class="form-control" id="drop_amount" name="drop_amount"/>
            </div>
          </div>
          </form>
          </div>

        </div>
        </div>
         <div class="modal-footer">
          <center><button type="button" class="btn theme-btn " >Send Price Estimate <i class="fa fa-arrow-circle-right"></i></button></center>
        </div>
      
      </div>
      
    </div>
  </div>
</div>
</div>









<section class="content">
      <div class="row" >
        <div class="col-xs-12">

          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">

            <div class="horizontal-scroll">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>

                  <th style="width: 10px">#</th>
                  <th>Job ID</th>
                  <th>Remarks</th>
                  <th>User ID</th>
                  <th>Engineer ID</th>
                  <th>Mobile</th>
                  <th>Repair Amount</th>
                  <th>Total Amount</th>
                  <th>Payable Amount</th>
                  <th style="width: 130px;">Delivery Type</th>
                  <!-- <th class="big-space-2">Start Date</th> -->
                  <th class="big-space-2">Delivery Date</th>
                  <th class="big-space-2">Start Time</th>
                  <th class="big-space-2">End Time</th>
                  <!-- <th>DCC</th>-->
                  <th class="big-space-2">DCR</th>
                  <th class="big-space-2">PR</th> 
                  <th class="big-space-2">DR</th> 
                  <th>Work Status</th>
                  <!-- <th class="big-space-3">Delivery Status</th> -->
                  <th class="big-space-2">Assign to DeliveryBoy</th>
                  <th>Print</th>
                  <th>--</th>
                </tr>
                </thead>
                <tbody>



<?php
foreach ($data as $key => $item){
        $id = $item['Id'];
        $caseId = $item['CaseId'];
        $userId = $item['UserId'];
        $empId = $item['EmployeeId'];
        $totalAmount = $item['TotalAmount'];
        $startDate = $item['StartDate'];
        $deliveryDate = $item['DeliveryDate'];
        $workStatus = $item['WorkStatus'];
        $deliveryOptions = $item['DeliveryOptions'];
        $deliveryStatus = $item['DeliveryStatus'];
        $dateChangeCount = $item['DDateChangeCount'];
        $dateChangeReason = $item['DDateChangeReason'];
        $repairDetail = $item['RepairDetail'];
        $location = $item['Location'];
        $startTime = $item['EmpStartTime'];
        $endTime = $item['EmpEndTime'];
        $pikDropStatus = $item['PickDropStatus'];
        $delBoyId = $item['DelBoyId'];
        $delBoyStartTime = $item['DelBoyStartTime'];
        $delBoyEndTime = $item['DelBoyEndTime'];
        $totalAmount = $item['TotalAmount'];
        $pickDropAmount = $item['PickDropAmount'];
        $pickDropAmountStatus = $item['PickDropAmountStatus'];

        $brand = $item['Brand'];
        $model = $item['Model'];
        $mobile = $item['Phone'];
        $problem = $item['Description'];
        $imei_number = $item['IMEI_Number'];
        $remarks = $item['Remarks'];
        $name = $item['First_Name'];
        $assessories = $item['Accessories'];
        $repairAmount = $item['RepairAmount'];

        $emp_name = $item['Emp_Name'];
        $emp_mobile = $item['Emp_Mobile'];
        $emp_location = $item['Emp_Location'];

        $printDate=$deliveryDate;

        $datetime = date("Y-m-d H:i:s");
        $printDate=$datetime;

        // if($printDate=="0000-00-00"){
        //   $printDate=$datetime;
        // }

        $count=$key+1;
        

        $delivery="";
        $delivery1="";

        if($deliveryOptions==0){
          $delivery="NA";
          $delivery1="NA";
        }else if($deliveryOptions==1){
          $delivery="NA";
          $delivery1="Pick";
        }
        else if($deliveryOptions==2){
          $delivery="Drop";
          $delivery1="Drop";
        }
        else if($deliveryOptions==3){
          $delivery="Drop";
          $delivery1="Pick and Drop";
        }


        echo'<tr id="'.$id.'">'; 
        echo'<td>'.$count.'</td>';
?>
        <td><input type="hidden" value="<?php echo $brand;?>" id="brand<?php echo $id;?>"><input type="hidden" value="<?php echo $model;?>" id="model<?php echo $id;?>"><input type="hidden" value="<?php echo $problem;?>" id="problem<?php echo $id;?>"><input type="hidden" value="<?php echo $caseId;?>" id="caseId<?php echo $id;?>"><a data-toggle="modal" data-target="#case-detail-modal"
         onClick="showCaseDetail('<?php echo $id;?>');"><?php echo $item['CaseId']; ?></a></td>


         <?php echo '<td>'.$remarks.'</td>';?>

<?php         

        echo'<td><input type="hidden" value="'.$name.'" id="name'.$userId.'"><input type="hidden" value="'.$mobile.'" id="mobile'.$userId.'"><input type="hidden" value="'.$location.'" id="location'.$userId.'"><a data-toggle="modal" data-target="#user-info-modal" onClick="showUserDetail('.$userId.');">'.$item['UserId'].'</a></td>';
        
        echo'<td><input type="hidden" value="'.$emp_name.'" id="emp_name'.$id.'"><input type="hidden" value="'.$emp_mobile.'" id="emp_mobile'.$id.'"><input type="hidden" value="'.$emp_location.'" id="emp_location'.$id.'"><input type="hidden" value="'.$empId.'" id="empId'.$id.'"><input type="hidden" value="'.$caseId.'" id="caseId'.$id.'"><a data-toggle="modal" data-target="#employee-info-modal" onClick="showEmpDetail('.$id.');">'."E".$item['EmployeeId'].'</a></td>';
        echo'<td>'.$item['Phone'].'</td>';

        echo'<td ><input type="hidden" value="'.$repairAmount.'" id="repairAmount'.$id.'"><input type="hidden" value="'.$caseId.'" id="caseId'.$id.'"><a data-toggle="modal" data-target="#repair_amount_change_modal" onClick="showRepairAmount('.$id.');"><span id="repair_amount_span'.$id.'">'.$item['RepairAmount'].'</span></td>';

        echo'<td><span id="total_amount_span'.$id.'">'.$item['TotalAmount'].'</span></td>';



        if($pickDropAmountStatus==1){
          $payableAmount= $totalAmount - $pickDropAmount;

          echo'<td><span id="payable_amount_span'.$id.'">'.$payableAmount.'</span></td>';

          //echo'<td>'.$payableAmount.'</td>';
        }else{
          echo'<td><span id="payable_amount_span'.$id.'">'.$item['TotalAmount'].'</span></td>';
          
        }



        
        //echo'<td>'.$delivery1.'</td>';

?>
       <td><form><div class="theme-form-table">
                  <select style="width:130px;" class="form-control" onchange="changeDeliveryType(<?php echo $id;?> ,this.value);" id="delivery_type" name="delivery_type">
                  <option <?php if($delivery1=="NA"){ ?> selected <?php }?>value="NA">NA</option>
                  <option <?php if($delivery1=="Pick"){ ?> selected <?php }?> value="Pick">Pick</option>
                  <option <?php if($delivery1=="Drop"){ ?> selected <?php }?> value="Drop">Drop</option>
                  <option <?php if($delivery1=="Pick and Drop"){ ?> selected <?php }?> value="Pick and Drop">Pick and Drop</option></select></div></form></td>


<?php
        //selectDeliveryType($delivery1);

        // if($startDate=="0000-00-00"){
        //   echo'<td>'.'NA'.'</td>';
        // }else{
        //   echo'<td>'.$item['StartDate'].'</td>';
        // }

        if($deliveryDate=="0000-00-00"){
          echo'<td>'.'NA'.'</td>';
        }else{
          echo'<td>'.$item['DeliveryDate'].'</td>';
        }

        if($startTime=="0000-00-00 00:00:00"){
          echo'<td>'.'NA'.'</td>';
        }else{
          echo'<td>'.$item['EmpStartTime'].'</td>';
        }

        if($endTime=="0000-00-00 00:00:00"){
          echo'<td>'.'NA'.'</td>';
        }else{
          echo'<td>'.$item['EmpEndTime'].'</td>';
        }

        // if($dateChangeCount==0){
        //   echo'<td>'.'NA'.'</td>';
        // }else{
        //   echo'<td>'.$item['DDateChangeCount'].'</td>';
        // }

        
        echo'<td>'.$item['DDateChangeReason'].'</td>';
        echo'<td>'.$item['PendingReason'].'</td>';
        echo'<td>'.$item['RepairDetail'].'</td>';
        

        if($workStatus==1){
          echo'<td class="no-padding-td"><div class="working">'.'Working'.'</div></td>';
        }else if($workStatus==2){
          echo'<td class="no-padding-td"><div class="pending">'.'Pending'.'</div></td>';
        }else if($workStatus==3){
          echo'<td class="no-padding-td"><div class="working">'.'Completed'.'</div></td>';
        }else if($workStatus==4){
          echo'<td class="no-padding-td"><div class="working">'.'Completed'.'</div></td>';
        }else if($workStatus==5){
          echo'<td class="no-padding-td"><div class="pending">'.'Cancelled'.'</div></td>';
        }else if($workStatus==0){
          echo'<td class="no-padding-td"><div class="pending">'.'NA'.'</div></td>';
        }

  //       if($deliveryStatus==1){
  //       echo'<td class=""><div class="onoffswitch">
  // <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch'.$id.'" onClick="setDeliveryStatus(\'' .$item['CaseId']. '\');" checked>
  //         <label class="onoffswitch-label" for="myonoffswitch'.$id.'">
  //           <span class="onoffswitch-inner"></span>
  //           <span class="onoffswitch-switch"></span>
  //         </label>
  //       </div></td>';
  //       }else{
  //       echo'<td ><div class="onoffswitch">
  //       <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch'.$id.'" onClick="setDeliveryStatus(\'' .$item['CaseId']. '\');" unchecked>
  //         <label class="onoffswitch-label" for="myonoffswitch'.$id.'">
  //           <span class="onoffswitch-inner"></span>
  //           <span class="onoffswitch-switch"></span>
  //         </label>
  //       </div></td>';
  //       }

        if($delivery=="NA"){
            echo '<td >'.$delivery.'</td>';
          }else if($delivery=="Drop"){
            if($pikDropStatus==0){
              echo '<td >'."NA".'</td>';
            }else if($pikDropStatus==1){
              echo '<td >'."NA".'</td>';
            }else if($pikDropStatus==2){
              echo'<td><input type="hidden" value="'.$caseId.'" id="caseId'.$id.'"><input type="hidden" value="'.$location.'" id="location'.$id.'"><input type="hidden" value="'.$pikDropStatus.'" id="pikDropStatus'.$id.'"><input type="hidden" value="'.$delBoyId.'" id="delBoyId'.$id.'"><input type="hidden" value="'.$delBoyStartTime.'" id="delBoyStartTime'.$id.'"><input type="hidden" value="'.$delBoyEndTime.'" id="delBoyEndTime'.$id.'"><a  onClick="assignDelBoy('.$id.');">Drop</a></td>';
            }else if($pikDropStatus==3){
              echo'<td ><input type="hidden" value="'.$caseId.'" id="caseId'.$id.'"><input type="hidden" value="'.$location.'" id="location'.$id.'"><input type="hidden" value="'.$pikDropStatus.'" id="pikDropStatus'.$id.'"><input type="hidden" value="'.$delBoyId.'" id="delBoyId'.$id.'"><input type="hidden" value="'.$delBoyStartTime.'" id="delBoyStartTime'.$id.'"><input type="hidden" value="'.$delBoyEndTime.'" id="delBoyEndTime'.$id.'"><a  onClick="assignDelBoy('.$id.');">Assigned</a></td>';
            }else if($pikDropStatus==4){
              echo'<td ><input type="hidden" value="'.$caseId.'" id="caseId'.$id.'"><input type="hidden" value="'.$location.'" id="location'.$id.'"><input type="hidden" value="'.$pikDropStatus.'" id="pikDropStatus'.$id.'"><input type="hidden" value="'.$delBoyId.'" id="delBoyId'.$id.'"><input type="hidden" value="'.$delBoyStartTime.'" id="delBoyStartTime'.$id.'"><input type="hidden" value="'.$delBoyEndTime.'" id="delBoyEndTime'.$id.'"><a  onClick="assignDelBoy('.$id.');">Droped</a></td>';
            }else if($pikDropStatus==5){
              echo'<td ><input type="hidden" value="'.$caseId.'" id="caseId'.$id.'"><input type="hidden" value="'.$location.'" id="location'.$id.'"><input type="hidden" value="'.$pikDropStatus.'" id="pikDropStatus'.$id.'"><input type="hidden" value="'.$delBoyId.'" id="delBoyId'.$id.'"><input type="hidden" value="'.$delBoyStartTime.'" id="delBoyStartTime'.$id.'"><input type="hidden" value="'.$delBoyEndTime.'" id="delBoyEndTime'.$id.'"><a  onClick="assignDelBoy('.$id.');">Cancelled</a></td>';
            }
          }


        echo'<td ><input type="hidden" value="'.$caseId.'" id="caseId'.$id.'"><input type="hidden" value="'.$location.'" id="location'.$id.'"><input type="hidden" value="'.$printDate.'" id="deliveryDate'.$id.'"><input type="hidden" value="'.$brand.'" id="brand'.$id.'"><input type="hidden" value="'.$model.'" id="model'.$id.'"><input type="hidden" value="'.$mobile.'" id="mobile'.$id.'"><input type="hidden" value="'.$problem.'" id="problem'.$id.'"><input type="hidden" value="'.$name.'" id="name'.$id.'"><input type="hidden" value="'.$assessories.'" id="assessories'.$id.'"><input type="hidden" value="'.$totalAmount.'" id="totalAmount'.$id.'"><input type="hidden" value="'.$imei_number.'" id="imei_number'.$id.'"><input type="hidden" value="'.$remarks.'" id="remarks'.$id.'"><button class="btn btn-success btn-sm" onClick="printCaseDetail('.$id.');">Print</button></td>';

        echo'<td ><input type="hidden" value="'.$caseId.'" id="caseId'.$id.'"><input type="hidden" value="'.$remarks.'" id="remarks'.$id.'"><a data-toggle="modal" data-target="#change_remarks_modal"><button class="btn btn-danger btn-sm" onClick="addRemarks('.$id.');">close</a></button></td>';

        echo'</tr>';
    }
?>
 

              </tbody>
                
              </table>
               </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>




     
    </section>

  </div>
  
 
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jQuery/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="plugins/jQuery/raphael-min.js"></script>

<!-- daterangepicker -->
<script src="plugins/jQuery/moment.min.js"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<!-- page script -->

<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<script type="text/javascript">

$('#password_submit').click(function(){

var old_pass = $('#old_password').val();
var new_pass = $('#new_password').val();
var new_pass_confirm = $('#new_password_confirm').val();

$.ajax({
    url:"ChangeAdminPassword.php",
    data:{OldPAss:old_pass,
    NewPAss:new_pass,
    NewPAssConfirm:new_pass_confirm},
    type:'post',
    success:function(response){

      alert(response);
      location.reload();

    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
    }

   });


});


$(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });



function showCaseDetail(id){

  var brand = $("#brand"+id).val();
  var model = $("#model"+id).val();
  var problem = $("#problem"+id).val();
  var caseid = $("#caseId"+id).val();


  $.ajax({
    url:"GetCaseDetail.php",
    data:{CaseId:caseid},
    type:'post',
    dataType: 'json',
    success:function(response){

      //alert(response);

      var brand1=response['Brand'];
      var model1=response['Model'];
      var problem1=response['Description'];

      document.getElementById("brand").value=brand1;
      document.getElementById("model").value=model1;
      document.getElementById("description").value=problem1;
      document.getElementById("caseid").value=caseid;


      //window.location.reload();
    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
  }

   });

}

function updateCaseDetail(){

  var brand = document.getElementById('brand').value;
  var model = document.getElementById('model').value;
  var description = document.getElementById('description').value;
  var caseid = document.getElementById('caseid').value;

$.ajax({
    url:"UpdateCaseDetail.php",
    data:{Brand:brand,
      Model:model,
      Description:description,
      CaseId:caseid},
    type:'post',
    success:function(response){

      alert(response);
      //window.location.reload();
    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
  }

   });

}

function updateUserInfo(){

  var name = document.getElementById('name').value;
  var mobile = document.getElementById('mobile').value;
  var address = document.getElementById('email').value;
  var userid = document.getElementById('userid1').value;

  $.ajax({
    url:"UpdateUserDetail.php",
    data:{UserName:name,
      UserMobile:mobile,
      UserLocation:address,
      UserId:userid},
    type:'post',
    success:function(response){

      alert(response);
      //window.location.reload();
    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
  }

   });

  //alert(userid);

}




function showUserDetail(id){

   var name = $("#name"+id).val();
   var location = $("#location"+id).val();
   var mobile = $("#mobile"+id).val();


   $.ajax({
    url:"GetUserDetail.php",
    data:{UserId:id},
    type:'post',
    dataType: 'json',
    success:function(response){

      //alert(response);

      var user_name=response['First_Name'];
      var user_location=response['Location'];
      var user_mobile=response['Mobile_Number'];

      document.getElementById("name").value=user_name;
      document.getElementById("mobile").value=user_mobile;
      document.getElementById("email").value=user_location;
      document.getElementById("userid1").value=id;


      //window.location.reload();
    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
  }

   });

}

function showEmpDetail(id){

   var emp_name = $("#emp_name"+id).val();
   var emp_mobile = $("#emp_mobile"+id).val();
   var emp_location = $("#emp_location"+id).val();
   var empId = $("#empId"+id).val();
   var caseId = $("#caseId"+id).val();

  

    if(empId!=0){
      document.getElementById('select_empname').value=empId;
    }

   //document.getElementById("empname").innerHTML=emp_name;
  document.getElementById("empmobile").innerHTML=emp_mobile;
  document.getElementById("empemail").innerHTML=emp_location;
  document.getElementById("caseid2").value=caseId;



}

function changeEmp(){
  var empid = document.getElementById('select_empname').value;
  var caseId = document.getElementById('caseid2').value;
  

  $.ajax({
    url:"AssignCaseToEmp.php",
    data:{CaseId:caseId,
      EmpId:empid},
    type:'post',
    success:function(response){

      alert(response);
      location.reload();

    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
}

   });




}

function closeCase(){

//alert('romil');

  var caseid = document.getElementById('caseid_remarks').value;
  var remarks = document.getElementById('remarks_input').value;
  var td_id = document.getElementById('td_id').value;


$.ajax({
    url:"CloseCase.php",
    data:{CaseId:caseid,
      Remarks:remarks},
    type:'post',
    success:function(response){
      alert(response);
      //location.reload();

      //$('#example1 > tr').eq(rowNum).children(td_id).remove();

      $("#" + td_id).remove();

    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
}

   });

}

function addRemarks(id){
   var caseid = $("#caseId"+id).val();
   var remarks = $("#remarks"+id).val();

   document.getElementById("caseid_remarks").value=caseid;
    document.getElementById("remarks_input").value=remarks;
    document.getElementById("td_id").value=id;
}

function printCaseDetail(id){

  

  var totalAmount = $("#total_amount_span"+id).html();

  //var totalAmount =document.getElementById("total_amount_span"+id).value;



   var caseid = $("#caseId"+id).val();
   var location = $("#location"+id).val();
   var deliveryDate = $("#deliveryDate"+id).val();
   var brand = $("#brand"+id).val();
   var model = $("#model"+id).val();
   var mobile = $("#mobile"+id).val();
   var problem = $("#problem"+id).val();
   var imei_number = $("#imei_number"+id).val();
   var name = $("#name"+id).val();
   var assessories = $("#assessories"+id).val();
   var remarks = $("#remarks"+id).val();
   //var totalAmount = $("#totalAmount"+id).val();

  document.getElementById("caseid1").innerHTML=caseid;
  document.getElementById("date1").innerHTML=deliveryDate;
  document.getElementById("name1").innerHTML=name;
  document.getElementById("address1").innerHTML=location;
  document.getElementById("mobile1").innerHTML=mobile;
  document.getElementById("brand1").innerHTML=brand;
  document.getElementById("model1").innerHTML=model;
  document.getElementById("problem1").innerHTML=problem;
  document.getElementById("assessories1").innerHTML=assessories;
  document.getElementById("remarks1").innerHTML=remarks;
  document.getElementById("totalAmount1").innerHTML=totalAmount;
  document.getElementById("imei_number1").innerHTML=imei_number;


  printdiv('print-case-detail-modal');

}




function printdiv(printpage)
{
var headstr = "<html><head><title></title></head><body>";
var footstr = "</body>";
var newstr = document.all.item(printpage).innerHTML;
var oldstr = document.body.innerHTML;
document.body.innerHTML = headstr+newstr+footstr;
window.print();
document.body.innerHTML = oldstr;
return false;
}

function assignDelBoy(id){
  //alert('assigned');

  var caseid = $("#caseId"+id).val();
   var location = $("#location"+id).val();
   var pickDropStatus = $("#pikDropStatus"+id).val();
   var delBoyId = $("#delBoyId"+id).val();
   var delBoyStartTime = $("#delBoyStartTime"+id).val();
   var delBoyEndTime = $("#delBoyEndTime"+id).val();
   var drop="";


    if(delBoyStartTime=="0000-00-00 00:00:00"){
      delBoyStartTime="NA";
      delBoyEndTime="NA";
    }
    if(delBoyEndTime=="0000-00-00 00:00:00"){
      delBoyEndTime="NA";
    }


    if(pickDropStatus==2){
      drop="Not droped";
      delBoyStartTime="NA";
      delBoyEndTime="NA";
    }else if(pickDropStatus==3){
      drop="Assigned to Delivery boy";
      delBoyEndTime="NA";
    }else if(pickDropStatus==4){
      drop="Dropped";
    }else if(pickDropStatus==5){
      drop="Cancelled";
    }

    

     $('#case-delivery-boy-model').modal('show');

    if(delBoyId!=0){
      document.getElementById('select_deliveryBoy').value=delBoyId;
    }


    if(pickDropStatus==2){
      $('#assign_btn2').hide();
    }else if(pickDropStatus==4){
      $('#assign_btn2').hide();
    }
    
  

    document.getElementById("caseid").innerHTML=caseid;
    document.getElementById("location").innerHTML=location;
    document.getElementById("pick_status").innerHTML=drop;
    document.getElementById("startTime").innerHTML=delBoyStartTime;
    document.getElementById("endTime").innerHTML=delBoyEndTime;


 

 // data-toggle="modal" data-target="#case-delivery-boy-model" 
}

function assignCaseDelBoy1(){

   var empid = document.getElementById('select_deliveryBoy').value;
   var caseid = $("#caseid").text();
   var type = "drop";
  

$.ajax({
    url:"AssignCaseToDelBoy.php",
    data:{CaseId:caseid,
      EmpId:empid,
      Type:type},
    type:'post',
    success:function(response){

      alert(response);
      location.reload();

    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
  }

   });

}

function setDeliveryStatus(caseid){

//alert('romil');

$.ajax({
    url:"SetDeliveryStatus.php",
    data:{CaseId:caseid},
    type:'post',
    success:function(response){
      alert(response);
      //location.reload();

    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
}

   });

//location.reload();

}

function selectDeliveryType(deliveryType){

  document.getElementById('delivery_type').value=deliveryType;
}


function changeDeliveryType(id,type){
//alert(type);

$.ajax({
    url:"ChangeDeliveryType.php",
    data:{Id:id,
      Type:type},
    type:'post',
    success:function(response){
      alert(response);
      //location.reload();

    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
}

   });

}

function updateRepairAmount(){
  
  var repair_amount = document.getElementById('repair_amount').value;
  var caseid_amount = document.getElementById('caseid_amount').value;
  var id = document.getElementById('row_id').value;

  document.getElementById("repair_amount_span"+id).innerHTML=repair_amount;
  

  
  

  $.ajax({
    url:"UpdateRepairAmount.php",
    data:{RepairAmount:repair_amount,
      CaseId:caseid_amount},
    type:'post',
    dataType: 'json',
    success:function(response){
      

      var totalAmount=response['TotalAmount'];
      var payableAmount=response['PayableAmount'];
      var message=response['Message'];

      

     document.getElementById("payable_amount_span"+id).innerHTML=payableAmount;
     document.getElementById("total_amount_span"+id).innerHTML=totalAmount;

     alert(message);
      

      //location.reload();

    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
}

   });


  

}

function showRepairAmount(id){

   var caseid = $("#caseId"+id).val();
   var repairAmount = $("#repairAmount"+id).val();
   //alert(repairAmount);

    document.getElementById("caseid_amount").value=caseid;
    document.getElementById("repair_amount").value=repairAmount;
    document.getElementById("row_id").value=id;


}

</script>
</body>
</html>
