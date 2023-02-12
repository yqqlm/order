<?php
session_start();
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
    $msg=$table->setRecord("kucunhistory",null);
    if($msg==""){
        echo "<script>javascript:alert('添加成功');location.href='kucunhistory_add.php';</script>";
    }else{
        echo $msg;
    }
}else if($fromProducts!="1"){
	$record=$table->getRecord("kucunhistory","");
	$table->setCurrentRecord($record);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>添加出入库信息</title><script language="javascript" src="js/Calendar.js"></script><link rel="stylesheet" href="css.css" type="text/css">
</head>
<?php echo getCommonScript();?>
<body>
<p>添加出入库信息</p>
<p>今天是： <?php echo "  ".$ndate; ?></p>
<script language="javascript">
function check()
{
	//if(document.form1.shangpinbianhao.value==""){alert("请输入商品型号");document.form1.shangpinbianhao.focus();return false;}
    //if(document.form1.shangpinmingcheng.value==""){alert("请输入商品名称");document.form1.shangpinmingcheng.focus();return false;}
    //if(document.form1.guige.value==""){alert("请输入规格");document.form1.guige.focus();return false;}
    return checkProduct();
}

function calcJine()
{
    document.form1.jine.value=document.form1.danjia.value*document.form1.shuliang.value;
}

</script>
<form id="form1" name="form1" method="post" action="">
<?php
echo $table->getDetail("kucunhistory",1,null);
?>
<?php
  echo "<script>initCanPinXinXi('$mc','$bh','$gg')</script>";
?>
</form>
<p>&nbsp;</p>
</body>
</html>

