<?php

include_once 'conn.php';
include_once 'tables.php';
include_once 'commonscript.php';
$ndate =date("Y-m-d");
$addnew=getPostValue("addnew");
$fromProducts=getValue("fromProducts");
$id=getValue("id");
checkSessionTimeOut();
$mc="";
$bh="";
$gg="";
if ($addnew=="1" )
{
	$id=$table->getCurrentRecordField("id");
	echo "id=".$id;
	$table->setValsFromPost("kucun");
	$msg=$table->setRecord("kucun",null);
	if($msg==""){
		$historyBack=$table->getHistoryBack();
		//echo "<script>javascript:alert('修改成功');location.href='kucun_updt.php?id=".$id."';</script>";
		echo "<script>$historyBack;</script>";
	}else{
		echo $msg;
		echo  "<script>javascript:alert('".$msg."');location.href='kucun_updt.php?id=".$id."';</script>";
	}
}else if($fromProducts!=1){

	$record=$table->getRecord("kucun",$id);
	$table->setCurrentRecord($record);
	if(isset($record["shangpinmingcheng"])){
		$mc=$record["shangpinmingcheng"];
	}
	if(isset($record["shangpinbianhao"])){
		$mc=$record["shangpinbianhao"];
	}
	if(isset($record["guige"])){
		$mc=$record["guige"];
	}
}else{
	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>修改库存</title><script language="javascript" src="js/Calendar.js"></script><link rel="stylesheet" href="css.css" type="text/css">
</head>
<?php echo getCommonScript();?>
<body>
<p>修改库存 <?php echo $ndate; ?></p>

<script language="javascript">
function check()
{
	if(document.form1.shangpinleibie.value==""){alert("请输入商品类别");document.form1.shangpinleibie.focus();return false;}
    if(document.form1.shangpinbianhao.value==""){alert("请输入商品型号");document.form1.shangpinbianhao.focus();return false;}
    if(document.form1.shangpinmingcheng.value==""){alert("请输入商品名称");document.form1.shangpinmingcheng.focus();return false;}
    if(document.form1.guige.value==""){alert("请输入规格");document.form1.guige.focus();return false;}
}

function calcJine()
{
  document.form1.jine.value=document.form1.danjia.value*document.form1.shuliang.value;
}

</script>
<form id="form1" name="form1" method="post" action="">
<?php
echo $table->getDetail("kucun",2,null);
?>
<?php
//echo "<script>initCanPinXinXi('$mc','$bh','$gg')</script>";
?>
</form>
<p>&nbsp;</p>
</body>
</html>

