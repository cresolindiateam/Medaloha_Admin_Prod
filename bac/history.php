<?php
ini_set('date.timezone', 'Asia/Kolkata');

require 'dbconfig.php';
require 'admin.php';


session_start();
if($_SESSION['username']==""){
  echo "<script> window.location = 'http://prateekmobile.justevent.in/admin_login.php'</script>";
}

  $db=db_connect();

  $sql = "SELECT `CaseHistory`.`Id`,`CaseHistory`.`CaseId`,`CaseHistory`.`UserId`,`CaseHistory`.`EmployeeId`,`CaseHistory`.`TotalAmount`,`CaseHistory`.`StartDate`,`CaseHistory`.`DeliveryDate`,`CaseHistory`.`EmpStartTime`,`CaseHistory`.`EmpEndTime`,`CaseHistory`.`RepairDetail`,`CaseHistory`.`Rating`,`CaseHistory`.`RepairDetail`,`CaseHistory`.`ProblemDescription`,`CaseHistory`.`DeliveryOptions`,`CaseHistory`.`Accessories`,`CaseHistory`.`TotalAmount`,`RepairEnquery`.`Brand`,`RepairEnquery`.`Model`,`RepairEnquery`.`Location`,`RepairEnquery`.`Phone`,`RepairEnquery`.`Description`,`RepairEnquery`.`IMEI_Number`,`RepairEnquery`.`Remarks`,`UserProfile`.`First_Name` FROM `CaseHistory` LEFT JOIN `RepairEnquery` ON `CaseHistory`.`CaseId` = `RepairEnquery`.`CaseId` LEFT JOIN `UserProfile` ON `CaseHistory`.`UserId` = `UserProfile`.`Id` ORDER BY `CaseHistory`.`Created_At` DESC";






  // $sql = "SELECT Id,CaseId,UserId,EmployeeId,TotalAmount,StartDate,DeliveryDate,EmpStartTime,EmpEndTime,RepairDetail,Rating,RepairDetail,ProblemDescription,DeliveryOptions,Accessories,TotalAmount FROM `CaseHistory` ORDER BY `Created_At` DESC";
  
  $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_ASSOC);

  // foreach ($data as $key => $value){
  //     $caseId=$value['CaseId'];
  //     $userId=$value['UserId'];

  //     $sqlBrandName="SELECT Brand,Model,Location,Phone,Description,IMEI_Number,Remarks FROM `RepairEnquery` where `CaseId`='$caseId'";
  //       $exeBrandName = $db->query($sqlBrandName);

  //       if($exeBrandName->num_rows > 0){
  //         $resultBrandName = $exeBrandName->fetch_all(MYSQLI_ASSOC);
  //          foreach ($resultBrandName as $key1 => $value1){
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

  //     $sqlName="SELECT First_Name FROM `UserProfile` where `Id`='$userId'";
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
      <h1 >
        Case History
      </h1>

      <a href="case_history_list_csv.php"><button class="btn btn-warning pull-right">Export&nbsp;&nbsp;<i class="fa fa-file-excel-o"></i></button></a>
      
     
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
  <div class="modal fade" id="print-case-detail-modal" role="dialog" style="background: black;">
    <div class="modal-dialog">
      <div class="modal-content">
        



        <div >
          <center>
          <div >Job Sheet</div>
          <h2>
          <img src="dist/img/prateek_icon_black.png" style="width:13%;">
          <br/>
          <b>PRATEEK MOBILE</b>
          <br/>
          <small>2nd Floor Rajeev Plaza</small><br/>
          <small>Jayendra Ganj Gwalior</small><br/>
          <small>9755669222, 7354995571</small><br/>
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
          
          <div>

            <h5 class="pull-right">Customer's Signature</h5>
          </div>

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
                  <th>Emp ID</th>
                  <th>Brand </th>
                  <th>Modal </th>
                  <th class="big-space-1">Problem</th>
                  <th class="big-space-1">Repair Detail </th>
                  <th>Total Amount</th>
                  <th>Delivery Type</th>
                  <th >Start Date</th>
                  <th>Delivey Date</th>
                  <th>Start Time</th>
                  <th>End Time</th>
                  <th><span>Rating</span></th>
                  <th>Print</th>
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
        $deliveryDate = $item['DeliveryDate'];
        $repairDetail = $item['RepairDetail'];
        $brand = $item['Brand'];
        $model = $item['Model'];
        $mobile = $item['Phone'];
        $problem = $item['Description'];
        $imei_number = $item['IMEI_Number'];
        $location = $item['Location'];
        $name = $item['First_Name'];
        $assessories = $item['Accessories'];
        $rating = $item['Rating'];
        $totalAmount = $item['TotalAmount'];
        $remarks = $item['Remarks'];

        $currentDate = date("Y-m-d H:i:s");


        $count=$key+1;





        echo'<tr>'; 
        echo'<td>'.$count.'</td>';
        echo'<td>'.$item['CaseId'].'</td>';
        echo'<td>'.$item['UserId'].'</td>';
        echo'<td>'.$item['EmployeeId'].'</td>';
        echo'<td>'.$item['Brand'].'</td>';
        echo'<td>'.$item['Model'].'</td>';
        echo'<td>'.$item['ProblemDescription'].'</td>';
        echo'<td>'.$item['RepairDetail'].'</td>';
        echo'<td>'.$item['TotalAmount'].'</td>';
        echo'<td>'.$item['DeliveryOptions'].'</td>';
        echo'<td>'.$item['StartDate'].'</td>';
        echo'<td>'.$item['DeliveryDate'].'</td>';
        echo'<td>'.$item['EmpStartTime'].'</td>';
        echo'<td>'.$item['EmpEndTime'].'</td>';
        echo'<td><div class="star-ratting"><ul>';
       for($x = 1; $x < 6; $x++) {
      
          if($x<=$rating){
            
              echo'<li><i class="fa fa-star rated"></i></li>';
          }else{
            echo'<li><i class="fa fa-star"></i></li>';
          }
        }
        echo '</ul></div></td>';
        //echo'<td>'.$item['Rating'].'</td>';
        echo'<td ><input type="hidden" value="'.$caseId.'" id="caseId'.$id.'"><input type="hidden" value="'.$location.'" id="location'.$id.'"><input type="hidden" value="'.$currentDate.'" id="deliveryDate'.$id.'"><input type="hidden" value="'.$brand.'" id="brand'.$id.'"><input type="hidden" value="'.$model.'" id="model'.$id.'"><input type="hidden" value="'.$mobile.'" id="mobile'.$id.'"><input type="hidden" value="'.$problem.'" id="problem'.$id.'"><input type="hidden" value="'.$name.'" id="name'.$id.'"><input type="hidden" value="'.$assessories.'" id="assessories'.$id.'"><input type="hidden" value="'.$totalAmount.'" id="totalAmount'.$id.'"><input type="hidden" value="'.$imei_number.'" id="imei_number'.$id.'"><input type="hidden" value="'.$remarks.'" id="remarks'.$id.'"><button class="btn btn-success btn-sm" onClick="printCaseDetail('.$id.');">Print</button></td>';
        echo'</tr>';
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


function printCaseDetail(id){

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
   var totalAmount = $("#totalAmount"+id).val();
   var remarks = $("#remarks"+id).val();

  document.getElementById("caseid1").innerHTML=caseid;
  document.getElementById("date1").innerHTML=deliveryDate;
  document.getElementById("name1").innerHTML=name;
  document.getElementById("address1").innerHTML=location;
  document.getElementById("mobile1").innerHTML=mobile;
  document.getElementById("brand1").innerHTML=brand;
  document.getElementById("model1").innerHTML=model;
  document.getElementById("problem1").innerHTML=problem;
  document.getElementById("assessories1").innerHTML=assessories;
  document.getElementById("totalAmount1").innerHTML=totalAmount;
  document.getElementById("imei_number1").innerHTML=imei_number;
  document.getElementById("remarks1").innerHTML=remarks;




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



</script>
</body>
</html>
