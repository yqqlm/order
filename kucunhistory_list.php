<?php 
include_once 'conn.php';
include_once 'tables.php';
include 'commonscript.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>库存信息</title><link rel="stylesheet" href="css.css" type="text/css">
</head>
<?php echo getCommonScript();?>

<body>
<p></p>
<?php 
checkSessionTimeOut();
$mc=getValue("shangpinmingcheng");
$bh=getValue("shangpinbianhao");
$gg=getValue("guige");
?>
<form id="form1" name="form1" method="get" action="">
  搜索: 
  商品名称：<select name='shangpinmingcheng' id='shangpinmingcheng' style="width: 20%"></select><script>$("#shangpinmingcheng").select2()</script>
  商品型号：<select name='shangpinbianhao' id='shangpinbianhao'  style="width: 20%"></select><script>$("#shangpinbianhao").select2()</script>
  包装规格：<select name='guige' id='guige'  style="width: 20%"></select><script>$("#guige").select2()</script>
<?php
  echo "<script>initCanPinXinXi('$mc','$bh','$gg')</script>";
?>

  <input type="hidden" name="pagecurrent" value="<?php if (getValue("pagecurrent")) echo getValue("pagecurrent"); else echo '1'; ?>" />
  <input type="submit" name="Submit" value="查找" />
</form>

<p></p>
<p>库存信息:</p>
<?php 
    $total=0;
    $sql="select * from kucunhistory where 1=1";
  
    if ($mc!=""){$sql=$sql." and shangpinmingcheng = '$mc'";}
    if ($bh!=""){$sql=$sql." and shangpinbianhao = '$bh'";}
    if ($gg!=""){$sql=$sql." and guige = '$gg'";}
    $sql=$sql."  order by id desc";
    $tables=new Tables();
    $arrOpts=array();
    if($_SESSION['cx']==="销售总监" || $_SESSION['cx']==="销售经理" ){
      
    }else{
      array_push($arrOpts,"del","update","add");
    }
    
    $tables->getListTable("kucunhistory",$sql,$arrOpts,array(),null);
  ?>
  <input type="button" name="Submit2" onclick="javascript:window.print();" value="打印" />

</p>

</body>
</html>

