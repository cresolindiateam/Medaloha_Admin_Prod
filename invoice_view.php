
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


/*echo "<pre>";
  print_r($data);die;*/

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




<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Medaloha Admin</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include('header.php');?>

 
  <?php include('left_side_bar.php');?>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 >
        Invoice
      </h1>

  <ol class="breadcrumb">
                  <li>
                    <span>Admin </span>
                  </li>
                  <li class="active">
                    <span>Invoice</span>
                  </li>
                </ol>
    

     <!--  <button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_tag_list_modal" style="margin-top: 10px;margin-right: 10px;">Create New <i class="fa fa-plus-circle"></i></button> -->
      
     
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



            <!--   <div class="col-md-3">
                <div class="personal-info-label">First Name</div>
                <input type="text"  name="first_name" class="form-control" id="first_name"/>
              </div> -->

            <!--   <div class="col-md-3">
                <div class="personal-info-label">Last Name</div>
                <input type="text" name="last_name" class="form-control" id="last_name"/>
              </div> -->

              <!-- <div class="col-md-3">
                <div class="personal-info-label">Email</div>
                <input type="text" name="email" class="form-control" id="email"/>
              </div>
            </div> -->
      <!--       <hr/>
 -->
            <!-- <div class="row ">
              <div class="col-md-3">
                <div class="personal-info-label">Phone</div>
                <input type="text" class="form-control" name="phone" id="phone"/>
              </div>  -->
<!-- 
             <div class="col-md-3">
                <div class="personal-info-label">Password</div>
                <input type="text" class="form-control" name="password" id="password"/>
              </div> -->
              
             <!--   <div class="col-md-3">
                <div class="personal-info-label">Con. Password</div>
                <input type="text" class="form-control" name="cpassword" id="cpassword"/>
              </div>

              <div class="col-md-3">
                <div class="personal-info-label">Postal Code</div>
                <input type="text" class="form-control" name="postal_code" id="postal_code"/>
              </div> -->

              <!--  <div class="col-md-3">
                <div class="personal-info-label">Work Rate</div>
                <input type="text" class="form-control" name="work_rate" id="work_rate"/>
              </div> -->
            </div>
            <hr/>

            <div class="row ">
             

              <!-- <div class="col-md-3">
                <div class="personal-info-label">Mileage Rate</div>
                <input type="text" class="form-control" name="mileage_rate" id="mileage_rate"/>
              </div> -->

          <!--     <div class="col-md-3">
                <div class="personal-info-label">Due Date Range</div>
                <input type="text" class="form-control" name="due_date_range" id="due_date_range"/>
              </div> -->

              <!-- <div class="col-md-3"> 
                 <input type="file" name="file" id="file" />
              </div>
 -->
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
						<div class="col-lg-8 offset-lg-2">
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
												<strong>Order:</strong> <?php echo $data[0]['id']?> <br>
												<strong>Issued:</strong> <?php echo $data[0]['booking_date']?>
											</p>
										</div>
									</div>
								</div>
								
								<!-- Invoice Item -->
								<div class="invoice-item">
									<div class="row">
										<div class="col-md-6">
											<div class="invoice-info">
												<strong class="customer-text">Invoice From</strong>
												<p class="invoice-details invoice-details-two">
													<?php echo $data[0]['first_name'].' '.$data[0]['last_name']?> <br>
													

<?php 
echo $data[0]['holistic_center'];
?> 
<?php 

echo $data[0]['holistic_location'];
?>
<br/>
 <?php echo $data[0]['mobile'];?> <br>
												</p>
											</div>
										</div>
										<div class="col-md-6">
											<div class="invoice-info invoice-info2">
												<strong class="customer-text">Invoice To</strong>
												<p class="invoice-details">
													<?php echo $data[0]['user_f_name'].' '.$data[0]['user_l_name'] ?> <br>
													<?php echo $data[0]['street_address'];?>, <?php 
echo get_table_fieldname_by_id('cities',$data[0]['u_city_id'],$db);
?> , <br>
													 <?php  echo $data[0]['zipcode'];?>, 

													<?php 

echo get_table_fieldname_by_id('countries',$data[0]['u_country_id'],$db);
?> <br>
												</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /Invoice Item -->
								
								<!-- Invoice Item -->
								<div class="invoice-item">
									<div class="row">
										<div class="col-md-12">
											<div class="invoice-info">
												<strong class="customer-text">Payment Method</strong>
												<p class="invoice-details invoice-details-two">
													Debit Card <br>
													XXXXXXXXXXXX-2541 <br>
													HDFC Bank<br>
												</p>
											</div>
										</div>
									</div>
								</div>
								<!-- /Invoice Item -->
								
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
										<div class="col-md-6 col-xl-4 ml-auto">
											<div class="table-responsive">
												<table class="invoice-table-two table">
													<tbody>
													<tr>
														<th>Subtotal:</th>
														<td><span><?php echo '$'.$data[0]['booking_price'];?></span></td>
													</tr>
													<tr>
														<th>Discount:</th>
														<td><span>0%</span></td>
													</tr>
													<tr>
														<th>Total Amount:</th>
														<td><span><?php echo '$'.$data[0]['booking_price'];?></span></td>
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
									<h4>Other information</h4>
									<p class="text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sed dictum ligula, cursus blandit risus. Maecenas eget metus non tellus dignissim aliquam ut a ex. Maecenas sed vehicula dui, ac suscipit lacus. Sed finibus leo vitae lorem interdum, eu scelerisque tellus fermentum. Curabitur sit amet lacinia lorem. Nullam finibus pellentesque libero.</p>
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


function addNewTag(){ 
    
 var form_data = new FormData(document.querySelector('form'));  
//  var name = document.getElementById("file").files[0].name;
//  var file_data =  document.getElementById('file').files[0];
//  var files = $('#file')[0].files;
//  alert(files.length);
//  if(files.length == 0 ){ 
//  var ext = name.split('.').pop().toLowerCase();
//   if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
//   {
//   alert("Invalid Image File");
//   }
//   var oFReader = new FileReader();
//   oFReader.readAsDataURL(document.getElementById("file").files[0]);
//   var f = document.getElementById("file").files[0];
//   var fsize = f.size||f.fileSize;
//   if(fsize > 2000000)
//   {
//   alert("Image File Size is very big");
//   }

// }
 //else 
 if ($('#tag_name').val()== '') {
  alert("Please Type Tag Name");
 }
/*else if ($('#email').val()== '') {
  alert("Please Type Email");
 }*/
/* else if ($('#password').val()== '') {
  alert("Please Type password");
 }*/
/* else if ($('#cpassword').val()== '') {
  alert("Please Type confirm password");
 }*/
/*  else if ($('#cpassword').val()!= $('#password').val()) {
  alert("password can't matched");
 } */
else{

  //form_data.append('file',files[0]);

// form_data.append("file", document.getElementById('file').files[0]);
 // alert('statrttt');
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

