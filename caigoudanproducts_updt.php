<?php
session_start();
include_once 'conn.php';
include_once 'tables.php';
include_once 'commonscript.php';
$ndate =date("Y-m-d");
$addnew=getPostValue("addnew");
$editType=getValue("editType");
$index=getValue("id");
$mc="";
$bh="";
$gg="";
if ($addnew=="1")
{
    $vals=$table->getValsFromForm("caigoudanproducts");
    $table->setCurrentRecordArrField("products",$index,$vals,"caigoudanproducts");
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
<title>修改采购单产品</title><script language="javascript" src="js/Calendar.js"></script><link rel="stylesheet" href="css.css" type="text/css">
</head>

<body>
<p>修改采购单产品<?php echo $ndate; ?></p>
<?php echo getCommonScript();?>
<script language="javascript">
function check()
{
    return checkProduct();
}
</script>
<form id="form1" name="form1" method="post" action="">
<?php
$record=$table->getCurrentRecord();
$rec=$record["products"][$index];
echo $table->getDetail("caigoudanproducts",2,$rec);
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
?>
</form>
<p>&nbsp;</p>
</body>
</html>

