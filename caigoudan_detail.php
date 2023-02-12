<?php 
$id=$_GET["id"];
include_once 'conn.php';
include_once 'tables.php';
$ndate =date("Y-m-d");
$id=getValue("id");
checkSessionTimeOut();
$record=$table->getRecord("caigoudan",$id);
$table->setCurrentRecord($record);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>采购单详细信息</title><link rel="stylesheet" href="css.css" type="text/css">
</head>
<body>
<p>采购单详细信息 当前日期： <?php echo $ndate; ?> </p>

<?php $tables=new Tables();echo $tables->getDetail("caigoudan",0,null);?>
<br>
<?php
if($_SESSION['cx']==="系统管理员" || $_SESSION['cx']==="营业录入员" ){
?>
<input type="button" id="Submit3" name="Submit3" onclick="location.href='products_ruku.php?id=<?php echo $id; ?>';" value="产品批量入库" />

<script>
<?php
    
    echo "document.getElementById('Submit3').disabled=".isRuKu($id);
?>
</script>
<?php
}
?>
<p>&nbsp;</p>
</body>
</html>

