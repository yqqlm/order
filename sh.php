<?php
//��֤��½��Ϣ

include_once 'conn.php';
//if($_POST['submit']){
	$id=getValue("id");
	$yuan=getValue("yuan");
	$tablename=getValue("tablename");
	if($yuan=="��")
	{
	$sql="update $tablename set issh='��' where id=$id";
	}
	else
	{
	$sql="update $tablename set issh='��' where id=$id";
	}
	$conn->query($sql);
	

		$comewhere=$_SERVER['HTTP_REFERER'];
		echo "<script language='javascript'>alert('�޸ĳɹ�');location.href='$comewhere';</script>";
	
//}
?>