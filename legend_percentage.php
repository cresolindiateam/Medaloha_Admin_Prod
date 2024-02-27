<?php
require 'dbconfig.php';
require 'function.php';
session_start();
$db=db_connect();
$case_array = array();
//print_r($_POST);
if(isset($_POST['legend']) && $_POST['legend']!=''){
$legend=$_POST['legend'];
foreach($legend as $key=>$l)
{
if($l[0]!='')
{
$sql = "update  legends_commissions set commission_percentage =".$l[0]." where id=".$key;
$exe = $db->query($sql);
}
}
}
$sql = "select id,legends_type,commission_percentage,status,created_at,updated_at from legends_commissions";
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

?>
<?php include('header.php');?>
<?php include('left_side_bar.php');?>
<div class="content-wrapper">
  <section class="content-header">
    <h1 class="make-inline">
    Legend Commision List(<span id="count_row"><?php echo count($data);?></span>)
    </h1>
    <ol class="breadcrumb">
      <li>
        <span>Admin </span>
      </li>
      <li class="active">
        <span>Legend Commision List</span>
      </li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="box">
        <!-- /.box-header -->
        
        <div class="box-body table-responsive">
          <form method="post" name="percentage_form">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Legend ID</th>
                  <th>Legend Name</th>
                  <th>Legend Percentage(%)</th>
                  
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
                  
                  if($item['legends_type']==1)
                  {
                  echo'<td>Message</td>';
                  }
                  if($item['legends_type']==2)
                  {
                  echo'<td>Video</td>';
                  }
                  if($item['legends_type']==3)
                  {
                  echo'<td>In Person</td>';
                  }
                  echo'<td><input id="numberOnlyInput" class="form-control" value='.$item['commission_percentage'].' type ="text" name="legend['.$id.'][]" placeholder="legend_percentage"></td>';
                  
                  ?>
                  <?php } ?>
                </tbody>
              </table>
            </form>
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
        window.onload = function() {
            const numberOnlyInput = document.getElementById('numberOnlyInput');

            numberOnlyInput.addEventListener('input', function(e) {
                // Replace non-digit characters with an empty string
                this.value = this.value.replace(/\D/g, '');
            });
        };
    </script>



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