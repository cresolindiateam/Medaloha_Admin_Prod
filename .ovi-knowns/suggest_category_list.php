<?php
require 'dbconfig.php';
session_start();
$db=db_connect();
$sql = "SELECT specialist_public_intros.specialist_id,specialist_public_intros.id as suggest_holistic_id,specialist_public_intros.suggest_holistic_field,specialist_private.first_name,specialist_private.last_name,specialist_public_intros.language_id,languages.language_name from specialist_public_intros left join specialist_private on specialist_private.id = specialist_public_intros.specialist_id left join languages on languages.id = specialist_public_intros.language_id where specialist_public_intros.suggest_holistic_field <>''";
$exe = $db->query($sql);
$data = $exe->fetch_all(MYSQLI_ASSOC);
if(isset($_GET['type']) && $_GET['suggest_category_name']!='')
{
if($_GET['type']==1)
{
if(isset($_GET['suggest_category_name']) && $_GET['suggest_category_name']!=''){
$type=$_GET['suggest_category_name'];
if($type!=''){
$name=$_GET['suggest_category_name'];
$language_id=$_GET['language_id'];
$select_status_sql="select category_name,id from categories where category_name='$name'";
$result=    mysqli_query($db,$select_status_sql);
$tagdata = $result->fetch_all(MYSQLI_ASSOC);
if($result->num_rows>0)
{
$c_id=$tagdata[0]['id'];
$update_status_sql="update categories set category_name='$name',language_id='$language_id' where id='$c_id'";
//echo $update_status_sql;die;
mysqli_query($db,$update_status_sql);


$sti=$_GET['suggest_category_id'];
$update_status_sql="update specialist_public_intros set suggest_holistic_field='' where id='$sti'";

mysqli_query($db,$update_status_sql);
$fullurl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$fullpathwithoutquery=explode("?",$fullurl);
echo ("<script>location.href='$fullpathwithoutquery[0]'</script>");
}
else
{
$insert_status_sql="insert into categories(category_name,language_id) values('$name',$language_id)";
mysqli_query($db,$insert_status_sql);


$sti=$_GET['suggest_category_id'];
$update_status_sql="update specialist_public_intros set suggest_holistic_field='' where id='$sti'";
mysqli_query($db,$update_status_sql);



$fullurl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$fullpathwithoutquery=explode("?",$fullurl);
echo ("<script>location.href='$fullpathwithoutquery[0]'</script>");
}
}
}
}
else
{
$name=$_GET['suggest_category_name'];
$select_status_sql="delete from categories where category_name='$name'";
mysqli_query($db,$select_status_sql);
$fullurl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$fullpathwithoutquery=explode("?",$fullurl);
echo ("<script>location.href='$fullpathwithoutquery[0]'</script>");
}
}
?>
<?php include('header.php');?>
<?php include('left_side_bar.php');?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1 >
    Suggest Category List(<span id="count_row"><?php echo count($data) ?></span>)
    </h1>
    <ol class="breadcrumb">
      <li>
        <span>Admin </span>
      </li>
      <li class="active">
        <span>Suggest Category List</span>
      </li>
    </ol>
    
  </section>
  <!-- Main content -->
  <section class="content">
    
    <div class="edit_user_list_modal">
      <div class="modal fade" id="edit_user_list_modal" role="dialog">
        <div class="modal-dialog">
          
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Edit User List</h4>
              <input type="text" class="form-control" id="editUserId" style="display: none;" />
            </div>
            <div class="modal-body">
              <table class="table table-bordered">
                <tr>
                  <th>Employee Name</th>
                  <th>Mobile</th>
                  <th>Email</th>
                  <th>Password</th>
                </tr>
                <tr>
                  
                  <td><input type="text" class="form-control" id="edituserName"/></td>
                  <td><input type="number" class="form-control" id="edituserMobile"  /></td>
                  <td><input type="text" class="form-control" id="edituserEmail"  /></td>
                  <td><input type="text" class="form-control" id="edituserPassword"/></td>
                  
                </tr>
              </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn theme-btn" id="add-employee-list-btn" onClick="editUser();">Save</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
            </div>
          </div>
          
        </div>
      </div>
    </div>
    
    
    <section class="content">
      <div class="row">
        <div class="">
          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    
                    <th>Suggest Category Name</th>
                    <th>Created by</th>
                    <th>Language Name</th>
                    <th width="10%">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($data as $key => $item){
                  
                  
                  $count=$key+1;
                  echo'<tr>';
                    echo'<td>'.$count.'</td>';
                    echo'<td>'.$item['suggest_holistic_field'].'</td>';
                    
                    
                    echo'<td>'.$item['first_name'].$item['last_name'].'</td>';
                    echo'<td>'.$item['language_name'].'</td>';
                    
                    
                    
                    echo '<td>
                      <div class="visible-md visible-lg hidden-sm hidden-xs">';
                        
                        
                        
                        echo "<span class='badge badge-complete'><a href='?type=1&language_id=".$item['language_id']."&suggest_category_name=".$item['suggest_holistic_field']."&suggest_category_id=".$item['suggest_holistic_id']."'>Make Category</a></span>&nbsp;";
                       /* echo "<span class='badge badge-pending'><a href='?type=0&language_id=".$item['language_id']."&suggest_category_name=".$item['suggest_holistic_field']."&suggest_category_id=".$item['suggest_holistic_id']."'>Make Suggest Category</a></span>&nbsp;";*/
                        
                        
                        
                        
                        
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
          </div>
          <!-- /.row -->
        </section>
      </section>
    </div>
    
    
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->
  <!-- jQuery 2.2.3 -->
  <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jQuery/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
  $.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 3.3.6 -->
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <!-- Morris.js charts -->
  <script src="plugins/jQuery/raphael-min.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/jQuery/moment.min.js"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/app.min.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <!-- DataTables -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/app.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <script>
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
  </script>
  <script>
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