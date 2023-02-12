<?php
session_start();
include_once 'conn.php';
include_once 'tables.php';
include_once 'commonscript.php';
$ndate =date("Y-m-d");
$addnew=getPostValue("addnew");
$editType=getValue("editType");
$mc="";
$bh="";
$gg="";
if ($addnew=="1")
{

    $vals=$table->getValsFromForm("caigoudanproducts");
   
    $table->pushCurrentRecordArrField("products",$vals);

    if($editType=="1" || $editType==1){
        echo "<script>location.href='caigoudan_add.php?fromProducts=1';</script>";
    }else{
        echo "<script>location.href='caigoudan_updt.php?fromProducts=1';</script>";
    }
	
}else{
    $table->setValsFromGet("caigoudan");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>添加采购单产品 </title><script language="javascript" src="js/Calendar.js"></script><link rel="stylesheet" href="css.css" type="text/css">
</head>

<body>
<p>添加销售单产品 <?php echo $ndate; ?></p>
<?php echo getCommonScript();?>
<script language="javascript">
function check()
{
    return checkProduct();
}
</script>
<form id="form1" name="form1" method="post" action="">
<?php
$rec=$table->getRecord("caigoudanproducts","");
$rec["caigoudanid"]=$table->getCurrentRecordField("id");
echo $table->getDetail("caigoudanproducts",1,$rec);
?>
<?php
  echo "<script>initCanPinXinXi('$mc','$bh','$gg')</script>";
?>
</form>
<p>&nbsp;</p>
</body>
</html>

