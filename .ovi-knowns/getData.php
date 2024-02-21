<?php 
require 'function.php';
require 'dbconfig.php';
$db=db_connect();
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
   /* echo $update_status_sql;die;*/
    mysqli_query($db,$update_status_sql);
 
 echo "<script>alert('Status Has been Updated.');</script>";
    $yourURL="http://".$_SERVER['HTTP_HOST'].'/Admin/city_list.php';
 echo ("<script>location.href='$yourURL'</script>");
  }
  
  }



$dbDetails = array( 
    'host' => '103.171.181.11:3306', 
    'user' => 'medalohaapi_dgoud', 
    'pass' => 'Dgoud123!@#', 
    'db'   => 'medalohaapi_medalohadb' 
); 


// DB table to use 
$table = 'cities'; 
 
// Table's primary key 
$primaryKey = 'id'; 
 
// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array( 
    array( 'db' => 'id', 'dt' => 0 ), 
    array( 'db' => 'city_name',  'dt' => 1 ), 


 array( 
        'db'        => 'country_id', 
        'dt'        => 2, 
        'formatter' => function( $d, $row ) { 
$db=db_connect();
$country_id=$row['country_id'];
$country_name=get_table_fieldname_by_id('countries',$row['country_id'],$db);
//return $country_id;
//return $row['country_id'];
           // return date( 'jS M Y', strtotime($d)); 
          return  $country_name;
        } 
    ),

    array( 
        'db'        => 'created_at', 
        'dt'        => 3, 
        'formatter' => function( $d, $row ) { 
            return date( 'jS M Y', strtotime($d)); 
        } 
    ),
    array( 
        'db'        => 'updated_at', 
        'dt'        => 4, 
        'formatter' => function( $d, $row ) { 
            return date( 'jS M Y', strtotime($d)); 
        } 
    ), 
    array( 
        'db'        => 'status', 
        'dt'        => 5, 
        'formatter' => function( $d, $row ) { 
           $id= $row['id'];
           $city_name= $row['city_name'];
           $status= $row['status'];
           $country_id= $row['country_id'];
           
            return 
             ($d == 1)?"<a href='?type=status&operation=disabled&id=$id'>

            <button type='button' class='badge badge-complete'>Active</button></a><button type='button' class='btn open-ClientDialog' data-toggle='modal' data-target='#edit_tag_list_modal' onClick='editTag1($id)' >Edit</button><input type='hidden' value='$city_name' id='edittagName$id'><input type='hidden' value='$status' id='editstatus$id'><input type='hidden' value='$country_id' id='editlanguageList$id'><input type='hidden' value='$id' id='editid'>":"<a href='?type=status&operation=enabled&id=$id'><button type='button' class='badge badge-pending'>Inactive</button></a><button type='button' class='btn open-ClientDialog' data-toggle='modal' data-target='#edit_tag_list_modal' onClick='editTag1($id)' >Edit</button><input type='hidden' value='$city_name' id='edittagName$id'><input type='hidden' value='$status' id='editstatus$id'><input type='hidden' value='$country_id' id='editlanguageList$id'><input type='hidden' value='$id' id='editid'>"; 
            "";
        } 
    ) 
); 
 
// Include SQL query processing class 
require 'ssp.class.php'; 
 
// Output data as json format 
echo json_encode( 
    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns ) 
);