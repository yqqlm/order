<?php 
session_start();
$_SESSION["ListUrl"]= (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
include_once 'conn.php';
include_once 'tables.php';
include 'commonscript.php';
checkSessionTimeOut();
//$addnew=getPostValue("addnew");
$sql="";
$hasQuery=false;
//if($addnew=="1")
{
  
  //search
  //INNER JOIN table 2 ON table 1.column_name=table 2.column_name
  $sql="select shangpinmingcheng,shangpinbianhao,guige from xiaoshoudanproducts left join xiaoshoudan on xiaoshoudan.id=xiaoshoudanproducts.xiaoshoudanid  where 1=1";
  if (getValue("shangpinmingcheng")!=""){$hasQuery=true;$nreqshangpinmingcheng=$_GET["shangpinmingcheng"];$sql=$sql." and shangpinmingcheng like '%$nreqshangpinmingcheng%'";}
  if (getValue("shangpinbianhao")!=""){$hasQuery=true;$nreqshangpinbianhao=$_GET["shangpinbianhao"];$sql=$sql." and shangpinbianhao like '%$nreqshangpinbianhao%'";}
  if (getValue("guige")!=""){$hasQuery=true;$nreqguige=$_GET["guige"];$sql=$sql." and guige like '%$nreqguige%'";}
 
  $sql=$sql." group by shangpinmingcheng ,shangpinbianhao, guige";
  //echo $sql;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>订单列表</title><link rel="stylesheet" href="css.css" type="text/css">
</head>
<script src="https://cdn.bootcss.com/select2/4.0.6-rc.1/js/i18n/zh-CN.js"></script>
<link href="select2.css" rel="stylesheet" />
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js";></script>
<script src="select2.js"></script>
<?php echo getCommonScript();?>
<body>

<p>产品查找</p>
<form id="form1" name="form1" method="get" action="">
    产品名称：
    <select name='shangpinmingcheng' id='shangpinmingcheng' >
      <option></option>
      <?php 
      $opts=array();
      $opts["fromtable"]="xiaoshoudanproducts";
      $opts["fromfield"]="shangpinmingcheng";
      $opts["noid"]=true;
      $opts["group"]=true;
      getoption($opts,getValue("shangpinmingcheng"));
      ?>
    </select>
    产品编号：
    <select name='shangpinbianhao' id='shangpinbianhao' >
      <option></option>
      <?php 
      $opts=array();
      $opts["fromtable"]="xiaoshoudanproducts";
      $opts["fromfield"]="shangpinbianhao";
      $opts["noid"]=true;
      $opts["group"]=true;
      getoption($opts,getValue("shangpinbianhao"));
      ?>
    </select>
    产品规格：
    <select name='guige' id='guige' >
      <option></option>
      <?php 
      $opts=array();
      $opts["fromtable"]="xiaoshoudanproducts";
      $opts["fromfield"]="guige";
      $opts["noid"]=true;
      $opts["group"]=true;
      getoption($opts,getValue("guige"));
      ?>
    </select>
    <p></p>

    &nbsp;<input type="submit" name="Submit" value="查找" />
    
</form>
<p></p>
<br>
<?php 
    $tables=new Tables();
    $arrOpts=array();

    array_push($arrOpts,"updateJinjia");
    
    if($hasQuery){
      echo "<p>订单查找结果</p>";
    }
   
    $totals= $tables->getListTable("xiaoshoudanproducts",$sql,$arrOpts,null,null);

    ?>
    
    <input type="button" name="Submit2" onclick="javascript:window.print();" value="打印" />
</body>
</html>

