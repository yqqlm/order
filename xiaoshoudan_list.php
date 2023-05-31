<?php 
session_start();
$_SESSION["ListUrl"]= (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
include_once 'conn.php';
include_once 'tables.php';
include 'commonscript.php';
checkSessionTimeOut();
//$addnew=getPostValue("addnew");
$sql="";
$sqlWhere="";
$sqlHead="";
$sqlExp="";
$hasQuery=false;
$arrXiaoshouyuan=array("牛洪薪","关春晖","白春智","夏希阳","耿顺赫","张磊","关春辉","侯申","李光","？","郝勇","崔莹","耿沙","商文志");
if($_SESSION['cx']!=="销售总监"){
  array_push($arrXiaoshouyuan,"张磊z");
}
//if($addnew=="1")
{
  
  //search
  //INNER JOIN table 2 ON table 1.column_name=table 2.column_name
  $sqlHead="select xiaoshoudan.* ,round(sum(xiaoshoudanproducts.shuliang*xiaoshoudanproducts.danjia),2) as xiaoshoujine ,round(sum(xiaoshoudanproducts.shuliang*xiaoshoudanproducts.danjia-xiaoshoudanproducts.shuliang*xiaoshoudanproducts.jinjia)-xiaoshoudan.yunfei,2) as xiaoshoulirun from xiaoshoudan left join xiaoshoudanproducts on xiaoshoudan.id=xiaoshoudanproducts.xiaoshoudanid where 1=1";
  $sqlExp="select xiaoshoudan.id,xiaoshoudan.dingdandate,xiaoshoudan.kehumingcheng,xiaoshoudan.xiaoshouyuan,xiaoshoudanproducts.shangpinmingcheng,xiaoshoudanproducts.shangpinbianhao,xiaoshoudanproducts.guige,xiaoshoudanproducts.shuliang,xiaoshoudanproducts.danjia INTO OUTFILE 'C:/phpstudy_pro/WWW/order/export/temp.txt'  from xiaoshoudan left join xiaoshoudanproducts on xiaoshoudan.id=xiaoshoudanproducts.xiaoshoudanid where 1=1";
  $sql="";//"select xiaoshoudan.* ,round(sum(xiaoshoudanproducts.shuliang*xiaoshoudanproducts.danjia),2) as xiaoshoujine ,round(sum(xiaoshoudanproducts.shuliang*xiaoshoudanproducts.danjia-xiaoshoudanproducts.shuliang*xiaoshoudanproducts.jinjia),2) as xiaoshoulirun from xiaoshoudan left join xiaoshoudanproducts on xiaoshoudan.id=xiaoshoudanproducts.xiaoshoudanid where 1=1";
  if(getValue("xiaoshoudanid")){
    $hasQuery=true;
    
    $sql=$sql." and xiaoshoudan.id=".getValue("xiaoshoudanid");
  }
  if (getValue("kehumingcheng")!=""){$hasQuery=true;$nreqgoumaidanwei=$_GET["kehumingcheng"];$sql=$sql." and kehumingcheng like '%$nreqgoumaidanwei%'";}
  if (getValue("tianbiaoren")!=""){$hasQuery=true;$nreqzhidanren=$_GET["tianbiaoren"];$sql=$sql." and tianbiaoren like '%$nreqzhidanren%'";}
  if (getValue("xiaoshouyuan_hidden")!=""){
    $xsy=explode(',',getValue("xiaoshouyuan_hidden"));
    $instring = "'".implode("','",$xsy)."'";

    //$hasQuery=true;$nreqjingshouren=$_GET["xiaoshouyuan"];$sql=$sql." and xiaoshouyuan like '%$nreqjingshouren%'";
    $hasQuery=true;$nreqjingshouren=$_GET["xiaoshouyuan"];$sql=$sql." and xiaoshouyuan in( $instring)";
  }
  
  if (getValue("shangpinbianhao")!=""){$hasQuery=true;$nreqshangpinbianhao=$_GET["shangpinbianhao"];$sql=$sql." and xiaoshoudanproducts.shangpinbianhao like '%$nreqshangpinbianhao%'";}
  if (getValue("shangpinmingcheng")!=""){$hasQuery=true;$nreqshangpinmingcheng=$_GET["shangpinmingcheng"];$sql=$sql." and xiaoshoudanproducts.shangpinmingcheng like '%$nreqshangpinmingcheng%'";}
  if(getValue("qiankuan")){
    $hasQuery=true;
    $value=date("Y-m-d");
    $sql=$sql." and not fukuanzhuangtai='是' and (isnull(fukuanshijian) or fukuanshijian<'".$value."')";
  }
  if(getValue("weifukuan")){
    $hasQuery=true;
    $sql=$sql." and not fukuanzhuangtai='是' ";
  }  
  if(getValue("weifahuo")){
    $hasQuery=true;
    $sql=$sql." and not fahuozhuangtai='是' ";
  }
  if(getValue("kongkehu")){
    $hasQuery=true;
    $sql=$sql." and kehumingcheng='' ";
  }
  $sqlDate=getSQLDate("dingdandate");
  if($sqlDate){
    $hasQuery=true;
    $sql=$sql." and ".$sqlDate;
  }

  if(getValue("nullLirun")){
    $hasQuery=true;
    $sql=$sql." and  xiaoshoudanproducts.jinjia is null";
  }
  if($_SESSION['cx']==="销售经理"){
    $sql=$sql." and xiaoshoudan.xiaoshouyuan ='".$_SESSION['username']."'";
  }
  if($_SESSION['cx']==="销售总监"){
    $sql=$sql." and not xiaoshoudan.xiaoshouyuan ='张磊z'";
  }
  if(getValue("export")!=="1"){
    //$sql=$sql." group by id  order by id desc";
    $sql=$sql." group by id  order by dingdandate desc";
  }
  else{
    //$sql=$sql." order by id desc";
    $sql=$sql." order by dingdandate desc";
  }

}
$sqlExp=$sqlExp.$sql;
$sql=$sqlHead.$sql;
//echo "sql=".$sql;
if(getValue("export")==="1"){
  $filename = 'temp.txt'; //获取文件名称
  $dir ="order/export/";  //相对于网站根目录的下载目录路径
  $down_host = $_SERVER['HTTP_HOST'].'/'; //当前域名
  $fileFullPath=__DIR__.'\export\temp.txt';
  if(file_exists($fileFullPath)){
    @unlink($fileFullPath);
  }
  global $conn;
  $query=$conn->query($sqlExp);
  if(!$query){
      echo "Error: ".$sqlExp."<br>".$conn->error;
      echo "<script>javascript:alert('error=".$conn->error."');</script>";
     
  }else{
    //判断如果文件存在,则跳转到下载路径
    //echo '\r\n location:http://'.$down_host.$dir.$filename;
    if(file_exists($fileFullPath)){
        header('location:https://'.$down_host.$dir.$filename); //拼接下载文件的绝对路径如：http://demo.xx.cn/down/demo.zip
    }else{
        header('HTTP/1.1 404 Not Found'); //这个文件不存在
    }
  }

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>订单列表</title><link rel="stylesheet" href="css.css" type="text/css">
</head>

<?php echo getCommonScript();?>
<body>

<p>订单查找</p>
<form id="form1" name="form1" method="get" action="">
客户名称：
    <select name='kehumingcheng' id='kehumingcheng'  >
      <option></option>
      <?php 
      $opts=array();
      $opts["fromtable"]="kehuxinxi";
      $opts["fromfield"]="kehumingcheng";
      $opts["noid"]=true;
      getoption($opts,getValue("kehumingcheng"));
      ?>
    </select>
    <script>$("#kehumingcheng").select2()</script>
    

    &nbsp;填表人：<input name="tianbiaoren" type="text" id="tianbiaoren" size="10" value="<?php echo getValue("tianbiaoren"); ?>" /> 
    
    &nbsp;销售经理：
    <?php 
      getMultipleSelect("xiaoshouyuan",$arrXiaoshouyuan);
    ?>
    
    <p></p>
    
    商品名称：<input name="shangpinmingcheng" type="text" id="shangpinmingcheng" size="10" value="<?php echo getValue("shangpinmingcheng"); ?>" />
    &nbsp;商品型号：<input name="shangpinbianhao" type="text" id="shangpinbianhao" size="10" value="<?php echo getValue("shangpinbianhao"); ?>" />
    &nbsp;销售单号：<input name="xiaoshoudanid" type="text" id="xiaoshoudanid" size="10" value="<?php echo getValue("xiaoshoudanid"); ?>" /> 
    <p></p>
    时间：<?php getDateSelect(); ?>
    <input type="hidden" name="pagecurrent" value="<?php if (getValue("pagecurrent")) echo getValue("pagecurrent"); else echo '1'; ?>" />
    
    &nbsp;<input type="checkbox" name="qiankuan" <?php if (getValue("qiankuan"))echo "checked='checked'";?> />逾期还款
    &nbsp;<input type="checkbox" name="weifukuan" <?php if (getValue("weifukuan"))echo "checked='checked'";?> />未付款
    &nbsp;<input type="checkbox" name="weifahuo" <?php if (getValue("weifahuo"))echo "checked='checked'";?> />未发货
    &nbsp;<input type="checkbox" name="kongkehu" <?php if (getValue("kongkehu"))echo "checked='checked'";?> />客户名称为空
    <?php
    if($_SESSION['cx']==="系统管理员"){
      ?>
    &nbsp;<input type="checkbox" name="nullLirun" <?php if (getValue("nullLirun"))echo "checked='checked'";?> />利润为空
        <?php
    }
    ?>
    &nbsp;<input type="submit" name="Submit" value="查找" />
    <input type="hidden" name="export" value="0" />
    <input type="submit" name="Submit3" onclick="javascript:document.form1.export.value='1';" value="导出" />
</form>
<p></p>
<br>
<?php 
    $tables=new Tables();
    $arrOpts=array();
    if($_SESSION['cx']==="销售总监" ){
      array_push($arrOpts,"detail");
    }else{
      array_push($arrOpts,"detail","update","del");
    }
    
    if($hasQuery){
      echo "<p>订单查找结果</p>";
    }
   
    $totals= $tables->getListTable("xiaoshoudan",$sql,$arrOpts,array("xiaoshoujine","yunfei","xiaoshoulirun"),null);
    if(($_SESSION['cx']==="系统管理员" || $_SESSION['cx']==="营业录入员" ) && count($totals)>0 && isset($totals["xiaoshoujine"]) && isset($totals["xiaoshoulirun"])){
      echo "<p>销售总金额：".$totals["xiaoshoujine"]."</p>";
      echo "<p>运费总金额：".$totals["yunfei"]."</p>";
      if($_SESSION['cx']==="系统管理员") echo "<p>销售利润：".$totals["xiaoshoulirun"]."</p>";
    }
    //echo getValue("xiaoshouyuan2");
    ?>
    
    <input type="button" name="Submit2" onclick="javascript:window.print();" value="打印" />
    
</body>
</html>

