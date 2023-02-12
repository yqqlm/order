<?php

session_start();


include_once 'conn.php';

	 
	$addnew=getPostValue("addnew");
	if($addnew=="1")
	{
	$name=getPostValue('name');

	$sql="select * from splb where name='$name'";
		
	$query=$conn->query($sql);;
	$rowscount=$query->num_rows;
		if($rowscount>0)
			{
					
					echo "<script language='javascript'>alert('名称已经存在');history.back();</script>";
			}
			else
			{
				//date_default_timezone_set("PRC");
				
				$ndate =date("Y-m-d H:i:s");

					$sql="insert into splb(name) values('$name')";
					$rtn=$conn->query($sql);
                    if($rtn==1){
                        echo "<script language='javascript'>location.href='splxgl.php';</script>";
                    }else{
                        echo "<script language='javascript'>alert('$rtn');history.back();</script>";
                    }
					
			}
	 }
	 
	 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>商品类别管理</title>
</head>

<body>
<p>新建商品类别</p>
<script language="javascript">
	function check()
	{
		if(document.form1.name.value=="")
		{
			alert("类别名不能为空");
			document.form1.name.focus();
			return false;
		}

	}
</script>
<form id="form1" name="form1" method="post" action="">
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#00FFFF" style="border-collapse:collapse">    <tr>
      <td>商品类型名</td>
      <td><input name="name" type="text" id="name" />
      *
      <input name="addnew" type="hidden" id="addnew" value="1" /></td>
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
    <td bgcolor="A4B6D7">商品类型名</td>

    <td bgcolor="A4B6D7">操作</td>
  </tr>
  <?php
		$sql="select * from splb order by id desc";
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
		echo $row["name"];
	?></td>

    <td><a href="del.php?id=<?php
		echo $row["id"];
		$i=$i+1;
	?>&tablename=splb" onClick="return confirm('确定删除吗')">删除</a> </td>
  </tr>
	<?php
	}
  ?>
</table>
<p>&nbsp; </p>
</body>
</html>
