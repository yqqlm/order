<?php

include_once 'conn.php';
include_once 'tables.php';

$id=$_GET["id"];
$comewhere=$_SERVER['HTTP_REFERER'];
$sql="select xiaoshoudanproducts.* , xiaoshoudan.kehumingcheng as kehumingcheng from xiaoshoudanproducts left join xiaoshoudan on xiaoshoudan.id=xiaoshoudanproducts.xiaoshoudanid where xiaoshoudanid=$id";
$ok=true;
$error="";
$query=$conn->query($sql);         
if(!$query){
	$ok=false;
	$error=$conn->error;
}else{
	$arr = $query->fetch_all(MYSQLI_BOTH);
	$rowscount=count($arr);
	//check 库存
	for($x=0;$x<$rowscount;$x++){
		$row=$arr[$x];
		$shangpinmingcheng=$row["shangpinmingcheng"];
		$shangpinbianhao=$row["shangpinbianhao"];
		$guige=$row["guige"];
		$shuliang=$row["shuliang"];
		
		$sql2="select * from kucun where shangpinmingcheng='$shangpinmingcheng' and shangpinbianhao='$shangpinbianhao' and guige='$guige'";
		$query2=$conn->query($sql2);
		if(!$query2){
			$ok=false;
			$error=$conn->error;
			break;
		}
		$arr2 = $query2->fetch_all(MYSQLI_BOTH);
		
		if ($query2->num_rows <= 0 || !isset($arr2[0]["shuliang"]) || $arr2[0]["shuliang"]<$shuliang) {
			$ok=false;
			$error="库存不足";
			break;
		}
	}
	if($ok){
		for($x=0;$x<$rowscount;$x++){
			$row=$arr[$x];
			$shangpinmingcheng=$row["shangpinmingcheng"];
			$shangpinbianhao=$row["shangpinbianhao"];
			$guige=$row["guige"];
			$shuliang=$row["shuliang"]*(-1);
			$kehumingcheng=$row["kehumingcheng"];
			$sql="insert into kucunhistory(shangpinmingcheng,shangpinbianhao,guige,shuliang,kehumingcheng,xiaoshoudanid) values('$shangpinmingcheng','$shangpinbianhao','$guige',$shuliang,'$kehumingcheng',$id)";
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
	echo "<script language='javascript'>alert('出库成功');location.href='$comewhere';</script>";
}else{
	echo "<script language='javascript'>alert('出库失败:".$error."');location.href='$comewhere';</script>";
}
	
?>