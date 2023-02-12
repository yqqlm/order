<?php

include_once 'conn.php';
include_once 'tables.php';
include_once 'commonscript.php';
checkSessionTimeOut();
global $conn;
$suc=$conn->query("delete from kucun_pandian");
if(!$suc){
 
  echo "<script>javascript:alert('库存盘点失败,delete from kucun_pandian Error：'<br>".$conn->error.");location.href='kucun_list.php';</script>";
}
$suc=$conn->query("insert into kucun_pandian select * from kucun");
if(!$suc){
  
  echo "<script>javascript:alert('库存盘点失败,Insert kucun_pandian Error：'<br>".$conn->error.");location.href='kucun_list.php';</script>";
}
$suc=$conn->query("insert into kucun_pandian_date values('".date("Y-m-d")."')");
if(!$suc){
  echo "<script>javascript:alert('库存盘点失败,insert into kucun_pandian_date Error：'<br>".$conn->error.");location.href='kucun_list.php';</script>";
}else{
  echo "<script>javascript:alert('库存盘点成功');location.href='kucun_list.php';</script>";
}

   
?>