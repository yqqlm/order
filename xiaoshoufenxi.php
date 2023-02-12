<?php 
session_start();

include_once 'conn.php';
include_once 'tables.php';
include 'commonscript.php';
checkSessionTimeOut();
$_SESSION["ListUrl"]= (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$hasQuery=false;
$arrXiaoshouyuan=array("牛洪薪","关春晖","白春智","夏希阳","耿顺赫","张磊","关春辉","侯申","李光","？","郝勇","崔莹","耿沙");
if($_SESSION['cx']!=="销售总监"){
  array_push($arrXiaoshouyuan,"张磊z");
}


//search
//INNER JOIN table 2 ON table 1.column_name=table 2.column_name
$sqlmid="round(sum(test.shuliang*test.danjia),2) as xiaoshoujine,round(sum(test.shuliang*test.danjia-test.shuliang*test.jinjia),2) as xiaoshoulirun ,round(sum(test.shuliang),2) as shuliang from (select kucun.shangpinleibie as shangpinleibie ,kucun.zhizhaoshang as zhizhaoshang,xiaoshoudanproducts.xiaoshoudanid as xiaoshoudanid ,xiaoshoudanproducts.shangpinmingcheng as shangpinmingcheng,xiaoshoudanproducts.shangpinbianhao as shangpinbianhao ,xiaoshoudanproducts.guige as guige ,xiaoshoudanproducts.shuliang as shuliang,xiaoshoudanproducts.danjia as danjia,xiaoshoudanproducts.jinjia as jinjia from xiaoshoudanproducts left join kucun on xiaoshoudanproducts.shangpinmingcheng=kucun.shangpinmingcheng and xiaoshoudanproducts.shangpinbianhao=kucun.shangpinbianhao and xiaoshoudanproducts.guige =kucun.guige) test left JOIN xiaoshoudan on (test.xiaoshoudanid=xiaoshoudan.id) where 1=1 ";
$sqlhead="select ";
$sql="";
$arrXiaoshoufenxiDescribe = array();
if (getValue("kehumingcheng")!=""){$hasQuery=true;$nreqgoumaidanwei=$_GET["kehumingcheng"];$sql=$sql." and xiaoshoudan.kehumingcheng like '%$nreqgoumaidanwei%'";}

if (getValue("xiaoshouyuan_hidden")!=""){
    $xsy=explode(',',getValue("xiaoshouyuan_hidden"));
    $instring = "'".implode("','",$xsy)."'";
    $hasQuery=true;
    $nreqjingshouren=$_GET["xiaoshouyuan"];$sql=$sql." and xiaoshoudan.xiaoshouyuan in( $instring)";
}
if (getValue("shangpinbianhao")!=""){$hasQuery=true;$nreqshangpinbianhao=$_GET["shangpinbianhao"];$sql=$sql." and test.shangpinbianhao like '%$nreqshangpinbianhao%'";}
if (getValue("shangpinmingcheng")!=""){$hasQuery=true;$nreqshangpinmingcheng=$_GET["shangpinmingcheng"];$sql=$sql." and test.shangpinmingcheng like '%$nreqshangpinmingcheng%'";}
if (getValue("shangpinleibie")!=""){$hasQuery=true;$val=$_GET["shangpinleibie"];$sql=$sql." and test.shangpinleibie like '%$val%'";}
if (getValue("zhizhaoshang")!=""){$hasQuery=true;$val=$_GET["zhizhaoshang"];$sql=$sql." and test.zhizhaoshang like '%$val%'";}

$sqlDate=getSQLDate("dingdandate");
if($sqlDate){
    $hasQuery=true;
    $sql=$sql." and ".$sqlDate;
}

if($_SESSION['cx']==="销售经理"){
    $sql=$sql." and xiaoshoudan.xiaoshouyuan ='".$_SESSION['username']."'";
}
if($_SESSION['cx']==="销售总监"){
    $sql=$sql." and not xiaoshoudan.xiaoshouyuan ='张磊z'";
}
$sql=$sql." group by ";
$hasDetail=false;
if (getValue("fenxileibie_hidden")!=""){
    $xsy=explode(',',getValue("fenxileibie_hidden"));
    $first=true;
    for($x=0;$x<count($xsy);$x++){
        $name=$xsy[$x];
        $col="";           

        if($name=="商品类别"){
            $col="shangpinleibie";
        }else if($name=="商品名称"){
            $col="shangpinmingcheng"; 
        }else if($name=="商品型号"){
            $col="shangpinbianhao";
        }else if($name=="销售经理"){
            $col="xiaoshouyuan";
        }else if($name=="客户名称"){
            $col="kehumingcheng";
        }else if($name=="制造商"){
            $col="zhizhaoshang";
        }else if($name=="销售单号"){
            $col="xiaoshoudanid";
            $hasDetail=true;
        }
        if($col){
            if(!$first){
                $sql=$sql.",";
            }
            $sql=$sql.$col;
            $first=false;
            $sqlhead=$sqlhead.$col.",";
            array_push($arrXiaoshoufenxiDescribe,array("name"=>$col,"title"=>$name,"type"=>""));
        }
    }

}else{
    
        $sql=$sql."shangpinleibie";
        $sqlhead=$sqlhead."shangpinleibie".",";
        array_push($arrXiaoshoufenxiDescribe,array("name"=>"shangpinleibie","title"=>"商品类别","type"=>""));
}
if($_SESSION['cx']==="系统管理员"){
    $sql=$sql." order by xiaoshoulirun desc";
}else{
    $sql=$sql." order by xiaoshoujine desc";
}

$sql=$sqlhead.$sqlmid.$sql;

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
    
    &nbsp;销售经理：
    <?php 
      getMultipleSelect("xiaoshouyuan",$arrXiaoshouyuan);
    ?>
    
    <p></p>
    商品类别：<?php getSelect("shangpinleibie","splb","name",true,150,true); ?>
    &nbsp;制造商：<?php getSelect("zhizhaoshang","zhizhaoshang","name",true,150,true); ?>
    
    &nbsp;商品名称：<input name="shangpinmingcheng" type="text" id="shangpinmingcheng" size="10" value="<?php echo getValue("shangpinmingcheng"); ?>" />
    &nbsp;商品型号：<input name="shangpinbianhao" type="text" id="shangpinbianhao" size="10" value="<?php echo getValue("shangpinbianhao"); ?>" /> 
    
    <p></p>
    时间：<?php getDateSelect(); ?>
    <input type="hidden" name="pagecurrent" value="<?php if (getValue("pagecurrent")) echo getValue("pagecurrent"); else echo '1'; ?>" />
    &nbsp;分析类别：
    <?php 
      getMultipleSelect("fenxileibie",array('商品类别','制造商','商品名称','商品型号','销售经理','客户名称','销售单号'));
    ?>
    &nbsp;<input type="submit" name="Submit" value="查找" />

</form>
<p></p>
<br>
<?php 
    $tables=new Tables();
    $arrOpts=array();
    if($hasDetail){
        array_push($arrOpts,"detail");
    }
    $parms=array();
    $parms["nopage"]=true;
    if($hasQuery){
      echo "<p>产品销售查找结果</p>";
    }

    array_push($arrXiaoshoufenxiDescribe,array("name"=>"xiaoshoujine","title"=>"销售金额","type"=>""));
    if($_SESSION['cx']==="系统管理员"){
        array_push($arrXiaoshoufenxiDescribe,array("name"=>"xiaoshoulirun","title"=>"销售利润","type"=>""));
    }
    array_push($arrXiaoshoufenxiDescribe,array("name"=>"shuliang","title"=>"数量","type"=>""));
    if($_SESSION['cx']==="系统管理员") {
        array_push($arrXiaoshoufenxiDescribe,array("name"=>"fene","title"=>"销售份额","type"=>"progress","progressCol"=>"xiaoshoulirun"));
    }else{
        array_push($arrXiaoshoufenxiDescribe,array("name"=>"fene","title"=>"销售份额","type"=>"progress","progressCol"=>"xiaoshoujine"));
    }
    
    $tables->arrTables["xiaoshoufenxi"]=$arrXiaoshoufenxiDescribe;
    $totals= $tables->getListTable("xiaoshoufenxi",$sql,$arrOpts,array("xiaoshoujine","xiaoshoulirun","shuliang"),$parms);
    if(($_SESSION['cx']==="系统管理员" || $_SESSION['cx']==="营业录入员" ) && count($totals)>0 && isset($totals["xiaoshoujine"]) && isset($totals["xiaoshoulirun"])){
      echo "<p>销售总金额：".$totals["xiaoshoujine"]."</p>";
      
      if($_SESSION['cx']==="系统管理员") echo "<p>销售利润：".$totals["xiaoshoulirun"]."</p>";
      echo "<p>数量：".$totals["shuliang"]."</p>";
    }
    //echo $sql;
    ?>
    
    <input type="button" name="Submit2" onclick="javascript:window.print();" value="打印" />
    
</body>
</html>

