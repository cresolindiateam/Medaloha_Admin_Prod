<?php
require 'dbconfig.php';
require 'function.php';
session_start();
$db=db_connect();
$case_array = array();
$sql = "SELECT medaloha_reports.id as id,medaloha_reports.message as report_issue,users.first_Name as u_first_name,users.last_Name as u_last_name,specialist_private.first_name,specialist_private.last_name,medaloha_reports.created_at FROM `medaloha_reports` left join users on users.id= medaloha_reports.user_id left join specialist_private on specialist_private.id= medaloha_reports.specialist_id";
$exe = $db->query($sql);
$data = $exe->fetch_all(MYSQLI_ASSOC);
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
    Report List(<span id="count_row"><?php echo count($data);?></span>)
    </h1>
    <ol class="breadcrumb">
      <li>
        <span>Admin </span>
      </li>
      <li class="active">
        <span>Report List</span>
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
                <th>Report ID</th>
                <!-- <th>Email</th> -->
                <th>Report Message</th>
                <!-- <th>Report To</th> -->
                <th>User</th>
                <th>Specialist</th>
                <th>Created At</th>
                
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($data as $key =>  $item)
              {
              $id = $item['id'];
              $count=$key+1;
              echo'<tr>';
                echo'<td>'.$count.'</td>';
                echo'<td>'.$item['id'].'</td>';
                // echo'<td>'.$item['email'].'</td>';
                echo'<td>'.$item['report_issue'].'</td>';
                
                // if($item['report_to']==0)
                // {
                // echo'<td> User </td>';
                // }
                // if($item['report_to']==1)
                // {
                // echo'<td> Specialist </td>';
                // }
                if($item['u_first_name']!='')
                {
                echo'<td>'.$item['u_first_name'].' '.$item['u_last_name'].'</td>';
                }
                else
                {
                echo'<td>-</td>';
                }
                if($item['first_name']!='')
                {
                echo'<td>'.$item['first_name'].' '.$item['last_name'].'</td>';
                
                }
                else
                {
                echo'<td>-</td>';
                }

                echo'<td>'.$item['created_at'].'</td>';
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