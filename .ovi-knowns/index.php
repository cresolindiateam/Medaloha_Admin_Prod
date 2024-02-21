<?php

require 'dbconfig.php';

$db=db_connect();

$url = "http://".$_SERVER['HTTP_HOST'].'/admin_login.php';
session_start();
if($_SESSION['username']==""){
  echo "<script> window.location = '".$url."'</script>";
}
?>
<?php include('header.php');?>
<?php include('left_side_bar.php');?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        DashBoard1
      </h1>
    </section>

    <!-- Main content -->
<section class="content">

      <div class="row">
        <!-- <div class="">

          <div class="box">
            
          
            <div class="box-body"> -->
  

<div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php 

$sql = "SELECT booking_histories.id from booking_histories where 1";
 $exe = $db->query($sql);
$data = $exe->fetch_all(MYSQLI_ASSOC);
                echo count($data); ?></h3>

                <p>Booking Count</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="booking_list.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php 

$sql = "SELECT specialist_private.id from specialist_private where 1";
 $exe = $db->query($sql);
$data = $exe->fetch_all(MYSQLI_ASSOC);
                echo count($data); ?><sup style="font-size: 20px"></sup></h3>

                <p>Specalist Count</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="specialist_list.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php 

$sql = "SELECT users.id from users where 1";
 $exe = $db->query($sql);
$data = $exe->fetch_all(MYSQLI_ASSOC);
                echo count($data); ?></h3>

                <p>User count</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="user_list.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php 

$sql = "SELECT report.id from report where 1";
 $exe = $db->query($sql);
$data = $exe->fetch_all(MYSQLI_ASSOC);
                echo count($data); ?></h3>

                <p>Report Count</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="report_list.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>

            <!-- </div>
          
          </div>
      
        </div> -->
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>


  </div>
</div>
<?php include('footer.php'); ?>
<script type="text/javascript">

$('#password_submit').click(function()
{
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
$( window ).on( "load", function() {
  //alert("hello");
  $(".theme-btn").show();

});


</script>
</body>
</html>
