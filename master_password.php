<?php
require 'dbconfig.php';
//require 'admin.php';

$url = "http://".$_SERVER['HTTP_HOST'].'/Admin/admin_login.php';
session_start();
if($_SESSION['username']==""){
  echo "<script> window.location = '".$url."'</script>";
}

$db=db_connect();


$sql = "select password,id from master_password";
$exe = $db->query($sql);
$data = $exe->fetch_all(MYSQLI_ASSOC);




?>




    <?php include('header.php');?>


    <?php include('left_side_bar.php');?>
<style>
  .fa-fw {
    width: 22!important;
    /* text-align: center; */
    font-size: 14px!important;
}</style>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1 >
          Master Password
        </h1>

        <ol class="breadcrumb">
          <li>
            <span>Admin </span>
          </li>
          <li class="active">
            <span>Master Password</span>
          </li>
        </ol>
      </section>

      <!-- Main content -->

      <section class="content">
        <div class="row">
          <div class="box">
            <div class="box-body">
              <h4 >Master Password</h4>
              <small>(This password will work for specialist and users profile login)<small>
                <div class="theme-form">
                  <div class="row mt-15">
                   <div class="col-md-12">

                     <?php 
                     $pw='';
                     foreach($data as $row)
                     {
                      $pw=$row['password'];
                    }
                    ?>

                    <?php foreach($data as $row){?>
                     <label id="password_label">Password</label>
                     <input type="hidden" class="form-control" value="<?php echo $row['password']; ?>" id="new_password1"/>
                     <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>

                   <?php }?>
               </div>
             </div>
             <center><button type="button" class="btn theme-btn btn-default" id="password_submit1">Save Changes </button></center>
           </div>
     </div>
   </div>
 </div>
</section>



</div>

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"
></script>

<script type="text/javascript">

  $('#password_submit1').click(function(){



    var new_global_pass = $('#new_password1').val();
    console.log(new_global_pass);
    console.log("hello");
    var new_global_pass_confirm = $('#new_password_confirm1').val();

    console.log(new_global_pass_confirm);
    $.ajax({
      url:"ChangeMasterPassword.php",
      data:{
        NewPAss:new_global_pass,
        NewPAssConfirm:new_global_pass_confirm},
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
</script>

<script>

  var input = $("#new_password1");


  input.attr('value','');
  $("#password_submit1").hide();
  $("#password_label").hide();

  $('.toggle-password').addClass("fa-eye fa-eye-slash");
  $(document).on('click', '.toggle-password', function() {



    let text;
    let person = prompt("Please Enter Admin Password for Viewing Master Password", "");
    if (person == null || person == "") {
      text = "";
    } else {

      $.ajax({
        url:"adminpasswordmatch.php",
        data:{password:person},
        type:'post',
        success:function(response){
          console.log(response+'test');
     // location.reload();
     
     if(response==1)
     {

      input.attr('value','<?php  echo $pw; ?>');
      input.attr('type','text');
      $("#password_submit1").show();
      $("#password_label").show();
      $('.toggle-password').removeClass("fa-eye-slash");

    }

    else
    {
      alert("admin password not same as type Password! please Enter Correct Password For Viewing The Master Password");
      input.attr('value','');
      input.attr('type','hidden')
      $("#password_submit1").hide();
      $("#password_label").hide();
      $('.toggle-password').addClass("fa-eye fa-eye-slash");
    }
  },
  error: function(xhr, status, error) {
    var err = eval("(" + xhr.responseText + ")");
    alert(err.Message);
  }
});
  }


});

  $(function () {
    $("#example1").DataTable();
  
  });


</script>
</body>
</html>
