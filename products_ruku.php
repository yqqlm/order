<?php

include_once 'conn.php';
include_once 'tables.php';

$id=$_GET["id"];
$comewhere=$_SERVER['HTTP_REFERER'];
$sql="select caigoudanproducts.* , caigoudan.gongyingshang as gongyingshang from caigoudanproducts left join caigoudan on caigoudan.id=caigoudanproducts.caigoudanid where caigoudanid=$id";
$ok=true;
$error="";
$query=$conn->query($sql);         
if(!$query){
	$ok=false;
	$error=$conn->error;
}else{
	$arr = $query->fetch_all(MYSQLI_BOTH);
	$rowscount=count($arr);

	if($ok){
		for($x=0;$x<$rowscount;$x++){
			$row=$arr[$x];
			$shangpinmingcheng=$row["shangpinmingcheng"];
			$shangpinbianhao=$row["shangpinbianhao"];
			$guige=$row["guige"];
			$shuliang=$row["shuliang"];
			$kehumingcheng=$row["gongyingshang"];
			$sql="insert into kucunhistory(shangpinmingcheng,shangpinbianhao,guige,shuliang,kehumingcheng,caigoudanid) values('$shangpinmingcheng','$shangpinbianhao','$guige',$shuliang,'$kehumingcheng',$id)";
			$suc=$conn->query($sql);
			if(!$suc){
				$ok=false;
				$error=$conn->error;
				break;
			}
		}
	}
}
if($ok){
	echo "<script language='javascript'>alert('入库成功');location.href='$comewhere';</script>";
}else{
	echo "<script language='javascript'>alert('入库失败:".$error."');location.href='$comewhere';</script>";
}
	
?>