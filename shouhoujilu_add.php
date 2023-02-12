<?php
session_start();
include_once 'conn.php';
$ndate =date("Y-m-d");
$addnew=$_POST["addnew"];
if ($addnew=="1" )
{
	$danjubianhao=$_POST["danjubianhao"];$shangpinmingcheng=$_POST["shangpinmingcheng"];$kehuxingming=$_POST["kehuxingming"];$kehudianhua=$_POST["kehudianhua"];$shouhouyaoqiu=$_POST["shouhouyaoqiu"];$fuwuneirong=$_POST["fuwuneirong"];$beizhu=$_POST["beizhu"];
	$sql="insert into shouhoujilu(danjubianhao,shangpinmingcheng,kehuxingming,kehudianhua,shouhouyaoqiu,fuwuneirong,beizhu) values('$danjubianhao','$shangpinmingcheng','$kehuxingming','$kehudianhua','$shouhouyaoqiu','$fuwuneirong','$beizhu') ";
	mysql_query($sql);
	echo "<script>javascript:alert('��ӳɹ�!');location.href='shouhoujilu_add.php';</script>";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�ۺ��¼</title><script language="javascript" src="js/Calendar.js"></script><link rel="stylesheet" href="css.css" type="text/css">
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
<p>����ۺ��¼�� ��ǰ���ڣ� <?php echo $ndate; ?></p>
<script language="javascript">
	function check()
{
	if(document.form1.danjubianhao.value==""){alert("�����뵥�ݱ��");document.form1.danjubianhao.focus();return false;}if(document.form1.shangpinmingcheng.value==""){alert("��������Ʒ����");document.form1.shangpinmingcheng.focus();return false;}if(document.form1.kehuxingming.value==""){alert("������ͻ�����");document.form1.kehuxingming.focus();return false;}if(document.form1.kehudianhua.value==""){alert("������ͻ��绰");document.form1.kehudianhua.focus();return false;}
}
	function gow()
	{
		location.href='shouhoujilu_add.php?danjubianhao='+document.form1.danjubianhao.value;
	}
</script>
<form id="form1" name="form1" method="post" action="">
<table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#00FFFF" style="border-collapse:collapse">    
	<tr><td>���ݱ�ţ�</td><td><select name='danjubianhao' id='danjubianhao' onchange='();'><?php getoption2("xiaoshoudan","danjubianhao")?></select></td></tr><tr><td>��Ʒ���ƣ�</td><td><input name='shangpinmingcheng' type='text' id='shangpinmingcheng' <?php getitem("xiaoshoudan","shangpinmingcheng","danjubianhao",$_GET["danjubianhao"])?> />&nbsp;*</td></tr><tr><td>�ͻ�������</td><td><input name='kehuxingming' type='text' id='kehuxingming' value='' />&nbsp;*</td></tr><tr><td>�ͻ��绰��</td><td><input name='kehudianhua' type='text' id='kehudianhua' value='' />&nbsp;*</td></tr><tr><td>�ۺ�Ҫ��</td><td><textarea name='shouhouyaoqiu' cols='50' rows='8' id='shouhouyaoqiu'></textarea></td></tr><tr><td>�������ݣ�</td><td><textarea name='fuwuneirong' cols='50' rows='8' id='fuwuneirong'></textarea></td></tr><tr><td>��ע��</td><td><textarea name='beizhu' cols='50' rows='8' id='beizhu'></textarea></td></tr>

    <tr>
      <td>&nbsp;</td>
      <td><input type="hidden" name="addnew" value="1" />
        <input type="submit" name="Submit" value="���" onclick="return check();" />
      <input type="reset" name="Submit2" value="����" /></td>
    </tr>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>

