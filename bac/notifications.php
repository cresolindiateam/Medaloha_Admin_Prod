<?php
require 'dbconfig.php';
require 'admin.php';


session_start();
if($_SESSION['username']==""){
  echo "<script> window.location = 'http://prateekmobile.justevent.in/admin_login.php'</script>";
}

  $db=db_connect();

  $sql = "SELECT `AdminNotification`.`Id`,`AdminNotification`.`CaseId`,`AdminNotification`.`Description`,`AdminNotification`.`UserId`,`AdminNotification`.`ViewStatus`,`AdminNotification`.`Created_At`,`AdminNotification`.`NotificationType`,`UserProfile`.`First_Name`,`UserProfile`.`UserType`,`RepairEnquery`.`Brand`,`RepairEnquery`.`Model`,`RepairEnquery`.`IMEI_Number`,`RepairEnquery`.`Description`,`RepairEnquery`.`Phone` FROM `AdminNotification` LEFT JOIN `UserProfile` ON `AdminNotification`.`UserId` = `UserProfile`.`Id` LEFT JOIN `RepairEnquery` ON `AdminNotification`.`CaseId` = `RepairEnquery`.`CaseId` WHERE `AdminNotification`.`ViewStatus`=0 && `UserProfile`.`DeleteStatus`=0 ORDER BY `AdminNotification`.`Created_At` DESC";


 



  // $sql = "SELECT Id,CaseId,Description,UserId,ViewStatus,Created_At,NotificationType FROM `AdminNotification` WHERE `ViewStatus`=0 ORDER BY `Created_At` DESC";


  $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_ASSOC);

  // foreach ($data as $key => $value){
  //     $caseId=$value['CaseId'];
  //     $userId=$value['UserId'];

  //       $sql1="SELECT First_Name,UserType FROM `UserProfile` where `DeleteStatus`=0 && `UserId`=$userId";
  //       $exe1 = $db->query($sql1);

  //       $sql2="SELECT Brand,Model,IMEI_Number,Description,Phone FROM `RepairEnquery` where `CaseId`='$caseId'";
  //       $exe2 = $db->query($sql2);

  //       if($exe1->num_rows > 0){
  //         $result1 = $exe1->fetch_all(MYSQLI_ASSOC);

  //          foreach ($result1 as $key1 => $value1){
  //           $data[$key]['First_Name']= $value1['First_Name'];
  //           $data[$key]['Mobile_Number']= $value1['Mobile_Number'];
  //           $data[$key]['UserType']= $value1['UserType'];
  //         }
  //       }

  //     if($exe2->num_rows > 0){
  //       $result2 = $exe2->fetch_all(MYSQLI_ASSOC);

  //       foreach ($result2 as $key2 => $value2){
  //           $data[$key]['Brand']= $value1['Brand'];
  //           $data[$key]['Model']= $value1['Model'];
  //           $data[$key]['Case_Description']= $value1['Description'];
  //           $data[$key]['IMEI_Number']= $value1['IMEI_Number'];   
  //       }
  //     }
  //   }

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
</style>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include('header.php');?>

 
  <?php include('left_side_bar.php');?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 >
        All Notifications
      </h1>

      <a ><button class="btn btn-warning pull-right" id="clearNotifications">Clear All</button></a>
      
     
    </section>

    <!-- Main content -->
    <section class="content">
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
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>

                  <th style="width: 10px">#</th>
                  <th>Job ID</th>
                  <th>User ID</th>
                  <th>Notification</th>
                  <th>Created At</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>



              <?php
 
foreach ($data as $k => $item){
        $id = $item['Id'];
        $caseId = $item['CaseId'];
        $userId = $item['UserId'];
        $notification = $item['Description'];
        $viewStatus = $item['ViewStatus'];
        $createdAt = $item['Created_At'];
        $name = $item['First_Name'];
        $mobile = $item['Phone'];
        $userType = $item['UserType'];
        $brand = $item['Brand'];
        $model = $item['Model'];
        $imei_number = $item['IMEI_Number'];
        $case_description = $item['Case_Description'];
        $notificationType = $item['NotificationType'];

        

        php?>
          <tr> 
         <td><?php echo $k+1; ?></td>
         <td><?php echo $item['CaseId']; ?></td>
         <td><?php echo $item['UserId']; ?></td>
         <td><?php echo $notification; ?></td>
         <td><?php echo $createdAt; ?></td>

         <td ><?php echo '<input type="hidden" value="'.$caseId.'" id="caseId'.$id.'"><input type="hidden" value="'.$notificationType.'" id="notificationType'.$id.'"><button class="btn btn-success btn-sm" onClick="notificationSeen('.$id.');">Go</button>' ?></td> 

        </tr>  
             <?php

    }
?>

        

              </tbody>
                
              </table>
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

$('#clearNotifications').click(function(){

  $.ajax({
    url:"ClearAllNotifications.php",
    data:{},
    type:'post',
    success:function(response){

      alert(response);
      window.location.reload();

    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
  }

   });

  //alert("hello");


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


$( document ).ready(function() {
    //displayEmpInfo($name,$mobile,$email);
});

function notificationSeen(id){

  $url="";

   var caseid = $("#caseId"+id).val();
   var notificationType = $("#notificationType"+id).val();

   if(notificationType==1){
    $url="index.php";
  }else if(notificationType==2){
    $url="approved_inquiries.php";
  }else if(notificationType==3){
    $url="approved_inquiries.php";
  }else if(notificationType==4){
    $url="case_status.php";
  }else{
    $url="#";
  }

  

  $.ajax({
    url:"SetNotificationSeen.php",
    data:{Id:id
      },
    type:'post',
    success:function(response){

      //alert(response);
      window.location.assign($url);

    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
  }

   });

}




</script>
</body>
</html>
