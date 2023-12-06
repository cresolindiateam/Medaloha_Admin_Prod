<?php
require '../dbconfig.php';
require '../function.php';
session_start();
$url = "http://".$_SERVER['HTTP_HOST'].'/Admin/admin_login.php';
if($_SESSION['username']==""){
  echo "<script> window.location = '".$url."'</script>";
}

 $db=db_connect();


  $sql = "SELECT booking_histories.*,specialist_private.first_name,specialist_private.city_id,specialist_private.country_id,specialist_private.last_name,specialist_private.email,specialist_private.mobile FROM booking_histories 


left join specialist_private on specialist_private.id= booking_histories.specialist_id 

  where booking_histories.id=7";

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





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Invoice</title>
	
	<link rel='stylesheet' type='text/css' href='css/style.css' />
	<link rel='stylesheet' type='text/css' href='css/print.css' media="print" />
	<script type='text/javascript' src='js/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='js/example.js'></script>

</head>

<body>

	<div id="page-wrap">

		<textarea id="header">INVOICE</textarea>
		
		<div id="identity">
		
            <textarea id="address"><?php echo $data[0]['first_name'].' '.$data[0]['last_name']?>

<?php 
echo get_table_fieldname_by_id('cities',$data[0]['city_id'],$db);
?> 
<?php 

echo get_table_fieldname_by_id('countries',$data[0]['country_id'],$db);
?>

Phone: <?php echo $data[0]['mobile'];?></textarea>

            <div id="logo">

              <div id="logoctr">
                <a href="javascript:;" id="change-logo" title="Change logo">Change Logo</a>
                <a href="javascript:;" id="save-logo" title="Save changes">Save</a>
                |
                <a href="javascript:;" id="delete-logo" title="Delete logo">Delete Logo</a>
                <a href="javascript:;" id="cancel-logo" title="Cancel changes">Cancel</a>
              </div>

              <div id="logohelp">
                <input id="imageloc" type="text" size="50" value="" /><br />
                (max width: 540px, max height: 100px)
              </div>
              <!-- <img id="image" src="images/logo.png" alt="logo" /> -->
            </div>
		
		</div>
		
		<div style="clear:both"></div>
		
		<div id="customer">

          <!--   <textarea id="customer-title">Widget Corp.
c/o Steve Widget</textarea> -->

            <table id="meta">
                <tr>
                    <td class="meta-head">Invoice #</td>
                    <td><textarea><?php echo $data[0]['id']?></textarea></td>
                </tr>
                <tr>

                    <td class="meta-head">Date</td>
                    <td><textarea id="date"><?php echo $data[0]['booking_date']?></textarea></td>
                </tr>
                <tr>
                    <td class="meta-head">Amount Due</td>
                    <td><div class="due"><?php echo $data[0]['booking_price']?></div></td>
                </tr>

            </table>
		
		</div>
		
		<table id="items">
		
		  <tr>
		      <th>Item</th>
		      <th>Description</th>
		      <th>Unit Cost</th>
		      <th>Quantity</th>
		      <th>Price</th>
		  </tr>
		

		  <tr class="item-row">
		      <td class="item-name"><div class="delete-wpr"><textarea><?php 
echo get_table_fieldname_by_id('legends',$data[0]['legend_id'],$db);
		  ?></textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
		      <td class="description"><textarea><?php echo $data[0]['private_note'];?></textarea></td>
		      <td><textarea class="cost"><?php echo '$'.$data[0]['booking_price'] ?></textarea></td>
		      <td><textarea class="qty">1</textarea></td>
		      <td><span class="price"><?php echo '$'.$data[0]['booking_price'] ?></span></td>
		  </tr>
		  
	<!-- 	  <tr class="item-row">
		      <td class="item-name"><div class="delete-wpr"><textarea>SSL Renewals</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>

		      <td class="description"><textarea>Yearly renewals of SSL certificates on main domain and several subdomains</textarea></td>
		      <td><textarea class="cost">$75.00</textarea></td>
		      <td><textarea class="qty">3</textarea></td>
		      <td><span class="price">$225.00</span></td>
		  </tr> -->
		  
		  <tr id="hiderow">
		    <td colspan="5"><a id="addrow" href="javascript:;" title="Add a row">Add a row</a></td>
		  </tr>
		  
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Subtotal</td>
		      <td class="total-value"><div id="subtotal">$150.00</div></td>
		  </tr>
		  <tr>

		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Total</td>
		      <td class="total-value"><div id="total">$150.00</div></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Amount Paid</td>

		      <td class="total-value"><textarea id="paid">$150.00</textarea></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line balance">Balance Due</td>
		      <td class="total-value balance"><div class="due">$0.00</div></td>
		  </tr>
		
		</table>
		
	
	
	</div>
	
</body>

</html>