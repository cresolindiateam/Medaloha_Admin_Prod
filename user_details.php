<?php
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
$sql = "select users.id as u_id,users.first_name,users.last_name,
users.email,users.mobile,users.std_code,
users.country_id,users.city_id,users.user_image,users.status,users.dob,users.dob,users.street_address, users.timezone,users.created_at,cities.city_name,countries.country_name from users left join countries on countries.id =users.country_id left join cities on cities.id =users.city_id where users.id =".$_GET['id'];

$exe = $db->query($sql);
$data = $exe->fetch_all(MYSQLI_ASSOC);

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
<div class="content-wrapper">
  <section class="content-header">
    <h1 >
    User Details(<span id="count_row"><?php echo count($data);?></span>)
    </h1>
    <ol class="breadcrumb">
      <li>
        <span>Admin </span>
      </li>
      <li class="active">
        <span>User Details</span>
      </li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="box">
        <div class="col">
          
          <div class="box-body">
              
              <span  style="margin-right:10px;/* color: #fb9678; */"><a href="http://medalohaadmin.cresol.in/user_list.php"><i class=" fa fa-arrow-left" style="color:blue;"></i></a></span>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>User ID</th>
                  <th>Full Name</th>
                  <th>Image</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>Date Of Birth</th>
                  <th>City</th>
                  <th>Country</th>
                  <th>Address</th>
                  <th>Timezone</th>
                  <th>Join Date</th>
                  <th>Status</th>
                  
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($data as $key => $item)
                {
                $count=$key+1;
                echo'<tr>';
                  echo'<td>'.$count.'</td>';
                  echo'<td>'.$item['u_id'].'</td>';
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
                  
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </section>
    </div>
  </div>
  
  
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
  $(document).ready(function() {
  $('input[type=text]').on('change', function() {
  document.forms['percentage_form'].submit();
  });
  });
  </script>
</body>
</html>
<!-- /Footer -->