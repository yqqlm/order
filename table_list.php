<?php 
include_once 'conn.php';
include_once 'tables.php';
include_once 'commonscript.php';
$tablename=getValue("tablename");
$tabletitle=getValue("tabletitle");
$checkList=$table->tableCheckList[$tablename];
$searchList=$table->tableSearchList[$tablename];
$searchAliasList=$table->tableSearchAliasList[$tablename];
$tableDesc=$table->arrTables[$tablename];
checkSessionTimeOut();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title><?php echo $tabletitle; ?></title><link rel="stylesheet" href="css.css" type="text/css">
</head>
<?php echo getCommonScript();?>
<body>

<p></p>

<form id="form1" name="form1" method="get" action="">

  <?php 
       $length=count($searchList);
       for($x=0;$x<$length;$x++){
          if($x!==0)echo "&nbsp";
           echo $searchAliasList[$x].":";
           for($i=0;$i<count($tableDesc);$i++){
             $col2=$tableDesc[$i];
             if($col2["name"]===$searchList[$x]){
               $col=$col2;
             }
           }
           
           if(isset($col) && isset($col["fromtable"]) && isset($col["fromfield"])){
              $noid=false;
              if(isset($col["noid"]) && $col["noid"]===true){
                $noid=true;
              }
              getSelect($searchList[$x],$col["fromtable"],$col["fromfield"],$noid,150,true);
              
           }else{
              echo "<input name='".$searchList[$x]."' type='text' id='".$searchList[$x]."' value='".getValue($searchList[$x])."' />";
           }
          
        }

        if($tablename==="xiaoshoudanproducts" || $tablename==="caigoudanproducts"){
          
          echo "<p></p>";
          echo '商品类别：';
          getSelect("shangpinleibie","splb","name",true,150,true); 
       
          echo '&nbsp;制造商：';
          getSelect("zhizhaoshang","zhizhaoshang","name",true,150,true); 
          
          echo '&nbsp;<input type="checkbox" name="nullleibie"';
          if (getValue("nullleibie"))echo "checked='checked'";
          echo ' />商品类别为空';
          echo '&nbsp;<input type="checkbox" name="badval"';
          if (getValue("badval"))echo "checked='checked'";
          echo ' />价格异常';
          echo '&nbsp;<input type="checkbox" name="nullval"';
          if (getValue("nullval"))echo "checked='checked'";
          echo ' />价格为空';
        }
    ?>

  <input type="hidden" name="pagecurrent" value="<?php if (getValue("pagecurrent")) echo getValue("pagecurrent"); else echo '1'; ?>" />
  
  <input type="hidden" name="tablename" value="<?php echo $tablename; ?>" />
  <input type="hidden" name="tabletitle" value="<?php echo $tabletitle; ?>" />
       
  &nbsp;<input type="submit" name="Submit" value="查找" />
</form>

<p></p>
<p><?php echo $tabletitle;?>信息</p>
<?php 
    $_SESSION["ListUrl"]= (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    $total=0;

    $sql="select * from ".$tablename." where 1=1";
    if($tablename==="xiaoshoudanproducts" || $tablename==="caigoudanproducts" ){
      $sql="select $tablename.* ,shangpinleibie,zhizhaoshang from $tablename left join kucun on $tablename.shangpinmingcheng =kucun.shangpinmingcheng and $tablename.shangpinbianhao=kucun.shangpinbianhao and $tablename.guige=kucun.guige where 1=1 ";
      if(getValue("nullleibie")){
        $sql=$sql." and shangpinleibie is null";
      }
      if(getValue("badval")){
        if($tablename==="xiaoshoudanproducts"){
          $sql=$sql." and ($tablename.danjia<0 or $tablename.jinjia<0 or $tablename.danjia>1000 or $tablename.jinjia>1000 or $tablename.danjia-$tablename.jinjia<0) ";
        }else{
          $sql=$sql." and ($tablename.danjia<0  or $tablename.danjia>1000 ) ";
        }
        
      }
      if(getValue("nullval")){
        if($tablename==="xiaoshoudanproducts"){
          $sql=$sql." and ($tablename.danjia is null or $tablename.jinjia is null) ";
        }else{
          $sql=$sql." and ($tablename.danjia is null) ";
        }
        
      }
      if(getValue("shangpinleibie")){
        $val=getValue("shangpinleibie");
        $sql=$sql." and shangpinleibie like '%$val%'";
      }
      if(getValue("zhizhaoshang")){
        $val=getValue("zhizhaoshang");
        $sql=$sql." and zhizhaoshang like '%$val%'";
      }
    }
    $length=count($searchList);
    for($x=0;$x<$length;$x++){
        if (getValue($searchList[$x])!=""){
          if($tablename==="xiaoshoudanproducts" || $tablename==="caigoudanproducts" ){
            $nreq=getValue($searchList[$x]);
            $sql=$sql." and ".$tablename.".".$searchList[$x]." like '$nreq'";
          }else{
            $nreq=getValue($searchList[$x]);
            $sql=$sql." and ".$searchList[$x]." like '$nreq'";
          }
        }
    }
    if(isset($table->tableKeyFilter[$tablename])){
      $sql=$sql." and ".$table->tableKey[$tablename]." in (".$table->tableKeyFilter[$tablename].")";
    }
    $tables=new Tables();
    $key="id";
    if(isset($table->tableKey[$tablename])){
      $key=$table->tableKey[$tablename];
    }
    $sql=$sql."  order by ".$key." desc";
    
    //echo $sql;
    $arrOpts=array();
    if($_SESSION['cx']==="销售总监" || $_SESSION['cx']==="销售经理" ){
      
    }else{
      array_push($arrOpts,"del","update");
    }
    if($tablename==="xiaoshoudanproducts" )$tables->arrTables["xiaoshoudanproducts"]=$tables->arrXiaoshoudanProducts2Describe;
    if($tablename==="caigoudanproducts" )$tables->arrTables["caigoudanproducts"]=$tables->arrCaiGouDanProducts2Describe;
    $tables->getListTable($tablename,$sql,$arrOpts,array(),null);
    if($tablename==="xiaoshoudanproducts")$tables->arrTables["xiaoshoudanproducts"]=$tables->arrXiaoshoudanProductsDescribe;
    if($tablename==="caigoudanproducts" )$tables->arrTables["caigoudanproducts"]=$tables->arrCaiGouDanProductsDescribe;
  ?>
  <input type="button" name="Submit2" onclick="javascript:window.print();" value="打印" />

</p>

</body>
</html>

