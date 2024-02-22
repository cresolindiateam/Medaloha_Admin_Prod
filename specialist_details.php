<?php
require 'dbconfig.php';
require 'function.php';
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/PHPMailerAutoload.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$url = "http://".$_SERVER['HTTP_HOST'].'/admin_login.php';
if($_SESSION['username']==""){
echo "<script> window.location = '".$url."'</script>";
}
$db=db_connect();
$case_array = array();
$sql = "SELECT * FROM `specialist_private`";
$exe = $db->query($sql);
$data = $exe->fetch_all(MYSQLI_ASSOC);




/*if(isset($_GET['type']) && $_GET['type']!=''){
$type=$_GET['type'];
if($type=='status'){
$operation=$_GET['operation'];
$id=$_GET['id'];
if($operation=='active'){
$status='4';
}else if($operation=='deactive'){
$status='3';
}
$update_status_sql="update specialist_private set status='$status' where id='$id'";
mysqli_query($db,$update_status_sql);
}
}*/
$specialist_id='';
if(isset($_GET['id']) && $_GET['id']!='')
{
//for overview
$specialist_id= $_GET['id'];
$sqlAdmin="SELECT specialist_public_intros.*,specialist_private.timezone,specialist_private.utc_offset_string,GROUP_CONCAT(specialist_overivew_details.consultation_id) AS consultation_id,cities.city_name,countries.country_name FROM `specialist_public_intros` 
left join specialist_overivew_details on specialist_overivew_details.specialist_id=specialist_public_intros.specialist_id

left join cities on cities.id=specialist_public_intros.city_id 
left join countries on countries.id=specialist_public_intros.country_id 


left join specialist_private on specialist_private.id=specialist_public_intros.specialist_id where specialist_public_intros.specialist_id=$specialist_id



  group by specialist_public_intros.specialist_id";


$exeAdmin = $db->query($sqlAdmin);
$datapublicinfo = $exeAdmin->fetch_all(MYSQLI_ASSOC);



//for degree
$sqlAdmin="SELECT * FROM `specialist_degrees` where specialist_id=$specialist_id";
$exeAdmin = $db->query($sqlAdmin);
$datadegree = $exeAdmin->fetch_all(MYSQLI_ASSOC);
//for review
$sqlAdmin1="SELECT replies.reply_desc,reviews.*,reviews.id as review_id,users.id as u_id,users.user_image as u_image,users.first_name as u_first_name,users.last_name as u_last_name,specialist_private.first_name,specialist_private.last_name,specialist_public_intros.profile_photo from reviews left join specialist_private on specialist_private.id=reviews.specialist_id left join specialist_public_intros on specialist_public_intros.specialist_id=reviews.specialist_id  left join users on users.id=reviews.user_id left join replies on replies.review_id=reviews.id where reviews.specialist_id=".$specialist_id." group by reviews.user_id";
$exeAdmin = $db->query($sqlAdmin1);
$datareview1 = $exeAdmin->fetch_all(MYSQLI_ASSOC);




if(isset($_GET['limit']) && $_GET['limit']!='')
{
$sqlAdmin="SELECT replies.reply_desc,reviews.*,reviews.id as review_id,users.id as u_id,users.user_image as u_image,users.first_name as u_first_name,users.last_name as u_last_name,specialist_private.first_name,specialist_private.last_name,specialist_public_intros.profile_photo from reviews left join specialist_private on specialist_private.id=reviews.specialist_id left join specialist_public_intros on specialist_public_intros.specialist_id=reviews.specialist_id  left join users on users.id=reviews.user_id left join replies on replies.review_id=reviews.id where reviews.specialist_id=".$specialist_id." group by reviews.user_id";
}
else
{
$sqlAdmin="SELECT replies.reply_desc,reviews.*,reviews.id as review_id,users.id as u_id,users.user_image as u_image,users.first_name as u_first_name,users.last_name as u_last_name,specialist_private.first_name,specialist_private.last_name,specialist_public_intros.profile_photo from reviews left join specialist_private on specialist_private.id=reviews.specialist_id left join specialist_public_intros on specialist_public_intros.specialist_id=reviews.specialist_id  left join users on users.id=reviews.user_id left join replies on replies.review_id=reviews.id where reviews.specialist_id=".$specialist_id." group by reviews.user_id limit 1";
}
$exeAdmin = $db->query($sqlAdmin);
$datareview = $exeAdmin->fetch_all(MYSQLI_ASSOC);
}
?>
<?php include('header.php');?>
<?php include('left_side_bar.php');?>
<style>
  .media {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: start;
    align-items: flex-start;
}
.doctor-img {
    flex: 0 0 198px;
    width: 198px;
}
.color-cus4 {
    color: #ff0a60;
}

.font-size-21 {
    font-size: 18px;
}
.doctor-img img {
    border-radius: 5px;
}

.w-100 {
    width: 100%!important;
}
.clinic-details {
    margin-bottom: 15px;
}

.mt-3, .my-3 {
    margin-top: 1rem!important;
}
.media-body {
    -ms-flex: 1;
    flex: 1;
}
.mt-4, .my-4 {
    margin-top: 1.5rem!important;
}
.doctor-widget .doc-name {
    font-weight: 700;
    margin-bottom: 0.2rem;
}
.text-dark {
    color: #343a40!important;
}
.text-muted {
    color: #757575 !important;
}
  </style>
<div class="content-wrapper">
  <section class="content-header">
    <h1 class="make-inline">
    Specialist Details
    </h1>
    <ol class="breadcrumb">
      <li>
        <span>Admin </span>
      </li>
      <li class="active">
        <span>Specialist Details</span>
      </li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="box">
        <!-- /.box-header -->
        <div class="visible-md visible-lg hidden-sm hidden-xs">
            
            <span  style="margin-right:10px;/* color: #fb9678; */"><a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/specialist_list.php"><i class=" fa fa-arrow-left" style="color:blue;"></i></a></span>
          <?php
          if(isset($_GET['type']) && $_GET['type']!='')
          {
          $type=$_GET['type'];
          $status='';
          if($type=='status')
          {
          $operation=$_GET['operation'];
          $id=$_GET['id'];
          if($operation=='enable'){
          $status='1';
          }else if($operation=='deactive'){
          $status='0';
          }
          if($status==1)
          {
          $recemail=$_GET['spec_email'];
          /*echo  $recemail;die;*/
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
            Now You Can Join With Us. Please Login Your Account
            <table cellspacing="0" style="border: 2px dashed #FB4314; width: 100%;">
              <tr>
                <th>Name:</th><td>Medaloha Admin</td>
              </tr>
              <tr style="background-color: #e0e0e0;">
                <th>Email:</th><td>cresoluser@gmail.com</td>
              </tr>
              <tr>
                <th>Website:</th><td><a href="https://medalohaadmin.cresol.in/">Medaloha Admin</a></td>
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
        if($status==0)
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
        <head><title>Account Has been Disapproved By Admin</title></head>
        <body>
          <h1>Thanks you for joining with us!</h1>
          Hello Specialist, i am here to Inform that  Your Profile has been Disapproved Successfully. Please Contact With Us For Further Details
          <table cellspacing="0" style="border: 2px dashed #FB4314; width: 100%;">
            <tr>
              <th>Name:</th><td>Medaloha Admin</td>
            </tr>
            <tr style="background-color: #e0e0e0;">
              <th>Email:</th><td>cresoluser@gmail.com</td>
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
      $update_status_sql="update specialist_public_intros set status='$status' where specialist_id='$id'";
      mysqli_query($db,$update_status_sql);
      echo "<script>alert('Status Has been Updated.');</script>";
      
      $yourURL="http://".$_SERVER['HTTP_HOST'].'/specialist_details.php?id='.$id;
      echo ("<script>location.href='$yourURL'</script>");
      }
      
      }
      $sql = "SELECT specialist_private.*,specialist_public_intros.status as status FROM `specialist_private` left join specialist_public_intros on specialist_public_intros.specialist_id=specialist_private.id

       where 1 and specialist_private.id=".$_GET['id']." group by specialist_private.id";
      $exe = $db->query($sql);
      $data = $exe->fetch_all(MYSQLI_ASSOC);
      foreach ($data as $key =>  $item)
      {
      if($item['status']==1){
      echo "<span class='badge badge-complete'><a href='?type=status&operation=disable&spec_email=".$item['email']."&id=".$item['id']."'>Enable</a></span>&nbsp;";
      }else{
      echo "<span class='badge badge-pending'><a href='?type=status&operation=enable&spec_email=".$item['email']."&id=".$item['id']."'>Disable</a></span>&nbsp;";
      }
      }
      ?>
    </span>
  </div>
  <div class="box-body ">

    <?php 
/*echo "<pre>";
print_r($datapublicinfo);*/


$port='';

if($_SERVER['HTTP_HOST']=='localhost')
{
$port=':2200';
$_SERVER['HTTP_HOST']='localhost';
}
else if($_SERVER['HTTP_HOST']=='medalohaadmin.cresol.in')
{
  $port='';
$_SERVER['HTTP_HOST']='medalohaapi.cresol.in';
    
}
else
{
   $port='';
$_SERVER['HTTP_HOST']='medalohaapi.cresol.in'; 
} 


    ?>



    
    <div class="card">
      <div class="card-body">
        <div class="doctor-widget">
          <div class="col-md-12 col-12">
            <div class=""><div class="media sp-media">
              <div class="doctor-img">


                <h4 class="font-size-21 color-cus4"><?php echo $data[0]['first_name'].' '.$data[0]['last_name'] ?></h4><a href="

<?php 
 $path1='';
                      if($datapublicinfo[0]['profile_photo']=='')
                      {
                      echo $path1='https://medalohaadmin.cresol.in/image/user/default_profile.png';
                      }
                      else
                      {
                      echo $path1='https:///medalohaapi.cresol.in/public/uploads/docs/'.$datapublicinfo[0]['profile_photo'];
                      }
                  ?>
                " class="d-flex"><img src="
<?php 
 $path1='';
                      if($datapublicinfo[0]['profile_photo']=='')
                      {
                      echo $path1='https://medalohaadmin.cresol.in/image/user/default_profile.png';
                      }
                      else
                      {
                      echo $path1='https:///medalohaapi.cresol.in/public/uploads/docs/'.$datapublicinfo[0]['profile_photo'];
                      }
                  ?>
                " class="img-fluid d-block w-100" alt="Specialist Image"></a>
              <!--   <div class="clinic-details mt-3">
                  <ul class="clinic-gallery">
                    <li><a href="#" class="btn btn-white text-muted msg-btn cus-padding cus-padding1"><i class="fa fa-share-alt sfz"></i></a></li>
                    <li><a href="javascript:void(0)" class="btn btn-white text-muted fav-btn cus-padding cus-padding1 "><i class="far fa-bookmark sfz"></i></a></li>
                    <li><a href="#" class="btn btn-white text-muted msg-btn cus-padding1 cus-padding"><i class="far fa-comment-alt sfz"></i></a></li>
                  </ul>
                </div> -->
              </div>
              <div class="media-body">
                <div class="doc-info-cont hidden-xs hidden-sm mt-4">
                  <h4 class="doc-name"><a href="javascript:void(0)" class="text-dark"><?php echo $datapublicinfo[0]['your_title'] ?>
                    



                  </a></h4>
                  <p class="doc-speciality font-weight-bold mb-10"></p>
                  <a href="#"> <!-- <h6 class="text-info">Ayurveda,Antroposophy</h6> --></a><h6 class="text-muted"><?php echo $datapublicinfo[0]['work_experience']; ?> years experience overall</h6>
                 
                  <div class="clinic-details">
                    <p class="doc-location">
                    <i class="fas fa-map-marker-alt"></i> &nbsp; <?php echo get_table_fieldname_by_id('countries',$data[0]['country_id'],$db)?>, <?php echo  get_table_fieldname_by_id('cities',$data[0]['city_id'],$db)?></p></div>
                    <div class="clinic-details">
                      <ul class="clinic-gallery">
                        <li><a href="<?php
                          $path='';
                          if($datapublicinfo[0]['activity_image1']=='')
                          {
                       echo   $path='https://medalohaadmin.cresol.in/image/user/default_profile.png';
                          }
                          else
                          {
                        echo   $path='https://'.$_SERVER['HTTP_HOST'].$port.'/public/uploads/docs/'.$datapublicinfo[0]['activity_image1'];
                          }
?>" data-fancybox="gallery"><img src="

 <?php
                          $path='';
                          if($datapublicinfo[0]['activity_image1']=='')
                          {
                          echo $path='https://medalohaadmin.cresol.in/image/user/default_profile.png';
                          }
                          else
                          {
                        echo   $path='https://'.$_SERVER['HTTP_HOST'].$port.'/public/uploads/docs/'.$datapublicinfo[0]['activity_image1'];
                          }
?>

                          " alt="Other1"></a></li>
                       

                        <li><a href=" <?php
                          $path='';
                          if($datapublicinfo[0]['activity_image2']=='')
                          {
                          
echo $path='https://medalohaadmin.cresol.in/image/user/default_profile.png';
                          }
                          else
                          {
                       echo    $path='https://'.$_SERVER['HTTP_HOST'].$port.'/public/uploads/docs/'.$datapublicinfo[0]['activity_image2'];
                          }
?>" data-fancybox="gallery"><img src=" <?php
                          $path='';
                          if($datapublicinfo[0]['activity_image2']=='')
                          {
                      echo   $path='https://medalohaadmin.cresol.in/image/user/default_profile.png';
                          }
                          else
                          {
                         echo  $path='https://'.$_SERVER['HTTP_HOST'].$port.'/public/uploads/docs/'.$datapublicinfo[0]['activity_image2'];
                          }
?>" alt="Other2"></a></li>


   <li><a href=" <?php
                          $path='';
                          if($datapublicinfo[0]['activity_image3']=='')
                          {
                        
echo $path='https://medalohaadmin.cresol.in/image/user/default_profile.png';
                          }
                          else
                          {
                        echo   $path='https://'.$_SERVER['HTTP_HOST'].$port.'/public/uploads/docs/'.$datapublicinfo[0]['activity_image3'];
                          }
?>" data-fancybox="gallery"><img src=" <?php
                          $path='';
                          if($datapublicinfo[0]['activity_image3']=='')
                          {
                        

echo $path='https://medalohaadmin.cresol.in/image/user/default_profile.png';
                          }
                          else
                          {
                          echo $path='https://'.$_SERVER['HTTP_HOST'].$port.'/public/uploads/docs/'.$datapublicinfo[0]['activity_image3'];
                          }
?>" alt="Other3"></a></li>


<li><a href=" <?php
                          $path='';
                          if($datapublicinfo[0]['activity_image4']=='')
                          {
                         echo  $path='https://medalohaadmin.cresol.in/image/user/default_profile.png';
                          }
                          else
                          {
                        echo   $path='https://'.$_SERVER['HTTP_HOST'].$port.'/public/uploads/docs/'.$datapublicinfo[0]['activity_image4'];
                          }
?>" data-fancybox="gallery"><img src=" <?php
                          $path='';
                          if($datapublicinfo[0]['activity_image4']=='')
                          {
                         
echo $path='https://medalohaadmin.cresol.in/image/user/default_profile.png';
                          }
                          else
                          {
                      echo  $path='https://'.$_SERVER['HTTP_HOST'].$port.'/public/uploads/docs/'.$datapublicinfo[0]['activity_image4'];
                          }
?>" alt="Other4"></a></li>
                      </ul></div>
                    </div>
                  </div>
                </div>
                <div class="doc-info-cont hidden-lg hidden-md text-center">
                  <h4 class="doc-name">
                  <a href="javascript:void(0)" class="text-dark">GNM &amp; Naturopathy Practitioner</a>
                  </h4>
                  <p class="doc-speciality doc-sub font-weight-bold mb-10">PhD in Chemistry, Naturopathy, Antroposophy</p>
                  <a href="#">
                  <h6 class="text-info">Ayurveda, Antroposophy</h6></a><h6 class="text-muted">3 years experience overall</h6><h6 class="text-muted">15 consultations done -since Nov 2020 </h6>
                  <div class="rating">
                    <i class="fas fa-star filled"></i>
                    <i class="fas fa-star filled"></i>
                    <i class="fas fa-star filled"></i>
                    <i class="fas fa-star filled"></i>
                    <i class="fas fa-star"></i>
                    <span class="d-inline-block average-rating text-muted">(17)</span>&nbsp;
                    <span class="text-muted"><i class="fa fa-thumbs-up text-muted"></i> 99%</span>
                  </div>
                  <div class="clinic-details mb-1">
                    <p class="doc-location mb-1"><i class="fas fa-map-marker-alt"></i> Florida, USA</p>
                  </div>
                  <div class="clinic-details">
                    <ul class="clinic-gallery">
                      <li><a href="assets\img\features\feature-01.jpg" data-fancybox="gallery"><img src="assets\img\features\feature-01.jpg" alt="Feature"></a></li>
                      <li><a href="assets\img\features\feature-02.jpg" data-fancybox="gallery"><img src="assets\img\features\feature-02.jpg" alt="Feature Image"></a></li>
                      <li><a href="assets\img\features\feature-03.jpg" data-fancybox="gallery"><img src="assets\img\features\feature-03.jpg" alt="Feature"></a></li>
                      <li><a href="assets\img\features\feature-04.jpg" data-fancybox="gallery"><img src="assets\img\features\feature-04.jpg" alt="Feature"></a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
         <!--    <div class="col-md-5 col-12 mt-3 p-0">
              <div class="clinic-services border w-100" id="avlcon"><div class="mt-3 w-100">
                <div class="w-100 d-flex hidden-sm hidden-xs">
                  <div class="col-md-8">
                    <h6 class="font-weight-bold text-muted ml-4 mb-3">Available Consultations &nbsp;
                    <div class="tooltip1 line-height"><i class="fas fa-info-circle" title=""></i><span class="tooltiptext text-left"><h4 class="text-center text-white t-o-consult-text">Types of consultations:</h4>
                      <ul class="mb-0 cus-font-size">
                        <li>Message: you can write/voice message the specialist about a specific subject</li><li>Video: you can access online your audio-video session, comfortably from your place</li><li>In-person: join a specialist for a live session, searching by area of interest</li>
                      </ul>
                      <h5 class="text-justify text-white tool-tip-text"> Modes can be PART (e.g. exploratory session) or FULL (e.g. complete session). Check specialist’s profile for specific details.</h5>
                      <div class="text-center">
                        <a href="how-it-work.html" class="text-white h-i-w-text">How it works</a>
                      </div>
                    </span>
                  </div>
                  </h6>
                </div>
                <div class="col-md-4 pl5">
                  <h6 class="font-weight-bold text-muted float-left">Price</h6>
                  <i class="fa fa-eur ml-5 cus-font-size1 " aria-hidden="true"></i>
                <img src="assets/icon/euro.png" class="ml-1 d-none euro-img"></div>
              </div>
              <div class=" d-flex hidden-md hidden-lg">
                <div class="w-70">
                  <h6 class="font-weight-bold text-muted mb-1">Available Consultations &nbsp;
                  <div class="tooltip line-height">
                    <i class="fas fa-info-circle" title=""></i><span class="tooltiptext text-left">
                      <h4 class="text-center text-white t-o-consult-text">Types of consultations:</h4>
                      <ul class="mb-0 cus-font-size">
                        <li>Message: you can write/voice message the specialist about a specific subject</li>
                        <li>Video: you can access online your audio-video session, comfortably from your place</li>
                        <li>In-person: join a specialist for a live session, searching by area of interest</li>
                      </ul>
                      <h5 class="text-justify text-white cus-font-size p-5"> Modes can be PART (e.g. exploratory session) or FULL (e.g. complete session). Check specialist’s profile for specific details.</h5>
                      <div class="text-center">
                        <a href="how-it-work.html" class="text-white h-i-w-text">How it works</a></div>
                      </span>
                    </div>
                    </h6>
                  </div>
                  <div class="d-flex w-30 justify-content-center"><h6 class="font-weight-bold text-muted mb-3">Price</h6><i class="fa fa-eur ml-5 color-cus1 cus-font-size1" aria-hidden="true"></i>
                    <img src="assets/icon/euro.png" class="ml-1 d-none euro-img1">
                  </div>
                </div>
              </div>
              <div class="card flex-fill mt-0 mb-0 border-0" style="height: 235px;">
                <ul class="list-group list-group-flush ml-0" style="height: 65px;">
                  <div class="col-md-12 padding0 d-flex">
                    <div class="col-md-5 col-5 pleftright10">
                      <h6 class=" d-flex">
                      <img src="/assets/images/written.png" class="avcon-img1">
                      <span class="written_text_color  avcon-txt1 border-0 mt-2 w-150">Message &nbsp;</span>
                      </h6>
                    </div>
                    <div class="col-md-7 col-7 mt-2 d-flex">
                      <div class="col-md-6 col-6 p-0">
                        <h6 class="written_text_color text-left">MESSAGE</h6>
                        <h6 class="written_text_color text-left">PART </h6>
                      </div>
                      <div class="col-md-6 col-6 p-0">
                        <div class="written_text_color">
                          <label class="mtn-3 mb-0">900 </label>
                          <input type="checkbox" name="messageConfirm" class="avcch mtn-3" value="900">
                        </div>
                        <div class="written_text_color">
                          <label class="mtn-1 mb-0">67 </label>
                          <input type="checkbox" name="messageConfirm" class="avcch mtn-1" value="67">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 padding0 d-flex">
                    <div class="col-md-5 col-5 pleftright10">
                      <h6 class=" d-flex">
                      <img src="/assets/images/video.png" class="avcon-img2">
                      <span class="orange mt-2 border-0 avcon-txt1 w-150">Video  &nbsp;</span>
                      </h6>
                    </div>
                    <div class="col-md-7 col-7 mt-2 d-flex">
                      <div class="col-md-6 col-6 p-0">
                        <h6 class="written_text_color text-left">VIDEO</h6>
                        <h6 class="written_text_color text-left">PART </h6>
                      </div>
                      <div class="col-md-6 col-6 p-0">
                        <div class="orange">
                          <label class="mtn-5 mb-0">80</label>
                          <input type="checkbox" name="messageConfirm" class="avcch mtn-5" value="80">
                        </div>
                        <div class="orange">
                          <label class="mtn-4 mb-0">160</label>
                          <input type="checkbox" name="messageConfirm" class="avcch mtn-4" value="160">
                        </div>
                      </div>
                    </div>
                  </div>
                </ul>
                <div class="">
                  <div class="col-md-12 mb-3">
                    <a href="javascript:void(0)" class="btn btn-primary  rounded float-right" id="myLink_33" style="margin-top: 125px;">Go To Booking</a>
                  </div>
                  <div id="modal1" class="modal" tabindex="0">
                    <div class="modal-content">
                      <a href="#!" class=" text-right modal-action modal-close waves-effect waves-green btn-flat">Close</a>
                      <h4 class="text-muted text-center">Report To Medaloda</h4>
                      <p>Email*</p>
                      <form>
                        <div class="form-group form-focus"><input required="" type="email" class="form-control floating">
                        <label class="focus-label">Email</label></div>
                        <button class="btn btn-primary btn-block " type="submit">Send</button>
                      </form>
                    </div>
                  </div></div>
                </div>
              </div>
            </div> -->
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body pt-0">
          <!-- Tab Menu -->
          <nav class="user-tabs mb-4">
            <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
              <li class="nav-item active">
                <a class="nav-link active" href="#doc_overview" data-toggle="tab">Overview</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#doc_locations" data-toggle="tab">Degrees</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#doc_reviews" data-toggle="tab">Reviews</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#doc_business_hours" data-toggle="tab">Extra</a>
              </li>
            </ul>
          </nav>
          <!-- /Tab Menu -->
          <!-- Tab Content -->
          <div class="tab-content pt-0">
            <!-- Overview Content -->
            <?php

         
            if(count($datapublicinfo)>0){


            foreach($datapublicinfo as $data){
//               echo "<pre>"; 
// print_r($data);

$values = explode(',', $data['consultation_id']);
              ?>
            <div role="tabpanel" id="doc_overview" class="tab-pane fade active  in">
              <div class="row">
                <div class="col-md-12 col-lg-12">
                  <!-- Awards Details -->
                  <div class="widget awards-widget">
                    <h4 class="widget-title font-weight-bold">Consultation description</h4>
                    
<?php  
if(in_array(1,$values)) {?>
                    <div style="display:flex;">
                      <div class="experience-box">
                        <div class="widget-title font-weight-bold" style="color:#49b8ae;">Chat:
                        </div>
                      </div>
                      <div class="experience-box">
                        <p>
                          &nbsp;<?php echo $data['consultation_description_message'] ?>
                        </p>
                      </div>
                    </div>
                  <?php } ?>


<?php  
if(in_array(2,$values)){?>
                    <div style="display:flex;">
                      <div class="experience-box">
                        <div class="widget-title font-weight-bold" style="color:#49b8ae;">Chat PART: </div>
                      </div>
                      <div class="experience-box">
                        <p style="margin-bottom:0rem!important">
                          &nbsp;<?php echo $data['consultation_description_message_part'];?>
                        </p>
                      </div>
                    </div>
<?php }?>


<?php  
if(in_array(3,$values)){?>

                     <div style="display:flex;">
                      <div class="experience-box">
                        <div class="widget-title font-weight-bold" style="color:#49b8ae;">Chat FULL: </div>
                      </div>
                      <div class="experience-box">
                        <p style="margin-bottom:0rem!important">
                          &nbsp;<?php echo $data['consultation_description_message_full'];?>
                        </p>
                      </div>
                    </div>
<?php }?>


<?php  
if(in_array(7,$values)){?>


                    <div style="display:flex;">
                      <div class="experience-box">
                        <div class="widget-title font-weight-bold" style="color:#49b8ae;">Audio: </div>
                      </div>
                      <div class="experience-box">
                        <p style="margin-bottom:0rem!important">
                          &nbsp;<?php echo $data['consultation_description_audio'];?>
                        </p>
                      </div>
                    </div>

<?php }?>

<?php  
if(in_array(8,$values)){?>

                    <div style="display:flex;">
                      <div class="experience-box">
                        <div class="widget-title font-weight-bold" style="color:#49b8ae;">Audio PART: </div>
                      </div>
                      <div class="experience-box">
                        <p style="margin-bottom:0rem!important">
                          &nbsp;<?php echo $data['consultation_description_audio_part'];?>
                        </p>
                      </div>
                    </div>
<?php }?>

<?php  
if(in_array(9,$values)){?>

                    <div style="display:flex;">
                      <div class="experience-box">
                        <div class="widget-title font-weight-bold" style="color:#49b8ae;">Audio FULL: </div>
                      </div>
                      <div class="experience-box">
                        <p style="margin-bottom:0rem!important">
                          &nbsp;<?php echo $data['consultation_description_audio_full'];?>
                        </p>
                      </div>
                    </div>
<?php }?>


<?php  
if(in_array(4,$values)){?>

 <div style="display:flex;">
                      <div class="experience-box">
                        <div class="widget-title font-weight-bold" style="color:#49b8ae;">Video : </div>
                      </div>
                      <div class="experience-box">
                        <p style="margin-bottom:0rem!important">
                          &nbsp;<?php echo $data['consultation_description_video'];?>
                        </p>
                      </div>
                    </div>

<?php }?>

<?php  
if(in_array(5,$values)){?>

                    <div style="display:flex;">
                      <div class="experience-box">
                        <div class="widget-title font-weight-bold" style="color:#49b8ae;">Video PART: </div>
                      </div>
                      <div class="experience-box">
                        <p style="margin-bottom:0rem!important">
                          &nbsp;<?php echo $data['consultation_description_video_part'];?>
                        </p>
                      </div>
                    </div>
<?php }?>

<?php  
if(in_array(6,$values)){?>


                    <div style="display:flex;">
                      <div class="experience-box">
                        <div class="widget-title font-weight-bold" style="color:#49b8ae;">Video FULL: </div>
                      </div>
                      <div class="experience-box">
                        <p style="margin-bottom:0rem!important">
                          &nbsp;<?php  if($data['consultation_description_video_full']=='undefined'){ echo $data['consultation_description_video_full']; }?>
                        </p>
                      </div>
                    </div>
<?php }?>

<?php  
if(in_array(10,$values)){?>

                     <div style="display:flex;">
                      <div class="experience-box">
                        <div class="widget-title font-weight-bold" style="color:#49b8ae;">Vivo : </div>
                      </div>
                      <div class="experience-box">
                        <p style="margin-bottom:0rem!important">
                          &nbsp;<?php echo $data['consultation_description_vivo'];?>
                        </p>
                      </div>
                    </div>

<?php }?>


<?php  
if(in_array(11,$values)){?>

                    <div style="display:flex;">
                      <div class="experience-box">
                        <div class="widget-title font-weight-bold" style="color:#49b8ae;">Vivo PART: </div>
                      </div>
                      <div class="experience-box">
                        <p style="margin-bottom:0rem!important">
                          &nbsp;<?php echo $data['consultation_description_vivo_part'];?>
                        </p>
                      </div>
                    </div>
<?php }?>


<?php  
if(in_array(12,$values)){?>

                    <div style="display:flex;">
                      <div class="experience-box">
                        <div class="widget-title font-weight-bold" style="color:#49b8ae;">Vivo FULL: </div>
                      </div>
                      <div class="experience-box">
                        <p style="margin-bottom:0rem!important">
                          &nbsp;<?php echo $data['consultation_description_vivo_full'];?>
                        </p>
                      </div>
                    </div>

                  <?php }?>
                  </div>
                  <!-- About Details -->
                  <div class="widget about-widget">
                    <h4 class="widget-title font-weight-bold">About Me</h4>
                    <p><?php echo $data['about_me'];?></p>
                  </div>
                  <!-- /About Details -->
                  <div class="widget awards-widget">
                    <h4 class="widget-title font-weight-bold">My holistic expertise</h4>
                    <div class="experience-box">
                      <p>
                        <?php echo $data['holistic_expertise'];?>
                      </p>
                    </div>
                  </div>
                  <!-- Education Details -->
                  <div class="widget education-widget">
                    <h4 class="widget-title font-weight-bold">Education</h4>
                    <div class="experience-box">
                      <p>
                        <?php echo $data['education'];?>
                      </p>
                    </div>
                  </div>
                  <!-- /Education Details -->
                  <!-- Experience Details -->
                  <div class="widget experience-widget">
                    <h4 class="widget-title font-weight-bold">Work &amp; Experience</h4>
                    <div class="experience-box">
                      <p>
                        <?php echo $data['work_experience_detail'];?>
                      </p>
                    </div>
                  </div>
                  <!-- /Experience Details -->
                  <div class="widget experience-widget">
                    <h4 class="widget-title font-weight-bold">See presentation videos</h4>
                    <div class="experience-box">
                      <p>
                        <a target="_blank" href="<?php echo $data['presentation_video_url1'];?>"><?php echo $data['presentation_video_url1'];?></a>
                      </p>
                      <p>
                        <a target="_blank" href="<?php echo $data['presentation_video_url2'];?>"><?php echo $data['presentation_video_url2']; ?></a>
                      </p>
                    </div>
                  </div>
                  <div class="widget awards-widget">
                    <h4 class="widget-title font-weight-bold">Languages available for consultation</h4>
                    <div class="experience-box">
                      <p>
                        <?php echo $data['available_languages'];?>
                      </p>
                    </div>
                  </div>
                  <div class="widget awards-widget">
                    <h4 class="widget-title font-weight-bold">Other contributions</h4>
                    <div class="experience-box">
                      <p>
                        <?php echo $data['other_contribution'];?>
                      </p>
                    </div>
                  </div>
                  <div class="widget awards-widget">
                    <h4 class="widget-title font-weight-bold">Mission</h4>
                    <div class="experience-box">
                      <p>
                        <?php echo $data['mission'];?>
                      </p>
                    </div>
                  </div>
                  <!-- /Awards Details -->
                  <div class="widget awards-widget">
                    <h4 class="widget-title font-weight-bold">Comments</h4>
                    <div class="experience-box">
                      <p>
                        <?php echo $data['comments'];?>
                      </p>
                    </div>
                  </div>
                  <div class="widget about-widget">
                    <h4 class="widget-title font-weight-bold">Tags</h4>
                    <p>
                      <span style="color:#507edc !important">
                        <?php $datat= gettagnamebyspcintroid($data['id'],$db);
                        foreach($datat as $val){
                        echo $val[0].',';
                        }
                        ?>
                      </span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <?php } }
            else{?>
            <div role="tabpanel" id="doc_overview" class="tab-pane fade active  in">
              <div class="row">
                <div class="col-md-12 col-lg-12">
                  <!-- Awards Details -->
                  <div class="widget awards-widget">
                    <h4 class="widget-title font-weight-bold">Consultation description</h4>
                    <div style="display:flex;">
                      <div class="experience-box">
                        <div class="widget-title font-weight-bold" style="color:#49b8ae;">Message:
                        </div>
                      </div>
                      <div class="experience-box">
                        <p>
                          &nbsp;
                        </p>
                      </div>
                    </div>
                    <div style="display:flex;">
                      <div class="experience-box">
                        <div class="font-weight-bold" style="color:#49b8ae;">Message PART: </div>
                      </div>
                      <div class="experience-box">
                        <p style="margin-bottom:0rem!important">
                          &nbsp;
                        </p>
                      </div>
                    </div>
                  </div>
                  <!-- About Details -->
                  <div class="widget about-widget">
                    <h4 class="widget-title font-weight-bold">About Me</h4>
                    <p></p>
                  </div>
                  <!-- /About Details -->
                  <div class="widget awards-widget">
                    <h4 class="widget-title font-weight-bold">My holistic expertise</h4>
                    <div class="experience-box">
                      <p>
                        
                      </p>
                    </div>
                  </div>
                  <!-- Education Details -->
                  <div class="widget education-widget">
                    <h4 class="widget-title font-weight-bold">Education</h4>
                    <div class="experience-box">
                      <p>
                        
                      </p>
                    </div>
                  </div>
                  <!-- /Education Details -->
                  <!-- Experience Details -->
                  <div class="widget experience-widget">
                    <h4 class="widget-title font-weight-bold">Work &amp; Experience</h4>
                    <div class="experience-box">
                      <p>
                        
                      </p>
                    </div>
                  </div>
                  <!-- /Experience Details -->
                  <div class="widget experience-widget">
                    <h4 class="widget-title font-weight-bold">See presentation videos</h4>
                    <div class="experience-box">
                      <p>
                        <a target="_blank" href="#"></a>
                      </p>
                      <p>
                        <a target="_blank" href="#"></a>
                      </p>
                    </div>
                  </div>
                  <div class="widget awards-widget">
                    <h4 class="widget-title font-weight-bold">Languages available for consultation</h4>
                    <div class="experience-box">
                      <p>
                        
                      </p>
                    </div>
                  </div>
                  <div class="widget awards-widget">
                    <h4 class="widget-title font-weight-bold">Other contributions</h4>
                    <div class="experience-box">
                      <p>
                        
                      </p>
                    </div>
                  </div>
                  <div class="widget awards-widget">
                    <h4 class="widget-title font-weight-bold">Mission</h4>
                    <div class="experience-box">
                      <p>
                        
                      </p>
                    </div>
                  </div>
                  <!-- /Awards Details -->
                  <div class="widget awards-widget">
                    <h4 class="widget-title font-weight-bold">Comments</h4>
                    <div class="experience-box">
                      <p>
                        
                      </p>
                    </div>
                  </div>
                  <div class="widget about-widget">
                    <h4 class="widget-title font-weight-bold">Tags</h4>
                    <p>
                      <span style="color:#507edc !important">
                        
                      </span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <?php }?>
            <!-- /Overview Content -->
            <div role="tabpanel" id="doc_locations" class="tab-pane fade ">
              <?php
              if(count($datadegree)>0){
              foreach($datadegree as $data1){?>
              <div class="location-list">
                <div class="row">
                  <!-- Clinic Content -->
                  <div class="col-md-8">
                    <div class="clinic-content mt-4">
                      <h3><a href="#">DEGREE TITLE:-</a> <?php echo $data1['degree_title']; ?></h3>
                      <h4>Description:-<?php echo $data1['details']; ?></h4>
                      <h4 style="color:darkgray">Institute:-<?php echo $data1['institute']; ?></h4>
                      <h4 style="font-style:italic">Year:-<?php echo $data1['year']; ?></h4>
                      <h4>Other information:-:-<?php echo $data1['other_information']; ?></h4>
                    </div>
                  </div>
                  <!-- /Clinic Content -->
                  <!-- Clinic Timing -->
                  <div class="col-md-4">
                    <div class="clinic-timing">
                      <a href="" data-toggle="modal" data-target="#dview">


<?php if ($data1['document_file'] != '') { ?>
    <img src="http://<?php echo $_SERVER['HTTP_HOST'] . $port; ?>/public/uploads/docs/<?php echo $data1['document_file']; ?>" height="100" width="100" class="img-fluid border w-75"/>
<?php } else { ?>
    <img src="https://medaloha.cresol.in/assets/images/noimg.jpg" height="100" width="100" class="img-fluid border w-75"/>
<?php } ?>


                      </a>
                    </div>
                  </div>
                  <!-- /Clinic Timing -->
                </div>
              </div>
              <?php }}
              else{?>
              <div class="location-list">
                <div class="row">
                  <!-- Clinic Content -->
                  <div class="col-md-8">
                    <div class="clinic-content mt-4">
                      <h3><a href="#">DEGREE TITLE:-</a> </h3>
                      <h4>Description:-</h4>
                      <h4 style="color:darkgray">Institute:-</h4>
                      <h4 style="font-style:italic">Year:-</h4>
                      <h4>Other information:-:-</h4>
                    </div>
                  </div>
                  <!-- /Clinic Content -->
                  <!-- Clinic Timing -->
                  <div class="col-md-4">
                    <div class="clinic-timing">
                      <a href="" data-toggle="modal" data-target="#dview">
                        
                      </a>
                    </div>
                  </div>
                  <!-- /Clinic Timing -->
                </div>
              </div>
              <?php }?>
            </div>
            <!-- /Location List -->
            <!-- Degree Modal -->
            <!-- Reviews Content -->
            <div role="tabpanel" id="doc_reviews" class="tab-pane fade">
              <?php
              if(count($datareview)>0){
              foreach($datareview as $data1){?>
              <!-- Review Listing -->
              <div class="widget review-listing">
                <ul class="comments-list">
                  <!-- Comment List -->
                  <li>
                    <div class="comment">
                      <?php

// echo "<pre>";
// print_r($data1);

                      $path1='';
                      if($data1['profile_photo']=='')
                      {
                     

                     $path1='https://medalohaadmin.cresol.in/image/user/default_profile.png';
                    
                      }
                      else
                      {
                         $path1='https:///medalohaapi.cresol.in/public/uploads/docs/'.$data1['profile_photo'];
                      }
                      ?>
                      <img class="avatar avatar-sm rounded-circle" alt="User Image" src="<?php echo $path1;?>"/>
                      <div class="comment-body">
                        <div class="meta-data">
                          <span class="comment-author"><?php  echo $data1['u_first_name']?>
                            &nbsp;<?php  echo $data1['u_last_name']?>
                          </span>
                          <span class="comment-date">Nov 2020, Message Consultation
                          </span>
                          <div class="review-count rating">
                            <?php
                            for($i=0;$i<$data1['review_star'];$i++){?>
                            <i class="fa fa-star filled"></i>
                            <?php }?>
                            <?php
                            for($i=0;$i<5-$data1['review_star'];$i++){?>
                            <i class="fa fa-star "></i>
                            <?php }?>
                          </div>
                        </div>
                        
                        <?php if($data1['recommend_status']==1){?>
                        <p class="recommended">
                        <i class="fa fa-thumbs-up" style="font-size: 20px"></i> I recommend this Specialist</p>
                        <?php }
                        else{?>
                        <p class="recommended">
                        <i class="fa fa-thumbs-down" style="font-size: 20px"></i> I don't recommend this Specialist</p>
                        <?php }
                        ?>
                        
                        <p class="comment-content">
                          <?php  echo $data1['review_desc']?>
                        </p>
                      </div>
                    </div>
                    <!-- Comment Reply -->
                    <ul class="comments-reply test">
                      <li>
                        <div class="comment">
                          <?php

// echo "<pre>";
// print_r($data1);
// https://medalohaapi.cresol.in/public/uploads/profile/1708326149694-Koala.jpg

                          $path='';
                          if($data1['u_image']=='')
                          {
                          
                           $path1='https://medalohaadmin.cresol.in/image/user/default_profile.png';
                    
                          }
                          else

                          {
                            
                    
                         $path1='https:///medalohaapi.cresol.in/public/uploads/profile/'.$data1['u_image'];
                          }
                          ?>
                          <img class="avatar avatar-sm rounded-circle" alt="User Image" src="<?php  echo $path1;?>">
                          <div class="comment-body">
                            <div class="meta-data">
                              <span class="comment-author"><?php echo $data1['first_name']; ?>&nbsp; <?php echo $data1['last_name']; ?></span>
                              <span class="comment-date">Specialist</span>
                            </div>
                            <p class="comment-content">
                            </p>
                            <?php echo $data1['reply_desc']; ?>
                            <p></p>
                          </div>
                        </div>
                      </li>
                    </ul>
                    <!-- /Comment Reply -->
                  </li>
                  <!-- /Comment List -->
                  <!-- Comment List -->
                  <!-- /Comment List -->
                </ul>
                <!-- Show All -->
                <!-- /Show All -->
              </div>
              <?php
              $i='';
              if(isset($_GET['id'])&& $_GET['id']!="")
              {
              $i= $_GET['id'];
              }
              $pat='?id='.$i.'&limit=all';
              ?>
              <div class="all-feedback text-center">
                <a href="<?php echo $pat; ?>" class="btn btn-primary btn-sm">
                  Show all feedback <strong>( <?php echo count($datareview1);?> )</strong>
                </a>
              </div>
              <?php }}
              else{?>

              <h3>No Record Found </h3>
            <!--   <div class="widget review-listing">
                <ul class="comments-list">
                  <!-- Comment List -->
                  <!--<li>
                    <div class="comment">
                      <img class="avatar avatar-sm rounded-circle" alt="User Image" src="image\user\default_profile.png"/>
                      <div class="comment-body">
                        <div class="meta-data">
                          <span class="comment-author">first name
                            &nbsp; last name
                          </span>
                          <span class="comment-date"> date
                          </span>
                          <div class="review-count rating" style="left:250px!important">
                            <i class="fa fa-star "></i>
                            <i class="fa fa-star "></i>
                            <i class="fa fa-star "></i>
                            <i class="fa fa-star "></i>
                            <i class="fa fa-star "></i>
                          </div>
                        </div>
                        
                        
                        <p class="comment-content">
                          content
                        </p>
                      </div>
                    </div>
                    <!-- Comment Reply -->
                    <!--<ul class="comments-reply">
                      <li>
                        <div class="comment">
                          <img class="avatar avatar-sm rounded-circle" alt="User Image" src="image\user\default_profile.png">
                          <div class="comment-body">
                            <div class="meta-data">
                              <span class="comment-author">first name&nbsp; last name </span>
                              <span class="comment-date">Specialist</span>
                            </div>
                            <p class="comment-content">
                              content
                            </p>
                            
                            <p></p>
                          </div>
                        </div>
                      </li>
                    </ul>
                    <!-- /Comment Reply -->
                 <!-- </li>
                </ul>
              </div> -->
              <div class="all-feedback text-center">
                <a href="<?php echo $pat; ?>" class="btn btn-primary btn-sm">
                  Show all feedback <strong>(0)</strong>
                </a>
              </div>
              <?php }?>
            </div>
            <?php

          


            if(count($datapublicinfo)>0){


            foreach($datapublicinfo as $data2){
            ?>
            <div role="tabpanel" id="doc_business_hours" class="tab-pane fade">
              <div class="row">
                <div class="col-md-6">
                  <div class="widget business-widget">
                    <div class="widget-content">
                      <h3>Location </h3><hr>
                      <div class="doc-info-cont">
                        <h4 class="doc-name"><?php echo $data2['holistic_center']; ?></h4>
                        <p class="doc-speciality"><?php echo $data2['holistic_location'];?></p>
                        <div class="clinic-details">

                          <p class="doc-location mb-2"><i class="fas fa-map-marker-alt"></i> <?php echo $data2['city_name'].','.$data2['country_name']; ?>-
<?php 
$city = !empty($data2['city_name']) ? $data2['city_name'] : "";
$country = !empty($data2['country_name']) ? $data2['country_name'] : "";
$mapUrl = '';

if (!empty($country) || !empty($city)) {
    $mapUrl = 'https://www.google.com/maps?q=' . urlencode($city) . ',' . urlencode($country);
}
?>

<a href="<?php echo $mapUrl;?>" class="text-info font-weight-bold">Get Direction</a>

                        </p>
                        <ul class="clinic-gallery">
                          <li>
                            <a href="

 <?php
                          $url='';
                          if($data2['activity_image1']=='')
                          {
                         echo  $url='https://medalohaadmin.cresol.in/image/user/default_profile.png';
                          }
                          else
                          {
                          echo $url='https://'.$_SERVER['HTTP_HOST'].$port.'/public/uploads/docs/'.$data2['activity_image1'];
                          }
?>
                            " data-fancybox="gallery">
                              <img src="


 <?php
                          $path='';
                          if($data2['activity_image1']=='')
                          {
                         echo  $path='https://medalohaadmin.cresol.in/image/user/default_profile.png';
                          }
                          else
                          {
                         echo  $path='https://'.$_SERVER['HTTP_HOST'].$port.'/public/uploads/docs/'.$data2['activity_image1'];
                          }
?>

                              " height="68" width="78" alt="Feature">



                            </a>
                          </li>
                          <li>
                            <a href="

 <?php
                          $url='';
                          if($data2['activity_image2']=='')
                          {
                         echo  $url='https://medalohaadmin.cresol.in/image/user/default_profile.png';
                          }
                          else
                          {
                          echo $url='https://'.$_SERVER['HTTP_HOST'].$port.'/public/uploads/docs/'.$data2['activity_image2'];
                          }
?>


                            " data-fancybox="gallery">
                              <img src="

                              <?php
                          $path='';
                          if($data2['activity_image2']=='')
                          {
                         echo  $path='https://medalohaadmin.cresol.in/image/user/default_profile.png';
                          }
                          else
                          {
                         echo  $path='https://'.$_SERVER['HTTP_HOST'].$port.'/public/uploads/docs/'.$data2['activity_image2'];
                          }
?>



                              " height="68" width="68" alt="Feature Image">
                            </a>
                          </li>
                          <li>
                            <a href="

 <?php
                          $url='';
                          if($data2['activity_image3']=='')
                          {
                         echo  $url='https://medalohaadmin.cresol.in/image/user/default_profile.png';
                          }
                          else
                          {
                          echo $url='https://'.$_SERVER['HTTP_HOST'].$port.'/public/uploads/docs/'.$data2['activity_image3'];
                          }
?>
                            " data-fancybox="gallery">
                              <img src="



 <?php
                          $url='';
                          if($data2['activity_image3']=='')
                          {
                         echo  $url='https://medalohaadmin.cresol.in/image/user/default_profile.png';
                          }
                          else
                          {
                          echo $url='https://'.$_SERVER['HTTP_HOST'].$port.'/public/uploads/docs/'.$data2['activity_image3'];
                          }
?>


                              " height="68" width="68" alt="Feature Image">
                            </a>
                          </li>
                          <li>
                            <a href="
 <?php
                          $url='';
                          if($data2['activity_image4']=='')
                          {
                         echo  $url='https://medalohaadmin.cresol.in/image/user/default_profile.png';
                          }
                          else
                          {
                          echo $url='https://'.$_SERVER['HTTP_HOST'].$port.'/public/uploads/docs/'.$data2['activity_image4'];
                          }
?>
                            " data-fancybox="gallery">
                              <img src="
 <?php
                          $url='';
                          if($data2['activity_image4']=='')
                          {
                         echo  $url='https://medalohaadmin.cresol.in/image/user/default_profile.png';
                          }
                          else
                          {
                          echo $url='https://'.$_SERVER['HTTP_HOST'].$port.'/public/uploads/docs/'.$data2['activity_image4'];
                          }
?>" height="68" width="68" alt="Feature Image">
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div></div>
                <div class="col-md-6 ">
                  <!-- Business Hours Widget -->
                  <div class="widget business-widget">
                    <div class="widget-content">
                      <div class="listing-hours">
                        <div class="listing-day current">
                          <h3>Working Time
                          <span class="h6">(Specialist’s Time Zone)</span></h3></div>
        





<?php  

//echo $data2['working_time'];

//$data12=explode('-',$data2['working_time']); 
if (!empty($data2['working_time'])) {
    $workingTimes = explode('||', $data2['working_time']);
    foreach ($workingTimes as $datat) 


{?>
                          <div class="listing-day">
                            <div class="day"> 
                            <?php echo ($datat != 'null' && strlen($datat) > 0) ? substr($datat, 0, strpos($datat, '-')) : ''; ?>




                            </div>

<div class="time-items">
                <span class="time"><?php echo ($datat != 'null' && strlen($datat) > 0) ? substr($datat, strpos($datat, '-') + 1) : ""; ?></span>
            </div>



                            
                         
                          </div>
<?php } }?>

                        </div>
                        <hr>
                        <h4 class="text-center">Time Zone: UTC <?php echo $data2['utc_offset_string']; ?></h4>
                      </div>
                    </div>
                    <!-- /Business Hours Widget -->
                    <?php }}
                    else{?>
                    <div role="tabpanel" id="doc_business_hours" class="tab-pane fade">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="widget business-widget">
                            <div class="widget-content">
                              <h3>Location </h3><hr>
                              <div class="doc-info-cont">
                                <p class="doc-speciality"></p>
                                <div class="clinic-details">
                                  <p class="doc-location mb-2"><i class="fas fa-map-marker-alt"></i> -<a href="" class="text-info font-weight-bold">Get Direction</a>
                                </p>
                                <ul class="clinic-gallery">
                                  <li>
                                    <a href="http://<?php echo $_SERVER['HTTP_HOST'].$port;?>/public/uploads/docs/" data-fancybox="gallery">
                                      <img src="image/user/default_profile.png" height="68" width="78" alt="Feature">
                                    </a>
                                  </li>
                                  <li>
                                    <a href="http://<?php echo $_SERVER['HTTP_HOST'].$port;?>/public/uploads/docs/" data-fancybox="gallery">
                                      <img src="image/user/default_profile.png" height="68" width="68" alt="Feature Image">
                                    </a>
                                  </li>
                                  <li>
                                    <a href="http://<?php echo $_SERVER['HTTP_HOST'].$port;?>/public/uploads/docs/" data-fancybox="gallery">
                                      <img src="image/user/default_profile.png" height="68" width="68" alt="Feature Image">
                                    </a>
                                  </li>
                                  <li>
                                    <a href="http://<?php echo $_SERVER['HTTP_HOST'].$port;?>/public/uploads/docs/" data-fancybox="gallery">
                                      <img src="image/user/default_profile.png" height="68" width="68" alt="Feature Image">
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div></div>
                        <div class="col-md-6 ">
                          <!-- Business Hours Widget -->
                          <div class="widget business-widget">
                            <div class="widget-content">
                              <div class="listing-hours">
                                <div class="listing-day current">
                                  <h3>Working Time
                                  <span class="h6">(Specialist’s Time Zone)</span></h3></div>
                                  <div class="listing-day">
                                    <div class="day">
                                    </div>
                                    <div class="time-items">
                                      <span class="time">-</span>
                                    </div>
                                  </div>
                                </div>
                                <hr>
                                <h4 class="text-center">Time Zone: </h4>
                              </div>
                            </div>
                            <!-- /Business Hours Widget -->
                            <?php }
                            ?>
                          </div>
                        </div>
                      </div>
                      <!-- /Business Hours Content -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </section>
      </div>
      <?php  echo include('footer.php');?>
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
      $(document).ready(function() {
      $(".nav-link").click(function () {
      $(".nav-link").removeClass("active");
      $(this).addClass("active");
      });
      });
      </script>
    </body>
  </html>