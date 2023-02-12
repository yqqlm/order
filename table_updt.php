<?php
session_start();
include_once 'conn.php';
include_once 'tables.php';
include_once 'commonscript.php';
$ndate =date("Y-m-d");
$addnew=getPostValue("addnew");
$fromProducts=getValue("fromProducts");
$id=getValue("id");
$tablename=getValue("tablename");
$tabletitle=getValue("tabletitle");
$checkList=$table->tableCheckList[$tablename];
$key="id";
if(isset($table->tableKey[$tablename])){
  $key=$table->tableKey[$tablename];
}
checkSessionTimeOut();
if ($addnew=="1" )
{
	$id=$table->getCurrentRecordField($key);
	//echo "key=".$id;
	$table->setValsFromPost($tablename);
	$msg=$table->setRecord($tablename,"update");
	if($msg==""){
		$historyBack=$table->getHistoryBack();
		//echo "<script>javascript:alert('修改成功');location.href='kucun_updt.php?id=".$id."';</script>";
		echo "<script>$historyBack;</script>";
		//echo "<script>javascript:alert('$historyBack');</script>";
	}else{
		
		echo $msg;
	}
}else if($fromProducts!=1){

	$record=$table->getRecord($tablename,$id);
	$table->setCurrentRecord($record);
	
}else{
	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>修改<?php echo $tablename;?></title><script language="javascript" src="js/Calendar.js"></script><link rel="stylesheet" href="css.css" type="text/css">
</head>
<?php echo getCommonScript();?>
<body>
<p>修改<?php echo $tabletitle;?> <?php echo $ndate; ?></p>
<div id="myModal" class="modal">
    <span class="close cursor" onclick="closeModal()">&times;</span>
    <div class="modal-content">
        <img src="图片路径" style="width: 100%" id="previewImage" onclick="closeModal()">
    </div>
</div>
<script language="javascript">
function check()
{
    <?php
     $length=count($checkList);
     for($x=0;$x<$length;$x++){
        echo "if(document.form1.".$checkList[$x].".value==''){alert('请输入".$checkList[$x]."');document.form1.".$checkList[$x].".focus();return false;}";
     }
    ?>
	}

</script>
<form id="form1" name="form1" method="post" action="">
<?php
echo $table->getDetail($tablename,2,null);
if($tablename==="xiaoshoudanproducts" || $tablename==="caigoudanproducts"){
	$rec=$table->getCurrentRecord();

	if(isset($rec["shangpinmingcheng"])){
		$mc=$rec["shangpinmingcheng"];
	}
	if(isset($rec["shangpinbianhao"])){
		$bh=$rec["shangpinbianhao"];
	}
	if(isset($rec["guige"])){
		$gg=$rec["guige"];
	}
	echo "<script>initCanPinXinXi('$mc','$bh','$gg')</script>";
}

?>
</form>
<p>&nbsp;</p>
</body>
</html>

