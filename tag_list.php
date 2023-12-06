<?php
require 'dbconfig.php';
require 'function.php';
$fullurl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  $fullpathwithoutquery=explode("?",$fullurl);
session_start();
$db=db_connect();
$sql = "SELECT id,language_id,tag_name,status,created_at,updated_at FROM `tags` ORDER BY tags.id DESC";
$exe = $db->query($sql);
$data = $exe->fetch_all(MYSQLI_ASSOC);
if(isset($_GET['type']) && $_GET['type']!=''){
$type=$_GET['type'];
if($type=='status'){
$operation=$_GET['operation'];
$id=$_GET['id'];
if($operation=='enabled'){
$status='1';
}else{
$status='0';
}
$update_status_sql="update tags set status='$status',updated_at=now() where id='$id'";
mysqli_query($db,$update_status_sql);
echo "<script>alert('Status Has been Updated.');</script>";
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
    Tag List(<span id="count_row"><?php echo count($data);?></span>)
    </h1>
    <ol class="breadcrumb">
      <li>
        <span>Admin </span>
      </li>
      <li class="active">
        <span>Tag List</span>
      </li>
    </ol>
    
    <button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_tag_list_modal" style="margin-top: 10px;margin-right: 10px;">Create New <i class="fa fa-plus-circle"></i></button>
    
    
  </section>
  <!-- Modal -->
  <div class="add_tag_list_modal">
    <div class="modal fade" id="add_tag_list_modal" role="dialog">
      <div class="modal-dialog">
        
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Create New Tag</h4>
          </div>
          <div class="modal-body">
            <div class="user-info-area">
              <form enctype="multipart/form-data" method="post">
                <div class="row ">
                  <div class="col-md-3">
                    <div class="personal-info-label">Tag Name</div>
                    <input type="text" name="tag_name" class="form-control" id="tag_name"/>
                  </div>
                  <div class="col-md-4">
                    <div class="personal-info-label"> Language</div>
                    <select name="language_list" class="form-control" >
                      <option value="" >Select Language</option>
                      <?php
                      $languagelist=get_table_data('languages',$db);
                      foreach($languagelist as $language){
                      ?>
                      <option value="<?php echo $language['id']; ?>"><?php echo $language['language_name']; ?></option>
                      <?php }
                      ?>
                    </select>
                  </div>
                  
                </div>
                <hr/>
                <div class="row ">
                  
                  
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn theme-btn" id="add-company-btn" onClick="addNewTag();">Create</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
          </div>
        </div>
        
      </div>
    </div>
  </div>
  <!-- Main content -->
  <section class="content">
    
  
    <div class="edit_user_list_modal">
      <div class="modal fade" id="edit_tag_list_modal" role="dialog">
        <div class="modal-dialog">
          
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <p class="test" value="" ></p>
              <h4 class="modal-title">Edit Tag </h4>
              <input type="text" class="form-control" id="editUserId" style="display: none;" />
            </div>
            <div class="modal-body">
              <div class="user-info-area">
                <div class="row ">
                  <div class="col-md-3">
                    <div class="personal-info-label">Tag Name</div>
                    <input type="text" class="form-control" id="edittagName"/>
                  </div>
                  <div class="col-md-3">
                    <div class="personal-info-label"> Language</div>
                    <select name="language_list" id="editlanguageList" class="form-control" >
                      <option value="" >Select Language</option>
                      <?php
                      $languagelist=get_table_data('languages',$db);
                      foreach($languagelist as $language){
                      ?>
                      <option value="<?php echo $language['id']; ?>"><?php echo $language['language_name']; ?></option>
                      <?php }
                      ?>
                    </select>
                  </div>
                  
                  <div class="col-md-3">
                    <div class="personal-info-label">Status</div>
                    <select class="form-control" id="editstatus">
                      <option value="1">Active</option>
                      <option value="0">Deactive</option>
                    </select>
                  </div>
                </div>
                
                <hr/>
                
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn theme-btn" id="add-employee-list-btn" onClick="editTag();">Update</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
            </div>
          </div>
          
        </div>
      </div>
    </div>
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
                  <th>Tag Name</th>
                  <th>Created At</th>
                  
                  
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
              <table id="example1" class="table table-bordered table-striped dataTable no-footer">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Tag Name</th>
                    <th>Language Name</th>
                    <th>Created Date</th>
                    <th>Updated Date</th>
                    <th width="10%">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($data as $key => $item){
                  $id = $item['id'];
                  $name = $item['tag_name'];
                  
                  
                  $count=$key+1;
                  echo'<tr>';
                    echo'<td>'.$count.'</td>';
                    
                    echo'<td>'.$item['tag_name'].'</td>';
                    echo'<td>'.get_table_fieldname_by_id('languages',$item['language_id'],$db).'</td>';
                    echo'<td>'.$item['created_at'].'</td>';
                    echo'<td>'.$item['updated_at'].'</td>';
                    
                    echo'<input type="hidden" value="'.$item['tag_name'].'" id="edittagName'.$item['id'].'"><input type="hidden" value="'.$item['language_id'].'" id="editlanguageList'.$item['id'].'">
                    <input type="hidden" value="'.$item['status'].'" id="editstatus'.$item['id'].'">
                    <input type="hidden" value="'.$item['id'].'" id="editid">
                    ';
                    echo '
                    <td>
                      
                      
                      <button type="button" class="btn open-ClientDialog" data-toggle="modal" data-target="#edit_tag_list_modal" onClick="editTag1('.$item['id'].');" >Edit</button>
                      <div class="visible-md visible-lg hidden-sm hidden-xs">';
                        
                        if($item['status']==1){
                        echo "<span class='badge badge-complete'><a href='?type=status&operation=disabled&id=".$item['id']."'>Active</a></span>&nbsp;";
                        }else{
                        echo "<span class='badge badge-pending'><a href='?type=status&operation=enabled&id=".$item['id']."'>Deactive</a></span>&nbsp;";
                        
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
  function addNewTag(){
  var form_data = new FormData(document.querySelector('form'));
  if ($('#tag_name').val()== '') {
  alert("Please Enter Tag Name");
  }
  else{
  $.ajax({
  url:"AjaxCreateTag.php",
  data:form_data,
  type:'post',
  async: true,
  dataType:'json',
  contentType: false,
  cache: false,
  processData: false,
  success:function(response){
  console.log(response);
  var status=response['Status'];
  alert(response['Message']);
  if(status==1){
  location.reload();
  }
  },
  error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
  }
  });
  }
  }
  function deleteUser(id){
  //alert(id);
  $.ajax({
  url:"deleteUser.php",
  data:{UserId:id},
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
  }
  function editTag(){
  var tag = document.getElementById('edittagName').value;
  var language = document.getElementById('editlanguageList').value;
  var TagId = document.getElementById('editid').value;
  var Status = document.getElementById('editstatus').value;
  $.ajax({
  url:"editTag.php",
  data:{Tag:tag,
  Language:language,
  TagId:TagId,Status:Status},
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
  }
  function editTag1(id){
  var tagname = $("#edittagName"+id).val();
  var languageList = $("#editlanguageList"+id).val();
  var status = $("#editstatus"+id).val();
  $("#editid").val(id);
  $("#edittagName").val(tagname);
  $("#editstatus").val(status);
  $("#editlanguageList").val(languageList);
  }
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