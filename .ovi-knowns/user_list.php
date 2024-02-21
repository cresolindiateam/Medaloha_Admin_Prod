<?php
require 'dbconfig.php';
require 'function.php';
session_start();
$fullurl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$db=db_connect();
$country='';
$status=1;
$consult='';
$date1='';
$date2='';

$sql = "SELECT users.*,cities.city_name,countries.country_name, booking_histories.legend_id FROM `users` left join cities on cities.id=users.city_id  left join countries on countries.id=users.country_id
left join booking_histories on booking_histories.user_id=users.id
where 1";
if(isset($_POST['country']) && $_POST['country']!='')
{
 $country=$_POST['country']; 
 $sql.=" and countries.id=".$country;
}

if(isset($_POST['consult']) && $_POST['consult']!='')
{
 $consult=$_POST['consult']; 
 $sql.=" and booking_histories.legend_id=".$consult;
}

if(isset($_POST['date1']) && $_POST['date1']!='' && isset($_POST['date2']) && $_POST['date2']!='')
{
$date1 = date("Y-m-d", strtotime($_POST['date1']));
$date2 = date("Y-m-d", strtotime($_POST['date2']));
$sql .= " and users.created_at BETWEEN '$date1' AND '$date2'";
  }




if(isset($_POST['status']) && $_POST['status']!='')
{

  $status=$_POST['status']; 
  if($status==1)
  {
    $sql.='';
  }
  else
  {
   $sql.= " and users.status=".$status;
 }
}






else
{
  $sql = "SELECT users.*,cities.city_name,countries.country_name,booking_histories.legend_id FROM `users` left join cities on cities.id=users.city_id  left join countries on countries.id=users.country_id left join booking_histories on booking_histories.user_id=users.id";
}
//echo $sql;
$sql= $sql." group by users.id ORDER BY users.id DESC";

//echo $sql;
$exe = $db->query($sql);
$data = $exe->fetch_all(MYSQLI_ASSOC);

if(isset($_GET['type']) && $_GET['type']!=''){
 $type=$_GET['type'];
 if($type=='status'){
  $operation=$_GET['operation'];
  $id=$_GET['id'];
  if($operation=='active'){
    $status='2';
  }else{
    $status='0';
  }
  $update_status_sql="update users set status='$status' where id='$id'";
  mysqli_query($db,$update_status_sql);

  $fullurl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  $fullpathwithoutquery=explode("?",$fullurl);
  echo "<script> window.location ='".$fullpathwithoutquery[0]."'</script>";
}
}


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
$_SERVER['HTTP_HOST']='localhost'; 
}
?>

<?php include('header.php');?>
<?php include('left_side_bar.php');?>
<style>
  .lanselect
  {
/*float: right!important;*/
width: 52%;

}
#example1_filter input{margin-left: unset!important;margin-right: 20px!important;}

.d-flex{display: flex;}
#example1_length select{width: 90%;margin-left: unset!important;margin-right: 20px!important;}
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1 >
      User List(<span id="count_row"><?php echo count($data);?></span>)
    </h1>

    <ol class="breadcrumb">
      <li>
        <span>Admin </span>
      </li>
      <li class="active">
        <span>User List</span>
      </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="box table-responsive">
       <div class="col">
        <!-- <form name="filter_form1" acrtion="" method="post" style="display: flex;width: 50%;"> -->
          <div class="">

            <div class="col-md-12">

              <!-- <strong>Status</strong> -->
<!--         <select name="status" class="form-control" id="status">Language:-
<option   <?php  

  if($status==2)
  {
 // echo   'selected';
  }


?>  value="2">Status</option>  
<option  <?php  
  if($status== 0)
  {
 // echo   'selected';
  }
 

?>  value="0">Active</option>
<option  <?php  
  if($status== 1)
  {
  //echo   'selected';
  }
 

?>  value="1">Deactive</option>

</select> -->

</div></div>

<div class="">

  <div class="col-md-12">

<!-- <strong>Type Of Consultation</strong>
        <select name="consult" class="form-control" id="consult">Language:-
          <option   value="">All</option> -->
          <?php 

          $sql1 = "SELECT id,legend_name FROM `legends`";
          $exe1 = $db->query($sql1);
          $data1 = $exe1->fetch_all(MYSQLI_ASSOC);

  //foreach ($data1 as $key =>  $item)

  //{?>
  <!--<option <?php  
  if($consult== $item['id'])
  {
 // echo   'selected';
  }
  else
  {
    echo '';
  }

?>  value="<?php //echo $item['id']; ?>"><?php //echo $item['legend_name'];?></option>
  

<?php //}?>

</select>-->

</div></div>
<div class="row">
  <div class="col-md-12">

<!-- <strong>Country</strong>

        <select name="country" class="form-control" id="country">Language:-
  
          <option   value="">All</option> -->
          <?php 

          $sql1 = "SELECT id,country_name FROM `countries`";
          $exe1 = $db->query($sql1);
          $data2 = $exe1->fetch_all(MYSQLI_ASSOC);

  //foreach ($data1 as $key =>  $item)

  //{?>
  <!--<option <?php  
 // if($country== $item['id'])
 // {
  //echo   'selected';
  //}
  //else
 /* {
    echo '';
  }
*/
?>  value="<?php echo $item['id']; ?>"><?php echo $item['country_name'];?></option>
  

<?php //}?>
</select> -->

</div></div>
<!-- </form> -->
<div class="box-body">
  <table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="width: 10px">#</th>
        <th>Name</th>
        <th>Image</th>
        <th>Mobile</th>
        <th>Email</th>
        <th>Date Of Birth</th>
        <th>City</th>
        <th>Country</th>
        <th>Address</th>
        <th>Timezone</th>
        <th>Consultation</th>
        <th>Join Date</th>
        <th>Status</th>
        <th width="10%">Action</th>
      </tr>
    </thead>
    <tbody>
     <?php

     foreach ($data as $key => $item)
     {
      $count=$key+1;
      echo'<tr>'; 
      echo'<td>'.$count.'</td>';

      echo'<td>'.$item['first_name'].' '.$item['last_name'].'</td>';
      $img=$item['user_image'];

      if($img!='')
      {
       echo'<td><div class="yellowish"> 
        <img src="http://'.$_SERVER['HTTP_HOST'].$port.'/public/uploads/profile/'.$img.'" class="img-fluid" alt="user image" height="50" width="50" border="1px solid"/>';
        echo '</div></td>';
      }
      else
      {
        echo '<td><div><img src="http://medalohaadmin.cresol.in/image/user/default_profile.png" class="img-fluid" alt="user image" height="50" width="50" border="1px solid"/>';
        echo '</div></td>';
      }

      echo'<td>'.$item['mobile'].'</td>';
      echo'<td>'.$item['email'].'</td>';
      echo'<td>'.$item['dob'].'</td>';
      echo'<td>'.$item['city_name'].'</td>';
      echo'<td>'.$item['country_name'].'</td>';
      echo'<td>'.$item['street_address'].'</td>';
      echo'<td>'.$item['timezone'].'</td>';
      if(!empty($item['legend_id'])){
      echo'<td>'.get_table_fieldname_by_id('legends',$item['legend_id'],$db).'</td>';
                    }

                    else
                    {
                        echo'<td>-</td>';
                    }

      echo'<td>'.$item['created_at'].'</td>';
      echo'<td>';

    if($item['status']==2){
       
          echo "<span >Active</span>";
      }else  if($item['status']==0) {


         echo "<span >Deactive</span>";
     

      }

      else  {


         echo "<span >-</span>";
     

      }

     echo '</td>';
      echo '<td>
      <div class="visible-md visible-lg hidden-sm hidden-xs">';

      if($item['status']==2){
       
          echo "<span class='badge badge-pending'><a href='?type=status&operation=deactive&id=".$item['id']."'>Deactive</a></span>&nbsp;";
      }else  if($item['status']==0) {


         echo "<span class='badge badge-complete'><a href='?type=status&operation=active&id=".$item['id']."'>Active</a></span>&nbsp;";
     

      }
      
     echo  "<a href='user_details.php?id=".$item['id']."'><i class='fa fa-eye'></i></a>";

      echo '</td>';
    }  
    ?>
  </tbody>

</table>
</div>
</div>
</div>
</section>
</div>

</div>
<?php include('footer.php');?>

<script>
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
    $("#example1").DataTable({
      dom: '<" w-100"<l><"lanselect"><f><"#mydiv.d-flex ml-auto text-right">>tips',
    });
    $("div.lanselect").html('<form name="filter_form" action="" method="post" style="width:100%;display:flex;"><label>Date:<input type="date" class="form-control" placeholder="Start" id="date1" name="date1" value="<?php if(!empty($date1)){echo $date1;}?>"></label><label>To<input type="date" class="form-control" placeholder="End" id="date2" name="date2" value="<?php if(!empty($date2)){echo $date2;}?>"></label><label>Status:-<select name="status" class="form-control" id="status" style="margin-right:25px;">Language:-<option value="1" <?php if($status==1){

      echo 'selected';}?>>All</option><option value="2" <?php if($status==2){echo 'selected';}?>>Activate</option><option value="0" <?php if($status==0){echo 'selected';}?>>Deactivate</option></select></label><label>Country:-<select name="country" class="form-control" id="country" style="margin-right:25px;">Language:-<option value="">All</option><?php foreach ($data2 as $key =>  $item){
      if($country== $item['id'])
      {
        echo "<option  selected    value=".$item['id'].">".$item['country_name']."</option>";}
        else
        {
          echo "<option      value=".$item['id'].">".$item['country_name']."</option>";
        }
      }?></select></label>  <label>Consult Type:-<select name="consult" class="form-control" id="consult" style="margin-right:25px;">Language:-<option value="">All</option><?php foreach ($data1 as $key =>  $item){
        if($consult== $item['id'])
        {
          echo "<option  selected    value=".$item['id'].">".$item['legend_name']."</option>";}
          else
          {
            echo "<option      value=".$item['id'].">".$item['legend_name']."</option>";
          }
        }?></select></label></form>');
    
    $('#date1').on('change', function() {
     //document.forms['filter_form'].submit();

var current=$("#date1").val();
var date2=$("#date2").val();


if(date2){
if(current)
{

document.forms['filter_form'].submit();

}
}

else{
if(current)
{
  $( "#date2" ).focus();
   
     $( "#date1" ).css('border','unset');
}
else
{
  $( "#date1" ).focus();
     $( "#date1" ).css('border','1px solid red');
}

}
     
   });

     $('#date2').on('change', function() {





var date1=$("#date1").val();
 var current=$("#date2").val();    
if(date1){
     

      if(current)
{
  document.forms['filter_form'].submit();
}
else
{
  $( "#date2" ).focus();
     $( "#date2" ).css('border','1px solid red');
}




   }
else
{
  $( "#date1" ).focus();
  $( "#date1" ).css('border','1px solid red');
}




   });

     $('#country').on('change', function() {
     document.forms['filter_form'].submit();
   });

    $('#status').on('change', function() {
     document.forms['filter_form'].submit();
   });
    $('#consult').on('change', function() {
     document.forms['filter_form'].submit();
   });
  });
  $(document).ready(function() {
    $('input[type=search]').on( 'keyup click', function () {
      var rows = document.getElementById('example1').getElementsByTagName('tbody')[0].getElementsByTagName('tr').length;
      if(rows)
      {
        document.getElementById('count_row').textContent=rows;
      }
    } );

  })
</script>
</body>
</html>
