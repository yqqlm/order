<?php

include_once 'conn.php';
include_once 'tables.php';
include_once 'commonscript.php';
checkSessionTimeOut();
$ndate =date("Y-m-d");
$addnew=getPostValue("addnew");
$fromProducts=getPostValue("fromProducts");
$mc="";
$bh="";
$gg="";
if ($addnew=="1" )
{
	$table->setCurrentRecordWithForm("kucunhistory");
    $table->setCurrentRecordField("kehumingcheng",getPostValue("zhizhaoshang"));
    $msg=$table->setRecord("kucunhistory",null);
    if($msg==""){
        $historyBack=$table->getHistoryBack();
		//echo "<script>javascript:alert('修改成功');location.href='kucun_updt.php?id=".$id."';</script>";
		echo "<script>$historyBack;</script>";
        //echo "<script>javascript:alert('添加成功');location.href='kucun_add.php';</script>";
    }else{
        echo $msg;
    }
}else if($fromProducts!="1"){
	$record=$table->getRecord("kucun","");
	$table->setCurrentRecord($record);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>添加库存信息</title><script language="javascript" src="js/Calendar.js"></script><link rel="stylesheet" href="css.css" type="text/css">
</head>
<?php echo getCommonScript();?>
<body>
<p>添加库存信息</p>
<p>今天是： <?php echo "  ".$ndate; ?></p>
<script language="javascript">
function check()
{
    if(document.form1.shangpinleibie.value==""){alert("请输入商品类别");document.form1.shangpinleibie.focus();return false;}
	if(document.form1.shangpinbianhao.value==""){alert("请输入商品型号");document.form1.shangpinbianhao.focus();return false;}
    if(document.form1.shangpinmingcheng.value==""){alert("请输入商品名称");document.form1.shangpinmingcheng.focus();return false;}
    if(document.form1.guige.value==""){alert("请输入规格");document.form1.guige.focus();return false;}
    if(document.form1.zhizhaoshang.value==""){alert("请输入制造商");document.form1.zhizhaoshang.focus();return false;}
}

function calcJine()
{
    document.form1.jine.value=document.form1.danjia.value*document.form1.shuliang.value;
}

</script>
<form id="form1" name="form1" method="post" action="">
<?php
echo $table->getDetail("kucun",1,null);
?>
<?php
  //echo "<script>initCanPinXinXi('$mc','$bh','$gg')</script>";
?>
</form>
<p>&nbsp;</p>
</body>
</html>

