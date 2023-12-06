<?php
require 'dbconfig.php';
require 'function.php';
$url = "http://".$_SERVER['HTTP_HOST'].'/admin_login.php';
session_start();
$db=db_connect();
if(isset($_POST['booking_history_id']) && $_POST['booking_history_id']!='')
{
$booking_status=$_POST['status_change_by_admin'];
$booking_id=$_POST['booking_history_id'];
$update_status_sql="update booking_histories set booking_status='$booking_status' where id='$booking_id'";
mysqli_query($db,$update_status_sql);
}
//status 2 for all
$status=2;
$sql = " SELECT booking_histories.id,booking_histories.booking_date,booking_histories.session_date,
booking_histories.booking_price,booking_histories.legend_id,booking_histories.user_id,booking_histories.specialist_id,booking_histories.id as booking_history_id,specialist_public_intros.status as status,booking_histories.booking_status  FROM `booking_histories` left join specialist_public_intros on specialist_public_intros.specialist_id=booking_histories.specialist_id  where 1";
if(isset($_POST['status']) && $_POST['status']!='')
{
$status=$_POST['status'];
if($status==0 ||$status==2)
{
if($status==2)
{
$sql.= "";
}
else{
$sql.= "  and specialist_public_intros.status=".$status;
}
}
else
{
$sql.= " and (booking_histories.booking_status =1 or booking_histories.booking_status =4 or booking_histories.booking_status =3)   and specialist_public_intros.status=".$status;
}
}
else
{
$sql = "SELECT booking_histories.id,booking_histories.booking_date,booking_histories.session_date,
booking_histories.booking_price,booking_histories.legend_id,booking_histories.user_id,booking_histories.specialist_id,booking_histories.id as booking_history_id,specialist_public_intros.status as status,booking_histories.booking_status FROM `booking_histories` left join specialist_public_intros on specialist_public_intros.specialist_id=booking_histories.specialist_id  where 1";
}
$sql.=" ORDER By booking_histories.id DESC";

//echo $sql ;

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
$update_status_sql="update tags set status='$status' where id='$id'";
mysqli_query($db,$update_status_sql);
}
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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1 >
    Booking List (<span id="count_row"><?php echo count($data);?></span>)
    </h1>
    <ol class="breadcrumb">
      <li>
        <span>Admin </span>
      </li>
      <li class="active">
        <span>Booking List</span>
      </li>
    </ol>
    
    
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
                  <div class="col-md-3">
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
    
    
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Image Tag Description</h4>
          </div>
          <div class="modal-body">
            <p id="desc"></p>
            <p id="status"></p>
            <p id="consult"></p>
            <p id="booking_date"></p>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            
          </div>
        </div>
      </div>
    </div>
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
                      <option value="1">Enable</option>
                      <option value="0">Disable</option>
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
                    <th>Specialist Name</th>
                    <th>User Name</th>
                    <th>Consulttation</th>
                    <th>Booking Date</th>
                    <th>Session Date</th>
                    <th>Booking Price</th>
                    <th>Booking Status</th>
                    
                    <th>Action</th>
                    
                  </tr>
                </thead>
                <tbody>
                  <?php
                  
                  foreach ($data as $key => $item){
                  $id = $item['id'];
                  
                  $count=$key+1;
                  $spec_id=$item['specialist_id'];
                  $user_id=$item['user_id'];
                  $url1 = "http://".$_SERVER['HTTP_HOST'].'/specialist_details.php?id='.$spec_id;
                  $url2 = "http://".$_SERVER['HTTP_HOST'].'/user_details.php?id='.$user_id;
                  echo'<tr>';
                    echo'<td>'.$count.'</td>';
                    echo'<td><a href='.$url1.' target="_blank">'.get_table_fieldname_by_id('specialist_private',$item['specialist_id'],$db).'</a></td>';
                    echo'<td><a href='.$url2.' target="_blank">'.get_table_fieldname_by_id('users',$item['user_id'],$db).'</a></td>';
                    echo'<td>'.get_table_fieldname_by_id('legends',$item['legend_id'],$db).'</td>';
                    
                    echo'<td>'.$item['booking_date'].'</td>';
                    echo'<td>'.$item['session_date'].'</td>';
                    echo'<td>'.$item['booking_price'].'</td>';
                    
                    echo '<td>';

   if($item['booking_status']==3){
                        echo  '<span style="color:red">Cancel</span>';
                        }
                        
                        
                       else if($item['booking_status']==1){
                        echo  '<span style="color:orange">Pending</span>';
                        }

                         else if($item['booking_status']==2){
                        echo  '<span style="color:green">Completed</span>';
                        }

                         else if($item['booking_status']==5){
                        echo  '<span style="color:gray">Past</span>';
                        }

                         else if($item['booking_status']==4){
                        echo  '<span class="text-success">Rebook Request <span>';

   if($item['user_rebooking_status']==0){
                        echo  '<span >Cancel</span>';
                        }

                        else if($item['user_rebooking_status']==1){
                        echo  '<span >Accept</span>';
                        }

                        }



                      else{
                        echo  '-';
                        }


                      echo '</td>';
                      
                    
                    echo'<td> <i class="fa fa-eye view-booking-details" onClick="showDetails('.$item['booking_history_id'].')"></i>
                      ';
                      
                      /* echo $status;*/
                      if($status==1){
                      if($item['booking_status']==1 || $item['booking_status']==4 ){
                      ?>
                      <form name="disable_spec_admin_book_status_form" method="post" >
                        <input type ="hidden" name="booking_history_id" value="<?php echo $item['booking_history_id'] ?>">
                        <select class="status_change_by_admin form-control" name="status_change_by_admin">
                          <option value='1'   <?php if($item['booking_status']==1)
                            { echo "selected";
                            }?>
                          >Booking </option>
                          <option value='4'   <?php if($item['booking_status']==4)
                            { echo "selected";
                            }?>
                          >Rebooking </option>
                          <option value='3'   <?php if($item['booking_status']==3)
                            { echo "selected";
                            }?>
                          >Cancel </option>
                        </select></form>
                        
                        <?php
                        }
                        if($item['booking_status']==3){
                        echo  '<button type="button" class="btn open-ClientDialog " onClick="refund('.$item['booking_history_id'].');" >Refund</button>';
                        }
                        }
                        if($status==0){
                        if($item['booking_status']==2){
                        echo  '<button type="button" class="btn theme-btn " onClick="invoice('.$item['booking_history_id'].')">Create Invoice<i class="fa fa-plus-circle"></i></button>';
                        }
                        if($item['booking_status']==3){
                        echo  '<button type="button" class="btn open-ClientDialog " onClick="refund('.$item['booking_history_id'].');" >Refund</button>';
                        }
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
  
  $("#example1").DataTable({
  dom: '<"d-flex w-100"<"lanselect"><f><l><"#mydiv.d-flex ml-auto text-right">>tips',
  });
  $("div.lanselect").html('<form name="filter_form" action="" method="post"><label>Status:  <select name="status" class="form-control" id="status121">Status:-<option  value="2" <?php if($status==2) {echo 'selected';}?> >Status</option><option <?php if($status==0) {echo 'selected';}?>    value="0">Enable</option>";<option   <?php if($status==1) {echo 'selected';}?>   value="1" >Disable</option>"</select></label></form>');
  $('#status121').on('change', function() {
  document.forms['filter_form'].submit();
  });
  });
  function addNewTag(){
  
  var form_data = new FormData(document.querySelector('form'));
  if ($('#tag_name').val()== '') {
  alert("Please Type Tag Name");
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
  function invoice(bookingid){
  
  window.location.href='http://'+window.location.host+'/invoice_view.php?bookingid='+bookingid;
  }
  function refund(bookingid){
  var booking_id=bookingid;
  $.ajax({
  type: 'post',
  url: "Refund_amount.php",
  dataType: 'json',
  data: 'bookingid='+booking_id,
  
  
  success: function(data)
  {
  
  alert(data);
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
  
  $('.status_change_by_admin').on('change', function() {
  document.forms['disable_spec_admin_book_status_form'].submit();
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
  function showDetails(booking_id)
  {
  window.location.href='http://'+window.location.host+'/booking_details_view.php?bookingid='+booking_id;
  
  }
  
  </script>
</body>
</html>