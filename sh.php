<?php
//ï¿½ï¿½Ö¤ï¿½ï¿½Â½ï¿½ï¿½Ï¢

include_once 'conn.php';
//if($_POST['submit']){
	$id=getValue("id");
	$yuan=getValue("yuan");
	$tablename=getValue("tablename");
	if($yuan=="ÊÇ")
	{
	$sql="update $tablename set issh='·ñ' where id=$id";
	}
	else
	{
	$sql="update $tablename set issh='ÊÇ' where id=$id";
	}
	$conn->query($sql);
	

		$comewhere=$_SERVER['HTTP_REFERER'];
		echo "<script language='javascript'>alert('ÐÞ¸Ä³É¹¦');location.href='$comewhere';</script>";
	
//}
?>