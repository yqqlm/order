<?php 
$id=$_GET["id"];
include_once 'conn.php';
$ndate =date("Y-m-d");
$addnew=isset($_POST["addnew"])?$_POST["addnew"]:0;
if ($addnew=="1" )
{

	$shangpinbianhao=$_POST["shangpinbianhao"];$shangpinmingcheng=$_POST["shangpinmingcheng"];$guige=$_POST["guige"];$chandi=$_POST["chandi"];$baozhiqi=$_POST["baozhiqi"];$beizhu=$_POST["beizhu"];
	$sql="update shangpinxinxi set shangpinbianhao='$shangpinbianhao',shangpinmingcheng='$shangpinmingcheng',guige='$guige',chandi='$chandi',baozhiqi='$baozhiqi',beizhu='$beizhu' where id= ".$id;
	$conn->query($sql);
	echo "<script>javascript:alert('修改成功!');location.href='shangpinxinxi_list.php';</script>";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>修改商品信息</title><link rel="stylesheet" href="css.css" type="text/css"><script language="javascript" src="js/Calendar.js"></script>
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
<p>修改商品信息： 当前日期： <?php echo $ndate; ?></p>
<?php
$sql="select * from shangpinxinxi where id=".$id;
$query=$conn->query($sql);
$rowscount=$query->num_rows;
$arr = $query->fetch_all(MYSQLI_BOTH);
if($rowscount>0)
{
?>
<form id="form1" name="form1" method="post" action="">
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#00FFFF" style="border-collapse:collapse"> 

      <tr><td>商品编号：</td><td><input name='shangpinbianhao' type='text' id='shangpinbianhao' value='<?php echo $arr[0]["shangpinbianhao"];?>' /></td></tr><tr><td>商品名称：</td><td><input name='shangpinmingcheng' type='text' id='shangpinmingcheng' size='50' value='<?php echo $arr[0]["shangpinmingcheng"];?>' /></td></tr><tr><td>规格：</td><td><input name='guige' type='text' id='guige' size='50' value='<?php echo $arr[0]["guige"];?>' /></td></tr><tr><td>产地：</td><td><input name='chandi' type='text' id='chandi' value='<?php echo $arr[0]["chandi"];?>' /></td></tr><tr><td>保质期：</td><td><input name='baozhiqi' type='text' id='baozhiqi' value='<?php echo $arr[0]["baozhiqi"];?>' /></td></tr><tr><td>备注：</td><td><textarea name='beizhu' cols='50' rows='8' id='beizhu'><?php echo $arr[0]["beizhu"];?></textarea></td></tr>
   
   
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

