<?php

include_once 'conn.php';
include_once 'tables.php';
include_once 'commonscript.php';
checkSessionTimeOut();
$ndate =date("Y-m-d");
$addnew=getPostValue("addnew");
$tablename=getValue("tablename");
$tabletitle=getValue("tabletitle");
$key=$table->getTableKey($tablename);
$checkList=$table->tableCheckList[$tablename];
if ($addnew=="1" )
{
	$table->setCurrentRecordWithForm($tablename);
    $msg=$table->setRecord($tablename  ,"add");
    if($msg==""){
        echo "<script>javascript:alert('添加成功');location.href='table_add.php?tablename=".$tablename."&tabletitle=".$tabletitle."';</script>";
    }else{
        if(strpos($msg,"Duplicate")>=0){
            echo $key."重复";
        }else{
            echo $msg;
        }
    }
}else {
    $record=$table->getRecord($tablename,"");
	$table->setCurrentRecord($record);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title><?php echo $tabletitle;?></title><script language="javascript" src="js/Calendar.js"></script><link rel="stylesheet" href="css.css" type="text/css">
</head>
<?php echo getCommonScript();?>
<body>
<p>添加<?php echo $tabletitle;?></p>
<p>今天是： <?php echo "  ".$ndate; ?></p>
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
echo $table->getDetail($tablename,1,null);
?>
</form>
<p>&nbsp;</p>
</body>
</html>

