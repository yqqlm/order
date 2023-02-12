<?php 
include_once 'conn.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>销售单</title><link rel="stylesheet" href="css.css" type="text/css">
</head>

<body>

<p>已有销售单列表：</p>
<form id="form1" name="form1" method="post" action="">
  单据编号：
    <input name="danjubianhao" type="text" id="danjubianhao" size="10" />
    购买单位：<select name='goumaidanwei' id='goumaidanwei'><option value="">所有</option><?php getoption("gongyingshangxinxi","gongyingshangmingcheng")?></select> 制单人：<input name="zhidanren" type="text" id="zhidanren" size="10" /> 
    经手人：<input name="jingshouren" type="text" id="jingshouren" size="10" /> 
    商品编号：<input name="shangpinbianhao" type="text" id="shangpinbianhao" size="10" /> 
    商品名称：<input name="shangpinmingcheng" type="text" id="shangpinmingcheng" size="10" />
    付款账户：<select name='fukuanzhanghu' id='fukuanzhanghu'><option value="">所有</option><?php getoption("caiwuzhanghu","zhanghubianhao")?></select>
    退货：
    <select name='issh' id='issh'>
      <option value="">所有</option>
      <option value="是">是</option>
      <option value="否">否</option>
      
    </select>
    <input type="submit" name="Submit" value="查找" />
</form>
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#00FFFF" style="border-collapse:collapse">  
  <tr>
    <td width="25" bgcolor="#CCFFFF">序号</td>
    <td bgcolor='#CCFFFF'>单据编号</td><td bgcolor='#CCFFFF'>购买单位</td><td bgcolor='#CCFFFF'>制单人</td><td bgcolor='#CCFFFF'>经手人</td><td bgcolor='#CCFFFF'>商品编号</td><td bgcolor='#CCFFFF'>商品名称</td><td bgcolor='#CCFFFF'>生产日期</td><td bgcolor='#CCFFFF'>单价</td><td bgcolor='#CCFFFF'>数量</td><td bgcolor='#CCFFFF'>金额</td><td bgcolor='#CCFFFF'>付款账户</td><td width="120" align="center" bgcolor="#CCFFFF">添加时间</td>
    <td width="70" align="center" bgcolor="#CCFFFF">是否退货</td>
    <td width="70" align="center" bgcolor="#CCFFFF">订单状态</td>
    <td width="70" align="center" bgcolor="#CCFFFF">操作</td>
  </tr>
  <?php 
    $sql="select * from xiaoshoudan where 1=1";
  
if (getPostValue("danjubianhao")!=""){$nreqdanjubianhao=getPostValue("danjubianhao");$sql=$sql." and danjubianhao like '%$nreqdanjubianhao%'";}
if (getPostValue("goumaidanwei")!=""){$nreqgoumaidanwei=getPostValue("goumaidanwei");$sql=$sql." and goumaidanwei like '%$nreqgoumaidanwei%'";}
if (getPostValue("zhidanren")!=""){$nreqzhidanren=getPostValue("zhidanren");$sql=$sql." and zhidanren like '%$nreqzhidanren%'";}
if (getPostValue("jingshouren")!=""){$nreqjingshouren=getPostValue("jingshouren");$sql=$sql." and jingshouren like '%$nreqjingshouren%'";}
if (getPostValue("shangpinbianhao")!=""){$nreqshangpinbianhao=getPostValue("shangpinbianhao");$sql=$sql." and shangpinbianhao like '%$nreqshangpinbianhao%'";}
if (getPostValue("shangpinmingcheng")!=""){$nreqshangpinmingcheng=getPostValue("shangpinmingcheng");$sql=$sql." and shangpinmingcheng like '%$nreqshangpinmingcheng%'";}
if (getPostValue("fukuanzhanghu")!=""){$nreqfukuanzhanghu=getPostValue("fukuanzhanghu");$sql=$sql." and fukuanzhanghu like '%$nreqfukuanzhanghu%'";}
if (getPostValue("issh")!=""){$nissh=getPostValue("issh");$sql=$sql." and issh like '%$nissh%'";}
  $sql=$sql." order by id desc";
  
  $query=$conn->query($sql);
  $rowscount=$query->num_rows;
  $arr = $query->fetch_all(MYSQLI_BOTH);
  if($rowscount==0)
  {}
  else
  {
  $pagelarge=10;//每页行数；
  $pagecurrent=getValue("pagecurrent");
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
  $ze=0;
	for($i=$pagecurrent*$pagelarge-$pagelarge;$i<$ddddd;$i++)
	
{
$ze=$ze+floatval($arr[$i]["jine"]);
  ?>
  <tr>
    <td width="25"><?php
	echo $i+1;
?></td>
    <td><?php echo $arr[$i]["danjubianhao"];?></td>
    <td><?php echo $arr[$i]["goumaidanwei"];?></td>
    <td><?php echo $arr[$i]["zhidanren"];?></td>
    <td><?php echo $arr[$i]["jingshouren"];?></td>
    <td><?php echo $arr[$i]["shangpinbianhao"];?></td>
    <td><?php echo $arr[$i]["shangpinmingcheng"];?></td>
    <td><?php echo $arr[$i]["shengchanriqi"];?></td>
    <td><?php echo $arr[$i]["danjia"];?></td>
    <td><?php echo $arr[$i]["shuliang"];?></td>
    <td><?php echo $arr[$i]["jine"];?></td>
    <td><?php echo $arr[$i]["fukuanzhanghu"];?></td>
    <td width="120" align="center"><?php
echo $arr[$i]["addtime"];
?></td>
    <td width="90" align="center">
	<a href="sh.php?id=<?php echo $arr[$i]["id"] ?>&yuan=<?php echo $arr[$i]["issh"]?>&tablename=xiaoshoudan" onclick="return confirm('您确定要执行此操作？')"><?php echo $arr[$i]["issh"]?></a>	</td>
    <td width="90" align="center">
	<?php
	if ($arr[$i]["issh"]=="是")
	{
		$arr[$i]["zt"];
	}
	else
	{
	  ?>
	<a href="zt.php?id=<?php echo $arr[$i]["id"] ?>&yuan=<?php echo $arr[$i]["zt"] ?>"><?php echo $arr[$i]["zt"] ?></a>
	  <?php
	}
	
	?>
	
	</td>
    <td width="90" align="center"><a href="del.php?id=<?php echo $arr[$i]["id"];?>&tablename=xiaoshoudan" onclick="return confirm('真的要删除？')">删除</a> <a href="xiaoshoudan_updt.php?id=<?php echo $arr[$i]["id"];?>">修改</a> <a href="xiaoshoudan_detail.php?id=<?php echo $arr[$i]["id"];?>">详细</a> </td>
  </tr>
  	<?php
	}
}
?>
</table>
<p>以上数据共<?php
		echo $rowscount;
	?>条，共计总额<?php echo $ze?>元,
  <input type="button" name="Submit2" onclick="javascript:window.print();" value="打印本页" />
</p>
<p align="center"><a href="xiaoshoudan_list.php?pagecurrent=1">首页</a>, <a href="xiaoshoudan_list.php?pagecurrent=<?php echo $pagecurrent-1;?>">前一页</a> ,<a href="xiaoshoudan_list.php?pagecurrent=<?php echo $pagecurrent+1;?>">后一页</a>, <a href="xiaoshoudan_list.php?pagecurrent=<?php echo $pagecount;?>">末页</a>, 当前第<?php echo $pagecurrent;?>页,共<?php echo $pagecount;?>页 </p>

<p>&nbsp; </p>

</body>
</html>

