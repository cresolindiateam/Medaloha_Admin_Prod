<?php
ini_set('date.timezone', 'Asia/Kolkata');

require 'dbconfig.php';
require 'admin.php';


session_start();
if($_SESSION['username']==""){
  echo "<script> window.location = 'http://prateekmobile.justevent.in/admin_login.php'</script>";
}


    
  $db=db_connect();


  $sql = "SELECT `RepairingStatus`.`Id`,`RepairingStatus`.`CaseId`,`RepairingStatus`.`UserId`,`RepairingStatus`.`TotalAmount`,`RepairingStatus`.`DeliveryOptions`,`RepairingStatus`.`PickDropStatus`,`RepairingStatus`.`DelBoyId`,`RepairingStatus`.`DelBoyStartTime`,`RepairingStatus`.`DelBoyEndTime`,`RepairingStatus`.`Accessories`,`RepairingStatus`.`TotalAmount`,`RepairingStatus`.`UserSubmitStatus`,`RepairEnquery`.`Description`,`RepairEnquery`.`Location`,`RepairEnquery`.`Brand`,`RepairEnquery`.`Model`,`RepairEnquery`.`Phone`,`RepairEnquery`.`IMEI_Number`,`RepairEnquery`.`Remarks`,`UserProfile`.`First_Name`,`UserProfile`.`Location` FROM`RepairingStatus` LEFT JOIN `RepairEnquery` ON `RepairingStatus`.`CaseId` = `RepairEnquery`.`CaseId` LEFT JOIN `UserProfile` ON `UserProfile`.`Id` = `RepairingStatus`.`UserId` WHERE `RepairingStatus`.`EmployeeId`=0 && `RepairingStatus`.`UserSubmitStatus`!=0 ORDER BY `RepairingStatus`.`Created_At` DESC";


  // $sql = "SELECT Id,CaseId,UserId,TotalAmount,DeliveryOptions,PickDropStatus,DelBoyId,DelBoyStartTime,DelBoyEndTime,Accessories,TotalAmount,UserSubmitStatus FROM `RepairingStatus` WHERE `EmployeeId`=0 && `UserSubmitStatus`!=0 ORDER BY `Created_At` DESC";
  
  $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_ASSOC);

  // foreach ($data as $key => $value){
  //     $caseId=$value['CaseId'];
  //     $userId=$value['UserId'];

  //     $sqldescription="SELECT Description,Location,Brand,Model,Phone,IMEI_Number,Remarks FROM `RepairEnquery` where `CaseId`='$caseId'";
  //       $exe1 = $db->query($sqldescription);

  //       if($exe1->num_rows > 0){
  //         $result1 = $exe1->fetch_all(MYSQLI_ASSOC);
  //          foreach ($result1 as $key1 => $value1){
  //           $data[$key]['Description']= $value1['Description'];
  //           $data[$key]['Location']= $value1['Location'];
  //           $data[$key]['Brand']= $value1['Brand'];
  //           $data[$key]['Model']= $value1['Model'];
  //           $data[$key]['Phone']= $value1['Phone'];
  //           $data[$key]['IMEI_Number']= $value1['IMEI_Number'];
  //           $data[$key]['Remarks']= $value1['Remarks'];
            
  //       }
  //     }
  //     else{
  //           $data[$key]['Description']= "";
  //           $data[$key]['Location']= "";
  //           $data[$key]['Brand']= "";
  //           $data[$key]['Model']= "";
  //           $data[$key]['Phone']= "";
  //           $data[$key]['IMEI_Number']= "";
  //           $data[$key]['Remarks']= "";
  //     }


  //     $sqlName="SELECT First_Name,Location FROM `UserProfile` where `Id`='$userId'";
  //     $exe2 = $db->query($sqlName);

  //     if($exe2->num_rows > 0){
  //         $result2 = $exe2->fetch_all(MYSQLI_ASSOC);
  //          foreach ($result2 as $key2 => $value2){
  //           $data[$key]['First_Name']= $value2['First_Name'];
  //           $data[$key]['User_Location']= $value2['Location'];
  //         }
  //     }
  //     else{
  //           $data[$key]['First_Name']= "";
  //           $data[$key]['User_Location']= "";
  //     }
  //   }



  $sqlEmp = "SELECT Id,First_Name FROM `UserProfile` WHERE `UserType`=2 && `DeleteStatus`=0";
  $exeEmp = $db->query($sqlEmp);
  $dataEng = $exeEmp->fetch_all(MYSQLI_ASSOC);

  $sqlDelBoy = "SELECT Id,First_Name FROM `UserProfile` WHERE `UserType`=3 && `DeleteStatus`=0";
  $exeDelBoy = $db->query($sqlDelBoy);
  $dataDelBoy = $exeDelBoy->fetch_all(MYSQLI_ASSOC);

  $sqlAdmin="SELECT First_Name,Last_Name FROM `Admin_Info`";
  $exeAdmin = $db->query($sqlAdmin);
  $dataAdmin = $exeAdmin->fetch_all(MYSQLI_ASSOC);

?>







<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  
  <title>Prateek Mobile</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
</head>

<style>
   body{
    padding: 0px !important;
  }


.printHeading{
  font-size: 1.5em;
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
      <h1 class="make-inline">
        Repairing Queries
      </h1>

      <a href="approved_inquiries_csv.php"><button class="btn btn-warning pull-right"> Export &nbsp;&nbsp;<i class="fa fa-file-excel-o"></i></button></a>
     


      
       <button type="button" class="btn theme-btn pull-right mr-10" data-toggle="modal" data-target="#new-approved-inquiry" style>Create New &nbsp;&nbsp;<i class="fa fa-plus-circle"></i></button>
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

          <div class="col-md-9">
          <div class="personal-info-label">Name</div>
          <input type="text" class="form-control" id="name"/>
          <input type="hidden" class="form-control" id="userid1"/>
        
          </div>

        </div>
        <hr/>
         <div class="row ">
          <div class="col-md-1"><i class="fa fa-phone"></i></div>

          <div class="col-md-9">
          <div class="personal-info-label">Mobile</div>
          <input type="text" class="form-control" id="mobile"/>
          </div>

        </div>
        <hr/>

        <div class="row ">
          <div class="col-md-1"><i class="fa fa-envelope"></i></div>

          <div class="col-md-9">
          <div class="personal-info-label">Address</div>
          <input type="text" class="form-control" id="email"/>
          </div>

        </div>
        <hr/>
        </div>
        </div>
         <div class="modal-footer">
          <button type="button" class="btn theme-btn " data-dismiss="modal" onclick="updateUserInfo();">Update</button>
        </div>
      
      </div>
      
    </div>
  </div>
</div>
</div>




<div class="case-delivery-boy-model popup-info-modal" >
      <div class="container">
  <div class="modal fade" id="case-delivery-boy-model" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Mobile Picking Information</h4>
        </div>
        <div class="modal-body">
         <div class="user-info-area">
          
          <div class="row">
            <div class="col-md-6">
            <div class="row ">
            <div class="col-md-1"><i class="fa fa-briefcase"></i></div>
            <div class="col-md-9">
            <div class="popup-info-label">Job Id</div>
            <div class="popup-info-answer"><span id="caseid"></span></div>
            </div>
            </div>
            </div>
            <div class="col-md-6">
             <div class="row ">
          <div class="col-md-1"><i class="fa fa-map-marker"></i></div>
          <div class="col-md-9">
          <div class="popup-info-label">Location</div>
           <div class="popup-info-answer"><span id="location"></span></div>
          </div>
        </div>
            </div>
          </div>

        
        <hr/>

       <div class="row">
         <div class="col-md-6">
           <div class="row ">
          <div class="col-md-1"><i class="fa fa-male"></i></div>
          <div class="col-md-9">
          <div class="popup-info-label">Select Delivery Boy</div>
          <div class="popup-info-answer"><select class="form-control delivery-boy-dropdown" id="select_deliveryBoy" name="select_deliveryBoy">  
                         <?php foreach($dataDelBoy as $k2 => $v2){?>
                         <option value="<?php echo $v2['Id'];?>"><?php echo $v2['Id'];?> - <?php echo $v2['First_Name'];?></option>
                         <?php } ?>
                    </select> </div>
        </div>
        
        </div>
         </div>

         <div class="col-md-6">
            <div class="row ">
          <div class="col-md-1"><i class="fa fa-hourglass-half"></i></div>
          <div class="col-md-9">
          <div class="popup-info-label">Pic Status</div>
          <div class="popup-info-answer"><span id="pick_status"></span></div>
          </div>
        </div>
         </div>
       </div>
        <hr/>

        <div class="row">
          <div class="col-md-6">
        <div class="row ">
          <div class="col-md-1"><i class="fa fa-clock-o"></i></div>
          <div class="col-md-9">
           <div class="popup-info-label">Start Time</div>
           <div class="popup-info-answer"><span id="startTime"></span></div>
           </div>
        </div>
          </div>
          <div class="col-md-6">
             <div class="row ">
          <div class="col-md-1"><i class="fa fa-clock-o"></i></div>
          <div class="col-md-9">
          <div class="popup-info-label">End Time</div>
          <div class="popup-info-answer"><span id="endTime"></span></div>
          </div>
        </div>
          </div>

        </div>


       

        


        </div>
         <div class="modal-footer">
          <button type="button" class="btn theme-btn" data-dismiss="modal" id="assign_btn1" onClick="assignCaseDelBoy1();">Assign</button>
        </div>
      
      </div>
      
    </div>
  </div>
</div>
</div>
</div>




<div class="case-detail-modal">
      <div class="container">
  <div class="modal fade" id="case-detail-modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Case Detail</h4>
        </div>
        <div class="modal-body">
         <div class="user-info-area">
        <div class="row ">
          <div class="col-md-1"><i class="fa fa-tags"></i></div>
          <div class="col-md-9">
          <div class="personal-info-label">Brand Name</div>
          <input type="text" class="form-control" id="brand"/>
          </div>
        </div>
        <hr/>
         <div class="row ">
          <div class="col-md-1"><i class="fa fa-mobile"></i></div>
          <div class="col-md-9">
              <div class="personal-info-label">Modal Name</div>
              <input type="text" class="form-control" id="model"/>
          
          </div>
        </div>
        <hr/>
        <div class="row ">
          <div class="col-md-1"><i class="fa fa-cogs"></i></div>
          <div class="col-md-9">
              <div class="personal-info-label">Repairing Detail</div>
              <input type="text" class="form-control" id="description"/>
              <input type="hidden" class="form-control" id="caseid"/>
          </div>
        </div>
        <hr/>
        <div class="row ">
          <div class="col-md-1"><i class="fa fa-cogs"></i></div>
          <div class="col-md-9">
              <div class="personal-info-label">IMEI Number</div>
              <input type="number" class="form-control" id="imei_number"/>
          </div>
        </div>
        </div>
        </div>
         <div class="modal-footer">
          <button type="button" class="btn theme-btn " data-dismiss="modal" onclick="updateCaseDetail();">Update</button>
        </div>
      
      </div>
      
    </div>
  </div>
</div>
</div>


<div class="container">
  
  <!-- Trigger the modal with a button -->
 

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>





<div class="new-approved-inquiry">
  <div class="container">

  <!-- Modal -->
  <div class="modal fade" id="new-approved-inquiry" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Approved Enquiry </h4>
        </div>
        <div class="modal-body">
          <div id="complete-case-info" style="display:none;" > 
            
            <div class="row">
               <div class="col-md-4"><b>Case Id</b></div>
               <div class="col-md-8"><span id="lv_caseid">: NA</span></div>
             </div>
             <hr/>
             <div class="row">
               <div class="col-md-4"><b>Brand Name</b></div>
               <div class="col-md-8"><span id="lv_brand">: NA</span></div>
             </div>
               <hr/>
              <div class="row">
               <div class="col-md-4"><b>Modal Name</b></div>
               <div class="col-md-8"><span id="lv_model">: NA</span></div>
             </div>
              <hr/>     
             <div class="row">
               <div class="col-md-4"><b>Problem</b></div>
               <div class="col-md-8"><span id="lv_problem">: NA</span></div>
             </div>
             <hr/>
             <div class="row">
               <div class="col-md-4"><b>Start Date</b></div>
               <div class="col-md-8"><span id="lv_startDate">: NA</span></div>
             </div>
             <hr/>
              <!-- <div class="row">
               <div class="col-md-4"><b>End Date</b></div>
               <div class="col-md-8">: 20-09-2017 </div>
             </div> -->
          </div>
         <div class="user-info-area">
        <div class="theme-form">
         
               <div class="row">
                 <div class="col-md-10">
                    <div class="visit-date" ><i class="fa fa-calendar"></i>&nbsp;&nbsp;Last Visit : <span id="last_visit">NA</span>
                  
               </div>
                 </div>
                 <div class="col-md-2 text-right"><span id="loading"></span></div>

               </div>
              

              



          <div class="row mt-15" >
           
            <div class="col-md-4">
             <label>Mobile Number</label>
             <i class="fa fa-sort-numeric-asc form-inner-icon" ></i>
             <input type="number" class="form-control" id="mobileNumber"/>
            </div>

            <div class="col-md-4">
             <label>Customer Name</label>
             <i class="fa fa-user form-inner-icon" ></i>
             <input type="text" class="form-control" id="customername"/>
            </div>

            <div class="col-md-4">
             <label>Location</label>
             <i class="fa fa-map-marker form-inner-icon" ></i>
             <input type="text" class="form-control" id="custlocation"/>
            </div>

            <div class="col-md-4">
             <label>Brand Name</label>
             <i class="fa fa-tags form-inner-icon" ></i>
             <input type="text" class="form-control" id="brandName"/>
            </div>

             <div class="col-md-4">
             <label>Modal Name</label>
             <i class="fa fa-mobile form-inner-icon" ></i>
             <input type="text" class="form-control" id="modelName"/>
            </div>


            <div class="col-md-4">
             <label>Delivery Options</label>
            
             <select class="form-control" id="deliveryOptions">
             <option>None</option>
             <option>Pick</option>
             <option>Drop</option>
             <option>Pick And Drop</option>
             </select>
            </div>

            <div class="col-md-3">
             <label>Repair Amount</label>
             <i class="fa fa-inr form-inner-icon" ></i>
             <input type="number" class="form-control" id="repairAmount"/>
            </div>
           

            <div class="col-md-3">
             <label>Pick Amount</label>
             <i class="fa fa-inr form-inner-icon" ></i>
             <input type="number" class="form-control" id="pickAmount"/>
            </div>

             <div class="col-md-3">
             <label>Drop Amount</label>
             <i class="fa fa-inr form-inner-icon" ></i>
             <input type="number" class="form-control" id="dropAmount"/>
            </div>

            <div class="col-md-3">
             <label>Pick & Drop Amount</label>
             <i class="fa fa-inr form-inner-icon" ></i>
             <input type="number" class="form-control" id="pickDropAmount"/>
            </div>

            <div class="col-md-6">
              <label>Problem Description</label>
              <i class="fa fa-pencil form-inner-icon" ></i>
              <textarea class="form-control" id="problemDescription"></textarea>
            </div>

            <div class="col-md-6">
              <label>Accessories</label>
              <i class="fa fa-pencil form-inner-icon" ></i>
              <textarea class="form-control" id="accessories"></textarea>
            </div>

            <div class="col-md-6">
              <label>IMEI Number</label>
              <i class="fa fa-sort-numeric-asc form-inner-icon" ></i>
             <input type="number" class="form-control" id="imei_number_newcase"/>
            </div>

            <div class="col-md-6">
              <label>Remarks</label>
              <i class="fa fa-pencil form-inner-icon" ></i>
             <textarea class="form-control" id="remarks"></textarea>
            </div>
            
           
            
          </div>
        
          </div>

        </div>
        </div>
        <div class="modal-footer">
         <center><button type="button" class="btn theme-btn " onClick="addNewCase();" id="create_case_button">Create <i class="fa fa-arrow-circle-right"></i></button></center>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
</div>


<div class="print-case-detail-modal">

      <div class="container">
  <div class="modal fade" id="print-case-detail-modal" role="dialog" style="background: black;">
    <div class="modal-dialog">
      <div class="modal-content">

        <div >
          <center>
          <div >Job Sheet</div>
          <h2>
          <img src="dist/img/prateek_icon_black.png" style="width:13%;">
          <br/>
          <b>PRATEEK MOBILE</b>
          <br/>
          <small>2nd Floor Rajeev Plaza</small><br/>
          <small>Jayendra Ganj Gwalior</small><br/>
          <small>9755669222, 7354995571</small><br/>
          </h2>
          <hr/>
          
          <table align="center" >
            <tr><td class="printHeading"><b>Date: </b></td> <td id="date1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>Job No: </b></td> <td id="caseid1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>Name: </b></td> <td id="name1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>Address: </b></td> <td id="address1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>Mobile: </b></td> <td id="mobile1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>Brand: </b></td> <td id="brand1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>Model: </b></td> <td id="model1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>IMEI Number: </b></td> <td id="imei_number1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>Problem: </b></td> <td id="problem1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>Amount: </b></td> <td id="totalAmount1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>Assessories: </b></td> <td id="assessories1" class="printHeading"></td></tr>
            <tr><td class="printHeading"><b>Remarks: </b></td> <td id="remarks1" class="printHeading"></td></tr>
          </table>
          
          <hr/>
          <div><b><i>Download prateek mobile app from  </i></b> <br><br><img src="dist/img/google_play.png" style="width:30%" /><br><br>
           <b><i>& enjoy home pick and drop services</b></i>
          </div>

          </center>
         
          <div>

            <h5 class="pull-right">Customer's Signature</h5>
          </div>

        </div>






      </div>
      
    </div>
  </div>
</div>

</div>




<div class="send-approval-modal">
      <div class="container">
  <div class="modal fade" id="send-approval-modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Send Price Estimate To Customer</h4>
        </div>
        <div class="modal-body">
        <div class="user-info-area">
        <div class="theme-form">
          <form>
          <div class="row">
            <div class="col-md-12">
             <label>Repairing Amount</label>
             <i class="fa fa-inr form-inner-icon" ></i>
             <input type="text" class="form-control" id="repairing_amount" name="repairing_amount"/>
            </div>
            <div class="col-md-12">
             <label>Pick And Drop Amount</label>
             <i class="fa fa-car form-inner-icon" ></i>
             <input type="text" class="form-control" id="pick_drop_amount" name="pick_drop_amount"/>
            </div>
            <div class="col-md-6">
             <label>Pick Amount</label>
             <i class="fa fa-car form-inner-icon" ></i>
             <input type="text" class="form-control" id="pick_amount" name="pick_amount"/>
            </div>
            <div class="col-md-6">
             <label>Drop Amount</label>
             <i class="fa fa-car form-inner-icon" ></i>
             <input type="text" class="form-control" id="drop_amount" name="drop_amount"/>
            </div>
          </div>
          </form>
          </div>

        </div>
        </div>
         <div class="modal-footer">
          <center><button type="button" class="btn theme-btn " >Send Price Estimate <i class="fa fa-arrow-circle-right"></i></button></center>
        </div>
      
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
                  <th>Job ID</th>
                  <th>User ID</th>
                  <th>Total Amount</th>
                  <th>Problem</th>
                  <th>Location</th>
                  <th>Remarks</th>
                  <th>User Status</th>
                  <th>Pick Status</th>
                  <th>Choose Engineer</th>
                  <th style="width:15%;">Assign To Engineer </th>
                  <th>Print</th>
                </tr>
                </thead>
                <tbody>



              <?php
// foreach ($data as $item){
//         $caseId = $item['CaseId'];
//         $userId = $item['UserId'];
//         $totalAmount = $item['TotalAmount'];
        

//         echo'<tr>'; 
//         echo'<td>'."1".'</td>';
//         echo'<td><a data-toggle="modal" data-target="#case-detail-modal"
//          onClick="showCaseDetail(\'' .$item['CaseId']. '\');">'.$item['CaseId'].'</a></td>';
//         echo'<td><a data-toggle="modal" data-target="#user-info-modal" onClick="showUserDetail('.$userId.');">'.$item['UserId'].'</a></td>';
//         echo'<td>'.$item['TotalAmount'].'</td>';
//         echo'<td><form>
//                   <div class="theme-form-table">
//                   <select class="form-control" id="choose_employee" name="choose_employee">'.
//                   '<option>'.'Romil'.'</option>'.
//                   '<option>'.'shubham'.'</option>'.
//                   '<option>'.'deepak'.'</option>'.
//                   '<option>'.'nitesh'.'</option>'.'</select></div></form></td>';
//         echo'<td><center><input type="submit" class="btn theme-btn btn-sm" value="Assign" id="assign_btn" />'.'</center></td>';
//         echo'</tr>';
//     }
 
foreach ($data as $k => $item){
        $id = $item['Id'];
        $caseId = $item['CaseId'];
        $userId = $item['UserId'];
        $totalAmount = $item['TotalAmount'];
        $description = $item['Description'];
        $location = $item['Location'];
        $deliveryOption = $item['DeliveryOptions'];
        $pikStatus = $item['PickDropStatus'];
        $delBoyId = $item['DelBoyId'];
        $delBoyStartTime = $item['DelBoyStartTime'];
        $delBoyEndTime = $item['DelBoyEndTime'];

        $totalAmount = $item['TotalAmount'];
        $brand = $item['Brand'];
        $model = $item['Model'];
        $mobile = $item['Phone'];
        $problem = $item['Description'];
        $remarks = $item['Remarks'];
        $imei_number = $item['IMEI_Number'];
        $name = $item['First_Name'];
        $userLocation = $item['User_Location'];
        $assessories = $item['Accessories'];
        $userSubmitStatus = $item['UserSubmitStatus'];

        $currentDate = date("Y-m-d H:i:s");

        $delivery="";
        $pick=0;

        
        
        

        if($deliveryOption==0){
          $delivery="NA";
        }else if($deliveryOption==1){
          $delivery="Pick";
        }
        else if($deliveryOption==2){
          $delivery="NA";
        }
        else if($deliveryOption==3){
          $delivery="Pick";
        }

        
        // if($pikStatus==2){
        //   $pick=1;
        // }
        
        // else if($pikStatus==0 && $deliveryOption==0){
        //   $pick=1;
        // }
        




        php?>
          <tr> 
         <td><?php echo $k+1; ?></td> 
         <td><input type="hidden" value="<?php echo $brand;?>" id="brand<?php echo $id;?>"><input type="hidden" value="<?php echo $model;?>" id="model<?php echo $id;?>"><input type="hidden" value="<?php echo $problem;?>" id="problem<?php echo $id;?>"><input type="hidden" value="<?php echo $caseId;?>" id="caseId<?php echo $id;?>"><input type="hidden" value="<?php echo $imei_number;?>" id="imei_number<?php echo $id;?>"><a data-toggle="modal" data-target="#case-detail-modal"
         onClick="showCaseDetail('<?php echo $id;?>');"><?php echo $item['CaseId']; ?></a></td>

         <?php echo '<td><input type="hidden" value="'.$name.'" id="name'.$userId.'"><input type="hidden" value="'.$mobile.'" id="mobile'.$userId.'"><input type="hidden" value="'.$userLocation.'" id="userLocation'.$userId.'"><a data-toggle="modal" data-target="#user-info-modal" onClick="showUserDetail('.$userId.');">'.$item['UserId'].'</a></td>'?>

        <td><?php echo $item['TotalAmount'];?></td>
        <td><?php echo $item['Description'];?></td>
        <td><?php echo $item['Location'];?></td>
        <td><?php echo $item['Remarks'];?></td>


        



          <td><form><div class="theme-form-table">
                  <select style="width:105px;" class="form-control" onchange="changeApproveType('<?php echo $caseId;?>' ,this.value);" id="approve_type" name="approve_type">
                  <option <?php if($userSubmitStatus==1){ ?> selected <?php }?>value="1">Approved</option>
                  <option <?php if($userSubmitStatus==2){ ?> selected <?php }?>value="2">Cancelled</option>
                  </select></div></form></td>






        <td><?php 

          if($delivery=="NA"){
            echo $delivery;
            $pick=1;
             
          }else if($item['PickDropStatus']==0 && $delivery=="Pick"){
            $pick=0;
            echo '<input type="hidden" value="'.$caseId.'" id="caseId'.$id.'"><input type="hidden" value="'.$location.'" id="location'.$id.'"><input type="hidden" value="'.$pikStatus.'" id="pickStatus'.$id.'"><input type="hidden" value="'.$delBoyId.'" id="delBoyId'.$id.'"><input type="hidden" value="'.$delBoyStartTime.'" id="delBoyStartTime'.$id.'"><input type="hidden" value="'.$delBoyEndTime.'" id="delBoyEndTime'.$id.'"><a data-toggle="modal" data-target="#case-delivery-boy-model" onClick="assignCaseToDelBoy('.$id.');">'.$delivery.'</a>';
          }else if($item['PickDropStatus']==1 && $delivery=="Pick"){
            $pick=0;
            echo '<input type="hidden" value="'.$caseId.'" id="caseId'.$id.'"><input type="hidden" value="'.$location.'" id="location'.$id.'"><input type="hidden" value="'.$pikStatus.'" id="pickStatus'.$id.'"><input type="hidden" value="'.$delBoyId.'" id="delBoyId'.$id.'"><input type="hidden" value="'.$delBoyStartTime.'" id="delBoyStartTime'.$id.'"><input type="hidden" value="'.$delBoyEndTime.'" id="delBoyEndTime'.$id.'"><a data-toggle="modal" data-target="#case-delivery-boy-model" onClick="assignCaseToDelBoy('.$id.');">'."Assigned".'</a>';
          }else if($item['PickDropStatus']==2 && $delivery=="Pick"){
            $pick=1;
            echo '<input type="hidden" value="'.$caseId.'" id="caseId'.$id.'"><input type="hidden" value="'.$location.'" id="location'.$id.'"><input type="hidden" value="'.$pikStatus.'" id="pickStatus'.$id.'"><input type="hidden" value="'.$delBoyId.'" id="delBoyId'.$id.'"><input type="hidden" value="'.$delBoyStartTime.'" id="delBoyStartTime'.$id.'"><input type="hidden" value="'.$delBoyEndTime.'" id="delBoyEndTime'.$id.'"><a data-toggle="modal" data-target="#case-delivery-boy-model" onClick="assignCaseToDelBoy('.$id.');">'."Picked".'</a>';
          }else if($item['PickDropStatus']==5 && $delivery=="Pick"){
            $pick=0;
            echo '<input type="hidden" value="'.$caseId.'" id="caseId'.$id.'"><input type="hidden" value="'.$location.'" id="location'.$id.'"><input type="hidden" value="'.$pikStatus.'" id="pickStatus'.$id.'"><input type="hidden" value="'.$delBoyId.'" id="delBoyId'.$id.'"><input type="hidden" value="'.$delBoyStartTime.'" id="delBoyStartTime'.$id.'"><input type="hidden" value="'.$delBoyEndTime.'" id="delBoyEndTime'.$id.'"><a data-toggle="modal" data-target="#case-delivery-boy-model" onClick="assignCaseToDelBoy('.$id.');">'."Cancelled".'</a>';
          }

        ?></td>
        <td><form>
                   <div class="theme-form-table">
                  <select class="form-control" id="select_empname_<?php echo $item['CaseId'];?>" name="select_empname">  
                         <?php foreach($dataEng as $k2 => $v2){?>
                         <option value="<?php echo $v2['Id'];?>"><?php echo $v2['Id'];?> - <?php echo $v2['First_Name'];?></option>
                         <?php } ?>
                    </select>

                    </div></form></td> 
         <td><center><input type="submit" class="btn theme-btn btn-sm" value="Assign" 
         <?php if($pick!=1){?>style="display:none;" <?php } ?> id="assign_btn" onClick="assignCaseToEmp('<?php echo $item['CaseId'];?>');" /></center></td>

         <td ><?php echo '<input type="hidden" value="'.$caseId.'" id="caseId'.$id.'"><input type="hidden" value="'.$location.'" id="location'.$id.'"><input type="hidden" value="'.$currentDate.'" id="deliveryDate'.$id.'"><input type="hidden" value="'.$brand.'" id="brand'.$id.'"><input type="hidden" value="'.$model.'" id="model'.$id.'"><input type="hidden" value="'.$totalAmount.'" id="totalAmount'.$id.'"><input type="hidden" value="'.$mobile.'" id="mobile'.$id.'"><input type="hidden" value="'.$problem.'" id="problem'.$id.'"><input type="hidden" value="'.$name.'" id="name'.$id.'"><input type="hidden" value="'.$assessories.'" id="assessories'.$id.'"><input type="hidden" value="'.$imei_number.'" id="imei_number'.$id.'"><input type="hidden" value="'.$remarks.'" id="remarks'.$id.'"><button class="btn btn-success btn-sm" onClick="printCaseDetail('.$id.');">Print</button>' ?></td> 
        </tr>  
             <?php

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

<!-- page script -->

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
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });

$('#mobileNumber').keyup(function(){
  if( this.value.length>10){
     this.value="";
     alert("value should not be more than 10 or less than 10.");
    return false;
  }
  else if( this.value.length==10){
    document.getElementById("loading").innerHTML="Loading";
    ifUserExist(this.value);
    //alert("value is 10");
  }
});

function ifUserExist(mobile){
  var mobileNumber = mobile;

$.ajax({
    url:"GetUserDetailMobileWise.php",
    data:{
      MobileNumber:mobileNumber},
    type:'post',
    dataType: 'json',
    success:function(response){
        
        //alert(response['LastVisit'])

      var name=response['First_Name'];
      var location1=response['Location'];

      var caseid=response['CaseId'];
      var brand=response['Brand'];
      var model=response['Model'];
      var problem=response['Problem'];

      $("#customername").val(name);
      $("#custlocation").val(location1);
      document.getElementById("last_visit").innerHTML=response['LastVisit'];
      document.getElementById("loading").innerHTML="Fetched";



       document.getElementById("lv_caseid").innerHTML=caseid;
       document.getElementById("lv_brand").innerHTML=brand;
       document.getElementById("lv_model").innerHTML=model;
       document.getElementById("lv_problem").innerHTML=problem;
       document.getElementById("lv_startDate").innerHTML=response['LastVisit'];



      

    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
}

   });

}


function addNewCase(){

  


var deliveryOptions=0;
  var deliverOpt=document.getElementById('deliveryOptions').value;

  if(deliverOpt=="Pick"){
    deliveryOptions=1;
  }else if(deliverOpt=="Drop"){
    deliveryOptions=2;
  }else if(deliverOpt=="Pick And Drop"){
    deliveryOptions=3;
  }else{
    deliveryOptions=0;
  }

  var brandName = document.getElementById('brandName').value;
  var modelName = document.getElementById('modelName').value;
  var location = document.getElementById('custlocation').value;
  var mobileNumber = document.getElementById('mobileNumber').value;
  var repairAmount = document.getElementById('repairAmount').value;
  var pickAmount = document.getElementById('pickAmount').value;
  var dropAmount = document.getElementById('dropAmount').value;
  var pickDropAmount = document.getElementById('pickDropAmount').value;
  var problemDescription = document.getElementById('problemDescription').value;
  var accessories = document.getElementById('accessories').value;
  var customername = document.getElementById('customername').value;
  var imei_number = document.getElementById('imei_number_newcase').value;
  var remarks = document.getElementById('remarks').value;

  document.getElementById("create_case_button").disabled = true;

  $.ajax({
    url:"AddNewCase.php",
    data:{BrandName:brandName,
      ModelName:modelName,
      Location:location,
      MobileNumber:mobileNumber,
      DeliveryOptions:deliveryOptions,
      RepairAmount:repairAmount,
      PickAmount:pickAmount,
      DropAmount:dropAmount,
      PickDropAmount:pickDropAmount,
      ProblemDescription:problemDescription,
      Accessories:accessories,
      CustomerName:customername,
      IMEINumber:imei_number,
      Remarks:remarks},
    type:'post',
    success:function(response){
      alert(response);
      document.getElementById("create_case_button").disabled = false;

      window.location.reload();

    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
}

   });

}


function showCaseDetail(id){

  var brand = $("#brand"+id).val();
  var model = $("#model"+id).val();
  var problem = $("#problem"+id).val();
  var caseid = $("#caseId"+id).val();
  var imei_number = $("#imei_number"+id).val();

    $.ajax({
    url:"GetCaseDetail.php",
    data:{CaseId:caseid},
    type:'post',
    dataType: 'json',
    success:function(response){

      //alert(response);

      var brand1=response['Brand'];
      var model1=response['Model'];
      var problem1=response['Description'];
      var imei1=response['IMEI_Number'];

      document.getElementById("brand").value=brand1;
      document.getElementById("model").value=model1;
      document.getElementById("description").value=problem1;
      document.getElementById("caseid").value=caseid;
      document.getElementById("imei_number").value=imei1;


      //window.location.reload();
    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
  }

   });



}

function updateCaseDetail(){

  var brand = document.getElementById('brand').value;
  var model = document.getElementById('model').value;
  var description = document.getElementById('description').value;
  var imei_number = document.getElementById('imei_number').value;
  var caseid = document.getElementById('caseid').value;

$.ajax({
    url:"UpdateCaseDetail.php",
    data:{Brand:brand,
      Model:model,
      Description:description,
      IMEI_Number:imei_number,
      CaseId:caseid},
    type:'post',
    success:function(response){

      alert(response);
      //window.location.reload();
    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
}

   });

}


function showUserDetail(id){

   var name = $("#name"+id).val();
   var location = $("#location"+id).val();
   var mobile = $("#mobile"+id).val();


   $.ajax({
    url:"GetUserDetail.php",
    data:{UserId:id},
    type:'post',
    dataType: 'json',
    success:function(response){

      //alert(response);

      var user_name=response['First_Name'];
      var user_location=response['Location'];
      var user_mobile=response['Mobile_Number'];

      document.getElementById("name").value=user_name;
      document.getElementById("mobile").value=user_mobile;
      document.getElementById("email").value=user_location;
      document.getElementById("userid1").value=id;


      //window.location.reload();
    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
  }

   });

}


function updateUserInfo(){

  var name = document.getElementById('name').value;
  var mobile = document.getElementById('mobile').value;
  var address = document.getElementById('email').value;
  var userid = document.getElementById('userid1').value;

  $.ajax({
    url:"UpdateUserDetail.php",
    data:{UserName:name,
      UserMobile:mobile,
      UserLocation:address,
      UserId:userid},
    type:'post',
    success:function(response){

      alert(response);
      //window.location.reload();
    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
  }

   });

  //alert(userid);

}

function assignCaseToEmp(caseid){

  
  
  var empid = document.getElementById("select_empname_"+caseid).value;
  //var empid = e.options[e.selectedIndex].value;


  //alert(empid);
  //alert(caseid);
  

$.ajax({
    url:"AssignCaseToEmp.php",
    data:{CaseId:caseid,
      EmpId:empid},
    type:'post',
    success:function(response){

      alert(response);

    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
}

   });

location.reload();


}

function assignCaseToDelBoy(id){

   var caseid = $("#caseId"+id).val();
   var location = $("#location"+id).val();
   var pickStatus = $("#pickStatus"+id).val();
   var delBoyId = $("#delBoyId"+id).val();
   var delBoyStartTime = $("#delBoyStartTime"+id).val();
   var delBoyEndTime = $("#delBoyEndTime"+id).val();
   var pick="";

    if(pickStatus==0){
      pick="Not picked";
    }else if(pickStatus==1){
      pick="Assigned to Delivery boy";
    }else if(pickStatus==2){
      pick="Picked";
    }else if(pickStatus==5){
      pick="Cancelled";
    }

    if(delBoyStartTime=="0000-00-00 00:00:00"){
      delBoyStartTime="NA";
      delBoyEndTime="NA";
    }
    if(delBoyEndTime=="0000-00-00 00:00:00"){
      delBoyEndTime="NA";
    }

    if(delBoyId!=0){
      document.getElementById('select_deliveryBoy').value=delBoyId;
    }

    if(pickStatus==2){
      $('#assign_btn1').hide();
    }else if(pickStatus==4){
      $('#assign_btn1').hide();
    }
    
  


    document.getElementById("caseid").innerHTML=caseid;
    document.getElementById("location").innerHTML=location;
    document.getElementById("pick_status").innerHTML=pick;
    document.getElementById("startTime").innerHTML=delBoyStartTime;
    document.getElementById("endTime").innerHTML=delBoyEndTime;
    
    
}

function assignCaseDelBoy1(){

   var empid = document.getElementById('select_deliveryBoy').value;
   var caseid = $("#caseid").text();
   var type = "pick";
  

$.ajax({
    url:"AssignCaseToDelBoy.php",
    data:{CaseId:caseid,
      EmpId:empid,
      Type:type},
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

function changeApproveType(caseid,type){

  $.ajax({
    url:"ChangeApprovedStatus.php",
    data:{CaseId:caseid,
      Type:type},
    type:'post',
    success:function(response){
      alert(response);
      //location.reload();

    },
    error: function(xhr, status, error) {
  var err = eval("(" + xhr.responseText + ")");
  alert(err.Message);
}

   });

}

function printCaseDetail(id){

   var caseid = $("#caseId"+id).val();
   var location = $("#location"+id).val();
   var deliveryDate = $("#deliveryDate"+id).val();
   var brand = $("#brand"+id).val();
   var model = $("#model"+id).val();
   var mobile = $("#mobile"+id).val();
   var problem = $("#problem"+id).val();
   var imei_number = $("#imei_number"+id).val();
   var name = $("#name"+id).val();
   var assessories = $("#assessories"+id).val();
   var totalAmount = $("#totalAmount"+id).val();
   var remarks = $("#remarks"+id).val();

  document.getElementById("caseid1").innerHTML=caseid;
  document.getElementById("date1").innerHTML=deliveryDate;
  document.getElementById("name1").innerHTML=name;
  document.getElementById("address1").innerHTML=location;
  document.getElementById("mobile1").innerHTML=mobile;
  document.getElementById("brand1").innerHTML=brand;
  document.getElementById("model1").innerHTML=model;
  document.getElementById("problem1").innerHTML=problem;
  document.getElementById("assessories1").innerHTML=assessories;
  document.getElementById("remarks1").innerHTML=remarks;
  document.getElementById("totalAmount1").innerHTML=totalAmount;
  document.getElementById("imei_number1").innerHTML=imei_number;


  printdiv('print-case-detail-modal');

}

function printdiv(printpage)
{
var headstr = "<html><head><title></title></head><body>";
var footstr = "</body>";
var newstr = document.all.item(printpage).innerHTML;
var oldstr = document.body.innerHTML;
document.body.innerHTML = headstr+newstr+footstr;
window.print();
document.body.innerHTML = oldstr;
return false;
}

function showAssignButton(){
  //$(".theme-btn").show();
  alert('romil');
}



$(function(){

$(".visit-date").mouseover(function(){
  
  $("#complete-case-info").show();
});

$(".visit-date").mouseout(function(){
  $("#complete-case-info").hide();
});

});


</script>



</body>
</html>
