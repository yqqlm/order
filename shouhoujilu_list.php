<?php 
include_once 'conn.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>售后记录</title><script language="javascript" src="js/Calendar.js"></script><link rel="stylesheet" href="css.css" type="text/css">
</head>

<body>

<p>已有售后记录列表：</p>
<form id="form1" name="form1" method="post" action="">
  搜索: 单据编号：<input name="danjubianhao" type="text" id="danjubianhao" /> 商品名称：<input name="shangpinmingcheng" type="text" id="shangpinmingcheng" /> 客户姓名：<input name="kehuxingming" type="text" id="kehuxingming" /> 客户电话：<input name="kehudianhua" type="text" id="kehudianhua" />
  <input type="submit" name="Submit" value="查找" />
</form>
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#00FFFF" style="border-collapse:collapse">  
  <tr>
    <td width="25" bgcolor="#CCFFFF">序号</td>
    <td bgcolor='#CCFFFF'>单据编号</td><td bgcolor='#CCFFFF'>商品名称</td><td bgcolor='#CCFFFF'>客户姓名</td><td bgcolor='#CCFFFF'>客户电话</td><td bgcolor='#CCFFFF'>售后要求</td><td bgcolor='#CCFFFF'>服务内容</td><td bgcolor='#CCFFFF'>备注</td><td bgcolor='#CCFFFF' width='80' align='center'>是否解决</td>
    <td width="120" align="center" bgcolor="#CCFFFF">添加时间</td>
    <td width="70" align="center" bgcolor="#CCFFFF">操作</td>
  </tr>
  <?php 
    $sql="select * from shouhoujilu where 1=1";
  
if ($_POST["danjubianhao"]!=""){$nreqdanjubianhao=$_POST["danjubianhao"];$sql=$sql." and danjubianhao like '%$nreqdanjubianhao%'";}
if ($_POST["shangpinmingcheng"]!=""){$nreqshangpinmingcheng=$_POST["shangpinmingcheng"];$sql=$sql." and shangpinmingcheng like '%$nreqshangpinmingcheng%'";}
if ($_POST["kehuxingming"]!=""){$nreqkehuxingming=$_POST["kehuxingming"];$sql=$sql." and kehuxingming like '%$nreqkehuxingming%'";}
if ($_POST["kehudianhua"]!=""){$nreqkehudianhua=$_POST["kehudianhua"];$sql=$sql." and kehudianhua like '%$nreqkehudianhua%'";}
  $sql=$sql." order by id desc";
  
$query=mysql_query($sql);
  $rowscount=mysql_num_rows($query);
  if($rowscount==0)
  {}
  else
  {
  $pagelarge=10;//每页行数；
  $pagecurrent=$_GET["pagecurrent"];
  if($rowscount%$pagelarge==0)
  {
		$pagecount=$rowscount/$pagelarge;
  }
  else
  {
   		$pagecount=intval($rowscount/$pagelarge)+1;
  }
  if($pagecurrent=="" || $pagecurrent<=0)
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
  ?>
  <tr>
    <td width="25"><?php
	echo $i+1;
?></td>
    <td><?php echo mysql_result($query,$i,danjubianhao);?></td><td><?php echo mysql_result($query,$i,shangpinmingcheng);?></td><td><?php echo mysql_result($query,$i,kehuxingming);?></td><td><?php echo mysql_result($query,$i,kehudianhua);?></td><td><?php echo mysql_result($query,$i,shouhouyaoqiu);?></td><td><?php echo mysql_result($query,$i,fuwuneirong);?></td><td><?php echo mysql_result($query,$i,beizhu);?></td><td width='80' align='center'><a href="sh.php?id=<?php echo mysql_result($query,$i,"id") ?>&yuan=<?php echo mysql_result($query,$i,"issh")?>&tablename=shouhoujilu" onclick="return confirm('您确定要执行此操作？')"><?php echo mysql_result($query,$i,"issh")?></a></td>
    <td width="120" align="center"><?php
echo mysql_result($query,$i,"addtime");
?></td>
    <td width="70" align="center"><a href="del.php?id=<?php
		echo mysql_result($query,$i,"id");
	?>&tablename=shouhoujilu" onclick="return confirm('真的要删除？')">删除</a> <a href="shouhoujilu_updt.php?id=<?php
		echo mysql_result($query,$i,"id");
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
<p align="center"><a href="shouhoujilu_list.php?pagecurrent=1">首页</a>, <a href="shouhoujilu_list.php?pagecurrent=<?php echo $pagecurrent-1;?>">前一页</a> ,<a href="shouhoujilu_list.php?pagecurrent=<?php echo $pagecurrent+1;?>">后一页</a>, <a href="shouhoujilu_list.php?pagecurrent=<?php echo $pagecount;?>">末页</a>, 当前第<?php echo $pagecurrent;?>页,共<?php echo $pagecount;?>页 </p>

<p>&nbsp; </p>

</body>
</html>

