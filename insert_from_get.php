<?php

include_once 'conn.php';
include_once 'tables.php';

$tablename=$_GET['tablename'];
$res=$table->insertDataToTableFromGet($tablename);
$comewhere=$_SERVER['HTTP_REFERER'];
if($res==""){
	echo "<script language='javascript'>alert('添加成功');location.href='$comewhere';</script>";
}else{
	echo "<script language='javascript'>alert('添加失败');";
}
	
?>