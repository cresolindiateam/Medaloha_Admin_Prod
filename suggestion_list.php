<?php
require 'dbconfig.php';
require 'function.php';
session_start();
$db=db_connect();




$case_array = array();

$option=1;
$sql='';

/*print_r($_POST);*/

if(isset($_POST['option']) && $_POST['option']!='')
{
$option=$_POST['option'];

if($option==1)
{
$sql= "SELECT id,name,email,message,created_at FROM `suggestions` ORDER By suggestions.id DESC";
}
 if($option==2)
{
$sql = "SELECT id,name,email,created_at FROM `signup_newsletter` ORDER By signup_newsletter.id DESC";
}
$exe = $db->query($sql);
$data = $exe->fetch_all(MYSQLI_ASSOC);


}
else{
$sql = "SELECT id,name,email,message,created_at FROM `suggestions` ORDER By suggestions.id DESC";
$exe = $db->query($sql);
$datadefault = $exe->fetch_all(MYSQLI_ASSOC);
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

<?php 
              if(isset($_POST['option']) && $_POST['option']!='' && $_POST['option']==2)
                {?>
               Newsletter List
                <?php }
 else if(isset($_POST['option']) && $_POST['option']!='' && $_POST['option']==1)
                {?>
              Suggestion List
                <?php }

                else
                {?>
                 Suggestion List
                <?php }


                ?>

    (<span id="count_row"><?php 

if(isset($_POST['option']) && $_POST['option']!='' && $_POST['option']==2)
                {
                  echo count($data);
                }
               else if(isset($_POST['option']) && $_POST['option']!='' && $_POST['option']==1)
                {
                  echo count($data);
                }
                else
                {
                  echo count($datadefault);
                }

  ?></span>)
    </h1>
    <ol class="breadcrumb">
      <li>
        <span>Admin </span>
      </li>
      <li class="active">
       

        <?php 
              if(isset($_POST['option']) && $_POST['option']!='' && $_POST['option']==2)
                {?>
               <span>Newsletter List</span>
                <?php }
 else if(isset($_POST['option']) && $_POST['option']!='' && $_POST['option']==1)
                {?>
                <span>Suggestion List</span>
                <?php }

                else
                {?>
                 <span>Suggestion List</span>
                <?php }


                ?>

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
                <th>Name</th>
                <th>Email</th>

<?php 
              if(isset($_POST['option']) && $_POST['option']!='' && $_POST['option']==2)
                {?>
              
                <?php }
 else if(isset($_POST['option']) && $_POST['option']!='' && $_POST['option']==1)
                {?>
                <th >Message</th>
                <?php }

                else
                {?>
                <th >Message</th>
                <?php }


                ?>

              </tr>
            </thead>
            <tbody>
              <?php
              
  
                if(isset($_POST['option']) && $_POST['option']!='' && $_POST['option']==2)
                {
              

              foreach ($data as $key =>  $item)
              {
              $id = $item['id'];
              $count=$key+1;
              echo'<tr>';
                echo'<td>'.$count.'</td>';
                echo'<td>'.$item['name'].'</td>';
                echo'<td>'.$item['email'].'</td>';
              
              
                
                 } }

               else if(isset($_POST['option']) && $_POST['option']!='' && $_POST['option']==1)
                {
              

              foreach ($data as $key =>  $item)
              {
              $id = $item['id'];
              $count=$key+1;
              echo'<tr>';
                echo'<td>'.$count.'</td>';
                echo'<td>'.$item['name'].'</td>';
                echo'<td>'.$item['email'].'</td>';
                echo'<td>'.$item['message'].'</td>';
              
                
                 } }
else {
  foreach ($datadefault as $key =>  $item)
              {
              $id = $item['id'];
              $count=$key+1;
              echo'<tr>';
                echo'<td>'.$count.'</td>';
                echo'<td>'.$item['name'].'</td>';
                echo'<td>'.$item['email'].'</td>';
                echo'<td>'.$item['message'].'</td>';
              
                
                 }


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
$("#example1").DataTable({
dom: '<"d-flex w-100"<"lanselect"><f><l><"#mydiv.d-flex ml-auto text-right">>tips',
});

$("div.lanselect").html('<form name="option_form" action="" method="post"><label>Suggestion or Newsletter List:  <select name="option" class="form-control" id="option">Language:-<option value="1" <?php if($option==1){echo 'selected';}?>>Suggestion List</option><option value="2" <?php if($option==2){echo 'selected';}?>>Newsletter</option></select></label></form>');

$('#option').on('change', function() {
document.forms['option_form'].submit();
});
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