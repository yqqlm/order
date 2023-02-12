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
$_SESSION["ListUrl"]= (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
checkSessionTimeOut();
$mc=getValue("shangpinmingcheng");
$bh=getValue("shangpinbianhao");
$gg=getValue("guige");
?>
<form id="form1" name="form1" method="get" action="">


搜索: 
  商品名称：<select name='shangpinmingcheng' id='shangpinmingcheng' style="width: 20%"></select>
  <script>
  $("#shangpinmingcheng").select2(); 
  </script>
  商品型号：<select name='shangpinbianhao' id='shangpinbianhao'  style="width: 20%"></select><script>$("#shangpinbianhao").select2()</script>
  包装规格：<select name='guige' id='guige'  style="width: 20%"></select><script>$("#guige").select2()</script>
<?php
  echo "<script>initCanPinXinXi('$mc','$bh','$gg')</script>";
?>
<p></p>

商品类别：<?php getSelect("shangpinleibie","splb","name",false,150,true); ?>
&nbsp;制造商：<?php getSelect("zhizhaoshang","zhizhaoshang","name",true,150,true); ?>
&nbsp;<input type="checkbox" name="nullleibie" <?php if (getValue("nullleibie"))echo "checked='checked'";?> />类别为空
&nbsp;<input type="checkbox" name="nullzhizhaoshang" <?php if (getValue("nullzhizhaoshang"))echo "checked='checked'";?> />制造商为空
&nbsp;<input type="checkbox" name="haskucun" <?php if (getValue("haskucun"))echo "checked='checked'";?> />库存不为空
<p></p>
  <input type="hidden" name="pagecurrent" value="<?php if (getValue("pagecurrent")) echo getValue("pagecurrent"); else echo '1'; ?>" />
  <input type="submit" name="Submit" value="查找" />
  
</form>

<p></p>
<p>库存信息:</p>
<?php 
    $total=0;
    $sql="select * from kucun where 1=1";
    $sqlw=" where 1=1 ";
    if ($mc!=""){$sql=$sql." and shangpinmingcheng = '$mc'";$sqlw=$sqlw." and shangpinmingcheng = '$mc'";}
    if ($bh!=""){$sql=$sql." and shangpinbianhao = '$bh'";$sqlw=$sqlw." and shangpinbianhao = '$bh'";}
    if ($gg!=""){$sql=$sql." and guige = '$gg'";$sqlw=$sqlw." and guige = '$gg'";}
    if(getValue("shangpinleibie")){
      $val=getValue("shangpinleibie");
      $sql=$sql." and (shangpinleibie like '%$val%')";
      $sqlw=$sqlw." and (shangpinleibie like '%$val%')";
    }
    if(getValue("zhizhaoshang")){
      $val=getValue("zhizhaoshang");
      $sql=$sql." and (zhizhaoshang like '%$val%')";
      $sqlw=$sqlw." and (zhizhaoshang like '%$val%')";
    }
    if(getValue("nullleibie")){

      $sql=$sql." and (shangpinleibie is null or shangpinleibie ='')";
      $sqlw=$sqlw." and (shangpinleibie is null or shangpinleibie ='')";
    }
    if(getValue("nullzhizhaoshang")){

      $sql=$sql." and (zhizhaoshang is null or zhizhaoshang ='')";
      $sqlw=$sqlw." and (zhizhaoshang is null or zhizhaoshang ='')";
    }
    if(getValue("haskucun")){

      $sql=$sql." and (shuliang is not null and shuliang !=0)";
      $sqlw=$sqlw." and (shuliang is not null and shuliang !=0)";
    }
    $sql=$sql."  order by shangpinleibie,shangpinmingcheng,shangpinbianhao desc";
    //echo "sql=".$sql;
    $tables=new Tables();
    $arrOpts=array();
    if($_SESSION['cx']==="销售总监" || $_SESSION['cx']==="销售经理" ){
      
    }else{
      array_push($arrOpts,"del","update");
    }
    
    $tables->getListTable("kucun",$sql,$arrOpts,array(),null);
    if($_SESSION['cx']==="系统管理员"){
      $sql="select sum(shuliang*danjia),sum(shuliang) from kucun ".$sqlw;
      global $conn;
      $query=$conn->query($sql);
      $arr = $query->fetch_all(MYSQLI_BOTH);
      $total=$arr[0][0];
      $sum=$arr[0][1];
      echo "<p> 库存总金额:".round($total,2)."</p>";
      echo "<p> 库存总数量（公斤）:".round($sum,2)."</p>";
    }
  ?>
  <input type="button" name="Submit2" onclick="javascript:window.print();" value="打印" />
  <?php
  if($_SESSION['cx']==="系统管理员" || $_SESSION['cx']==="营业录入员" ){
  ?>
  <input type="button" name="pandian" onclick="location.href='kucun_pandian.php'" value="更新盘点库存" />
  <input type="button" name="add" onclick="location.href='kucun_add.php'" value="添加新产品" />
  <input type="button" name="updatedanjia" onclick="location.href='kucun_updateDanJiaWithCaiGou.php'" value="更新库存商品单价" />
  <?php
  }
  ?>

</p>

</body>
</html>

