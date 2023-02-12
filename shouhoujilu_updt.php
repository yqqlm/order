<?php 
$id=$_GET["id"];
include_once 'conn.php';
$ndate =date("Y-m-d");
$addnew=$_POST["addnew"];
if ($addnew=="1" )
{

	$danjubianhao=$_POST["danjubianhao"];$shangpinmingcheng=$_POST["shangpinmingcheng"];$kehuxingming=$_POST["kehuxingming"];$kehudianhua=$_POST["kehudianhua"];$shouhouyaoqiu=$_POST["shouhouyaoqiu"];$fuwuneirong=$_POST["fuwuneirong"];$beizhu=$_POST["beizhu"];
	$sql="update shouhoujilu set danjubianhao='$danjubianhao',shangpinmingcheng='$shangpinmingcheng',kehuxingming='$kehuxingming',kehudianhua='$kehudianhua',shouhouyaoqiu='$shouhouyaoqiu',fuwuneirong='$fuwuneirong',beizhu='$beizhu' where id= ".$id;
	mysql_query($sql);
	echo "<script>javascript:alert('修改成功!');location.href='shouhoujilu_list.php';</script>";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>修改售后记录</title><link rel="stylesheet" href="css.css" type="text/css"><script language="javascript" src="js/Calendar.js"></script>
</head>
<script language="javascript">
	
	
	function OpenScript(url,width,height)
{
  var win = window.open(url,"SelectToSort",'width=' + width + ',height=' + height + ',resizable=1,scrollbars=yes,menubar=no,status=yes' );
}
	function OpenDialog(sURL, iWidth, iHeight)
{
   var oDialog = window.open(sURL, "_EditorDialog", "width=" + iWidth.toString() + ",height=" + iHeight.toString() + ",resizable=no,left=0,top=0,scrollbars=no,status=no,titlebar=no,toolbar=no,menubar=no,location=no");
   oDialog.focus();
}
</script>
<body>
<p>修改售后记录： 当前日期： <?php echo $ndate; ?></p>
<?php
$sql="select * from shouhoujilu where id=".$id;
$query=mysql_query($sql);
$rowscount=mysql_num_rows($query);
if($rowscount>0)
{
?>
<form id="form1" name="form1" method="post" action="">
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#00FFFF" style="border-collapse:collapse"> 

      <tr><td>单据编号：</td><td><input name='danjubianhao' type='text' id='danjubianhao' value='<?php echo mysql_result($query,$i,danjubianhao);?>' /></td></tr><tr><td>商品名称：</td><td><input name='shangpinmingcheng' type='text' id='shangpinmingcheng' value='<?php echo mysql_result($query,$i,shangpinmingcheng);?>' /></td></tr><tr><td>客户姓名：</td><td><input name='kehuxingming' type='text' id='kehuxingming' value='<?php echo mysql_result($query,$i,kehuxingming);?>' /></td></tr><tr><td>客户电话：</td><td><input name='kehudianhua' type='text' id='kehudianhua' value='<?php echo mysql_result($query,$i,kehudianhua);?>' /></td></tr><tr><td>售后要求：</td><td><textarea name='shouhouyaoqiu' cols='50' rows='8' id='shouhouyaoqiu'><?php echo mysql_result($query,$i,shouhouyaoqiu);?></textarea></td></tr><tr><td>服务内容：</td><td><textarea name='fuwuneirong' cols='50' rows='8' id='fuwuneirong'><?php echo mysql_result($query,$i,fuwuneirong);?></textarea></td></tr><tr><td>备注：</td><td><textarea name='beizhu' cols='50' rows='8' id='beizhu'><?php echo mysql_result($query,$i,beizhu);?></textarea></td></tr>
   
   
    <tr>
      <td>&nbsp;</td>
      <td><input name="addnew" type="hidden" id="addnew" value="1" />
      <input type="submit" name="Submit" value="修改" />
      <input type="reset" name="Submit2" value="重置" /></td>
    </tr>
  </table>
</form>
<?php
	}
?>
<p>&nbsp;</p>
</body>
</html>

