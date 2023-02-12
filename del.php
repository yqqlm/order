<?php

include_once 'conn.php';
include_once 'tables.php';

$id=$_GET["id"];
$tablename=$_GET['tablename'];
$key="id";
$keyType="int";
if(isset($table->tableKey[$tablename])){
  $key=$table->tableKey[$tablename];
  $key=$table->tableKey[$tablename];
  $keyType=$table->tableKeyType[$tablename];
}

$sql="delete from ".$tablename." where ".$key."=";
if($keyType==="string"){
	$sql=$sql."'".$id."'";
}else{
	$sql=$sql.$id;
}
//echo $sql;
$query=$conn->query($sql);

$oTable=$table->arrTables[$tablename];
$length=count($oTable);
for($x=0;$x<$length;$x++){
	$col=$oTable[$x];
	if($col["type"]=="Navigation" && $col["NavTable"] && $col["FKey"]){
		$sql="delete from ".$col["NavTable"]." where ".$col["FKey"]."=".$id;
		$query=$conn->query($sql);
	}
}
$comewhere=$_SERVER['HTTP_REFERER'];
echo "<script language='javascript'>alert('删除成功');location.href='$comewhere';</script>";
	
?>