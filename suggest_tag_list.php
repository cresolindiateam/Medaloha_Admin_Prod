<?php
require 'dbconfig.php';
session_start();
$db=db_connect();
$sql = "SELECT specialist_public_intros.specialist_id,specialist_public_intros.id as suggest_tag_id,specialist_public_intros.language_id,languages.language_name,specialist_public_intros.suggest_holistic_field,specialist_public_intros.suggest_tag_field,specialist_private.first_name,specialist_private.last_name from specialist_public_intros left join specialist_private on specialist_private.id = specialist_public_intros.specialist_id left join languages on languages.id = specialist_public_intros.language_id where specialist_public_intros.suggest_tag_field <>''";
$exe = $db->query($sql);
$data = $exe->fetch_all(MYSQLI_ASSOC);



if(isset($_GET['type']) && $_GET['suggest_tag_name']!='')
{

if($_GET['type']==1)
{
if(isset($_GET['suggest_tag_name']) && $_GET['suggest_tag_name']!=''){
$type=$_GET['suggest_tag_name'];
if($type!=''){


$name=$_GET['suggest_tag_name'];
$language_id=$_GET['language_id'];

$select_status_sql="select tag_name,id from tags where tag_name='$name'";
$result=    mysqli_query($db,$select_status_sql);
$tagdata = $result->fetch_all(MYSQLI_ASSOC);
if($result->num_rows>0)
{
$tag_id=$tagdata[0]['id'];
$update_status_sql="update tags set tag_name='$name',language_id='$language_id' where id='$tag_id'";

mysqli_query($db,$update_status_sql);

//remove suggest tag from specialit public
$sti=$_GET['suggest_tag_id'];
$update_status_sql="update specialist_public_intros set suggest_tag_field='' where id='$sti'";


$fullurl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$fullpathwithoutquery=explode("?",$fullurl);
echo ("<script>location.href='$fullpathwithoutquery[0]'</script>");
}
else
{
$insert_status_sql="insert into tags(tag_name,language_id,created_at) values('$name',$language_id,now())";
mysqli_query($db,$insert_status_sql);

//remove suggest tag from specialit public
$sti=$_GET['suggest_tag_id'];
$update_status_sql="update specialist_public_intros set suggest_tag_field='' where id='$sti'";


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
$name=$_GET['suggest_tag_name'];
$select_status_sql="delete from tags where tag_name='$name'";
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
          Suggest Tag List (<span id="count_row"><?php echo count($data) ?></span>)
          </h1>
          <ol class="breadcrumb">
            <li>
              <span>Admin </span>
            </li>
            <li class="active">
              <span>Suggest Tag List</span>
            </li>
          </ol>
          
        </section>
        <!-- Main content -->
        <section class="content">
          <div class="user-info-modal">
            <div class="container">
              <div class="modal fade" id="user-info-modal" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">User Information</h4>
                    </div>
                    <div class="modal-body">
                      <div class="user-info-area">
                        <div class="row ">
                          <div class="col-md-1"><i class="fa fa-user"></i></div>
                          <div class="col-md-9"><span>Shubham Shrivastava</span></div>
                        </div>
                        <hr/>
                        <div class="row ">
                          <div class="col-md-1"><i class="fa fa-phone"></i></div>
                          <div class="col-md-9"><span>9528584788</span></div>
                        </div>
                        <hr/>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn theme-btn " data-dismiss="modal">Okay</button>
                    </div>
                    
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
                          
                          <th>Suggest Tag Name</th>
                          <th>Language</th>
                          <th>Created by</th>
                          
                          
                          
                          <th width="10%">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        foreach ($data as $key => $item){
                        
                        
                        $count=$key+1;
                        echo'<tr>';
                          echo'<td>'.$count.'</td>';
                          echo'<td>'.$item['suggest_tag_field'].'</td>';
                          echo'<td>'.$item['language_name'].'</td>';
                          
                          echo'<td>'.$item['first_name'].$item['last_name'].'</td>';
                          
                          
                          
                          
                          echo '<td>
                            <div class="visible-md visible-lg hidden-sm hidden-xs">';
                              
                              
                              
                              echo "<span class='badge badge-complete'><a href='?type=1&language_id=".$item['language_id']."&suggest_tag_name=".$item['suggest_tag_field']."&suggest_tag_id=".$item['suggest_tag_id']."'>Make Tag</a></span>&nbsp;";
                              /*echo "<span class='badge badge-pending'><a href='?type=0&language_id=".$item['language_id']."&suggest_tag_name=".$item['suggest_tag_field']."&suggest_tag_id=".$item['suggest_tag_id']."'>Make Suggest Tag</a></span>&nbsp;";*/
                              
                              
                              
                              
                              
                            echo '</td>';
                            /*  echo'<td>'.'<input type="hidden" value="'.$name.'" id="name'.$id.'"><input type="hidden" value="'.$mobile.'" id="mobile'.$id.'"><input type="hidden" value="'.$email.'" id="email'.$id.'"><a data-toggle="modal" data-target="#edit_user_list_modal" onClick="editUser1('.$id.');"><i class="fa fa-pencil action-icon-edit"></i></a>&nbsp;&nbsp;<a onClick="deleteUser('.$id.');"><i class="fa fa-trash action-icon-delete"></i></a>'.'</td>';
                          echo'</tr>';*/
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
        
        
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
          <!-- Create the tabs -->
          <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane" id="control-sidebar-home-tab">
              <h3 class="control-sidebar-heading">Recent Activity</h3>
              <ul class="control-sidebar-menu">
                <li>
                  <a href="javascript:void(0)">
                    <i class="menu-icon fa fa-birthday-cake bg-red"></i>
                    <div class="menu-info">
                      <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                      <p>Will be 23 on April 24th</p>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0)">
                    <i class="menu-icon fa fa-user bg-yellow"></i>
                    <div class="menu-info">
                      <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
                      <p>New phone +1(800)555-1234</p>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0)">
                    <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
                    <div class="menu-info">
                      <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
                      <p>nora@example.com</p>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0)">
                    <i class="menu-icon fa fa-file-code-o bg-green"></i>
                    <div class="menu-info">
                      <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
                      <p>Execution time 5 seconds</p>
                    </div>
                  </a>
                </li>
              </ul>
              <!-- /.control-sidebar-menu -->
              <h3 class="control-sidebar-heading">Tasks Progress</h3>
              <ul class="control-sidebar-menu">
                <li>
                  <a href="javascript:void(0)">
                    <h4 class="control-sidebar-subheading">
                    Custom Template Design
                    <span class="label label-danger pull-right">70%</span>
                    </h4>
                    <div class="progress progress-xxs">
                      <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0)">
                    <h4 class="control-sidebar-subheading">
                    Update Resume
                    <span class="label label-success pull-right">95%</span>
                    </h4>
                    <div class="progress progress-xxs">
                      <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0)">
                    <h4 class="control-sidebar-subheading">
                    Laravel Integration
                    <span class="label label-warning pull-right">50%</span>
                    </h4>
                    <div class="progress progress-xxs">
                      <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="javascript:void(0)">
                    <h4 class="control-sidebar-subheading">
                    Back End Framework
                    <span class="label label-primary pull-right">68%</span>
                    </h4>
                    <div class="progress progress-xxs">
                      <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                    </div>
                  </a>
                </li>
              </ul>
              <!-- /.control-sidebar-menu -->
            </div>
            <!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
            <!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
              <form method="post">
                <h3 class="control-sidebar-heading">General Settings</h3>
                <div class="form-group">
                  <label class="control-sidebar-subheading">
                    Report panel usage
                    <input type="checkbox" class="pull-right" checked>
                  </label>
                  <p>
                    Some information about this general settings option
                  </p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label class="control-sidebar-subheading">
                    Allow mail redirect
                    <input type="checkbox" class="pull-right" checked>
                  </label>
                  <p>
                    Other sets of options are available
                  </p>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label class="control-sidebar-subheading">
                    Expose author name in posts
                    <input type="checkbox" class="pull-right" checked>
                  </label>
                  <p>
                    Allow the user to show his name in blog posts
                  </p>
                </div>
                <!-- /.form-group -->
                <h3 class="control-sidebar-heading">Chat Settings</h3>
                <div class="form-group">
                  <label class="control-sidebar-subheading">
                    Show me as online
                    <input type="checkbox" class="pull-right" checked>
                  </label>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label class="control-sidebar-subheading">
                    Turn off notifications
                    <input type="checkbox" class="pull-right">
                  </label>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label class="control-sidebar-subheading">
                    Delete chat history
                    <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                  </label>
                </div>
                <!-- /.form-group -->
              </form>
            </div>
            <!-- /.tab-pane -->
          </div>
        </aside>
        <!-- /.control-sidebar -->
        <!-- Add the sidebar's background. This div must be placed
        immediately after the control sidebar -->
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
      /*
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
      function editUser(){
      var name = document.getElementById('edituserName').value;
      var mobile = document.getElementById('edituserMobile').value;
      var email = document.getElementById('edituserEmail').value;
      var password = document.getElementById('edituserPassword').value;
      var userId = document.getElementById('editUserId').value;
      $.ajax({
      url:"EditUser.php",
      data:{UserName:name,
      UserMobile:mobile,
      UserEmail:email,
      UserPassword:password,
      UserId:userId},
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
      */
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