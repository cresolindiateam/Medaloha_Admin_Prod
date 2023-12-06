<?php
require 'dbconfig.php';
session_start();

$db=db_connect();
$case_array = array();
$sql = "SELECT id,language_name,language_code,created_at,updated_at,status FROM `languages` ORDER BY languages.id DESC";
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
    $update_status_sql="update languages set status='$status',updated_at=now() where id='$id'";
    mysqli_query($db,$update_status_sql);
    $fullurl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $fullpathwithoutquery=explode("?",$fullurl);
    echo "<script>alert('Status Has been Updated.');</script>";
    echo "<script> window.location ='".$fullpathwithoutquery[0]."'</script>";
  }
  
}
?>
<?php include('header.php');?>
<?php include('left_side_bar.php');?>
<div class="content-wrapper">
  <section class="content-header">
    <h1 class="make-inline">
      Language List(<span id="count_row"><?php echo count($data);?></span>)
    </h1>

    <ol class="breadcrumb">
      <li>
        <span>Admin </span>
      </li>
      <li class="active">
        <span>Language List</span>
      </li>
    </ol>
    <button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_language_list_modal" style="margin-top: 25px;margin-right: 10px;">Create New <i class="fa fa-plus-circle"></i></button>

  </section>

  <!-- Modal -->
  <div class="add_tag_list_modal">
    <div class="modal fade" id="add_language_list_modal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Create New Language</h4>
          </div>
          <div class="modal-body">
            <div class="user-info-area">
              <form enctype="multipart/form-data" method="post">
                <div class="row ">
                  <div class="col-md-5">
                    <div class="personal-info-label">Language Name</div>
                    <input type="text" name="language_name" class="form-control" id="language_name"/>
                  </div> 

                  <div class="col-md-5">
                    <div class="personal-info-label">Language Code</div>
                    <input type="text" name="language_code" class="form-control" id="language_code"/>
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
      <div class="row">
        <div class="box">
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Language Name</th>
                  <th>Language Code</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th width="10%">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($data as $key =>  $item){
                  $id = $item['id'];
                  $name = $item['language_name'];
                  $joinon = $item['created_at'];
                  $count=$key+1;
                  echo'<tr>'; 
                  echo'<td>'.$count.'</td>';
                 
                  echo'<td>'.$item['language_name'].'</td>';
                  echo'<td>'.$item['language_code'].'</td>';
                  echo'<td>'.$item['created_at'].'</td>';
                  echo'<td>'.$item['updated_at'].'</td>';
                  ?>
                  <td>   
                    <div class="visible-md visible-lg hidden-sm hidden-xs">
                      <?php
                      if($item['status']==1){
                        echo "<span class='badge badge-complete'><a href='?type=status&operation=disabled&id=".$item['id']."'>Enable</a></span>&nbsp;";
                      }else{
                        echo "<span class='badge badge-pending'><a href='?type=status&operation=enabled&id=".$item['id']."'>Disable</a></span>&nbsp;";

                      }
                      ?>

                    </td>
                  <?php }?>
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
  <?php include('footer.php');?>

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

    });

    function addNewTag(){ 

     var form_data = new FormData(document.querySelector('form'));  
     if ($('#language_name').val()== '') {
      alert("Please Enter Language Name");
    }

    else{
     $.ajax({
      url:"AjaxCreateLanguage.php", 
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
