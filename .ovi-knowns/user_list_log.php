<?php
session_start();
//error_reporting(0);
include('dbconfig.php');
/*include('include/checklogin.php');*/
/*check_login();*/

  $db=db_connect();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>User List Logs</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
   <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
        <!-- end: TOP NAVBAR -->

         <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 class="make-inline">
        Admin  | User Session Logs
      </h1>
        <ol class="breadcrumb">
                  <li>
                    <span>Admin </span>
                  </li>
                  <li class="active">
                    <span>User Session Logs</span>
                  </li>
                </ol>
     <!--  <a href="emp_list_csv.php"><button class="btn btn-warning pull-right">Export&nbsp;&nbsp;<i class="fa fa-file-excel-o"></i></button></a> -->
      
  <!--      <button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_employee_list_modal" style="margin-right: 10px;">Create New <i class="fa fa-plus-circle"></i></button> -->
     
    </section>

<section class="content">

<section class="content">
      <div class="row">
        <div class="">

          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">
             <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th class="center">#</th>
                        <th class="hidden-xs">User id</th>
                        <th>Username</th>
                        <th>User IP</th>
                        <th>Login time</th>
                        <th>Logout Time </th>
                        <th> Status </th>
                        
                        
                      </tr>
                    </thead>
                    <tbody>  
<?php
$sql=mysqli_query($db,"select * from userlog ");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>

                      <tr>
                        <td class="center"><?php echo $cnt;?>.</td>
                        <td class="hidden-xs"><?php echo $row['uid'];?></td>
                        <td class="hidden-xs"><?php echo $row['username'];?></td>
                        <td><?php echo $row['userip'];?></td>
                        <td><?php echo $row['loginTime'];?></td>
                        <td><?php echo $row['logout'];?>
                        </td>
                        
                        <td>
<?php if($row['status']==1)
{
  echo "Success";
}
else
{
  echo "Failed";
}?>

</td>
                        
                      </tr>
                      
                      <?php 
$cnt=$cnt+1;
                       }?>
                      
                      
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

          
            
      
      <!-- start: FOOTER -->
  
      <!-- end: FOOTER -->
    
      <!-- start: SETTINGS -->

      
      <!-- end: SETTINGS -->
    </div>
    <!-- start: MAIN JAVASCRIPTS -->
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

$('#empMobile').keydown(function(){
  //alert(this.value);
  //$("#myField").val(this.value.match(/[0-9]*/));
  if( this.value.length>9){
     this.value="";
     alert("value should not be more than 10 or less than 10.");
    return false;
  }
});

function addNewEmployee(){
  //alert('romil');

  userType=3;
  var emp = document.getElementById('empType').value;

  if(emp=="Engineer"){
    userType=2;
  }


  var name = document.getElementById('empName').value;
  var mobile = document.getElementById('empMobile').value;
  var password = document.getElementById('empPassword').value;



$.ajax({
    url:"CreateEmployee.php",
    data:{EmpName:name,
      UserType:userType,
      EmpMobile:mobile,
      EmpPassword:password},
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

function showCaseDetail(id){
  //alert(id);

  var brand = $("#brand"+id).val();
   var model = $("#model"+id).val();
   var description = $("#description"+id).val();

  document.getElementById("brand1").innerHTML=brand;
    document.getElementById("model1").innerHTML=model;
    document.getElementById("problem1").innerHTML=description;

}

function deleteUser(id){
    //alert(id);


$.ajax({
    url:"deleteUser.php",
    data:{UserId:id},
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

function editEmp(id){

  var name = $("#name"+id).val();
  var mobile = $("#mobile"+id).val();
  var userType = $("#userType"+id).val();

   $("#editempName").val(name);
   $("#editempMobile").val(mobile);
   $("#editempPassword").val("xxxxxxx");
   $("#editUserId").val(id);

   if(userType==2){
      $("#editempType").val("Engineer");
   }else{
      $("#editempType").val("Delivery Boy");
   }
  
}



function editEmployee(){
  //alert('romil');

  userType=3;
  var emp = document.getElementById('editempType').value;

  if(emp=="Engineer"){
    userType=2;
  }


  var name = document.getElementById('editempName').value;
  var mobile = document.getElementById('editempMobile').value;
  var password = document.getElementById('editempPassword').value;
  var userId = document.getElementById('editUserId').value;




$.ajax({
    url:"EditEmployee.php",
    data:{EmpName:name,
      UserType:userType,
      EmpMobile:mobile,
      EmpPassword:password,
      EmpId:userId},
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

function showCaseList(array1){

$("#case_list").html('');
  array1.forEach(function(element) {
    console.log(element);
    $("#case_list").append('<li>'+element+'</li>');
});

  
}




</script>
  </body>
</html>
