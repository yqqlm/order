<?php 
$id=$_GET["id"];
include_once 'conn.php';
include_once 'tables.php';
$ndate =date("Y-m-d");
$id=getValue("id");
$tablename=getValue("tablename");
$tabletitle=getValue("tabletitle");
checkSessionTimeOut();
$record=$table->getRecord($tablename,$id);
$table->setCurrentRecord($record);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title><?php echo $tabletitle; ?>详细信息</title><link rel="stylesheet" href="css.css" type="text/css">
</head>
<body>
<p><?php echo $tabletitle; ?>详细信息 当前日期： <?php echo $ndate; ?></p>

<?php $tables=new Tables();echo $tables->getDetail($tablename,0,null);?>
<br>

</body>
</html>

