<?php 
include_once 'conn.php';
include_once 'tables.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>配方列表</title><link rel="stylesheet" href="css.css" type="text/css">
</head>

<body>



<p></p>
<?php 
checkSessionTimeOut();
$t=getPostValue("title");
$d=getPostValue("peifang_describe");
?>
<form id="form1" name="form1" method="get" action="">
  搜索: 名称：<input name="title" type="text" id="title" value="<?php echo $t; ?>" />
   描述：<input name="peifang_describe" type="text" id="peifang_describe"  value="<?php echo $d; ?>"/>
   
  <input type="hidden" name="pagecurrent" value="<?php if (getValue("pagecurrent")) echo getValue("pagecurrent"); else echo '1'; ?>" />
  <input type="submit" name="Submit" value="查找" />
</form>

<p></p>
<p>配方列表</p>
<?php 
    
    $sql="select * from peifang where 1=1";
  
    if (getPostValue("title")!=""){$nreq=$_POST["title"];$sql=$sql." and title = '$nreq'";}
    if (getPostValue("peifang_describe")!=""){$nreq=$_POST["peifang_describe"];$sql=$sql." and peifang_describe like '$nreq'";}

    $sql=$sql."  order by id desc";
    $tables=new Tables();
    $arrOpts=array();
    array_push($arrOpts,"del","update");
    $tables->getListTable("peifang",$sql,$arrOpts,array(),null);

  ?>

</p>

</body>
</html>

