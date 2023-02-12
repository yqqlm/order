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
    $vals=$table->getValsFromForm("xiaoshoudanproducts");
    $table->setCurrentRecordArrField("products",$index,$vals,"xiaoshoudanproducts");
    if($editType=="1" || $editType==1){
        echo "<script>location.href='xiaoshoudan_add.php?fromProducts=1';</script>";
    }else{
        echo "<script>location.href='xiaoshoudan_updt.php?fromProducts=1';</script>";
    }
	
}else{
    $table->setValsFromGet("xiaoshoudan");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>修改销售单产品</title><script language="javascript" src="js/Calendar.js"></script><link rel="stylesheet" href="css.css" type="text/css">
</head>

<body>
<p>修改销售单产品</p>
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
$dingdandate=$record['dingdandate'];
echo "<p> 订单日期：".$dingdandate."<p>";
echo $table->getDetail("xiaoshoudanproducts",2,$rec);
?>

<script>
var visibility="hidden";
function switchVisibility(){
    if(visibility==="hidden"){
        document.getElementById("jinjialist").style.visibility="visible";
        document.getElementById("showjinjia").value="隐藏采购单信息";
        visibility="visible";
    }else{
        document.getElementById("jinjialist").style.visibility="hidden";
        document.getElementById("showjinjia").value="显示采购单信息";
        visibility="hidden";
    }
}
</script>

<?php
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
$sql="select caigoudanproducts.*, caigoudan.addtime as addtime from caigoudanproducts left join caigoudan on caigoudanproducts.caigoudanid=caigoudan.id where shangpinbianhao='$bh' and shangpinmingcheng='$mc'  order by addtime desc";
$arrOpts=array();
echo "<p>";
if($_SESSION['cx']==="系统管理员"){
    echo "以下是该产品的采购单信息 <p>";
    echo "<div id='jinjialist'>";
    $table->getListTable("caigoudanproducts_jinjia",$sql,$arrOpts,array(),null);
    echo "</div>";
}

?>
</form>
<p>&nbsp;</p>
</body>
</html>

