<?php

include_once 'conn.php';
include_once 'tables.php';
include_once 'commonscript.php';
$ndate =date("Y-m-d");
$username=$_SESSION['username'];
checkSessionTimeOut();
if (getPostValue("oldpassword") )
{
	$sql="select pwd from allusers where username='".$username."'";
	$suc;
	global $conn;
	$query=$conn->query($sql);
	$arr = $query->fetch_all(MYSQLI_BOTH);
	$oldpass=getPostValue("oldpassword");
	$newpass=getPostValue("newpassword");
	$alias=getPostValue("alias");
	if ($query->num_rows > 0) 
	{
		if(!isset($arr[0][0]) || is_null($arr[0][0]) || $oldpass!=$arr[0][0]){
			echo "<script>javascript:alert('原密码错误');</script>";
		}else{
			$sql="update allusers set pwd='".$newpass."',alias='".$alias."' where username='".$username."'";
			$suc=$conn->query($sql);
			if(!$suc){
				echo "<script>javascript:alert('出现错误：".$conn->error."');</script>";

			}
		}
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>修改用户信息</title><script language="javascript" src="js/Calendar.js"></script><link rel="stylesheet" href="css.css" type="text/css">
</head>
<?php echo getCommonScript();?>
<body>
<p><?php 
if(isset($suc) && $suc){
	echo '用户信息修改成功';
}
?></p>
<p>修改用户信息 <?php echo $ndate; ?></p>

<script language="javascript">
function check()
{
    if(document.form1.oldpassword.value==""){alert("请输入旧密码");document.form1.oldpassword.focus();return false;}
    if(document.form1.newpassword.value==""){alert("请输入新密码");document.form1.newpassword.focus();return false;}
    if(document.form1.passwordrepeat.value==""){alert("请输入确认密码");document.form1.passwordrepeat.focus();return false;}
	if(document.form1.passwordrepeat.value!==document.form1.newpassword.value){alert("新密码与确认密码不同");document.form1.passwordrepeat.focus();return false;}
}

</script>
<form id="form1" name="form1" method="post" action="">
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#00FFFF" style="border-collapse:collapse"> 
<tr>
	<td width='11%'>原密码:</td>
	<td width='69%'>
		<input name="oldpassword" type="password" id="oldpassword" style="width: 100%; height: 100%" size="10" value="<?php echo getPostValue("oldpassword"); ?>" /> 
    </td> 
</tr>
<tr>
	<td width='11%'>新密码:</td>
	<td width='69%'>
	<input name="newpassword" type="password" id="newpassword" size="10" style="width: 100%; height: 100%" value="<?php echo getPostValue("newpassword"); ?>" /> 
    </td> 
</tr>
<tr>
	<td width='11%'>新密码确认:</td>
	<td width='69%'>
	<input name="passwordrepeat" type="password" id="passwordrepeat" style="width: 100%; height: 100%" size="10" value="<?php echo getPostValue("passwordrepeat"); ?>" /> 
    </td> 
</tr>
<tr>
	<td width='11%'>昵称:</td>
	<td width='69%'>
	<input name  ="nicheng" type="text" id="nicheng" size="10" style="width: 100%; height: 100%" value="<?php echo getPostValue("nicheng"); ?>" /> 
    </td> 
</tr>
</table>
<p><p>
<input type="submit" name="Submit" value="修改" onClick="return check();" />
</form>

</body>
</html>

