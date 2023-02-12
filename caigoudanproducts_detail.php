<?php 
include_once 'conn.php';
include_once 'tables.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<?php 
$id=$_GET["id"];
include_once 'conn.php';
include_once 'tables.php';
$initSql="select * from caigoudanproducts where caigoudanid=".$id;;
?>
<title>采购单产品信息<?php echo $id?>采购单产品信息</title><link rel="stylesheet" href="css.css" type="text/css">
</head>

<body>

<p></p>

<p></p>
<?php 
  $tables=new Tables();
  $arrOpts=array();
  $tables->getListTable("caigoudanproducts",$initSql,$arrOpts,array(),null);
  ?>
  <input type="button" name="Submit2" onclick="javascript:history.back();" value="返回" />
</p>


</body>
</html>

