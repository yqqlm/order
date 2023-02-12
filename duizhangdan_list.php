<?php 
include_once 'conn.php';
include_once 'tables.php';
include 'commonscript.php';
checkSessionTimeOut();
//$addnew=getPostValue("addnew");
$sql="";
$hasQuery=true;
//if($addnew=="1")
{
  //search
  //INNER JOIN table 2 ON table 1.column_name=table 2.column_name
  $sqlXiaoshou="select xiaoshoudan.kehumingcheng as kehumingcheng ,xiaoshoudan.dingdandate as dingdandate";
  $sqlXiaoshou=$sqlXiaoshou.",xiaoshoudanproducts.shangpinmingcheng as shangpinmingcheng";
  $sqlXiaoshou=$sqlXiaoshou.",xiaoshoudanproducts.shangpinbianhao as shangpinbianhao";
  $sqlXiaoshou=$sqlXiaoshou.",xiaoshoudanproducts.guige as guige";
  $sqlXiaoshou=$sqlXiaoshou.",xiaoshoudanproducts.shuliang as shuliang";
  $sqlXiaoshou=$sqlXiaoshou.",xiaoshoudanproducts.danjia as danjia";
  $sqlXiaoshou=$sqlXiaoshou.", round(xiaoshoudanproducts.shuliang*xiaoshoudanproducts.danjia) as jine from xiaoshoudan left join xiaoshoudanproducts on xiaoshoudan.id=xiaoshoudanproducts.xiaoshoudanid where 1=1";
  $sqlHuikuan="select * from huikuan where 1=1 ";
  $sqlFapiao="select * from fapiao where 1=1 ";
  if (getValue("kehumingcheng")!=""){
    $hasQuery=true;
    $nreqgoumaidanwei=$_GET["kehumingcheng"];
    $sqlXiaoshou=$sqlXiaoshou." and kehumingcheng = '$nreqgoumaidanwei'";
    $sqlHuikuan=$sqlHuikuan." and kehumingcheng = '$nreqgoumaidanwei'";
    $sqlFapiao=$sqlFapiao." and kehumingcheng = '$nreqgoumaidanwei'";
    if($_SESSION['cx']=="销售经理"){
      $xiaoshouyuan=$_SESSION['username'];
      $sqlXiaoshou=$sqlXiaoshou." and xiaoshouyuan = '$xiaoshouyuan'";
    }
  }

  if(getValue("shijiantype") !=="无限制"){
    $hasQuery=true;
    $sqlXiaoshou=$sqlXiaoshou." and ".getSQLDate("dingdandate");
    $sqlHuikuan=$sqlHuikuan." and ".getSQLDate("huikuanriqi");
    $sqlFapiao=$sqlFapiao." and ".getSQLDate("kaipiaoriqi");
  }

  $sql=$sql."  order by id desc";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>对账单</title><link rel="stylesheet" href="css.css" type="text/css">
</head>

<?php echo getCommonScript();?>
<body>
<form id="form1" name="form1" method="get" action="">
    客户名称：<?php getSelect("kehumingcheng","kehuxinxi","kehumingcheng",true,null,true); ?>
    <p></p>
    时间：<?php getDateSelect(); ?>
    <input type="submit" name="Submit" value="查找" />
</form>

<hr />

<?php 
    $tables=new Tables();
    $arrOpts=array();
    
    if($hasQuery){
      $jine=0;
      $huikuanjine=0;
      $kaipiaojine=0;
      //echo $sqlXiaoshou;
      
      echo "<p>销售记录</p>";
      $parms=array();
      $parms["nopage"]=true;
      $totals= $tables->getListTable("duizhangxiaoshou",$sqlXiaoshou,$arrOpts,array("jine"),$parms);
      $jine=0;
      $kaipiaojine=0;
      if(isset($totals["jine"])){
          $jine=$totals["jine"];
          echo "<p>总金额：".$totals["jine"]."</p>";
      }else{
        echo "<p>总金额：0</p>";
      }
      if(isset($totals["count"]) && $totals["count"]>0){
        echo "<hr />";
        echo "<p>回款记录</p>";
        //echo "<p>".$sqlHuikuan."</p>";
        $totals= $tables->getListTable("huikuan",$sqlHuikuan,$arrOpts,array("huikuanjine"),$parms);
        if(isset($totals["huikuanjine"])){
          $huikuanjine=$totals["huikuanjine"];
          echo "<p>回款总金额：".$totals["huikuanjine"]."</p>";
        }else{
          echo "<p>回款总金额：0</p>";
        }
        echo "<hr />";
        echo "<p>发票记录</p>";
        $totals= $tables->getListTable("fapiao",$sqlFapiao,$arrOpts,array("jine"),$parms);
        if(isset($totals["jine"])){
          $kaipiaojine=$totals["jine"];
          echo "<p>开发票总金额：".$totals["jine"]."</p>";
        }else{
          echo "<p>开发票总金额：0</p>";
        }
        echo "<hr />";
        echo "<p>应付款金额:".($jine-$huikuanjine)."</p>";

      }

    }

    ?>
    
    <input type="button" name="Submit2" onclick="javascript:window.print();" value="打印" />
    <input type="button" name="Submit1" onclick="javascript:history.back();" value="返回" />
</body>
</html>

