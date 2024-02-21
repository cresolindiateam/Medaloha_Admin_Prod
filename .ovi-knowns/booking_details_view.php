<?php
require 'dbconfig.php';
require 'function.php';
$url = "http://".$_SERVER['HTTP_HOST'].'/Admin/admin_login.php';
session_start();
if($_SESSION['username']==""){
echo "<script> window.location = '".$url."'</script>";
}
$db=db_connect();
$bookingid=$_GET['bookingid'];
$sql = "SELECT booking_histories.*,users.first_name as user_f_name,users.last_name as user_l_name,users.street_address,users.zipcode,users.city_id as u_city_id,users.country_id as u_country_id,specialist_private.first_name,specialist_private.city_id,specialist_private.country_id,specialist_private.last_name,specialist_private.email,specialist_private.mobile,specialist_public_intros.holistic_center,specialist_public_intros.holistic_location FROM booking_histories
left join users on users.id= booking_histories.user_id
left join specialist_private on specialist_private.id= booking_histories.specialist_id
left join specialist_public_intros on specialist_public_intros.specialist_id= booking_histories.specialist_id
where booking_histories.id=".$bookingid;
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
$update_status_sql="update cities set status='$status' where id='$id'";
mysqli_query($db,$update_status_sql);
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
    Booking Details
    </h1>
    <ol class="breadcrumb">
      <li>
        <span>Admin </span>
      </li>
      <li class="active">
        <span>Booking Deatils</span>
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
              <div class="content">
                <div class="container-fluid">
                  <div class="row">
                      <span  style="margin-right:10px;/* color: #fb9678; */"><a href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/booking_list.php"><i class=" fa fa-arrow-left" style="color:blue;"></i></a></span>
                    <div class="col-lg-12">
                      <div class="invoice-content">
                        <div class="invoice-item">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="invoice-logo">
                                <img src="image/logo/logo.png" alt="logo">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <p class="invoice-details">
                                <strong>Booking id:</strong> <?php echo $data[0]['id']?> <br>
                                <strong>Booking Date:</strong> <?php echo $data[0]['booking_date']?>
                                <?php if($data[0]['booking_status']==1){?>
                                <strong>Status:</strong> <strong class="text-primary"><?php echo 'Pending'?></strong>
                                <?php }
                                ?>
                                <?php if($data[0]['booking_status']==2){?>
                                <strong>Status:</strong> <strong class="text-success"><?php echo 'Completed'?></strong>
                                <?php }
                                ?>
                                <?php if($data[0]['booking_status']==3){?>
                                <strong>Status:</strong> <strong class="text-danger"><?php echo 'Cancelled'?></strong>
                                <?php }?>
                                <?php if($data[0]['booking_status']==4){?>
                                <strong>Status:</strong> <strong class="text-primary"><?php echo 'Rebook'?></strong>
                                <?php }?>
                                <?php if($data[0]['booking_status']==5){?>
                                <strong>Status:</strong> <strong class="text-default"><?php echo 'Past'?></strong>
                                <?php }?>
                              </p>
                            </div>
                          </div>
                        </div>
                        
                        
                        <!-- Invoice Item -->
                        <div class="invoice-item invoice-table-wrap">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="table-responsive">
                                <table class="invoice-table table table-bordered">
                                  <thead>
                                    <tr>
                                      <th>Description</th>
                                      <th class="text-center">Quantity</th>
                                      <th class="text-center">VAT</th>
                                      <th class="text-right">Total</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td><?php
                                      echo get_table_fieldname_by_id('legends',$data[0]['legend_id'],$db);?></td>
                                      <td class="text-center">1</td>
                                      <td class="text-center">$0</td>
                                      <td class="text-right"><?php echo '$'.$data[0]['booking_price'];?></td>
                                    </tr>
                                    
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            
                          </div>
                        </div>
                        <!-- /Invoice Item -->
                        
                        <!-- Invoice Information -->
                        <div class="other-info">
                          <h4>Client Notes</h4>
                          <p class="text-muted mb-0"><?php echo $data[0]['client_note']; ?></p>
                        </div>
                        <!-- /Invoice Information -->
                        <!-- Invoice Information -->
                        <div class="other-info">
                          <h4>Private Notes</h4>
                          <p class="text-muted mb-0"><?php echo $data[0]['private_note']; ?></p>
                        </div>
                        <!-- /Invoice Information -->
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
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

window.location.href='http://'+window.location.host+'/Admin/invoice_view.php/?bookingid='+bookingid;
}
function refund(bookingid){

window.location.href='http://'+window.location.host+'/Admin/Refund/?bookingid='+bookingid;
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
</body>
</html>