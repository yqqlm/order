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
//if($addnew=="1")
{
  
  //search
  //INNER JOIN table 2 ON table 1.column_name=table 2.column_name
  $sqlHead="select xiaoshoudan.* ,round(sum(xiaoshoudanproducts.shuliang*xiaoshoudanproducts.danjia),2) as xiaoshoujine ,round(sum(xiaoshoudanproducts.shuliang*xiaoshoudanproducts.danjia-xiaoshoudanproducts.shuliang*xiaoshoudanproducts.jinjia),2) as xiaoshoulirun from xiaoshoudan left join xiaoshoudanproducts on xiaoshoudan.id=xiaoshoudanproducts.xiaoshoudanid where 1=1";
  $sqlExp="select xiaoshoudan.id,xiaoshoudan.dingdandate,xiaoshoudan.kehumingcheng,xiaoshoudan.xiaoshouyuan,xiaoshoudanproducts.shangpinmingcheng,xiaoshoudanproducts.shangpinbianhao,xiaoshoudanproducts.guige,xiaoshoudanproducts.shuliang,xiaoshoudanproducts.danjia INTO OUTFILE 'C:/phpstudy_pro/WWW/order/export/temp.txt'  from xiaoshoudan left join xiaoshoudanproducts on xiaoshoudan.id=xiaoshoudanproducts.xiaoshoudanid where 1=1";
  $sql="";//"select xiaoshoudan.* ,round(sum(xiaoshoudanproducts.shuliang*xiaoshoudanproducts.danjia),2) as xiaoshoujine ,round(sum(xiaoshoudanproducts.shuliang*xiaoshoudanproducts.danjia-xiaoshoudanproducts.shuliang*xiaoshoudanproducts.jinjia),2) as xiaoshoulirun from xiaoshoudan left join xiaoshoudanproducts on xiaoshoudan.id=xiaoshoudanproducts.xiaoshoudanid where 1=1";
  if (getValue("kehumingcheng")!=""){$hasQuery=true;$nreqgoumaidanwei=$_GET["kehumingcheng"];$sql=$sql." and kehumingcheng like '%$nreqgoumaidanwei%'";}
  if (getValue("tianbiaoren")!=""){$hasQuery=true;$nreqzhidanren=$_GET["tianbiaoren"];$sql=$sql." and tianbiaoren like '%$nreqzhidanren%'";}
  if (getValue("xiaoshouyuan")!=""){$hasQuery=true;$nreqjingshouren=$_GET["xiaoshouyuan"];$sql=$sql." and xiaoshouyuan like '%$nreqjingshouren%'";}
  if (getValue("shangpinbianhao")!=""){$hasQuery=true;$nreqshangpinbianhao=$_GET["shangpinbianhao"];$sql=$sql." and xiaoshoudanproducts.shangpinbianhao like '%$nreqshangpinbianhao%'";}
  if (getValue("shangpinmingcheng")!=""){$hasQuery=true;$nreqshangpinmingcheng=$_GET["shangpinmingcheng"];$sql=$sql." and xiaoshoudanproducts.shangpinmingcheng like '%$nreqshangpinmingcheng%'";}
  if(getValue("qiankuan")){
    $hasQuery=true;
    $value=date("Y-m-d");
    $sql=$sql." and not fukuanzhuangtai='???' and (isnull(fukuanshijian) or fukuanshijian<'".$value."')";
  }
  if(getValue("weifukuan")){
    $hasQuery=true;
    $sql=$sql." and not fukuanzhuangtai='???' ";
  }  
  if(getValue("weifahuo")){
    $hasQuery=true;
    $sql=$sql." and not fahuozhuangtai='???' ";
  }
  if(getValue("kongkehu")){
    $hasQuery=true;
    $sql=$sql." and kehumingcheng='' ";
  }
  if (getValue("shijiantype")==="?????????" || !getValue("shijiantype")){
    $hasQuery=true;
    $val=0;
    $date=date("Y");
    $bd=$date."-01-01";
    $ed=$date."-12-31";
    $sql=$sql." and dingdandate>='".$bd."' and dingdandate<='".$ed."'";
  }else if (getValue("shijiantype")==="??????"){
    $hasQuery=true;
    $date=date("Y-m");
    $bd=$date."-01";
    $ed=$date."-31";
    $sql=$sql." and dingdandate>='".$bd."' and dingdandate<='".$ed."'";
  }else if (getValue("shijiantype")==="?????????"){
    $hasQuery=true;
    $bd=getValue("qishi");
    $ed=getValue("zhongzhi");
    $sql=$sql." and dingdandate>='".$bd."' and dingdandate<='".$ed."'";
  }
  if(getValue("nullLirun")){
    $hasQuery=true;
    $sql=$sql." and  xiaoshoudanproducts.jinjia is null";
  }
  if($_SESSION['cx']==="????????????"){
    $sql=$sql." and xiaoshoudan.xiaoshouyuan ='".$_SESSION['username']."'";
  }
  if($_SESSION['cx']==="????????????"){
    $sql=$sql." and not xiaoshoudan.xiaoshouyuan ='??????z'";
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

if(getValue("export")==="1"){
  $filename = 'temp.txt'; //??????????????????
  $dir ="order/export/";  //?????????????????????????????????????????????
  $down_host = $_SERVER['HTTP_HOST'].'/'; //????????????
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
    //????????????????????????,????????????????????????
    //echo '\r\n location:http://'.$down_host.$dir.$filename;
    if(file_exists($fileFullPath)){
        header('location:http://'.$down_host.$dir.$filename); //???????????????????????????????????????http://demo.xx.cn/down/demo.zip
    }else{
        header('HTTP/1.1 404 Not Found'); //?????????????????????
    }
  }

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>??????????????????</title><link rel="stylesheet" href="css.css" type="text/css">
</head>

<?php echo getCommonScript();?>
<body>

<p>??????</p>
<form id="form1" name="form1" method="get" action="">
???????????????
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

    &nbsp;????????????<input name="tianbiaoren" type="text" id="tianbiaoren" size="10" value="<?php echo getValue("tianbiaoren"); ?>" /> 
    &nbsp;???????????????<input name="xiaoshouyuan" type="text" id="xiaoshouyuan" size="10" value="<?php echo getValue("xiaoshouyuan"); ?>" />
    &nbsp;???????????????<input name="shangpinmingcheng" type="text" id="shangpinmingcheng" size="10" value="<?php echo getValue("shangpinmingcheng"); ?>" />
    &nbsp;???????????????<input name="shangpinbianhao" type="text" id="shangpinbianhao" size="10" value="<?php echo getValue("shangpinbianhao"); ?>" /> 
    &nbsp;???????????????<select name='shangpinleibie' id='shangpinleibie' >
    
    <option value='?????????' selected>?????????</option>
    <?php
    $Def=$tables["kucun"][1]["options"];
    for($x=0;$x<count($Def);$x++){
        $name=$Def[$x];
        echo "<option value='".$name."' >".$name."</option>";
    }
    ?>
    <option value='?????????' >?????????</option>
    </select>
    <p></p>
    ?????????<select name='shijiantype' id='shijiantype' >
      <?php 
      if(getValue("shijiantype")==="?????????"  || !getValue("shijiantype")){
        echo "<option value='?????????' selected>?????????</option>";
      }else{
        echo "<option value='?????????' >?????????</option>";
      }
      if(getValue("shijiantype")==="??????"){
        echo "<option value='??????' selected>??????</option>";
      }else{
        echo "<option value='??????' >??????</option>";
      }
      if(getValue("shijiantype")==="?????????"){
        echo "<option value='?????????' selected>?????????</option>";
      }else{
        echo "<option value='?????????' >?????????</option>";
      }
      if(getValue("shijiantype")==="?????????"){
        echo "<option value='?????????' selected>?????????</option>";
      }else{
        echo "<option value='?????????' >?????????</option>";
      }
      ?>
    </select>
    &nbsp;???????????????<input name='qishi' id='qishi' type='date' value="<?php if(getValue("qishi")){echo getValue("qishi");} else{echo date('Y-m-d');} ?>"/>
    &nbsp;???????????????<input name='zhongzhi' id='zhongzhi' type='date' value="<?php if(getValue("zhongzhi")){echo getValue("zhongzhi");} else{echo date('Y-m-d');} ?>"/>
    &nbsp;
    <input type="hidden" name="pagecurrent" value="<?php if (getValue("pagecurrent")) echo getValue("pagecurrent"); else echo '1'; ?>" />
    
    &nbsp;<input type="checkbox" name="qiankuan" <?php if (getValue("qiankuan"))echo "checked='checked'";?> />????????????
    &nbsp;<input type="checkbox" name="weifukuan" <?php if (getValue("weifukuan"))echo "checked='checked'";?> />?????????
    &nbsp;<input type="checkbox" name="weifahuo" <?php if (getValue("weifahuo"))echo "checked='checked'";?> />?????????
    &nbsp;<input type="checkbox" name="kongkehu" <?php if (getValue("kongkehu"))echo "checked='checked'";?> />??????????????????
    <?php
    if($_SESSION['cx']==="???????????????"){
      ?>
    &nbsp;<input type="checkbox" name="nullLirun" <?php if (getValue("nullLirun"))echo "checked='checked'";?> />????????????
        <?php
    }
    ?>
    &nbsp;<input type="submit" name="Submit" value="??????" />
    <input type="hidden" name="export" value="0" />
    <input type="submit" name="Submit3" onclick="javascript:document.form1.export.value='1';" value="??????" />
</form>
<p></p>
<br>
<?php 
    $tables=new Tables();
    $arrOpts=array();
    if($_SESSION['cx']==="????????????" ){
      array_push($arrOpts,"detail");
    }else{
      array_push($arrOpts,"detail","update","del");
    }
    
    if($hasQuery){
      echo "<p>??????????????????</p>";
    }
   
    $totals= $tables->getListTable("xiaoshoudanproducts",$sql,$arrOpts,array("xiaoshoujine","xiaoshoulirun"),null);
    if(($_SESSION['cx']==="???????????????" || $_SESSION['cx']==="???????????????" ) && count($totals)>0 && isset($totals["xiaoshoujine"]) && isset($totals["xiaoshoulirun"])){
      echo "<p>??????????????????".$totals["xiaoshoujine"]."</p>";
      if($_SESSION['cx']==="???????????????") echo "<p>???????????????".$totals["xiaoshoulirun"]."</p>";
    }
    ?>
    
    <input type="button" name="Submit2" onclick="javascript:window.print();" value="??????" />
    
</body>
</html>

