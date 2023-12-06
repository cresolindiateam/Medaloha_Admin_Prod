<style>
  body {
    padding: 0px !important;
}
</style>
<?php 


$classIndex = "treeview";
$classApprovedEnq = "treeview";
$classCaseStatus = "treeview";
$classEmployeeList = "treeview";
$classUserList = "treeview";
$classCaseHistory = "treeview";
$classAllEnquiry = "treeview";
$classNotification = "treeview";


if($_SERVER['PHP_SELF']=="/index.php"){
  $classIndex="treeview active";
}
/*else if($_SERVER['PHP_SELF']=="/approved_inquiries.php"){
  $classApprovedEnq="treeview active";
}*/
/*else if($_SERVER['PHP_SELF']=="/case_status.php"){
  $classCaseStatus="treeview active";
}*/
else if($_SERVER['PHP_SELF']=="/specialist_list.php"){
  $classEmployeeList="treeview active"; 
}
else if($_SERVER['PHP_SELF']=="/user_list.php"){
  $classUserList="treeview active";
}
/*else if($_SERVER['PHP_SELF']=="/history.php"){
  $classCaseHistory="treeview active";
}*/
/*else if($_SERVER['PHP_SELF']=="/user_history.php"){
  $classUserList="treeview active";
}*/
/*else if($_SERVER['PHP_SELF']=="/employee_history.php"){
  $classEmployeeList="treeview active";
}*/
/*else if($_SERVER['PHP_SELF']=="/all_enquiry.php"){
  $classAllEnquiry="treeview active";
}
else if($_SERVER['PHP_SELF']=="/notifications.php"){
  $classNotification="treeview active";
}*/


?>


<div class="container">
 
 
  <div class="modal fade" id="change-password-modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Your Password</h4>
        </div>
        <div class="modal-body">
          <div class="theme-form">

          <div class="row mt-15">
           
            <div class="col-md-12">
             <label>Current Password</label>
             <i class="fa fa-lock form-inner-icon"></i>
             <input type="text" class="form-control" id="old_password">
            </div>

             <div class="col-md-12">
             <label>New Password</label>
             <i class="fa fa-lock form-inner-icon"></i>
             <input type="text" class="form-control" id="new_password">
            </div>

            <div class="col-md-12">
             <label>Re-enter New Password</label>
             <i class="fa fa-lock form-inner-icon"></i>
             <input type="text" class="form-control" id="new_password_confirm">
            </div>


          </div>
        
          </div>
        </div>
        <div class="modal-footer">
          <center><button type="button" class="btn theme-btn btn-default" id="password_submit">Save Changes</button></center>
        </div>
      </div>
      
    </div>
  </div>
  
</div>


<aside class="main-sidebar">
   
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="image admin-img " style="">
          
         <a href="<?php echo $url = "http://".$_SERVER['HTTP_HOST'].'/Admin/index.php';?>
"><img src="image/logo/medalogo.png" width="50%" /></a>
          <div class="admin-name">
          <p>Medaloha Admin</p>
         
        </div>
        </div>

        <hr/>

        <div ></div>

      </div>
      <!-- search form -->
      
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      
        
    <!--     <li class="<?php echo $classIndex; ?>" >
          <a href="index.php">
            <i class="fa fa-mobile mobile-icon"></i>
            <span>Phone Enquiry</span>
            <span class="pull-right-container">

            
              
            </span>
          </a>
          
        </li> -->
    <!--     <li class="<?php echo $classApprovedEnq; ?>">
          <a href="approved_inquiries.php">
            <i class="fa fa-check-circle-o"></i> <span>Approved Enquiries</span>
            
          </a>
        </li> -->
     <!--    <li class="<?php echo $classCaseStatus; ?>">
          <a href="case_status.php">
            <i class="fa fa-cogs"></i>
            <span>Repairing Status</span>
            
          </a>
        
        </li> -->
        <li class="<?php echo $classEmployeeList; ?>">
          <a href="specialist_list.php">
            <i class="fa fa-user-circle-o"></i>
            <span>Specialist List</span>
            
          </a>
          
        </li>
        <li class="<?php echo $classUserList; ?>">
          <a href="user_list.php">
            <i class="fa fa-user-circle-o"></i> <span>User List</span>
            
          </a>
          
        </li>
       <!--  <li class="<?php echo $classCaseHistory; ?>">
          <a href="history.php">
            <i class="fa fa-clock-o"></i>
            <span>Case History</span>
          </a>
        </li> -->

      <!--   <li class="<?php echo $classAllEnquiry; ?>">
          <a href="all_enquiry.php">
            <i class="fa fa-clock-o"></i>
            <span>All Enquiry</span>
          </a>
        </li> -->

       

     <!--   <li  class="<?php echo $classNotification; ?>">
          <a href="specialist-logs.php">
            <i class="fa fa-bell"></i>
            <span>Specialist Session Logs</span>
          </a>
        </li> 
 -->

<!-- <li  class="<?php echo $classNotification; ?>">
          <a href="user_list_log.php">
            <i class="fa fa-bell"></i>
            <span>User Logs</span>
          </a>
        </li> 
        
 -->


<li  class="<?php echo $classNotification; ?>">
          <a href="language_list.php">
            <i class="fa fa-language"></i>
            <span>Language List</span>
          </a>
        </li> 

        <li  class="<?php echo $classNotification; ?>">
          <a href="tag_list.php">
            <i class="fa fa-tags"></i>
            <span>Tag List</span>
          </a>
        </li> 

           <li  class="<?php echo $classNotification; ?>">
          <a href="category_list.php">
            <i class="fa fa-list"></i>
            <span>Category List</span>
          </a>
        </li> 

          <li  class="<?php echo $classNotification; ?>">
          <a href="country_list.php">
            <i class="fa fa-list"></i>
            <span>Country List</span>
          </a>
        </li> 

          <li  class="<?php echo $classNotification; ?>">
          <a href="city_list.php">
            <i class="fa fa-list"></i>
            <span>City List</span>
          </a>
        </li> 

        <li  class="<?php echo $classNotification; ?>">
          <a href="booking_list.php">
            <i class="fa fa-shopping-bag"></i>
            <span>Booking List</span>
          </a>
        </li> 



            <li  class="<?php echo $classNotification; ?>">
              <a href="suggest_category_list.php">
                <i class="fa fa-list"></i>
                <span>Suggest Category List</span>
              </a>
           </li> 

         <li  class="<?php echo $classNotification;?>">
          <a href="suggestion_list.php">
            <i class="fa fa-list"></i>
            <span>Suggestion List</span>
          </a>
         </li> 

           <li  class="<?php echo $classNotification;?>">
          <a href="report_list.php">
            <i class="fa fa-pie-chart"></i>
            <span>Report List</span>
          </a>
         </li> 

          <li  class="<?php echo $classNotification;?>">
          <a href="sendamountmedalohatospecialist.php">
            <i class="fa fa-money"></i>
            <span>Send Amount Meda To Specialst </span>
          </a>
         </li> 
        
        <li  class="<?php echo $classNotification;?>">
          <a href="legend_percentage.php">
            <i class="fa fa-percent"></i>
            <span>Legend Percerntage </span>
          </a>
         </li> 

         <li>
          <a data-toggle="modal" data-target="#change-password-modal">
            <i class="fa fa-lock"></i>
            <span>Change Password</span>
          </a>
        </li>
        
           <li  class="<?php echo $classNotification; ?>">
          <a href="master_password.php">
            <i class="fa fa-lock"></i>
            <span>Master Global Password</span>
          </a>
        </li> 
<!-- 
         <li  class="<?php echo $classNotification; ?>">
          <a href="specialist_global_password.php">
            <i class="fa fa-lock"></i>
            <span>Specialist Global Password</span>
          </a>
        </li>  -->

         <li  class="<?php echo $classNotification; ?>">
          <a href="suggest_tag_list.php">
            <i class="fa fa-tags"></i>
            <span>Suggest Tag List</span>
          </a>
        </li> 

          <li  class="<?php echo $classNotification; ?>">
          <a href="testimonial.php">
            <i class="fa fa-tags"></i>
            <span>Testimonial  List</span>
          </a>
        </li> 
        
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
