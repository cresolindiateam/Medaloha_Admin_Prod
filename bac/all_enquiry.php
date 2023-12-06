<?php
require 'dbconfig.php';
require 'admin.php';


/*session_start();
if($_SESSION['username']==""){
  echo "<script> window.location = 'http://prateekmobile.justevent.in/admin_login.php'</script>";
}

  $db=db_connect();
  $sql ="";

  $start_date=$_REQUEST['StartDate'];
  $end_date=$_REQUEST['EndDate'];

  $sort_WorkStatus = $_REQUEST['SortWorkStatus'];

  if($sort_WorkStatus==""){
    $sort_WorkStatus=6;
  }
  
  if($startDate=="" && $end_date==""){



    // $sql = "SELECT Id,CaseId,UserId,Brand,Model,Location,Phone,Description,PickAndDrop,PriceEstimateStatus,Created_At FROM `RepairEnquery` ORDER BY `Created_At` DESC";

    if($sort_WorkStatus==6){
        $sql = "SELECT `RepairEnquery`.`Id`,`RepairEnquery`.`CaseId`,`RepairEnquery`.`UserId`,`RepairEnquery`.`Brand`,`RepairEnquery`.`Model`,`RepairEnquery`.`Location`,`RepairEnquery`.`Phone`,`RepairEnquery`.`Description`,`RepairEnquery`.`IMEI_Number`,`RepairEnquery`.`Remarks`,`RepairEnquery`.`PickAndDrop`,`RepairEnquery`.`PriceEstimateStatus`,`RepairEnquery`.`Created_At`, `CaseHistory`.`DeliveryOptions`,`RepairingStatus`.`DeliveryOptions`,`RepairingStatus`.`UserSubmitStatus`,`RepairingStatus`.`WorkStatus`,`RepairingStatus`.`EmployeeId`,`RepairingStatus`.`CloseStatus`,`RepairingStatus`.`PartAmount`,`PriceEstimateStatus`.`RepairAmount`,`RepairingStatus`.`RepairDetail`,`RepairingStatus`.`PendingReason`,`RepairingStatus`.`CancelReason`,`CaseHistory`.`Created_At` AS `CloseTime` FROM `RepairEnquery` LEFT JOIN `RepairingStatus` ON `RepairingStatus`.`CaseId` = `RepairEnquery`.`CaseId` LEFT JOIN `CaseHistory` ON `CaseHistory`.`CaseId` = `RepairingStatus`.`CaseId` LEFT JOIN `PriceEstimateStatus` ON `PriceEstimateStatus`.`CaseId` = `RepairingStatus`.`CaseId` ORDER BY `RepairEnquery`.`Created_At` DESC";
    }else{
      $sql = "SELECT `RepairEnquery`.`Id`,`RepairEnquery`.`CaseId`,`RepairEnquery`.`UserId`,`RepairEnquery`.`Brand`,`RepairEnquery`.`Model`,`RepairEnquery`.`Location`,`RepairEnquery`.`Phone`,`RepairEnquery`.`Description`,`RepairEnquery`.`IMEI_Number`,`RepairEnquery`.`Remarks`,`RepairEnquery`.`PickAndDrop`,`RepairEnquery`.`PriceEstimateStatus`,`RepairEnquery`.`Created_At`, `CaseHistory`.`DeliveryOptions`,`RepairingStatus`.`DeliveryOptions`,`RepairingStatus`.`UserSubmitStatus`,`RepairingStatus`.`WorkStatus`,`RepairingStatus`.`EmployeeId`,`RepairingStatus`.`CloseStatus`,`RepairingStatus`.`PartAmount`,`PriceEstimateStatus`.`RepairAmount`,`RepairingStatus`.`RepairDetail`,`RepairingStatus`.`PendingReason`,`RepairingStatus`.`CancelReason`,`CaseHistory`.`Created_At` AS `CloseTime` FROM `RepairEnquery` LEFT JOIN `RepairingStatus` ON `RepairingStatus`.`CaseId` = `RepairEnquery`.`CaseId` LEFT JOIN `CaseHistory` ON `CaseHistory`.`CaseId` = `RepairingStatus`.`CaseId` LEFT JOIN `PriceEstimateStatus` ON `PriceEstimateStatus`.`CaseId` = `RepairingStatus`.`CaseId` WHERE `RepairingStatus`.`WorkStatus`='$sort_WorkStatus' ORDER BY `RepairEnquery`.`Created_At` DESC";

    }


    
      
  }else{
    if($sort_WorkStatus==6){
        $sql = "SELECT `RepairEnquery`.`Id`,`RepairEnquery`.`CaseId`,`RepairEnquery`.`UserId`,`RepairEnquery`.`Brand`,`RepairEnquery`.`Model`,`RepairEnquery`.`Location`,`RepairEnquery`.`Phone`,`RepairEnquery`.`Description`,`RepairEnquery`.`IMEI_Number`,`RepairEnquery`.`Remarks`,`RepairEnquery`.`PickAndDrop`,`RepairEnquery`.`PriceEstimateStatus`,`RepairEnquery`.`Created_At`, `CaseHistory`.`DeliveryOptions`,`RepairingStatus`.`DeliveryOptions`,`RepairingStatus`.`UserSubmitStatus`,`RepairingStatus`.`WorkStatus`,`RepairingStatus`.`EmployeeId`,`RepairingStatus`.`CloseStatus`,`RepairingStatus`.`PartAmount`,`PriceEstimateStatus`.`RepairAmount`,`RepairingStatus`.`RepairDetail`,`RepairingStatus`.`PendingReason`,`RepairingStatus`.`CancelReason`,`CaseHistory`.`Created_At` AS `CloseTime` FROM `RepairEnquery` LEFT JOIN `RepairingStatus` ON `RepairingStatus`.`CaseId` = `RepairEnquery`.`CaseId` LEFT JOIN `CaseHistory` ON `CaseHistory`.`CaseId` = `RepairingStatus`.`CaseId` LEFT JOIN `PriceEstimateStatus` ON `PriceEstimateStatus`.`CaseId` = `RepairingStatus`.`CaseId` WHERE DATE(`RepairEnquery`.`Created_At`) Between '$start_date' and '$end_date' ORDER BY `RepairEnquery`.`Created_At` DESC";
    }else{
      $sql = "SELECT `RepairEnquery`.`Id`,`RepairEnquery`.`CaseId`,`RepairEnquery`.`UserId`,`RepairEnquery`.`Brand`,`RepairEnquery`.`Model`,`RepairEnquery`.`Location`,`RepairEnquery`.`Phone`,`RepairEnquery`.`Description`,`RepairEnquery`.`IMEI_Number`,`RepairEnquery`.`Remarks`,`RepairEnquery`.`PickAndDrop`,`RepairEnquery`.`PriceEstimateStatus`,`RepairEnquery`.`Created_At`, `CaseHistory`.`DeliveryOptions`,`RepairingStatus`.`DeliveryOptions`,`RepairingStatus`.`UserSubmitStatus`,`RepairingStatus`.`WorkStatus`,`RepairingStatus`.`EmployeeId`,`RepairingStatus`.`CloseStatus`,`RepairingStatus`.`PartAmount`,`PriceEstimateStatus`.`RepairAmount`,`RepairingStatus`.`RepairDetail`,`RepairingStatus`.`PendingReason`,`RepairingStatus`.`CancelReason`,`CaseHistory`.`Created_At` AS `CloseTime` FROM `RepairEnquery` LEFT JOIN `RepairingStatus` ON `RepairingStatus`.`CaseId` = `RepairEnquery`.`CaseId` LEFT JOIN `CaseHistory` ON `CaseHistory`.`CaseId` = `RepairingStatus`.`CaseId` LEFT JOIN `PriceEstimateStatus` ON `PriceEstimateStatus`.`CaseId` = `RepairingStatus`.`CaseId` WHERE `RepairingStatus`.`WorkStatus`='$sort_WorkStatus' && DATE(`RepairEnquery`.`Created_At`) Between '$start_date' and '$end_date' && `RepairingStatus`.`WorkStatus`='$sort_WorkStatus' ORDER BY `RepairEnquery`.`Created_At` DESC";

    }
  }


  $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_ASSOC);


    $sqlAdmin="SELECT First_Name,Last_Name FROM `Admin_Info`";
  $exeAdmin = $db->query($sqlAdmin);
  $dataAdmin = $exeAdmin->fetch_all(MYSQLI_ASSOC);

*/
?>




<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Prateek Mobile</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"> -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/select2.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
</head>
<style>
  body{
    padding: 0px !important;
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
      
          
      <div class="row">
        <div class="col-md-9">
          <div class="col-md-2"><h1 class="page-heading">All Enquiry</h1></div>

          <div class="col-md-4">
              <label>Select Work Status</label>
             <!--     <select class="form-control" id="sortWork_select" onchange="sortWorkStatusWise();">
                  <option value="6" <?php if($sort_WorkStatus == "6") echo "selected"; ?>>All</option>
                  <option value="0" <?php if($sort_WorkStatus == "0") echo "selected"; ?>>NA</option>
                  <option value="1" <?php if($sort_WorkStatus == "1") echo "selected"; ?>>Working</option>
                  <option value="2" <?php if($sort_WorkStatus == "2") echo "selected"; ?>>Pending</option>
                  <option value="3" <?php if($sort_WorkStatus == "3") echo "selected"; ?>>Completed</option>
                  <option value="5" <?php if($sort_WorkStatus == "5") echo "selected"; ?>>Cancel</option>
              </select> -->
              </div>


           <div class="col-md-4">
         <div class="form-group">
                <label>Date range:</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="reservation">
                </div>
                <!-- /.input group -->
              </div>



              </div>
              <div class="col-md-1">
                  <a ><button class="btn btn-success pull-left " style=" margin-top: 23px;" id="search_date_wise">Search</button></a>
              </div>

              

          

             


        </div>
        <div class="col-md-3 pull-right">
       
          

      <a href="all_enquiry_csv.php"><button class="btn btn-warning pull-right" style="    margin-top: 21px;">Export&nbsp;&nbsp;<i class="fa fa-file-excel-o"></i></button></a>
      
        </div>

      </div>

     
      
     
    </section>

    <!-- Main content -->
    <section class="content" style="padding-top:0px;">


    <div class="user-info-modal">
      <div class="container">
  <div class="modal fade" id="user-info-modal" role="dialog">
    <div class="modal-dialog" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">User Information</h4>
        </div>
        <div class="modal-body">
         <div class="user-info-area">
        <div class="row ">
          <div class="col-md-1"><i class="fa fa-user"></i></div>
          <div class="col-md-9"><span>Shubham Shrivastava</span></div>
        </div>
        <hr/>
         <div class="row ">
          <div class="col-md-1"><i class="fa fa-phone"></i></div>
          <div class="col-md-9"><span>9528584788</span></div>
        </div>
        <hr/>
        </div>
        </div>
         <div class="modal-footer">
          <button type="button" class="btn theme-btn " data-dismiss="modal">Okay</button>
        </div>
      
      </div>
      
    </div>
  </div>
</div>
</div>


<div class="send_message_modal">
      <div class="container">
  <div class="modal fade" id="send_message_modal" role="dialog">
    <div class="modal-dialog" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Send Message</h4>
        </div>
        <div class="modal-body">
         <div class="user-info-area">
        
         <div class="row ">
          <div class="col-md-1"><i class="fa fa-phone"></i></div>
          <div class="col-md-9"><span id="sms_mobile">9528584788</span></div>
        </div>

        <hr/>
         <div class="row ">
          <div class="col-md-1"><i class="fa fa-envelope"></i></div>
          

          <div class="col-md-9">
          <div class="personal-info-label">Message</div>
          <input type="text" class="form-control" id="sms_message" name="sms_message"/>
          </div>

        </div>

        </div>
        </div>
         <div class="modal-footer">
          <button type="button" class="btn theme-btn " data-dismiss="modal" onclick="sendSMS();">Send</button>
        </div>
      
      </div>
      
    </div>
  </div>
</div>
</div>




<div class="print-case-detail-modal">
      <div class="container">
  <div class="modal fade" id="print-case-detail-modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        

        <div>
          <center>
          <div >Job Sheet</div>
          <h2>
          PRATEEK MOBILE
          <br/>
          <small>shop 25, fisrt floor rajeev plaza </small><br/>
          <small>jayendra ganj lashkar gwalior </small><br/>
          <small>9755669222, 7354995571</small><br/>
          </h2>
          <hr/>
          
          <table align="center" >
            <tr><td>Date: </td> <td id="date1"></td></tr>
            <tr><td>Job No: </td> <td id="caseid1"></td></tr>
             <tr><td>Name: </td> <td id="name1"></td></tr>
            <tr><td>Address: </td> <td id="address1"></td></tr>
            <tr><td>Mobile: </td> <td id="mobile1"></td></tr>
            <tr><td>Brand: </td> <td id="brand1"></td></tr>
            <tr><td>Model: </td> <td id="model1"></td></tr>
            <tr><td>Problem: </td> <td id="problem1"></td></tr>
            <tr><td>Amount: </td> <td id="totalAmount1"></td></tr>
            <tr><td>Assessories: </td> <td id="assessories1"></td></tr>
          </table>
          
          <hr/>
          <div>T & C : NO Responsibility of data lost during service all Subject To Gwalior jurisdiction </div>
          </center>
        </div>

      </div>
      
    </div>
  </div>
</div>
</div>



<div class="user-info-modal">
      <div class="container">
  <div class="modal fade" id="case-detail-modal" role="dialog">
    <div class="modal-dialog" style="width:800px" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Case Detail</h4>
        </div>
        <div class="modal-body">
         <div class="user-info-area">
         <div class="row ">
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6"><i class="fa fa-user"></i>&nbsp;&nbsp;Case ID :</div>
               <div class="col-md-6"><b>xxx1500</b></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6"><i class="fa fa-user"></i>&nbsp;&nbsp;Delivery Date :</div>
               <div class="col-md-6"><b>18-08-2017</b></div>
            </div>
          </div>
        </div>
        <hr/>
        <div class="row ">
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6"><i class="fa fa-user"></i>&nbsp;&nbsp;Brand Name :</div>
               <div class="col-md-6"><b>Samsung</b></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6"><i class="fa fa-user"></i>&nbsp;&nbsp;Modal Name :</div>
               <div class="col-md-6"><b>Galaxy</b></div>
            </div>
          </div>
        </div>
         <hr/>
         <div class="row ">
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6"><i class="fa fa-user"></i>&nbsp;&nbsp;Amount :</div>
               <div class="col-md-6"><b>200/-</b></div>
            </div>
          </div>
        </div>
        <hr/>
        <div class="row ">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-6"><i class="fa fa-user"></i>&nbsp;&nbsp;Repairing Detail :</div>
               <div class="col-md-6"><b>Display Damage, Speaker Problem</b></div>
            </div>
          </div>
        </div>
        </div>
        </div>
         <div class="modal-footer">
          <button type="button" class="btn theme-btn " data-dismiss="modal">Okay</button>
        </div>
      
      </div>
      
    </div>
  </div>
</div>
</div>




<section class="content">
      <div class="row">
        <div class="">

          <div class="box">

          


          
            <!-- /.box-header -->
            <div class="box-body">
            

          <div class="horizontal-scroll">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Job ID</th>
                  <th>User ID</th>
                  <th>Engineer ID</th>
                  <th>Brand </th>
                  <th>Modal </th>
                  <th class="big-space-1">Problem</th>
                  <th>IMEI</th>
                  <th>Remarks</th>
                  <th class="big-space-1">Location</th>
                  <th>Mobile</th>
                  <th>Repair Amount</th>
                  <th>Parts Amount</th>
                  <th>Case Type</th>
                  <th>Repair Detail</th>
                  <th>Pending Reason</th>
                  <th>Cancel Reason</th>
                  <th>Close Status</th>
                  <th>Delivery Type</th>
                  <th>Created_At</th>
                  <th>Close Time</th>
                  <th>Action</th>

                </tr>
                </thead>
                <tbody>



<?php
foreach ($data as $key => $item){
        $id = $item['Id'];
        $caseId = $item['CaseId'];
        $userId = $item['UserId'];
        $empId = $item['EmployeeId'];
        $deliveryOptions = $item['PickAndDrop'];
        $brand = $item['Brand'];
        $model = $item['Model'];
        $mobile = $item['Phone'];
        $repairAmount = $item['RepairAmount'];
        $problem = $item['Description'];
        $location = $item['Location'];
        $createdAt = $item['Created_At'];
        $workStatus = $item['WorkStatus'];
        $closeStatus = $item['CloseStatus'];
        $partAmount = $item['PartAmount'];
        $imei_number = $item['IMEI_Number'];
        $remarks = $item['Remarks'];

        $repairDetail = $item['RepairDetail'];
        $pendingReason = $item['PendingReason'];
        $cancelReason = $item['CancelReason'];
        $closeTime = $item['CloseTime'];


        $count=$key+1;

        echo'<tr>'; 
        echo'<td>'.$count.'</td>';
        echo'<td>'.$item['CaseId'].'</td>';
        echo'<td>'.$item['UserId'].'</td>';
        echo'<td>'."E".$item['EmployeeId'].'</td>';
        echo'<td>'.$item['Brand'].'</td>';
        echo'<td>'.$item['Model'].'</td>';
        echo'<td>'.$item['Description'].'</td>';
        echo'<td>'.$item['IMEI_Number'].'</td>';
        echo'<td>'.$item['Remarks'].'</td>';
        echo'<td>'.$item['Location'].'</td>';
        echo'<td>'.$item['Phone'].'</td>';
        echo'<td>'.$item['RepairAmount'].'</td>';
        echo'<td>'.$item['PartAmount'].'</td>';

        if($workStatus==1){
          echo'<td>'."Working".'</td>';
        }else if($workStatus==2){
          echo'<td>'."Pending".'</td>';
        }else if($workStatus==3){
          echo'<td>'."Completed".'</td>';
        }else if($workStatus==4){
          echo'<td>'."Delivered".'</td>';
        }else if($workStatus==5){
          echo'<td>'."Cancelled".'</td>';
        }else{
          echo'<td>'."NA".'</td>';
        }

        echo'<td>'.$item['RepairDetail'].'</td>';
        echo'<td>'.$item['PendingReason'].'</td>';
        echo'<td>'.$item['CancelReason'].'</td>';
        


        if($closeStatus==1){
          echo'<td>'."Closed".'</td>';          
        }else{
          echo'<td>'."Not Closed".'</td>';  
        }

        


        if($deliveryOptions==1){
          echo'<td>'."Pick".'</td>';
        }else if($deliveryOptions==2){
          echo'<td>'."Drop".'</td>';
        }else if($deliveryOptions==3){
          echo'<td>'."Pick and Drop".'</td>';
        }else{
          echo'<td>'."NA".'</td>';
        }

        echo'<td>'.$item['Created_At'].'</td>';
        echo'<td>'.$item['CloseTime'].'</td>';

        echo'<td><input type="hidden" value="'.$mobile.'" id="mobile'.$id.'"><button class="btn btn-success btn-sm" data-toggle="modal" data-target="#send_message_modal" onClick="sendSMS1('.$id.');">Send SMS</button></td>';


        
        
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
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/select2/select2.full.min.js"></script>
<!-- bootstrap datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- bootstrap time picker -->
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>

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

$("#search_date_wise").click(function(){

  var date = document.getElementById('reservation').value;
  var date_array = date.split(" ");

  var start_date = date_array[0];
  var end_date = date_array[2];

   start_date = convertDate(start_date);
   end_date = convertDate(end_date);

   //window.alert(start_date);
   //window.alert(end_date);

   var work_status = document.getElementById("sortWork_select").value;
    //var url1="all_enquiry.php?SortWorkStatus="+work_status;

   var url1="all_enquiry.php?StartDate="+start_date+"&EndDate="+end_date+"&SortWorkStatus="+work_status;

   //window.alert(url1);

   window.location.href = url1;

});

function sendSMS(){

   var mobile = document.getElementById('sms_mobile').innerHTML;
   var message = document.getElementById('sms_message').value;

   $.ajax({
    url:"SendSMS.php",
    data:{Mobile:mobile,
      Message:message,},
    type:'post',
    success:function(response){
      alert(response);
      
    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
}

   });

}

function sendSMS1(id){
   var mobile = $("#mobile"+id).val();
   document.getElementById("sms_mobile").innerHTML=mobile; 
}


function convertDate(inputFormat) {
  function pad(s) { return (s < 10) ? '0' + s : s; }
  var d = new Date(inputFormat);
  return [pad(d.getFullYear()), pad(d.getMonth()+1), d.getDate()].join('-');
}

function sortWorkStatusWise(){
  var work_status = document.getElementById("sortWork_select").value;
  var url1="all_enquiry.php?SortWorkStatus="+work_status;
   window.location.href = url1;
}


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


$( document ).ready(function() {
    //displayEmpInfo($name,$mobile,$email);
});






$(function () {
    //Initialize Select2 Elements
    $(".select2").select2();

    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
    //Money Euro
    $("[data-mask]").inputmask();

    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
    //Date range as a button
    $('#daterange-btn').daterangepicker(
        {
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    );

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    //Colorpicker
    $(".my-colorpicker1").colorpicker();
    //color picker with addon
    $(".my-colorpicker2").colorpicker();

    //Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
  });




</script>
</body>
</html>
