<?php
if(!isset($_SESSION)){
    session_start();
}
include_once 'conn.php';

$login=$_POST["login"];
$username=$_POST['username'];
$pwd=$_POST['pwd'];
$cx=$_POST['cx'];
if($login=="1")
{
	if ($username!="" && $pwd!="")
	{
		$suc=login($username,$pwd,$cx);
		
		if($suc)
		{
			echo "<script language='javascript'>location='main.php';</script>";
		}
		else
		{
			echo "<script language='javascript'>alert('用户名不存在');history.back();</script>";
		}
	}
	else
	{
		echo "<script language='javascript'>alert('输入用户名');history.back();</script>";
	}
}
	
?>