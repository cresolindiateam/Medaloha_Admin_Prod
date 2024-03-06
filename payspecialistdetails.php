<?php
require 'dbconfig.php';
require 'function.php';

//Enable error reporting for all errors
// error_reporting(E_ALL);

//Display errors on the page (only for development, not for production)
//ini_set('display_errors', 1);

$fullurl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$url = "http://".$_SERVER['HTTP_HOST'].'/admin_login.php';
session_start();
if($_SESSION['username']==""){
  echo "<script> window.location = '".$url."'</script>";
}

$db=db_connect();
$case_array = array();


  // $sql = "SELECT now() as now,DATE_ADD(booking_histories.booking_date, INTERVAL +30 Day) as Date_ADD1,booking_histories.booking_date,booking_histories.id as id, users.first_Name as u_first_name,users.last_Name as u_last_name,users.email as u_email,specialist_private.first_name,specialist_private.last_name,specialist_private.email as spec_email,booking_histories.booking_price FROM `booking_histories` left join users on users.id= booking_histories.user_id left join specialist_private on specialist_private.id= booking_histories.specialist_id where booking_histories.booking_status=2 and  now() < DATE_ADD(booking_histories.booking_date, INTERVAL +30 Day)";



// $exe = $db->query($sql);
// $data1 = $exe->fetch_all(MYSQLI_ASSOC);

  // $sql = "SELECT now(),DATE_ADD(booking_histories.booking_date, INTERVAL +30 Day),booking_histories.booking_date,booking_histories.id as id, users.first_Name as u_first_name,users.last_Name as u_last_name,users.email as u_email,specialist_private.first_name,specialist_private.last_name,specialist_private.email as spec_email FROM `booking_histories` left join users on users.id= booking_histories.user_id left join specialist_private on specialist_private.id= booking_histories.specialist_id where booking_histories.booking_status=2 and  now() > DATE_ADD(booking_histories.booking_date, INTERVAL +30 Day)";



// $exe = $db->query($sql);
// $data = $exe->fetch_all(MYSQLI_ASSOC);


// foreach ($data as $row){


// if(count($data)>0)
// {

//  $sql1 = "update booking_histories set  booking_status=5 where id=".$row['id'];

// echo $sql1;

// $exe1 = $db->query($sql1);
// $data1 = $exe1->fetch_all(MYSQLI_ASSOC);

// }

// }

if(isset($_POST['update']) && $_POST['update']!='')
{
// print_r($_POST);


$bookingid=$_POST['bookingid'];
   $specialistid=$_POST['specialistid'];
   $transactionid=$_POST['transactionid'];
   $status=$_POST['status'];
$query = "SELECT id FROM specialist_transaction_from_medaloha WHERE specialist_id='$specialistid' and booking_id='$bookingid'";

 // echo $query;
// Execute the query
$result1 = $db->query($query);


// Check if there are rows in the result set
if ($result1->num_rows > 0) {

$row = $result1->fetch_assoc();


// print_r($row);die;
$id=$row['id'];

  
 
    $update_status_sql="update specialist_transaction_from_medaloha set  specialist_id='$specialistid', transaction_id='$transactionid', payment_status='$status' where id='$id'";

// echo $update_status_sql;

    mysqli_query($db,$update_status_sql);

  }

  else
  {

$query = "INSERT INTO specialist_transaction_from_medaloha (specialist_id, transaction_id,payment_status,booking_id) VALUES ('$specialistid', '$transactionid','$status','$bookingid')";
// echo $query;die;
// Execute the query
if ($db->query($query) === TRUE) {
    echo "Record inserted successfully.";
}

  }
  
  
}

$specialist_id = '';
if(isset($_GET['specialistid']) && $_GET['specialistid'] != '') {
    $specialist_id = $_GET['specialistid'];
    $pending_status = '0';

    // Use prepared statements to prevent SQL injection
    $sqlAdmin = "SELECT payment_status,transaction_id FROM `specialist_transaction_from_medaloha` WHERE specialist_id = ?";
    $stmt = $db->prepare($sqlAdmin);
    $stmt->bind_param("i", $specialist_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $pending_status = ($data[0]['payment_status'] == 0) ? '0' : '1';
       
    }

    // Close the statement and the database connection
    $stmt->close();
    $db->close();
}

// echo $pending_status;

// echo "ajay";

?>
<?php include('header.php');?>
<?php include('left_side_bar.php');?>
<div class="content-wrapper">
  <section class="content-header">
    <h1 class="make-inline">
      Booking Amount Send To Specialist Deatils(<span id="count_row"><?php echo count($data1);?></span>)
    </h1>

    <ol class="breadcrumb">
      <li>
        <span>Admin </span>
      </li>
      <li class="active">
        <span>Booking Send Amount To Specialist Details</span>
      </li>
    </ol>
  </section>
  <!-- Main content -->

    <section class="content">
      <div class="row">

          <div class="box">
            <!-- /.box-header -->
                     
            <div class="box-body table-responsive">
   

   <form  method="post">
        <label for="bookingid">Booking id:</label>
        <input type="hidden" class="form-control"  id="bookingid" name="bookingid" placeholder="Booking Id" required  value="<?php if(isset($_GET['bookingid']) && $_GET['bookingid']!='') { echo $_GET['bookingid'];}?>">
        <input type="text" class="form-control" disabled id="bookingid" name="bookingid" placeholder="Booking Id" required  value="<?php if(isset($_GET['bookingid']) && $_GET['bookingid']!='') { echo $_GET['bookingid'];}?>">
        
        <br>

        <label for="specialistid">Specialist Id:</label>
        <input type="hidden" class="form-control"  id="specialistid" name="specialistid" placeholder="Specialist Id" required value="<?php if(isset($_GET['specialistid']) && $_GET['specialistid']!='') { echo $_GET['specialistid'];}?>">
        <input type="text" class="form-control" disabled id="specialistid" name="specialistid" placeholder="Specialist Id" required value="<?php if(isset($_GET['specialistid']) && $_GET['specialistid']!='') { echo $_GET['specialistid'];}?>">
        
        <br>

        <label for="specialistname">Specialist Name:</label>
        <input type="text" class="form-control" disabled id="specialistname" name="specialistname" placeholder="Specialist Name" required  value="<?php if(isset($_GET['specialistname']) && $_GET['specialistname']!='') { echo $_GET['specialistname'];}?>">
        
        <br>


        <label for="specialistlastname">Specialist Last Name:</label>
        <input type="hidden" class="form-control"  id="specialistlastname" name="specialistlastname" placeholder="Specialist Name" required  value="<?php if(isset($_GET['specialistlastname']) && $_GET['specialistlastname']!='') { echo $_GET['specialistlastname'];}?>">

        <input type="text" class="form-control" disabled id="specialistlastname" name="specialistlastname" placeholder="Specialist Name" required  value="<?php if(isset($_GET['specialistlastname']) && $_GET['specialistlastname']!='') { echo $_GET['specialistlastname'];}?>">
        
        <br>



         <label for="transactionid">Status:</label>
        <!-- Pending -->
<?php //echo $pending_status?>
        <select name="status">
          <option value="0"  <?php if($pending_status==0){echo 'selected';}?>>Pending</option>
          <option value="1" <?php if($pending_status==1){echo 'selected';}?> >Paid</option>
        </select>

        <br>

         <label for="transactionid">Transaction Id:</label>
        <input type="text" class="form-control"  id="transactionid" name="transactionid" placeholder="Transaction Id" required  value="<?php if($data[0]['transaction_id']!='') { echo $data[0]['transaction_id'];}?>">
        
        <br>



        <input type="submit" value="Update" name="update" />
    </form>
             <!--  <table id="example1" class="table table-bordered table-striped">
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
                  

                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($data1 as $key =>  $item)
                  {

                  $a=floatval($item['booking_price']);
                  $a1=  floatval($item['booking_price'])*15;
                  $b=  $a1/100;
                  $booking_price=$a-$b;

                    $id = $item['id'];
                  $count=$key+1;
                   //  echo'<tr>'; 
                   //  echo'<td>'.$count.'</td>';
                   // echo'<td>'.$item['id'].'</td>';
                   //  echo'<td>'.$item['u_email'].'</td>';
                    
             



if($item['u_first_name']!='')
{
             // echo'<td>'.$item['u_first_name'].' '.$item['u_last_name'].'</td>';
            }
            else
            {
             // echo'<td>-</td>';
            }

 // echo'<td>'.$item['spec_email'].'</td>';
            if($item['first_name']!='')
{
             // echo'<td>'.$item['first_name'].' '.$item['last_name'].'</td>';
                    
}
else
{
  //echo'<td>-</td>';
}

 $end = $item['Date_ADD1'];
 $start = $item['now'];
$diff = (strtotime($end)- strtotime($start))/24/3600; 




//echo '<td>'.round($diff).' Days </td>';

//echo '<td>'.$booking_price.'</td>';



               ?>   
                      <?php } ?>
                  </tbody>
                </table> -->
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
