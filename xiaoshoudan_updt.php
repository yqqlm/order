<?php
session_start();
include_once 'conn.php';
include_once 'tables.php';
include_once 'commonscript.php';

if(isset($_SESSION["ListUrl"])){
	//echo $_SESSION["ListUrl"];
}

$ndate =date("Y-m-d");
$addnew=getPostValue("addnew");
$fromProducts=getValue("fromProducts");
$id=getValue("id");
checkSessionTimeOut();
if ($addnew=="1" )
{
	$id=$table->getCurrentRecordField("id");
	echo "id=".$id;
	$table->setValsFromPost("xiaoshoudan");
	$msg=$table->setRecord("xiaoshoudan",null);
	if($msg==""){
		echo "<script>javascript:alert('修改成功');location.href='xiaoshoudan_updt.php?id=".$id."';</script>";
	}else{
		echo $msg;
		echo  "<script>javascript:alert('".$msg."');location.href='xiaoshoudan_updt.php?id=".$id."';</script>";
	}
}else if($fromProducts!=1){

	$record=$table->getRecord("xiaoshoudan",$id);
	$table->setCurrentRecord($record);
	
}else{
	
}
if(isset($_SESSION["Record"]["products_changed"]) && $_SESSION["Record"]["products_changed"]){
	
	//echo "products_changed";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>修改销售单</title><script language="javascript" src="js/Calendar.js"></script><link rel="stylesheet" href="css.css" type="text/css">
</head>
<?php echo getCommonScript();?>
<body>
<p>修改销售单 <?php echo $ndate; ?></p>
<div id="myModal" class="modal">
    <span class="close cursor" onclick="closeModal()">&times;</span>
    <div class="modal-content">
        <img src="图片路径" style="width: 100%" id="previewImage" onclick="closeModal()">
    </div>
</div>
<script language="javascript">
function check()
{
	if(document.form1.danjubianhao.value==""){alert("订单编号不能为空");document.form1.danjubianhao.focus();return false;}if(document.form1.goumaidanwei.value==""){alert("购买单位不能为空");document.form1.goumaidanwei.focus();return false;}if(document.form1.jingshouren.value==""){alert("经手人不能为空");document.form1.jingshouren.focus();return false;}if(document.form1.danjia.value==""){alert("单价不能为空");document.form1.danjia.focus();return false;}if(document.form1.shuliang.value==""){alert("数量不能为空");document.form1.shuliang.focus();return false;}
}

function calcJine()
{
  document.form1.jine.value=document.form1.danjia.value*document.form1.shuliang.value;
}

</script>
<form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
<?php
echo $table->getDetail("xiaoshoudan",2,null);
?>
</form>
<p>&nbsp;</p>
</body>
</html>

