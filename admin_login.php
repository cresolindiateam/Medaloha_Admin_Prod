<?php


require 'dbconfig.php';
$homeurl = "http://".$_SERVER['HTTP_HOST'].'/index.php';
$failed=1;
$db=db_connect();




$sql = "SELECT * FROM `admin`";
$exe = $db->query($sql);
$data = $exe->fetch_all(MYSQLI_ASSOC);


$AdminUsername=$data[0]['username'];
$AdminPassword= $data[0]['password'];
$AdminEmail= $data[0]['email'];
$username='';
$password='';
$SessionStatus=false;

session_start();
$url = "http://".$_SERVER['HTTP_HOST'].'/index.php';


if(isset($_REQUEST['username']) && $_REQUEST['username']=='')
{
echo "<script> alert('Please fill username field!'); window.location = '".$url."'</script>";
return false;
}

if(isset($_REQUEST['password']) && $_REQUEST['password']=='')
{
echo "<script> alert('Please fill password field!'); window.location = '".$url."'</script>";
return false;
}


if(isset($_SESSION['username']) && $_SESSION['username']!=""){
  echo "<script> window.location = '".$url."'</script>";
}

if(isset($_REQUEST['username']) && $_REQUEST['username']!=='')
{
  $username = mysqli_real_escape_string($db, $_REQUEST['username']);
}

if(isset($_REQUEST['password']) && $_REQUEST['password']!=='')
{
  $password = mysqli_real_escape_string($db, $_REQUEST['password']);
}





if($username!=""&&$password!="")
{
  if($AdminUsername==$username || $AdminEmail==$username)
  {
   if($AdminPassword==md5($password))
   {
      $SessionStatus=true;
      session_start();
      $_SESSION['valid'] = true;
      $_SESSION['timeout'] = time();
      $_SESSION['username'] = $username;
      header("Location: $homeurl");
      $LogedInMessage="You are successfully Logged In..";
      echo "<script type='text/javascript'>alert('$LogedInMessage')</script>";
      exit();
    }
    else
    {
      $failed=1;
      $passwordError="Invalid password! Enter a valid password...";
      echo "<script type='text/javascript'>alert('$passwordError')</script>";
    }
  }
  else
  {
    $failed=1;
    $UsernameError="Invalid User! Enter a valid user...";
    echo "<script type='text/javascript'>alert('$UsernameError')</script>";
  }
}
else
{
}


?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Medaloha Admin</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
    
      <img src="image/logo/medalogo.png" />
      <div class="mycompany-name">
        Medaloha Admin
    
      </div>
      <hr>
      <img src="dist/img/mobile.png" style="display: none;">
      <div class="theme-form">
        <form action="admin_login.php" method="post">
          <div class="login-header" style="display:none">Sign in to Admin Panel</div>
          <div class="login-inner-box">
            <div class="form-group has-feedback">
              <label style="display:none">Email</label>
              <input type="text"    class="form-control" placeholder="Username/Email" name="username">
              <i class="fa fa-user login-inner-icon"></i>
            </div>

            <div class="form-group has-feedback">
              <label style="display:none">Password</label>
              <input type="password" class="form-control" placeholder="Password" name="password" autocomplete="off">
              <i class="fa fa-lock login-inner-icon"></i>
            </div>

            <div class="row">
              <div class="col-xs-12">
                <center><input type="submit" class="btn theme-btn " value="Sign In" /></center>
              </div>
            </div>
          </div>

        </div>
      </form>
    </div>

    <div class="designby-text">Designed By <a href="http://www.cresol.in/" target="blank">Cresol.in</a></div>
  </div>


  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
