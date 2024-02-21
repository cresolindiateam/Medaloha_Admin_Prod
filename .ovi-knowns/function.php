<?php 



function get_table_data($tb_name,$db){
  $sql = "SELECT * FROM ".$tb_name;
  $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_ASSOC);

return $data;
}

function gettagnamebyspcintroid($id,$db)
{

  $sql = "SELECT tags.tag_name FROM specialist_tags
left join tags on tags.id =specialist_tags.tags

   where specialist_tags.specialist_public_intro_id=$id";
 
  $exe = $db->query($sql);
  $datatags = $exe->fetch_all(MYSQLI_NUM);

return $datatags;
}

function get_table_fieldname_by_id($tb_name,$id,$db){

$tb_name=$tb_name;
if($tb_name=='cities')
{

  $sql = "SELECT * FROM ".$tb_name.' where id='.$id;
 // echo $sql;die;
  $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_NUM);


foreach($data as $val){
  return $val[2];
}
}

if($tb_name=='specialist_private')
{

  $sql = "SELECT * FROM ".$tb_name.' where id='.$id;
 // echo $sql;die;
  $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_NUM);


foreach($data as $val){
  return $val[1].' '.$val[2];
}
}

if($tb_name=='users')
{

  $sql = "SELECT * FROM ".$tb_name.' where id='.$id;
 // echo $sql;die;
  $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_NUM);


foreach($data as $val){
  return $val[1].' '.$val[2];
}
}

  $sql = "SELECT * FROM ".$tb_name.' where id='.$id;
 // echo $sql;die;
  $exe = $db->query($sql);
  $data = $exe->fetch_all(MYSQLI_NUM);

foreach($data as $val){
	return $val[1];
}
}


?>