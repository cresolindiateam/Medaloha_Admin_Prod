<?php
require 'dbconfig.php';
require 'function.php';
session_start();


$db=db_connect();
$sql = "SELECT id,country_name,country_code,country_code_number,status,created_at,updated_at FROM `countries` ORDER BY countries.id DESC";
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
    $update_status_sql="update countries set status='$status',updated_at=now() where id='$id'";
    mysqli_query($db,$update_status_sql);

echo "<script>alert('Status Has been Updated.');</script>";
  $fullurl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
   $fullpathwithoutquery=explode("?",$fullurl);

 echo ("<script>location.href='$fullpathwithoutquery[0]'</script>");
  }
  
}
?>
<?php include('header.php');?>
<?php include('left_side_bar.php');?>
<div class="content-wrapper">
  <section class="content-header" style="padding:15px 15px 20px 15px;">
    <h1 >
      Country List(<span id="count_row"><?php echo count($data);?></span>)
    </h1>
    <ol class="breadcrumb">
      <li>
        <span>Admin </span>
      </li>
      <li class="active">
        <span>Country List</span>
      </li>
    </ol>
    <button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_tag_list_modal" style="margin-top: 10px;margin-right: 10px;">Create New <i class="fa fa-plus-circle"></i>
    </button>
  </section>
  <!-- Modal -->
  <div class="add_tag_list_modal">
    <div class="modal fade" id="add_tag_list_modal" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Create New Country</h4>
          </div>
          <div class="modal-body">
            <div class="user-info-area">
              <form enctype="multipart/form-data" method="post">
                <div class="row ">
                  <div class="col-md-3">
                    <div class="personal-info-label">Country Name</div>
                    <input type="text" name="tag_name" class="form-control" id="tag_name"/>
                  </div> 

                  <div class="col-md-3">
                    <div class="personal-info-label">Country Code</div>
                    <input type="text" name="tag_code" class="form-control" id="tag_name"/>
                  </div> 

                  <div class="col-md-4">
                    <div class="personal-info-label">Country Number</div>
                    <input type="text" name="tag_code_number" class="form-control" id="tag_name"/>
                  </div> 
                </div>
                <hr/>
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

    <div class="edit_user_list_modal">
      <div class="modal fade" id="edit_tag_list_modal" role="dialog">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <p class="test" value="" ></p>
              <h4 class="modal-title">Edit Country </h4>
              <input type="text" class="form-control" id="editUserId" style="display: none;" />
            </div>
            <div class="modal-body">
              <div class="user-info-area">
                <div class="row ">
                  <div class="col-md-3">
                    <div class="personal-info-label">Country Name</div>
                    <input type="text" class="form-control" id="edittagName"/>
                  </div>

                  <div class="col-md-3">
                    <div class="personal-info-label">Country Code</div>
                    <input type="text" class="form-control" id="edittagCode"/>
                  </div>


                  <div class="col-md-3">
                    <div class="personal-info-label">Country Code(Number)</div>
                    <input type="text" class="form-control" id="edittagcodeNumber"/>
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

    <section class="content">
      <div class="row">
      
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped dataTable no-footer">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Country Name</th>
                    <th>Country Code</th>
                    <th>Country Code(Number)</th>
                    <th>Created Date</th>
                    <th>Updated Date</th>
                    <th width="10%">Action</th>
                  </tr>
                </thead>
                <tbody>

                 <?php
                 foreach ($data as $key => $item){
                  $id = $item['id'];
                  $name = $item['country_name'];
                  $count=$key+1; 
                  echo'<tr>'; 
                  echo'<td>'.$count.'</td>';
              
                  echo'<td>'.$item['country_name'].'</td>';
                  echo'<td>'.$item['country_code'].'</td>';
                  echo'<td>'.$item['country_code_number'].'</td>';
                  echo'<td>'.$item['created_at'].'</td>';
                  echo'<td>'.$item['updated_at'].'</td>'; 
                  echo'<input type="hidden" value="'.$item['country_code_number'].'" id="edittagcodeNumber'.$item['id'].'"><input type="hidden" value="'.$item['country_code'].'" id="edittagCode'.$item['id'].'"><input type="hidden" value="'.$item['country_name'].'" id="edittagName'.$item['id'].'">
                  <input type="hidden" value="'.$item['status'].'" id="editstatus'.$item['id'].'">
                  <input type="hidden" value="'.$item['id'].'" id="editid">';
                  echo '<td><button type="button" class="btn open-ClientDialog" data-toggle="modal" data-target="#edit_tag_list_modal" onClick="editTag1('.$item['id'].');" >Edit</button><div class="visible-md visible-lg hidden-sm hidden-xs">';

                  if($item['status']==1)
                  {
                    echo "<span class='badge badge-complete'><a href='?type=status&operation=disabled&id=".$item['id']."'>Active</a></span>&nbsp;";
                  }
                  else
                  {
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
    <!-- /.row -->
  </section>
</div>


</div>
<!-- ./wrapper -->

<?php include('footer.php');?>

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
    alert("Please Enter Country Name");
  }

  else{

  //form_data.append('file',files[0]);

// form_data.append("file", document.getElementById('file').files[0]);
 // alert('statrttt');
 $.ajax({
  url:"AjaxCreateCountry.php", 
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
      var tagcode = document.getElementById('edittagCode').value;

      var tagnumber = document.getElementById('edittagcodeNumber').value;

    var TagId = document.getElementById('editid').value;
    var Status = document.getElementById('editstatus').value;


    $.ajax({
      url:"editCountry.php",
      data:{Tag:tag,Tagcode:tagcode,Tagnumber:tagnumber,

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
     var tagcode = $("#edittagCode"+id).val();
     var tagcodenumber = $("#edittagcodeNumber"+id).val();
    var languageList = $("#editlanguageList"+id).val();
    var status = $("#editstatus"+id).val();

    $("#editid").val(id);

    $("#edittagName").val(tagname);
    $("#edittagCode").val(tagcode);
    $("#edittagcodeNumber").val(tagcodenumber);
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
