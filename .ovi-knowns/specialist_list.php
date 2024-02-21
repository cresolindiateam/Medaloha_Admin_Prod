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
$mail->Username = 'cresoluser@gmail.com';   // SMTP username
$mail->Password = 'gbhrsgnkuxevramp';   // SMTP password


$mail->SMTPSecure = 'tls';   // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                    // TCP port to connect to
// Sender info
$mail->setFrom('cresoluser@gmail.com', 'Medaloha Admin');
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
        <th>Email:</th><td>'.$recemail.'</td>
      </tr>
      <tr>
        <th>Website:</th><td><a href="https://medalohaadmin.cresol.in/">Medaloha Admin</a></td>
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
$sql = "SELECT specialist_private.*,specialist_private.status as status FROM `specialist_private` left join specialist_public_intros on specialist_public_intros.specialist_id=specialist_private.id where 1";
if(isset($_POST['language']) && $_POST['language']!='')
{
$lan=$_POST['language'];
$sql.=" and specialist_public_intros.language_id=".$lan;
}

$fetaured_checked_spec=0;
if(isset($_POST['fetaured_checked_spec']) && $_POST['fetaured_checked_spec']=='on')
{
$fetaured_checked_spec=1;
$sql.=" and specialist_private.mark_featured_spec=".$fetaured_checked_spec;
}



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
$status='6';
}else if($operation=='disable'){ // 
$status='7';
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
$mail->Username = 'cresoluser@gmail.com';
$mail->Password = 'gbhrsgnkuxevramp';

$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->setFrom('cresoluser@gmail.com', 'Medaloha Admin');
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
      <th>Email:</th><td>'.$recemail.'</td>
    </tr>
    <tr>
      <th>Website:</th><td><a href="http://medalohaadmin.cresol.in/">Medaloha Admin</a></td>
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
$mail->Username = 'cresoluser@gmail.com';
$mail->Password = 'gbhrsgnkuxevramp';


$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->setFrom('cresoluser@gmail.com', 'Medaloha Admin');
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
    <th>Email:</th><td>'.$recemail.'</td>
  </tr>
  <tr>
    <th>Website:</th><td><a href="http://medalohaadmin.cresol.in/">Medaloha Admin</a></td>
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
.hidden1 {
    display:block;
    margin-right: 5px;
}

.orderinputboxspan
{
  color: red;
}

.form-row
{
  display: inline-flex;
  width: 100%;
}

.fetaured_check_box{margin-top: 8px;}
.hidden2{display: none;}
.margin-left-10{margin-left: 10px;}

input[type=checkbox], input[type=radio]{margin: 4px 8px 0px;}
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
              <th>Specialist Name</th>
              <th>Mobile</th>
              <th>Email</th>
              <th>Country</th>
              <th>City</th>
              <th>Date Of Birth</th>
              <th>Place Birth</th>
              <th>Other Text</th>
              <th>Id Document Front</th>
              <th>Id Document Back</th>
              <th>Iban</th>
              <th>Bic</th>
              <th>Main Consult Language</th>
              <th>Healthcare Degree</th>

              <th>Healthcare Degree Image</th>
              <th>University Degree</th>

              <th>University Degree Image</th>
              <!--  <th>Specialist Details</th> -->
              <th>Join on</th>
              <th>Mark As Featured</th>
              <th>Missing Profile Issue</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
             
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
           if($item['place_birth'])  { echo'<td>'.get_table_fieldname_by_id('countries',$item['place_birth'],$db).'</td>'; }  else  {  echo'<td>'."-". '</td>';}
              echo'<td>'.$item['other_text'].'</td>';
               echo '<td>';

if($item['id_document_front']!=''){
              echo  '<img alt="id_document_front" height="60" width="60" src=https://medalohaapi.cresol.in/public/uploads/docs/'.$item['id_document_front'].' />';
             }
             else
             {
echo '-';
             }
               echo '</td>';
                echo'<td>';

if($item['id_document_back']!=''){
              echo  '<img alt="id_document_back" height="60" width="60" src=https://medalohaapi.cresol.in/public/uploads/docs/'.$item['id_document_back'].' />';
             }
             else
             {
echo '-';
             }


                echo '</td>';
              echo'<td>'.$item['iban'].'</td>';
              echo'<td>'.$item['bic'].'</td>';
               echo'<td>'.$item['main_consult_language'].'</td>';

$checkedh='';
if($item['healthcare_university_degree']==1)
{
  $checkedh='checked';
}
else
{
  $checkedh='';
}
                echo'<td><input type="checkbox" '.$checkedh.'   value="1">
                </td>';


echo '<td>';
if($item['healthcare_documents']!=''){
              echo  '<img alt="healthcare_documents" height="60" width="60" src=https://medalohaapi.cresol.in/public/uploads/docs/'.$item['healthcare_documents'].' />';
             }
             else
             {
echo '-';
             }
echo '</td>';




$checkedu='';
if($item['university_degree']==1)
{
  $checkedu='checked';
}
else
{
  $checkedu='';
}
                echo'<td><input type="checkbox" '.$checkedu.'  ></td>';
           



echo '<td>';
if($item['university_documents']!=''){
              echo  '<img alt="healthcare_documents" height="60" width="60" src=https://medalohaapi.cresol.in/public/uploads/docs/'.$item['university_documents'].' />';
             }
             else
             {
echo '-';
             }
echo '</td>';


              echo'<td>'.$item['created_at'].'</td>';
              echo'<td>
                <form>

                <div class="form-row">
                 



 <div class="form-group customcontainer col-6 ml-2">

                  <div class="area'.$item['id'].' hidden2">
                   <input onkeypress="return event.charCode >= 48 && event.charCode <= 57"  name="order_sequence[]" onkeyup="inputbox('.$item['id'].')"  class="order_sequence form-control " type="text" required  id="orderinputbox_'.$item['id'].'" value="'.$item['featured_order'].'"></input>
                   <span   class="orderinputboxspan" id="orderinputboxspan'.$item['id'].'"></span>
                  </div> 
                  

                  

                  </div>
                   <div class="form-group customcontainer col-6 fetaured_check_box">
                    <input type="hidden"  name="featured_spec[]" value="0">
                    <input type="checkbox" '.$checked.' onclick="checkbox('.$item['id'].')" class="fetaured_checked_length " data-id="'.$item['id'].'" id="spec_'.$item['id'].'" name="featured_spec[]" value="1">
                    <label for="spec_'.$item['id'].'"></label>

                  

                  </div>


                  </div>




                </form>
              </td>';
              ?>
              <td>
                <div class="visible-md visible-lg hidden-sm hidden-xs">


                  <form id="send_email_form" method="post">

                    <div class="form-row">

                       <div class="form-group col-6">
                    <input type="hidden" name="spec_email" value="<?php echo $item['email'];?>">
                    <textarea id="missing_issue" name="missing_content" class="form-control"></textarea>
  
</div>
 <div class="form-group col-6">
                    <input class="btn theme-btn pull-right margin-left-10" type="button" onclick="send_email()" value="Send" />
</div>
                  </div>
                  </form>
                </div>
              </td>
              <td>

                 <div class="form-row">

                       <div class="form-group col-6">

                <div class="visible-md visible-lg hidden-sm hidden-xs">
                  <?php

                 
                  if($item['status']==4){
                  echo "<span class='badge badge-complete'><a href='?type=status&operation=enable&spec_email=".$item['email']."&id=".$item['id']."'>Publish</a></span>&nbsp;";
                  }else if($item['status']==6){
                  echo "<span class='badge badge-pending'><a href='?type=status&operation=disable&spec_email=".$item['email']."&id=".$item['id']."'>Block</a></span>&nbsp;";
                  }

                  ?>
                  </div>
                  </div>
                  <div class="form-group col-6">
                  <a href="specialist_details.php?id=<?php echo $id;?>"><i class="fa fa-eye"></i></a>
                   </div>
  </div> 


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

$("div.lanselect").html('<form name="language_form" action="" method="post"><label>Featured Specilaist: <input type="checkbox"  <?php if($fetaured_checked_spec==1){echo 'checked';} else{ '';} ?> name="fetaured_checked_spec" style="vertical:align:middle;" id="fetaured_checked_spec"/> <label>Language:  <select name="language" class="form-control" id="language">Language:-<option value="">All</option><?php foreach ($data1 as $key =>  $item){
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

$('#fetaured_checked_spec').on('change', function() {
document.forms['language_form'].submit();
});


});







      $('.fetaured_checked_length').each(function () {
       var sThisVal = (this.checked ? $(this).attr("id") : "");

if(sThisVal!="")
{
  var iid=sThisVal.split("_")[1];
   $(".area"+iid).show();
}

  });


function checkbox(id)
{


var testVar = ".area"+id;
var orderinputbox= $("#orderinputbox_"+id).val();
var check=0





 if($(".fetaured_checked_length:checked").length>20) 
      {
            

        $("#orderinputboxspan"+id).html("You Can't Choose Specialist AS Featured Specialist More Than 20");
              return false;
      }


/*else if(parseInt(orderinputbox)<=0 || parseInt(orderinputbox)>20)
{

$("#orderinputboxspan"+id).html("Please Fill The Order Sequence Between 1-20");
  return false;

}*/



else if(orderinputbox=="" && (!$("#spec_"+id+"").is(':checked')))
{


  console.log(testVar);
$(testVar).hide();

  $("#orderinputbox_"+id).focus();
  $("#orderinputboxspan"+id).html("Please Fill The Order Sequence Field");
  
var check=0
  return false;
}



else if(orderinputbox=="" && $("#spec_"+id+"").is(':checked'))
{

console.log(testVar);
$(testVar).show();
  $("#orderinputbox_"+id).focus();
  $("#orderinputboxspan"+id).html("Please Fill The Order Sequence Field");
var check=0
  return false;


}

else if(orderinputbox!="" && $("#spec_"+id+"").is(':checked'))
{

  console.log(testVar);
$(testVar).show();
 
  $("#orderinputboxspan"+id).html("");

var check=1



}


 else if(orderinputbox!="" && (!$("#spec_"+id+"").is(':checked')))
{


  console.log(testVar);
$(testVar).hide();
$("#orderinputbox_"+id).val("");


$("#orderinputbox_"+id).focus();

var check=0
  $("#orderinputbox_"+id).focus();
  $("#orderinputboxspan"+id).html("");
   $.ajax({
              url:"CreateFeaturedSpecialist.php",
              data:{Check:0,
              Specialist_id:id,
              Order:""
              },
              type:'post',
              success:function(response){
              var json = $.parseJSON(response);

              console.log(json.Message);
              console.log("#orderinputboxspan"+parseInt(json.Value));

              $("#orderinputboxspan"+parseInt(json.Value)).html("Specialist Unmark As Featured Specialist");
              /*alert(json.Message);*/
              //alert(response.Message);
              // location.reload();
              },
              error: function(xhr, status, error) {
              var err = eval("(" + xhr.responseText + ")");
              alert(err.Message);
              }
              });

           var checkid = $('#spec_'+testid);
           checkid.prop("checked", false);
          return false;




}









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
});


function inputbox(id)
{



var test= $("#orderinputbox_"+id).val();








 if($(".fetaured_checked_length:checked").length>20) 
      {
            

        $("#orderinputboxspan"+id).html("You Can't Choose Specialist AS Featured Specialist More Than 20");
              return false;
      }


else if(parseInt(test)<=0 || parseInt(test)>20)
{

$("#orderinputboxspan"+id).html("Please Fill The Order Sequence Between 1-20");
  return false;

}


          if(test=="")
          {



              $.ajax({
              url:"CreateFeaturedSpecialist.php",
              data:{Check:0,
              Specialist_id:id,
              Order:""
              },
              type:'post',
              success:function(response){
              var json = $.parseJSON(response);

              console.log(json.Message);
              console.log("#orderinputboxspan"+parseInt(json.Value));

              $("#orderinputboxspan"+parseInt(json.Value)).html("Specialist Unmark As Featured Specialist");
              /*alert(json.Message);*/
              //alert(response.Message);
              // location.reload();
              },
              error: function(xhr, status, error) {
              var err = eval("(" + xhr.responseText + ")");
              alert(err.Message);
              }
              });

           var checkid = $('#spec_'+id);
           checkid.prop("checked", false);
          return false;
          }

else
{
 

$.ajax({
url:"CreateFeaturedSpecialist.php",
data:{Check:1,
Specialist_id:id,
Order:test
},
type:'post',
success:function(response){
var json = $.parseJSON(response);


console.log(json.Message);
console.log("#orderinputboxspan"+parseInt(json.Value));
/*if(response.Status==2)
{*/
$("#orderinputboxspan"+parseInt(json.Value)).html(json.Message);
/*}*/


//alert(json.Message);
//alert(response.Message);
// location.reload();
},
error: function(xhr, status, error) {
var err = eval("(" + xhr.responseText + ")");
alert(err.Message);
}
});

var checkid = $('#spec_'+id);
          checkid.prop("checked", true);

}
  





}




/*
$('.order_sequence').on('keyup', function () {

 var test = $(this).val();
var testid = $(this).attr('id').split("_")[1];





})
*/



</script>
<script>
</script>
</body>
</html>