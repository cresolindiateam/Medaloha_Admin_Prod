<?php
require 'dbconfig.php';
require 'function.php';
//require 'admin.php';
session_start();

$db=db_connect();
$sql = "SELECT id,language_id,category_image,category_desc,category_name,status,created_at,updated_at FROM `categories` ORDER BY categories.id DESC";
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
$update_status_sql="update categories set status='$status',updated_at=now() where id='$id'";
mysqli_query($db,$update_status_sql);
echo "<script>alert('Status Has been Updated.');</script>";
$fullurl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
 $fullpathwithoutquery=explode("?",$fullurl);

echo ("<script>location.href='$fullpathwithoutquery[0]'</script>");
}

}
?>
<style type="text/css">

.yellowish {
/* box-shadow: inset 2000px 0 0 0 rgba(255, 255, 0, 0.5);*/
border-color: rgba(255, 255, 0, 1);
}
.yellowish {
/*border: solid 15px gray;*/
display: inline-block;
text-align: center;
margin: 1%;
min-width: 50px;
outline: 3px solid #ccc;
width: 10%;
/* background: url(http://lorempixel.com/200/200/nature/5) center no-repeat;*/
background-size: 100 100%;
}
.yellowish:after {
content: '';
display: inline-block;
padding-top: 100%;
vertical-align: middle;
}
</style>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <?php include('header.php');?>
    
    <?php include('left_side_bar.php');?>
    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1 >
        Category List (<span id="count_row"><?php echo count($data); ?></span>)
        </h1>
        <ol class="breadcrumb">
          <li>
            <span>Admin </span>
          </li>
          <li class="active">
            <span>Category List</span>
          </li>
        </ol>
        <!--  <a href="user_list_csv.php"><button class="btn btn-warning pull-right">Export&nbsp;&nbsp;<i class="fa fa-file-excel-o"></i></button></a> -->
        <button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_tag_list_modal" style="margin-top: 10px;margin-right: 10px;">Create New <i class="fa fa-plus-circle"></i></button>
        
        
      </section>
      <div class="edit_user_list_modal">
        <div class="modal fade" id="edit_tag_list_modal" role="dialog">
          <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <p class="test" value="" ></p>
                <h4 class="modal-title">Edit Category </h4>
                <input type="text" class="form-control" id="editUserId" style="display: none;" />
              </div>
              <div class="modal-body">
                <div class="user-info-area">
                  <form enctype="multipart/form-data" method="post" id="editform">
                    <div class="row ">
                      <div class="col-md-4">
                        <div class="personal-info-label">Category Name</div>
                        <input type="text" class="form-control" name="Tag" id="edittagName"/>
                      </div>
                      <div class="col-md-4">
                        <div class="personal-info-label">Description</div>
                        <input type="text" class="form-control" name="editcat_desc" id="editcat_desc"/>
                      </div>
                      <div class="col-md-4">
                        <div class="personal-info-label"> Language</div>
                        <select name="language_list" class="form-control" id="editlanguageList" >
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
                      <input type="hidden" name="TagId" value="" id="TagId">
                      <div class="col-md-3">
                        <div class="personal-info-label">Status</div>
                        <select class="form-control" name="Status" id="editstatus">
                          <option value="1">Active</option>
                          <option value="0">Deactive</option>
                        </select>
                      </div>
                    </div>
                    
                    <hr/>
                    <div class="col-md-3">
                      <div class="personal-info-label">Category Image</div>
                      <input type="file" name="file" id="editfile" />
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn theme-btn" id="add-employee-list-btn" onClick="editTag();">Update</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
                </div>
              </form>
            </div>
            
          </div>
        </div>
      </div>
      <!-- Modal -->
      <div class="add_tag_list_modal">
        <div class="modal fade" id="add_tag_list_modal" role="dialog">
          <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create New Category</h4>
              </div>
              <div class="modal-body">
                <div class="user-info-area">
                  <form enctype="multipart/form-data" method="post" id="addform">
                    <div class="row ">
                      <div class="col-md-4">
                        <div class="personal-info-label">Category Name</div>
                        <input type="text" name="tag_name" class="form-control" id="tag_name"/>
                      </div>
                      <div class="col-md-4">
                        <div class="personal-info-label">Description</div>
                        <input type="text" name="cat_desc" class="form-control" id="cat_desc"/>
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
                      
                      <div class="col-md-4">
                        <div class="personal-info-label">Category Image</div>
                        <input type="file" name="file" id="file" />
                      </div>
                      
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
          <div class="modal fade" id="edit_user_list_modal" role="dialog">
            <div class="modal-dialog">
              
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Category List</h4>
                  
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
                      
                        <th>Category Name</th>
                        <th>Category Description</th>
                        <th>Category Image</th>
                        
                        <th>Created Date</th>
                        <th>Updated Date</th>
                        <th width="10%">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($data as $key => $item){
                      $id = $item['id'];
                      $name = $item['category_name'];
                      $img=  $item['category_image'];
                      
                      $count=$key+1;
                      echo'<tr>';
                        echo'<td>'.$count.'</td>';
                        echo'<td>'.$item['category_name'].'</td>';
                        echo'<td>'.$item['category_desc'].'</td>';
                        
                        if($item['category_image']!=''){
                        echo'<td>
                          <div class="yellowish">
                          <img src="image/category/'.$item['category_image'].'" class="img-fluid" alt="Speciality" height="50" width="50" border="1px solid"></td>';
                          }
                          else
                          {
                          echo'<td>
                            <div class="yellowish">
                            <img src="image/category/default-thumbnail.jpg" class="img-fluid" alt="Speciality" height="50" width="50" border="1px solid"></td>';
                            }
                            echo'<td>'.$item['created_at'].'</td>';
                            echo'<td>'.$item['updated_at'].'</td>';
                            
                          echo '</div><td>
                          <button type="button" class="btn open-ClientDialog" data-toggle="modal" data-target="#edit_tag_list_modal" onClick="editTag1('.$item['id'].');" >Edit</button>
                          <div class="visible-md visible-lg hidden-sm hidden-xs">';
                            
                            if($item['status']==1){
                            echo "<span class='badge badge-complete'><a href='?type=status&operation=disabled&id=".$item['id']."'>Active</a></span>&nbsp;";
                            }else{
                            echo "<span class='badge badge-pending'><a href='?type=status&operation=enabled&id=".$item['id']."'>Deactive</a></span>&nbsp;";
                            
                            }
                            
                            echo'<input type="hidden" value="'.$item['category_name'].'" id="edittagName'.$item['id'].'">
                            <input type="hidden" value="'.$item['status'].'" id="editstatus'.$item['id'].'">
                            <input type="hidden" value="'.$item['category_desc'].'" id="editcategory'.$item['id'].'">
                            <input type="hidden" value="'.$item['language_id'].'" id="editlanguageList'.$item['id'].'">
                            <input type="hidden" value="'.$item['id'].'" id="editid">
                            ';
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
    function addNewTag(){
    
    var form_data = new FormData(document.getElementById("addform"));
    console.log(form_data);
    var files = $('#file')[0].files;
    //  alert(files.length);
    if(files.length > 0 ){
    var name = document.getElementById("file").files[0].name;
    var file_data =  document.getElementById('file').files[0];
    var ext = name.split('.').pop().toLowerCase();
    if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1)
    {
    alert("Invalid Image File");
    }
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("file").files[0]);
    var f = document.getElementById("file").files[0];
    var fsize = f.size||f.fileSize;
    if(fsize > 2000000)
    {
    alert("Image File Size is very big");
    }
    }
    //else
    if ($('#tag_name').val()== '') {
    alert("Please Enter Category Name");
    }
    else{
    console.log(form_data);
    form_data.append('file',files[0]);
    form_data.append("file", document.getElementById('file').files[0]);
    // alert('statrttt');
    $.ajax({
    url:"AjaxCreateCategory.php",
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
    function editTag(){
    var form_data1 = new FormData(document.getElementById("editform"));
    var files = $('#editfile')[0].files;
    //  alert(files.length);
    if(files.length > 0 ){
    var name = document.getElementById("editfile").files[0].name;
    var file_data =  document.getElementById('editfile').files[0];
    var ext = name.split('.').pop().toLowerCase();
    if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1)
    {
    alert("Invalid Image File");
    }
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("editfile").files[0]);
    var f = document.getElementById("editfile").files[0];
    var fsize = f.size||f.fileSize;
    if(fsize > 2000000)
    {
    alert("Image File Size is very big");
    }
    }
    var tag = document.getElementById('edittagName').value;
    
    var TagId = document.getElementById('editid').value;
    var Status = document.getElementById('editstatus').value;
    
    form_data1.append('file',files[0]);
    form_data1.append("file", document.getElementById('editfile').files[0]);
    $.ajax({
    url:"editCategory.php",
    data:form_data1,
    
    type:'post',
    async: true,
    dataType:'json',
    contentType: false,
    cache: false,
    processData: false,
    success:function(response){
    console.log('response');
    console.log(response);
    /*alert(response);
    location.reload();*/
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
    function editTag1(id){
    var tagname = $("#edittagName"+id).val();
    var languageList = $("#editlanguageList"+id).val();
    var status = $("#editstatus"+id).val();
    var catdesc = $("#editcategory"+id).val();
    
    $("#editid").val(id);
    $("#TagId").val(id);
    $("#edittagName").val(tagname);
    $("#editstatus").val(status);
    $("#editlanguageList").val(languageList);
    $("#editcat_desc").val(catdesc);
    
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