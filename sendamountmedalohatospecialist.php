<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require 'dbconfig.php';
require 'function.php';
$fullurl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$url = "http://".$_SERVER['HTTP_HOST'].'/admin_login.php';
session_start();
if($_SESSION['username']==""){
  echo "<script> window.location = '".$url."'</script>";
}

$db=db_connect();
$case_array = array();


  $sql = "SELECT now() as now,DATE_ADD(booking_histories.booking_date, INTERVAL +30 Day) as Date_ADD1,booking_histories.booking_date,booking_histories.id as id, users.first_Name as u_first_name,users.last_Name as u_last_name,users.email as u_email,specialist_private.first_name,specialist_private.last_name,specialist_private.email as spec_email,booking_histories.booking_price FROM `booking_histories` left join users on users.id= booking_histories.user_id left join specialist_private on specialist_private.id= booking_histories.specialist_id where booking_histories.booking_status=2";



$exe = $db->query($sql);
$data1 = $exe->fetch_all(MYSQLI_ASSOC);

  $sql1 = "SELECT now(),DATE_ADD(booking_histories.booking_date, INTERVAL +30 Day),booking_histories.booking_date,booking_histories.id as id, users.first_Name as u_first_name,users.last_Name as u_last_name,users.email as u_email,specialist_private.first_name,specialist_private.last_name,specialist_private.email as spec_email FROM `booking_histories` left join users on users.id= booking_histories.user_id left join specialist_private on specialist_private.id= booking_histories.specialist_id where booking_histories.booking_status=2";



$exe = $db->query($sql1);
$data = $exe->fetch_all(MYSQLI_ASSOC);


foreach ($data1 as $row){


if(count($data)>0)
{

 //$sql1 = "update booking_histories set  booking_status=5 where id=".$row['id'];

// echo $sql1;

$exe1 = $db->query($sql);
$data1 = $exe1->fetch_all(MYSQLI_ASSOC);

}

}

if(isset($_GET['type']) && $_GET['type']!='')
{
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
<div class="content-wrapper">
  <section class="content-header">
    <h1 class="make-inline">
      Booking Amount Send To Specialist List(<span id="count_row"><?php echo count($data1);?></span>)
    </h1>

    <ol class="breadcrumb">
      <li>
        <span>Admin </span>
      </li>
      <li class="active">
        <span>Booking Send Amount To Specialist</span>
      </li>
    </ol>
  </section>
  <!-- Main content -->

    <section class="content">
      <div class="row">

          <div class="box">
            <!-- /.box-header -->
                     
            <div class="box-body table-responsive">
   
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Booking ID</th>
                    <th>User Email</th>
                    <th>User</th>
                    <th>Specialist List</th>
                    <th>Specialist</th>
                    <th>Day Remain to send </th>
                    <th>Amount Remain For Specialist</th>
                     <th>Pay</th>
                  

                  </tr>
                </thead>
                <tbody>
                  <?php
                  
                //   echo "<pre>";
                //   print_r($data1);
                  foreach ($data1 as $key =>  $item)
                  {

                  $a=floatval($item['booking_price']);
                  $a1=  floatval($item['booking_price'])*15;
                  $b=  $a1/100;
                  $booking_price=$a-$b;

                    $id = $item['id'];
                  $count=$key+1;
                    echo'<tr>'; 
                    echo'<td>'.$count.'</td>';
                   echo'<td>'.$item['id'].'</td>';
                    echo'<td>'.$item['u_email'].'</td>';
                    
             



if($item['u_first_name']!='')
{
              echo'<td>'.$item['u_first_name'].' '.$item['u_last_name'].'</td>';
            }
            else
            {
              echo'<td>-</td>';
            }

  echo'<td>'.$item['spec_email'].'</td>';
            if($item['first_name']!='')
{
              echo'<td>'.$item['first_name'].' '.$item['last_name'].'</td>';
                    
}
else
{
  echo'<td>-</td>';
}

 $end = $item['Date_ADD1'];
 $start = $item['booking_date'];
$diff = (strtotime($end)- strtotime($start))/24/3600; 

// $end = strtotime($item['Date_ADD1']);
// $start = strtotime($item['now']);
// $diff_in_seconds = $end - $start;
// $diff = $diff_in_seconds / (24 * 3600);

// $strat_date = new DateTime($item['Date_ADD1']);
// $end_date = new DateTime($item['booking_date']);

// $interval = $end_date->diff($start_date);

// $diff = $interval->days;


  

echo '<td>'.round($diff).' Days </td>';

echo '<td>'.$booking_price.'</td>';
echo '<td>Pay to Specialist</td>';



               ?>   
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

  $('#language').on('change', function() {
     document.forms['language_form'].submit();
  });

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
</script>
<script>
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

</body>
</html>
