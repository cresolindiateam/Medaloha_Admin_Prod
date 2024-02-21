<?php
require 'dbconfig.php';
require 'function.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/PHPMailerAutoload.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
session_start();

$db=db_connect();
$case_array = array();
//send email to specialist
if(isset($_POST['missing_content']) && $_POST['missing_content']!=""){
$recemail=$_POST['spec_email'];
$messsage_content= $_POST['missing_content'];
$subject = "Send Email To Specialist For Filling Missing Things in Own Profile.";
$mail = new PHPMailer();
$mail->isSMTP();                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';   // Specify main and backup SMTP servers
$mail->Mailer = "smtp";
$mail->SMTPAuth = true;               // Enable SMTP authentication
$mail->Username = 'ajay@cresol.in';   // SMTP username
$mail->Password = 'petipa@#$';   // SMTP password


$mail->SMTPSecure = 'tls';   // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                    // TCP port to connect to
// Sender info
$mail->setFrom('ajay@cresol.in', 'Medaloha Admin');
// Add a recipient
$mail->addAddress($recemail);
// Set email format to HTML
$mail->isHTML(true);
// Mail subject
$mail->Subject = 'Send Email To Specialist For Filling Missing Things in Own Profile.';
// Mail body content
$bodyContent = '
<html>
  <head>
    <title>Missing Things in Profie</title>
  </head>
  <body>
    <h1>Thanks you for joining with us!</h1>
    Hello Specialist, i am here to Inform that there is something missing in Your Profile Please check following things <br/>'.
    $messsage_content.'<br/>
    <table cellspacing="0" style="border: 2px dashed #FB4314; width: 100%;">
      <tr>
        <th>Name:</th><td>Medaloha Admin</td>
      </tr>
      <tr style="background-color: #e0e0e0;">
        <th>Email:ajay@cresol.in</th><td></td>
      </tr>
      <tr>
        <th>Website:</th><td><a href="#">Medaloha Admin</a></td>
      </tr>
    </table>
  </body>
</html>';
$mail->Body    = $bodyContent;
// Send email
if(!$mail->send()) {
echo "<script>alert('Message could not be sent. Mailer Error:  $mail->ErrorInfo');</script>";
//echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
} else {
echo "<script>alert('Message has been sent.');</script>";
//echo 'Message has been sent.';
}
}
$lan='';
if(isset($_POST['language']) && $_POST['language']!='')
{
$lan=$_POST['language'];
$sql = "SELECT specialist_private.*,specialist_private.status as status FROM `specialist_private` left join specialist_public_intros on specialist_public_intros.specialist_id=specialist_private.id where specialist_public_intros.language_id=".$lan;
}
else
{
$sql = "SELECT specialist_private.*,specialist_private.status as status FROM `specialist_private` left join specialist_public_intros on specialist_public_intros.specialist_id=specialist_private.id where 1";
}
/*echo $sql;*/
$sql=$sql." GROUP BY specialist_private.id ORDER BY specialist_private.id DESC";
$exe = $db->query($sql);
$data = $exe->fetch_all(MYSQLI_ASSOC);
if(isset($_GET['type']) && $_GET['type']!='')
{
$type=$_GET['type'];
$status='';
if($type=='status'){
$operation=$_GET['operation'];
$id=$_GET['id'];
if($operation=='enable'){
$status='7';
}else if($operation=='disable'){
$status='6';
}
if($status==6)
{
$recemail=$_GET['spec_email'];
//$messsage_content= $_POST['missing_content'];
$subject = "Your Account has been  Approved By Admin";
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Mailer = "smtp";
$mail->SMTPAuth = true;
$mail->Username = 'ajay@cresol.in';
$mail->Password = 'petipa@#$';

$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->setFrom('ajay@cresol.in', 'Medaloha Admin');
$mail->addAddress($recemail);
$mail->isHTML(true);
$mail->Subject = 'Your Account Has been Approved BY Admin Now You Can Login Your Account';
$bodyContent = '
<html>
<head><title>Account Has been Approved By Admin</title></head>
<body>
  <h1>Thanks you for joining with us!</h1>
  Hello Specialist, i am here to Inform that  Your Profile has been Approved Successfully
  Now You Can Join With Us. Plase Login Your Account
  <table cellspacing="0" style="border: 2px dashed #FB4314; width: 100%;">
    <tr>
      <th>Name:</th><td>Medaloha Admin</td>
    </tr>
    <tr style="background-color: #e0e0e0;">
      <th>Email:ajay@cresol.in</th><td></td>
    </tr>
    <tr>
      <th>Website:</th><td><a href="#">Medaloha Admin</a></td>
    </tr>
  </table>
</body>
</html>';
$mail->Body    = $bodyContent;
if(!$mail->send())
{
echo "<script>alert('Message could not be sent. Mailer Error:  $mail->ErrorInfo');</script>";
}
else
{
echo "<script>alert('Message has been sent.');</script>";
}
}
if($status==7)
{
$recemail=$_GET['spec_email'];
//$messsage_content= $_POST['missing_content'];
$subject = "Your Account has been  Disapproved By Admin";
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Mailer = "smtp";
$mail->SMTPAuth = true;
$mail->Username = 'ajay@cresol.in';
$mail->Password = 'petipa@#$';


$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->setFrom('ajay@cresol.in', 'Medaloha Admin');
$mail->addAddress($recemail);
$mail->isHTML(true);
$mail->Subject = 'Your Account Has been Disapproved BY Admin Now You Cant Login Your Account';
$bodyContent = '
<html>
<head><title>Account Has been Disapproved By Admin</title>

</head>
<body>
<h1>Thanks you for joining with us!</h1>
Hello Specialist, i am here to Inform that  Your Profile has been Disapproved Successfully. Please Contact With Us For Further Details
<table cellspacing="0" style="border: 2px dashed #FB4314; width: 100%;">
  <tr>
    <th>Name:</th><td>Medaloha Admin</td>
  </tr>
  <tr style="background-color: #e0e0e0;">
    <th>Email:ajay@cresol.in</th><td></td>
  </tr>
  <tr>
    <th>Website:</th><td><a href="#">Medaloha Admin</a></td>
  </tr>
</table>
</body>
</html>';
$mail->Body    = $bodyContent;
if(!$mail->send())
{
echo "<script>alert('Message could not be sent. Mailer Error:  $mail->ErrorInfo');</script>";
}
else
{
echo "<script>alert('Message has been sent.');</script>";
}
}
$update_status_sql="update specialist_private set status='$status' where id='$id'";

/*echo $update_status_sql;die;*/
mysqli_query($db,$update_status_sql);
echo "<script>alert('Status Has been Updated.');</script>";
$yourURL="http://".$_SERVER['HTTP_HOST'].'/specialist_list.php';
echo ("<script>location.href='$yourURL'</script>");
}
}
$specialist_id='';
if(isset($_GET['id']) && $_GET['id']!='')
{
$specialist_id= $_GET['id'];
$sqlAdmin="SELECT * FROM `specialist_public_intros` where specialist_id=$specialist_id";
$exeAdmin = $db->query($sqlAdmin);
$datapublicinfo = $exeAdmin->fetch_all(MYSQLI_ASSOC);
}
?>
<?php include('header.php');?>
<?php include('left_side_bar.php');?>
<style>
.lanselect
{
float: right!important;
margin-left: 20px;
}
</style>
<div class="content-wrapper">
<section class="content-header">
<h1 class="make-inline">
Specialist List(<span id="count_row"><?php echo count($data);?></span>)
</h1>
<ol class="breadcrumb">
  <li>
    <span>Admin </span>
  </li>
  <li class="active">
    <span>Specialist List</span>
  </li>
</ol>
</section>
<!-- Main content -->
<section class="content">
<div class="row">
  <div class="box table-responsive">
    <!-- /.box-header -->
    <div class="row">
      <div class="col-md-2">
        
        <?php
        $sql1 = "SELECT id,language_name FROM `languages`";
        $exe1 = $db->query($sql1);
        $data1 = $exe1->fetch_all(MYSQLI_ASSOC);
        
        ?>
        
      </div></div>
      <div class="box-body table-responsive">
        
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th style="width: 10px">#</th>
               <th>First Name</th>
        <th>Sur Name</th>
        <th>Email</th>
         <th>Mobile</th>
        <th>Image</th>
       <th>Place Of Residence</th>
       <th>Place Of Birth</th>
       <th>Id Doc front</th>
        <th>Id Doc back</th>
        <th>Date Of Birth</th>
<th>Consulting Language</th>

        <th>Healthcare degree</th>

        <th>Healthcare degree attcahemnt</th>

         <th>Universiy degree</th>

        <th>Universiy degree attcahemnt</th>
        <th>Other</th>
        <th>Additional Info attachment</th>

        <th>Holder Name</th>
        <th>IBNA</th>
        <th>BIC</th>
        
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
echo "<pre>";
            print_r($data);
            foreach ($data as $key =>  $item)
            {
            $id = $item['id'];
            
            $joinon = $item['created_at'];
            $count=$key+1;
            $markfetaure=$item['mark_featured_spec'];
            if($markfetaure==1)
            {
            $checked='checked';
            }
            if($markfetaure==0)
            {
            $checked='';
            }
            echo'<tr>';
              echo'<td>'.$count.'</td>';
           
              echo'<td>'.$item['first_name'].' '.$item['last_name'].'</td>';
              echo'<td>'.$item['mobile'].'</td>';
              echo'<td>'.$item['email'].'</td>';
              echo'<td>'.get_table_fieldname_by_id('countries',$item['country_id'],$db).'</td>';
              echo'<td>'.get_table_fieldname_by_id('cities',$item['city_id'],$db).'</td>';
              echo'<td>'.$item['dob'].'</td>';
              echo'<td>'.$item['place_birth'].'</td>';
              echo'<td>'.$item['other_text'].'</td>';
              echo'<td>'.$item['iban'].'</td>';
              echo'<td>'.$item['bic'].'</td>';
              
              echo'<td>'.$item['created_at'].'</td>';
              echo'<td>
                <form>
                  <div class="form-group1">
                    <input type="hidden"  name="featured_spec[]" value="0">
                    <input type="checkbox" '.$checked.' onclick="checkbox('.$item['id'].')" id="spec_'.$item['id'].'" name="featured_spec[]" value="1">
                    <label for="spec_'.$item['id'].'"></label>
                  </div>
                </form>
              </td>';
              ?>
              <td>
                <div class="visible-md visible-lg hidden-sm hidden-xs">
                  <form id="send_email_form" method="post">
                    <input type="hidden" name="spec_email" value="<?php echo $item['email'];?>">
                    <textarea id="missing_issue" name="missing_content"></textarea>
                    <input class="btn theme-btn pull-right " type="button" onclick="send_email()" value="Send" />
                  </form>
                </div>
              </td>
              <td>
                <div class="visible-md visible-lg hidden-sm hidden-xs">
                  <?php
                  if($item['status']==7 || $item['status']==2 || $item['status']==4){
                  echo "<span class='badge badge-complete'><a href='?type=status&operation=disable&spec_email=".$item['email']."&id=".$item['id']."'>Publish</a></span>&nbsp;";
                  }else if($item['status']==6){
                  echo "<span class='badge badge-pending'><a href='?type=status&operation=enable&spec_email=".$item['email']."&id=".$item['id']."'>Disapproval</a></span>&nbsp;";
                  }

                  ?>
                  
                  
                  <a href="specialist_details.php?id=<?php echo $id;?>"><i class="fa fa-eye"></i></a>
                  
                </td>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
      
      <!-- /.row -->
    </section>
  </div>
</div>
<!-- ./wrapper -->
<?php include('footer.php'); ?>
<script>
function send_email()
{
document.forms['send_email_form'].submit();
}
</script>
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
$("#example1").DataTable({
dom: '<"d-flex w-100"<"lanselect"><f><l><"#mydiv.d-flex ml-auto text-right">>tips',
});

$("div.lanselect").html('<form name="language_form" action="" method="post"><label>Language:  <select name="language" class="form-control" id="language">Language:-<option value="">All</option><?php foreach ($data1 as $key =>  $item){
if($lan== $item['id'])
{
echo "<option  selected    value=".$item['id'].">".addslashes($item['language_name'])."</option>";}
else
{
echo "<option      value=".$item['id'].">".addslashes($item['language_name'])."</option>";
}
}
?></select></label></form>');




$('#language').on('change', function() {
document.forms['language_form'].submit();
});
});
function checkbox(id)
{
var check=0
if($("#spec_"+id+"").is(':checked'))
{
check=1
}
$.ajax({
url:"CreateFeaturedSpecialist.php",
data:{Check:check,
Specialist_id:id,
},
type:'post',
success:function(response){
var json = $.parseJSON(response);
alert(json.Message);
//alert(response.Message);
// location.reload();
},
error: function(xhr, status, error) {
var err = eval("(" + xhr.responseText + ")");
alert(err.Message);
}
});
}
$(document).ready(function() {
$('input[type=search]').on( 'keyup click', function () {
var rows = document.getElementById('example1').getElementsByTagName('tbody')[0].getElementsByTagName('tr').length;
//console.log(rows);
if(rows)
{
document.getElementById('count_row').textContent=rows;
}
} );
})
</script>
<script>
</script>
</body>
</html>

