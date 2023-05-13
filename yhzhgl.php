<?php
session_start();
if($_SESSION['cx']!="系统管理员")
{
	echo "<script>javascript:alert('不是系统管理员');history.back();</script>";
	exit;
}

include_once 'conn.php';

$addnew=getPostValue("addnew");
if($addnew=="1")
{
	$username=getPostValue('username');
	$pwd=getPostValue('pwd1');
	$cx=getPostValue('cx');
	$rtn= addUser($username,$pwd,$cx);
	if(rtn){
		echo "<script language='javascript'>alert($rtn);history.back();</script>";
	}else{
		echo "<script language='javascript'>alert('添加成功');location.href='yhzhgl.php';</script>";
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理</title>
</head>

<body>
<p>新建用户信息</p>
<script language="javascript">
	function check()
	{
		if(document.form1.username.value=="")
		{
			alert("用户名不能为空");
			document.form1.username.focus();
			return false;
		}
		if(document.form1.pwd1.value=="")
		{
			alert("密码不能为空");
			document.form1.pwd1.focus();
			return false;
		}
		if(document.form1.pwd2.value=="")
		{
			alert("确认密码不能为空");
			document.form1.pwd2.focus();
			return false;
		}
		if(document.form1.pwd1.value!=document.form1.pwd2.value)
		{
			alert("密码不一致");
			document.form1.pwd1.value="";
			document.form1.pwd2.value="";
			document.form1.pwd1.focus();
			return false;
		}
	}
</script>
<form id="form1" name="form1" method="post" action="">
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#00FFFF" style="border-collapse:collapse">    <tr>
      <td>用户名</td>
      <td><input name="username" type="text" id="username" />
      *
      <input name="addnew" type="hidden" id="addnew" value="1" /></td>
    </tr>
    <tr>
      <td>密码：</td>
      <td><input name="pwd1" type="password" id="pwd1" />
      *</td>
    </tr>
    <tr>
      <td>密码重复：</td>
      <td><input name="pwd2" type="password" id="pwd2" />
      *</td>
    </tr>
    
    <tr>
      <td>权限:</td>
      <td><select name="cx" id="cx">
        <option value="系统管理员">系统管理员</option>
		<option value="销售经理">销售经理</option>
		<option value="销售总监">销售总监</option>
        <option value="营业录入员">营业录入员</option>
		<option value="配送管理员">配送管理员</option>
		<option value="仓库管理员">仓库管理员</option>
		<option value="技术经理">技术经理</option>
        <option value="技术工程师">技术工程师</option>
      </select>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="提交" onClick="return check();" />
      <input type="reset" name="Submit2" value="重置" /></td>
    </tr>
  </table>
</form>
<p>用户列表</p>
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#00FFFF" style="border-collapse:collapse">  
  <tr>
    <td bgcolor="A4B6D7">序号</td>
    <td bgcolor="A4B6D7">用户名</td>
    <td bgcolor="A4B6D7">密码</td>
    <td bgcolor="A4B6D7">权限</td>
    <td bgcolor="A4B6D7">创建时间</td>
    <td bgcolor="A4B6D7">操作</td>
  </tr>
  <?php
		$sql="select * from allusers order by id desc";
		$query=$conn->query($sql);
		$rowscount=$query->num_rows;
		$i=0;
		while($row = $query->fetch_assoc()) 
	 {
  ?>
  <tr>
    <td><?php
		echo $i+1;
	?></td>
    <td><?php
		echo $row["username"];
	?></td>
    <td><?php
		echo $row["pwd"];
	?></td>
    <td><?php
		echo $row["cx"];
	?></td>
    <td><?php
		echo $row["addtime"];
	?></td>
    <td><a href="del.php?id=<?php
		echo $row["id"];
		$i=$i+1;
	?>&tablename=allusers" onClick="return confirm('确定删除吗')">删除</a> </td>
  </tr>
	<?php
	}
  ?>
</table>
<p>&nbsp; </p>
</body>
</html>
