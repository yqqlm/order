<?php 
include_once 'conn.php';
include_once 'tables.php';
include 'commonscript.php';
checkSessionTimeOut();

  //search
  //INNER JOIN table 2 ON table 1.column_name=table 2.column_name
  $sqlXiaoshou="select xiaoshoudan.kehumingcheng as kehumingcheng, 0 as huikuan,0 as qiankuan ";

  $sqlXiaoshou=$sqlXiaoshou.", sum(xiaoshoudanproducts.shuliang*xiaoshoudanproducts.danjia) as jine from xiaoshoudan left join xiaoshoudanproducts on xiaoshoudan.id=xiaoshoudanproducts.xiaoshoudanid where 1=1 ";
  $sqlHuiKuan="select kehumingcheng ,sum(huikuanjine) as jine from huikuan where 1=1 ";
  if (getValue("kehumingcheng")!=""){
    $hasQuery=true;
    $nreqgoumaidanwei=$_GET["kehumingcheng"];
    $sqlXiaoshou=$sqlXiaoshou." and kehumingcheng = '$nreqgoumaidanwei'";
    $sqlHuiKuan=$sqlHuiKuan." and kehumingcheng = '$nreqgoumaidanwei'";
  }
  if($_SESSION['cx']=="销售经理"){
    $xiaoshouyuan=$_SESSION['username'];
    $sqlXiaoshou=$sqlXiaoshou." and xiaoshouyuan = '$xiaoshouyuan'";
  }

  $sqlDate=getSQLDate("dingdandate");
  if($sqlDate){
    $hasQuery=true;
    $sqlXiaoshou=$sqlXiaoshou." and ".$sqlDate;
  }
  $sqlXiaoshou=$sqlXiaoshou."  group by kehumingcheng order by jine desc";
  $sqlDate=getSQLDate("huikuanriqi");
  if($sqlDate){
    $hasQuery=true;
    $sqlHuiKuan=$sqlHuiKuan." and ".$sqlDate;
  }
  $sqlHuiKuan=$sqlHuiKuan."  group by kehumingcheng";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>客户账单列表</title><link rel="stylesheet" href="css.css" type="text/css">
</head>

<?php echo getCommonScript();?>
<body>
<form id="form1" name="form1" method="get" action="">
    客户名称：
    <select name='kehumingcheng' id='kehumingcheng' >
      <?php 
      $opts=array();
      $opts["fromtable"]="kehuxinxi";
      $opts["fromfield"]="kehumingcheng";
      $opts["noid"]=true;
      getoption($opts,getValue("kehumingcheng"));
      ?>
    </select>
    <script>$("#kehumingcheng").select2()</script>
    <p></p>
    时间：<?php getDateSelect(); ?>
    <input type="hidden" name="pagecurrent" value="<?php if (getValue("pagecurrent")) echo getValue("pagecurrent"); else echo '1'; ?>" />
    
    <input type="submit" name="Submit" value="查找" />
</form>

<hr />

<?php 
    echo "<p>客户账单列表</p>";
    global $conn;

    $query=$conn->query($sqlXiaoshou);
    if(!$query){

        echo  "Error: ".$sqlXiaoshou."<br>".$conn->error;
    }
    $arrHuoKuan = $query->fetch_all(MYSQLI_BOTH);

    $query2=$conn->query($sqlHuiKuan);
    if(!$query2){

        echo  "Error: ".$sqlHuiKuan."<br>".$conn->error;
    }
    $arrHuiKuan = $query2->fetch_all(MYSQLI_BOTH);
    $arr=array();
    $rowscount=count($arrHuoKuan);
    $arrQian=array();
    for($i=0;$i<$rowscount;$i++){
      $rowHuoKuan=$arrHuoKuan[$i];
      $row=array();
      $row["kehumingcheng"]=$rowHuoKuan["kehumingcheng"];
      $row["jine"]=isset($rowHuoKuan["jine"])?round($rowHuoKuan["jine"]):0;
      $huiKuan=0;
      for($j=0;$j<count($arrHuiKuan);$j++){
        $rowHuiKuan=$arrHuiKuan[$j];
        if($rowHuiKuan["kehumingcheng"]===$row["kehumingcheng"]){
          $huiKuan=$rowHuiKuan["jine"];
          break;
        }
      }
      $row["huikuan"]=round($huiKuan);
      $row["qiankuan"]=$row["jine"]-$row["huikuan"];
      array_push($arr,$row);
      array_push($arrQian,$row["qiankuan"]);
    }
    array_multisort($arrQian, SORT_DESC, $arr);
    $tables=new Tables();
    $arrOpts=array();
    $parms=array();
    $parms["data"]=$arr;
    $totals= $tables->getListTable("kehuzhangdan",$sqlXiaoshou,$arrOpts,array("jine","huikuan","qiankuan"),$parms);
    
    echo "<p>销售总金额：".$totals["jine"]."</p>";
    echo "<p>回款总金额：".$totals["huikuan"]."</p>";
    echo "<p>欠款总金额：".$totals["qiankuan"]."</p>";
?>
    
    <input type="button" name="Submit2" onclick="javascript:window.print();" value="打印" />
</body>
</html>

