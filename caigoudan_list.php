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
<title>??????????????????</title><link rel="stylesheet" href="css.css" type="text/css">
</head>

<body>

<p>??????????????????</p>
<form id="form1" name="form1" method="get" action="">
    ???????????? <input name="gongyingshang" type="text" id="gongyingshang" size="10" value="<?php echo getValue("gongyingshang"); ?>" /> 
    &nbsp;???????????? <input name="tianbiaoren" type="text" id="tianbiaoren" size="10" value="<?php echo getValue("tianbiaoren"); ?>" /> 
    &nbsp;???????????? <input name="caigouyuan" type="text" id="caigouyuan" size="10" value="<?php echo getValue("caigouyuan"); ?>" /> 
    
    &nbsp;??????????????? <input name="shangpinmingcheng" type="text" id="shangpinmingcheng" size="10" value="<?php echo getValue("shangpinmingcheng"); ?>" />
    &nbsp;??????????????? <input name="shangpinbianhao" type="text" id="shangpinbianhao" size="10" value="<?php echo getValue("shangpinbianhao"); ?>" /> 
    &nbsp;???????????????<input name="caigoudanid" type="text" id="caigoudanid" size="10" value="<?php echo getValue("caigoudanid"); ?>" /> 
    <p></p>
    ?????????<?php getDateSelect(); ?>
    <input type="hidden" name="pagecurrent" value="<?php if (getValue("pagecurrent")) echo getValue("pagecurrent"); else echo '1'; ?>" />
    <input type="submit" name="Submit" value="??????" />
</form>
<p></p>
<br>
<?php 
    $tables=new Tables();
    $arrOpts=array();
    if($_SESSION['cx']==="????????????"){
      array_push($arrOpts,"detail");
    }else{
      array_push($arrOpts,"detail","update","del");
    }
    
    if($hasQuery){
      echo "<p>????????????????????????</p>";
    }
   
    $totals= $tables->getListTable("caigoudan",$sql,$arrOpts,array("caigoujine"),null);
    if($_SESSION['cx']==="???????????????" && count($totals)>0){
      echo "<p>??????????????????".$totals["caigoujine"]."</p>";
    }
    ?>
    
    <input type="button" name="Submit2" onclick="javascript:window.print();" value="??????" />
</body>
</html>

