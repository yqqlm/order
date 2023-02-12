<?php
if(!isset($_SESSION)){
    session_start();
}
include_once 'conn.php';
//if($_POST['submit']){
	$login=$_POST["login"];
	$username=$_POST['username'];
	$pwd=$_POST['pwd'];
	$cx=$_POST['cx'];
	//$userpass=md5($userpass);
	if($login=="1")
	{
		if ($username!="" && $pwd!="")
		{
		
			$sql="select * from allusers where username='$username' and pwd='$pwd' and cx='".$cx."'";
			
			$query=$conn->query($sql);;
			$rowscount=$query->num_rows;
			if($rowscount>0)
			{
					$_SESSION['username']=$username;
					
					$_SESSION['cx']=$cx;
					$_SESSION['expiretime'] = time() + 18; // 刷新时间戳
					global $conn;
					$sql="select alias from allusers where username='".$username."'";
					$query=$conn->query($sql);
					$arr = $query->fetch_all(MYSQLI_BOTH);
					$_SESSION['alias']= $arr[0][0];
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
	
//}
?>