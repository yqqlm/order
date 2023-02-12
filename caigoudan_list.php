<?php 
include_once 'conn.php';
include_once 'tables.php';
//$addnew=getPostValue("addnew");
checkSessionTimeOut();
$sql="";
$hasQuery=false;
$_SESSION["ListUrl"]= (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
//if($addnew=="1")
{
  
  //search
  //INNER JOIN table 2 ON table 1.column_name=table 2.column_name
  $sql="select caigoudan.* ,round(sum(caigoudanproducts.shuliang*caigoudanproducts.danjia),2) as caigoujine from caigoudan left join caigoudanproducts on caigoudan.id=caigoudanproducts.caigoudanid where 1=1";
  
  if (getValue("gongyingshang")!=""){$hasQuery=true;$nreqgoumaidanwei=$_GET["gongyingshang"];$sql=$sql." and gongyingshang like '%$nreqgoumaidanwei%'";}
  if (getValue("tianbiaoren")!=""){$hasQuery=true;$nreqzhidanren=$_GET["tianbiaoren"];$sql=$sql." and tianbiaoren like '%$nreqzhidanren%'";}
  if (getValue("caigouyuan")!=""){$hasQuery=true;$nreqjingshouren=$_GET["caigouyuan"];$sql=$sql." and caigouyuan like '%$nreqjingshouren%'";}
  if (getValue("shangpinbianhao")!=""){$hasQuery=true;$nreqshangpinbianhao=$_GET["shangpinbianhao"];$sql=$sql." and caigoudanproducts.shangpinbianhao like '%$nreqshangpinbianhao%'";}
  if (getValue("shangpinmingcheng")!=""){$hasQuery=true;$nreqshangpinmingcheng=$_GET["shangpinmingcheng"];$sql=$sql." and caigoudanproducts.shangpinmingcheng like '%$nreqshangpinmingcheng%'";}
  if(getValue("caigoudanid")){
    $hasQuery=true;
    
    $sql=$sql." and caigoudan.id=".getValue("caigoudanid");
  }
  $sqlDate=getSQLDate("addtime");
  if($sqlDate){
    $hasQuery=true;
    $sql=$sql." and ".$sqlDate;
  }
  //$sql=$sql." group by id  order by id desc";
  $sql=$sql." group by id  order by addtime desc";
  
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>采购订单列表</title><link rel="stylesheet" href="css.css" type="text/css">
</head>

<body>

<p>采购订单查找</p>
<form id="form1" name="form1" method="get" action="">
    供货商： <input name="gongyingshang" type="text" id="gongyingshang" size="10" value="<?php echo getValue("gongyingshang"); ?>" /> 
    &nbsp;填表人： <input name="tianbiaoren" type="text" id="tianbiaoren" size="10" value="<?php echo getValue("tianbiaoren"); ?>" /> 
    &nbsp;采购员： <input name="caigouyuan" type="text" id="caigouyuan" size="10" value="<?php echo getValue("caigouyuan"); ?>" /> 
    
    &nbsp;商品名称： <input name="shangpinmingcheng" type="text" id="shangpinmingcheng" size="10" value="<?php echo getValue("shangpinmingcheng"); ?>" />
    &nbsp;商品型号： <input name="shangpinbianhao" type="text" id="shangpinbianhao" size="10" value="<?php echo getValue("shangpinbianhao"); ?>" /> 
    &nbsp;采购单号：<input name="caigoudanid" type="text" id="caigoudanid" size="10" value="<?php echo getValue("caigoudanid"); ?>" /> 
    <p></p>
    时间：<?php getDateSelect(); ?>
    <input type="hidden" name="pagecurrent" value="<?php if (getValue("pagecurrent")) echo getValue("pagecurrent"); else echo '1'; ?>" />
    <input type="submit" name="Submit" value="查找" />
</form>
<p></p>
<br>
<?php 
    $tables=new Tables();
    $arrOpts=array();
    if($_SESSION['cx']==="销售总监"){
      array_push($arrOpts,"detail");
    }else{
      array_push($arrOpts,"detail","update","del");
    }
    
    if($hasQuery){
      echo "<p>采购订单查找结果</p>";
    }
   
    $totals= $tables->getListTable("caigoudan",$sql,$arrOpts,array("caigoujine"),null);
    if($_SESSION['cx']==="系统管理员" && count($totals)>0){
      echo "<p>采购总金额：".$totals["caigoujine"]."</p>";
    }
    ?>
    
    <input type="button" name="Submit2" onclick="javascript:window.print();" value="打印" />
</body>
</html>

