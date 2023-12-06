<?php
require 'dbconfig.php';
require 'admin.php'; 
session_start();
/*if($_SESSION['username']==""){
  echo "<script> window.location = 'admin_login.php'</script>";
} */


$limit = 1;  // Number of entries to show in a page. 
// Look for a GET variable page if not found default is 1.      
if (isset($_REQUEST["page"])) {  
$pn  = $_GET["page"];  
}  
else {  
$pn=1;  
};  

  $start_from = ($pn-1) * $limit; 

  $db=db_connect(); 


print_r($_REQUEST); 



              $sqlStriing='';
      if(isset($_REQUEST['bank_type']) && $_REQUEST['bank_type']!=''){
      $sqlStriing.= " and Type =".$_REQUEST['bank_type']; 
      }

      if(isset($_REQUEST['StartDate']) && $_REQUEST['StartDate']!='' && isset($_REQUEST['EndDate']) && $_REQUEST['EndDate']!=''){  


           $startDate = $_REQUEST['StartDate'];


     
           $endDate = $_REQUEST['EndDate'];


          $sqlStriing .= " and  Trans_date>= '".date('Y-m-d H:i:s', strtotime($startDate))."' and  Trans_date<= '".date('Y-m-d H:i:s', strtotime($endDate))."' "; 


     }

   /*   if(isset($_REQUEST['no_of_members']) && $_REQUEST['no_of_members']!=''){
      $sqlStriing.= " and cache_user_pod_social_details.added_members=".$_REQUEST['no_of_members']; 
      }

      if(isset($_REQUEST['no_of_trans']) && $_REQUEST['no_of_trans']!=''){
      $sqlStriing.= " and cache_user_pods.number_transactions=".$_REQUEST['no_of_trans']; 
      }*/



 /*
   $sql = "SELECT cache_user_pod_social_details.*,cache_user_pod_social_details.id as data_id ,cache_user_pods.*,user_profile.*,currency_info.* FROM cache_db.cache_user_pod_social_details join cache_db.cache_user_pods  on (cache_user_pods.id =cache_user_pod_social_details.user_pod_id) left join user_profile  on (user_profile.id =cache_user_pods.user_id) left join currency_info  on (currency_info.id =user_profile.currency_id) where 1".$sqlStriing." Limit $start_from , $limit";*/

    $sql = "select * from  Transactions where 1  ".$sqlStriing." Limit $start_from , $limit";
     

$exe = $db->query($sql);  
$data = $exe->fetch_all(MYSQLI_ASSOC); 


   $sql2 = "select  count(Transactions.id) as data_id  from Transactions   where 1  ".$sqlStriing.""; 
 
    $exe2 = $db->query($sql2); 
    $data2 = $exe2->fetch_all(MYSQLI_ASSOC); 
    $total_records= $data2[0]['data_id'];  
?> 
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"> 
  <title>Transactions -Cache Admin</title>
     <?php include('head.php');?> 
<style>
   body{
    padding: 0px !important;
  } 
.printHeading{
  font-size: 1.5em;
}

.table-img{
    width: 60px;
    height: 60px;
}
* {
  box-sizing: border-box;
}

* {
  box-sizing: border-box;
}
a {
  text-decoration: none;
  color: #379937;
}
body {
  margin: 40px;
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
     <div style=""> 
      <h1 class="make-inline">
           Transactions Details
      </h1> 
      <?php echo "<p>Total:"; ?>
      <?php echo $total_records.'</p>'; ?>

       <button class="btn btn-success pull-right" data-toggle="modal" data-target="#addTransactionData"  onclick="addTransaction()">Add</button>
    </div>

<div id="addTransactionData" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add </h4>
      </div>
      <div class="modal-body">
        
        <form id="uploadForm" enctype="multipart/form-data">
          <div class="row">


 <div class="col-md-6">
              <div class="form-group">
              <label>Banks </label>
              <select class="form-control" name="bank" id="bank">
   <option value="">Please Select Bank </option>           
 <?php  
$sql = "select * from  Banks where 1";
     

$exe = $db->query($sql);  
$bankdata = $exe->fetch_all(MYSQLI_ASSOC); 

foreach($bankdata as $row)
{?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['bank_name']; ?></option>
         <?php }?>     

              </select>
              </div>
            </div>

 <div class="col-md-6">
              <div class="form-group">
              <label>Users </label>
              <select class="form-control" name="user" id="user">
   <option value="">Please Select User </option>           
 <?php  
$sql = "select * from  Users where 1";
     

$exe = $db->query($sql);  
$userdata = $exe->fetch_all(MYSQLI_ASSOC); 

foreach($userdata as $row)
{?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['Name']; ?></option>
         <?php }?>     

              </select>
              </div>
            </div>


 <div class="col-md-6">
              <div class="form-group">
              <label>Transaction Date</label>
            <input type="date" name="trans_date" id="trans_date" class="form-control">
            </div>
            </div>

             <div class="col-md-6">
              <div class="form-group">
              <label>Value Date</label>
            <input type="date" name="value_date" id="value_date" class="form-control">
            </div>
            </div>

                 <div class="col-md-6">
              <div class="form-group">
              <label>Bank Transaction Details</label>
            <input type="text" name="bank_trans_details" id="bank_trans_details" class="form-control">
            </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
              <label>More Transaction Details</label>
               <input type="text" name="more_trans_details" id="more_trans_details" class="form-control">
              </div>
            </div>

             <div class="col-md-6">
              <div class="form-group">
              <label>Cheque</label>
               <input type="text" name="Cheque" id="Cheque" class="form-control">
              </div>
            </div>

             <div class="col-md-6">
              <div class="form-group">
              <label>Amount</label>
               <input type="text" name="amount" id="amount" class="form-control">
              </div>
            </div>

             <div class="col-md-6">
              <div class="form-group">
              <label>Type</label>
               

                 <select class="form-control" name="type" id="type">
   <option value="">Please Select</option>
    <option value="1">Credit</option>
     <option value="2">Debit</option>


 </select>
              </div>
            </div>

             <div class="col-md-6">
              <div class="form-group">
              <label>Balance</label>
               <input type="text" name="balance" id="balance" class="form-control">
              </div>
            </div>


            <div class="col-md-6">
              <div class="form-group">
              <label>Document</label>
               <input type="file" name="document_data" id="document_data" class="form-control">
              </div>
            </div>


<!--   <div class="col-md-6">
              <div class="form-group">
              <label>More Transaction Details</label>
              <select class="form-control" name="more_trans_details" id="more_trans_details">
                <option value="1">Admin</option>
              

              </select>
              </div>
            </div>

         -->


         

           
          </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" id="Transactioninsert" class="btn btn-success" data-dismiss="modal">Done</button>


      </div>
    </div>

  </div>
</div>

</section> 
    <!-- Main content -->
 <section class="content">   
 <section class="content">
  <form>
<div class="row">
   <div class="">
          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">
<div class="col-md-3">
<div class="form-group">
<label>Bank Type</label>
      

<select class="form-control" name="bank_type" id="bank_type" value="
<?php if(isset($_REQUEST['bank_type'])) { echo $_REQUEST['bank_type'];}?>">
   <option value="">Please Select Bank TYpe </option> 
   <option value="1">Credeit</option> 
   <option value="2">Debit</option>   
 </select>


</div> 
</div>

<div class="col-md-3">
<div class="form-group">
    <label>From Date(Transaction)</label>
     <input type="date" name="StartDate" value="<?php if(isset($_REQUEST['StartDate'])) {echo $_REQUEST['StartDate'];}?>" class="form-control">


   
</div> 
</div>



<div class="col-md-3">
<div class="form-group">
    <label>To Date(Transaction)</label><input type="date" name="EndDate" value="<?php if(isset($_REQUEST['EndDate'])) {echo $_REQUEST['EndDate'];}?>" class="form-control">
</div>
</div>


</div>
</div> 
</div>
</div>


<?php 

$string='';
if(isset($_REQUEST['StartDate']) &&  $_REQUEST['StartDate']!=""){ 

                  
                      $startDate = $_REQUEST['StartDate'];

                      $string .= '&StartDate='.$startDate;
                   } 

                      
                      if(isset($_REQUEST['EndTime']) && $_REQUEST['EndTime']!='')
                    {
                        $endDate = $_REQUEST['EndDate'];
                        $string .= '&EndDate='.$endDate;
                   } 


                      if(isset($_REQUEST['bank_type']) && $_REQUEST['bank_type']!='')
                    {
                        $bank_type = $_REQUEST['bank_type'];
                        $string .= '&bank_type='.$bank_type;
                   } 


?>
 <button type="submit" name="searchButton" class="btn btn-success">Search </button> 
        <a href="Transactions.php" class="btn btn-danger">Clear</a> 

        
          <a href="Transactions_download.php?page=1<?php echo str_replace("'", "", urldecode($string)); ?>">  <button type="button" class="btn theme-btn pull-right mr-10">Download &nbsp;&nbsp;<i class="fa fa-download"></i></button></a>
        
</form>
 


<form method="post" action="">

  <input type="checkbox" name="b" <?php if (isset($_POST['b'])) echo "value=1"; else echo "value=0"; ?>/>test

<input type="checkbox" name="bank_name" >Bank Name
<input type="checkbox" name="user_name"> User Name
<input type="checkbox" name="transactiondate">TRansaction Date
<input type="checkbox" name="valuedate">Value Date
<input type="checkbox" name="bank_trans_details">Bank Transaction Details
<input type="checkbox" name="more_trans_details">More Transaction Details
<input type="checkbox" name="cheque">Cheque
<input type="checkbox" name="amount">Amount
<input type="checkbox" name="type">Type
<input type="checkbox" name="balance">Balance
<input type="checkbox" name="createdat">Created At
<input type="checkbox" name="updatedat">Updated At
<input type="checkbox" name="document">Document
<input type="checkbox" name="action">Action
<input type="submit" name="save" value="save"/>
</form>


  





<!----- checkox select column -->
      <div class="row">



        <div class="">
          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              <table id="country_table" class="table table-bordered table-striped" >
                <thead>
                <tr> 
                   <th style="width: 10px">#</th>
                   <th class="bank_name">Bank Name</th>
                   <th class="user_name">User Name</th>
                   <th class="transactiondate">Transaction Date</th>
                   <th class="valuedate">Value Date</th>
                   <th class="bank_trans_details">Bank Transaction Details</th>
                   <th class="more_trans_details">More Transaction Details</th>
                   <th class="cheque">Cheque</th>
                   <th class="amount">Amount</th>
                    <th class="type">Type</th>
                   <th class="balance">Balance</th>
                   <th class="createdat">Created At</th>
                   <th class="updatedat">Updated At</th>
                   <th class="document">Document</th>
                   
                   <th class="action" style="width:100px">Action </th>   
                </tr>
                </thead>
                 <tbody> 
                <?php 
                 $counter=1;
            foreach ($data as $k => $item){
              $id = $item['id']; 
            ?>

            <tr id="row<?php echo $item['id'];?>"> 
              <td ><?php echo $counter; ?></td>
             
              <td class="bank_name">
                <span id="Bank_Name<?php echo $item['id'];?>"><?php $a=getbanknamebyid($item['Bank_id'],$db);

echo $a[0]['Bank_name'];
                 ?>
              </span>
              </td>
            
               <td class="user_name">
                <span id="User_Name<?php echo $item['id'];?>">
                  <?php 
                   $b=getusernamebyid($item['User_id'],$db);

echo $b[0]['Name'];
                   ?>
                </span>
              </td >

<td class="transactiondate">
                <span id="Trans_Date<?php echo $item['id'];?>">
                  <?php 
                 echo  $item['Trans_date'];

                   ?>
                </span>
              </td>

              <td class="valuedate">
                <span id="Value_Date<?php echo $item['id'];?>">
                  <?php 
                 echo  $item['Value_Date'];

                   ?>
                </span>
              </td>

                <td class="bank_trans_details">
                <span id="Bank_Transaction_Detail<?php echo $item['id'];?>">
                  <?php 
                 echo  $item['Bank_Transaction_Detail'];

                   ?>
                </span>
              </td>

      <td class="more_trans_details">
                <span id="More_Transaction_Detail<?php echo $item['id'];?>">
                  <?php 
                 echo  $item['More_Transaction_Detail'];

                   ?>
                </span>
              </td>


                    <td class="cheque">
                <span id="Cheque<?php echo $item['id'];?>">
                  <?php 
                 echo  $item['Cheque'];

                   ?>
                </span>
              </td>

 <td class="amount">
                <span id="Amount<?php echo $item['id'];?>">
                  <?php 
                 echo  $item['Amount'];

                   ?>
                </span>
              </td>
 <td class="type">
                <span id="Type<?php echo $item['id'];?>">
                  <?php 
                


                 if($item['Type']==1)
                 {
echo "Credeit";
                 }

                   else if($item['Type']==2)
                 {
echo "Debit";
                 }


                   ?>
                </span>
              </td>



 <td class="balance">
                <span id="Balance<?php echo $item['id'];?>">
                  <?php 
                 echo  $item['Balance'];

                   ?>
                </span>
              </td>




               <td class="createdat">
                 <span id=" Created_at<?php echo $item['id'];?>">
                  <?php $c_a=$item['Created_at'];  
echo $c_a;

                   ?>
                 </span>
               </td>

                <td class="updatedat">
                 <span id="Updated_at<?php echo $item['id'];?>"><?php echo $item['Updated_at']; ?>
                 </span>
               </td>

                  <td class="document">
                 <span id="Document<?php echo $item['id'];?>">


<img src="http://localhost/Admin/viewImage.php?trans_id=<?php echo $id;?>" width="50px;">

                  
                 </span>
               </td>
               
               <td class="action"> 
                <button type="button" name="Button" class="btn btn-danger" onclick="actionDelete(<?php echo   $item['id'];?>)">Delete</button>
          
              </tr>  
                <?php 

                $counter++;
                 }
                ?>
              </tbody> 
              </table> 


   <div class="pull-right">
                  <nav aria-label="Page navigation example">
                  <ul class="pagination">
                  <?php 

                     $string ='';

                 $string ='&searchButton=search'; 



if(isset($_REQUEST['StartDate']) &&  $_REQUEST['StartDate']!=""){ 

                  
                      $startDate = $_REQUEST['StartDate'];

                      $string .= '&StartDate='.$startDate;
                   } 

                      
                      if(isset($_REQUEST['EndDate']) && $_REQUEST['EndDate']!='')
                    {
                        $endDate = $_REQUEST['EndDate'];
                        $string .= '&EndDate='.$endDate;
                   } 


                      if(isset($_REQUEST['bank_type']) && $_REQUEST['bank_type']!='')
                    {
                        $bank_type = $_REQUEST['bank_type'];
                        $string .= '&bank_type='.$bank_type;
                   } 


                 $total_pages = ceil($total_records / $limit);   

                  $pagLink = "";                         
                  for ($i=1; $i<=$total_pages; $i++) { 
                  if ($i==$pn) { 
                  $pagLink .= "<li class='page-item active'><a href='Transactions.php?page="
                                    .$i."".$string."'>".$i."</a></li>"; 
                  }             
                  else  { 
                  $pagLink .= "<li class='page-item'><a href='Transactions.php?page=".$i."".$string."'> 
                                    ".$i."</a></li>";   
                  } 
                  };   
                  echo $pagLink;   
                  ?>
                  </ul>
                  </nav>
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
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>



<!-- ./wrapper --> 
<?php include('innerjsPart.php');?>
<script type="text/javascript">

$('input:checkbox').attr("checked",false).click(function()
{

var shcolumn="."+$(this).attr("name");

$(shcolumn).toggle();
});


</script>
<script type="text/javascript">

$(document).ready(function(){
 

function addTransaction(){



  $('#addTransactionData').modal('toggle');
  $("#Transactioninsert").show();

   //$("#hashtag_name").val("");
   
}
});

function actionDelete(transactionid,status){ 


    var status= 1;
    $.ajax({
        url: "AjaxDeleteTransaction.php?status="+status,
        type: "POST",  
        data: {transactionid:transactionid},
        dataType: 'JSON',

      beforeSend: function(){
          // Show image container
          $("#loader").show();
         },
    
      success: function(data)
        { 
            $("#loader").hide();
          //console.log(data);
          
          if(data){
              alert('Deleted Successfully.');
              setTimeout(function () {
              window.location.href = "Transactions.php"; //will redirect to your blog page (an ex: blog.html)
            }, 2000); //will call the function after 2 secs.
          }
           // $("#EtargetLayer").html(data);
         

        },
        error: function()
        {
        }
     });

}


 $(document).ready(function (e) {
  $("#Transactioninsert").on('click',(function(e) {


     $("#targetLayerError").text('');
    var bank_name  = $("#bank").val();
    if(bank_name==""){
      $("#bank_name").focus();
        $("#targetLayerError").text('Please select Bank.');
      return false; 
    }


     var user  = $("#user").val();
    if(user==""){
      $("#user").focus();
        $("#targetLayerError").text('Please select User.');
      return false; 
    }

/*
var trans_date  = $("#trans_date").val();
var value_date  = $("#value_date").val();
var bank_trans_details  = $("#bank_trans_details").val();
var more_trans_details  = $("#more_trans_details").val();
var Cheque  = $("#Cheque").val();
var Amount  = $("#amount").val();
var Type  = $("#type").val();
var Balance  = $("#balance").val();


var Document = $("#document_data");*/

var formData = new FormData(document.getElementById("uploadForm"));
 
 
    $.ajax({
        url: "insert_transaction.php",
        type: "POST",
        data: formData, 
  
        cache: false,
        contentType: false,
        processData: false,
        success: function(response){
           console.log(response);
          var obj = JSON.parse(response); 
          var status=obj['Status'];
          var message=obj['Message']; 
          alert(message);
          if(status==1)
          {
             location.reload();
          }
        },
        error: function(error){
          console.log(error);
        }           
      });


   
  }));
});
 </script> 


</body>
</html>
