<?php 
include_once 'conn.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>商品信息</title><link rel="stylesheet" href="css.css" type="text/css">
</head>

<body>

<p>已有商品信息列表：</p>
<form id="form1" name="form1" method="post" action="">
  搜索: 商品编号：<input name="shangpinbianhao" type="text" id="shangpinbianhao" /> 商品名称：<input name="shangpinmingcheng" type="text" id="shangpinmingcheng" />
  <input type="submit" name="Submit" value="查找" />
</form>
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#00FFFF" style="border-collapse:collapse">  
  <tr>
    <td width="25" bgcolor="#CCFFFF">序号</td>
    <td bgcolor='#CCFFFF'>商品编号</td><td bgcolor='#CCFFFF'>商品名称</td><td bgcolor='#CCFFFF'>规格</td><td bgcolor='#CCFFFF'>产地</td><td bgcolor='#CCFFFF'>保质期</td><td bgcolor='#CCFFFF'>备注</td>
    <td width="120" align="center" bgcolor="#CCFFFF">库存</td>
    <td width="120" align="center" bgcolor="#CCFFFF">添加时间</td>
    <td width="70" align="center" bgcolor="#CCFFFF">操作</td>
  </tr>
  <?php 
    $sql="select * from shangpinxinxi where 1=1";
    
if (isset($_POST["shangpinbianhao"])){$nreqshangpinbianhao=$_POST["shangpinbianhao"];$sql=$sql." and shangpinbianhao like '%$nreqshangpinbianhao%'";}
if (isset($_POST["shangpinmingcheng"])){$nreqshangpinmingcheng=$_POST["shangpinmingcheng"];$sql=$sql." and shangpinmingcheng like '%$nreqshangpinmingcheng%'";}
  $sql=$sql." order by id desc";
  
	$query=$conn->query($sql);
  $rowscount=$query->num_rows;
  $arr = $query->fetch_all(MYSQLI_BOTH);
  if($rowscount==0)
  {
    $pagelarge=10;//每页行数；
    $pagecurrent=1;
    $pagecount=0;
  }
  else
  {
  $pagelarge=10;//每页行数；
  $pagecurrent=isset($_GET["pagecurrent"])?$_GET["pagecurrent"]:1;
  if($rowscount%$pagelarge==0)
  {
		$pagecount=$rowscount/$pagelarge;
  }
  else
  {
   		$pagecount=intval($rowscount/$pagelarge)+1;
  }
  if($pagecurrent=="" || $pagecurrent<=0 )
{
	$pagecurrent=1;
}
 
if($pagecurrent>$pagecount)
{
	$pagecurrent=$pagecount;
}
		$ddddd=$pagecurrent*$pagelarge;
	if($pagecurrent==$pagecount)
	{
		if($rowscount%$pagelarge==0)
		{
		$ddddd=$pagecurrent*$pagelarge;
		}
		else
		{
		$ddddd=$pagecurrent*$pagelarge-$pagelarge+$rowscount%$pagelarge;
		}
	}

	for($i=$pagecurrent*$pagelarge-$pagelarge;$i<$ddddd;$i++)
{
  $v=$arr[$i];
  ?>
  <tr>
    <td width="25"><?php
	echo $i+1;
?></td>
    <td><?php echo $v["shangpinbianhao"];?></td><td><?php echo $v["shangpinmingcheng"];?></td><td><?php echo $v["guige"];?></td><td><?php echo $v["chandi"];?></td><td><?php echo $v["baozhiqi"];?></td><td><?php echo $v["beizhu"];?></td>
    <td width="120" align="center"><?php echo $v["kucun"];?></td>
    <td width="120" align="center"><?php
    echo $v["addtime"];
?></td>
    <td width="70" align="center"><a href="del.php?id=<?php
		echo $v["id"];
	?>&tablename=shangpinxinxi" onclick="return confirm('真的要删除？')">删除</a> <a href="shangpinxinxi_updt.php?id=<?php
    echo $v["id"];
	?>">修改</a></td>
  </tr>
  	<?php
	}
}
?>
</table>
<p>以上数据共<?php
		echo $rowscount;
	?>条,
  <input type="button" name="Submit2" onclick="javascript:window.print();" value="打印本页" />
</p>
<p align="center"><a href="shangpinxinxi_list.php?pagecurrent=1">首页</a>, <a href="shangpinxinxi_list.php?pagecurrent=<?php echo $pagecurrent-1;?>">前一页</a> ,<a href="shangpinxinxi_list.php?pagecurrent=<?php echo $pagecurrent+1;?>">后一页</a>, <a href="shangpinxinxi_list.php?pagecurrent=<?php echo $pagecount;?>">末页</a>, 当前第<?php echo $pagecurrent;?>页,共<?php echo $pagecount;?>页 </p>

<p>&nbsp; </p>

</body>
</html>

