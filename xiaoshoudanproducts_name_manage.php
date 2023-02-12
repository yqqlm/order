<?php 
include_once 'conn.php';
include_once 'tables.php';
include_once 'commonscript.php';
$tablename=getValue("tablename");
$tableDesc=$table->arrTables["namemanage"];
$searchList=array("shangpinmingcheng","shangpinbianhao","guige");
$updateList=array("shangpinmingcheng","shangpinbianhao","guige");
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
       $length=count($tableDesc);
       $indent=false;
       for($x=0;$x<$length;$x++){
          if($indent)echo "&nbsp";
          if(!$indent)$indent=true;
          $col=$tableDesc[$x];
          if($col["type"]==="newline"){
            echo "<p></p>";
            $indent=false;
            continue;
          }
           echo $col["title"].":";
  
           
           if(isset($col) && isset($col["fromtable"]) && isset($col["fromfield"])){
              $noid=false;
              if(isset($col["noid"]) && $col["noid"]===true){
                $noid=true;
              }
              getSelect($col["name"],$col["fromtable"],$col["fromfield"],$noid,150,true);
              
           }else if ($col["type"]==="select"){
            $name=$col["name"];
            echo "<select name='$name' id='$name' style='width: 20%'></select><script>$('#$name').select2()</script>";

           }else{
              echo "<input name='".$col["name"]."' type='text' id='".$col["name"]."' value='".getValue($col["name"])."' />";
           }
          
        }
        
    ?>
<p></p>

  <input type="hidden" name="pagecurrent" value="<?php if (getValue("pagecurrent")) echo getValue("pagecurrent"); else echo '1'; ?>" />
  
  <input type="hidden" name="tablename" value='<?php echo $tablename;?>'/>
  <input type="hidden" name="opt" value="search"/>
  &nbsp;<input type="submit" name="Submit" value="查找" />
  &nbsp;<input type="submit" name="Submit2" value="修改" onClick="javascript:document.form1.opt.value='update';document.form1.submit();"/>
  &nbsp;<input type="submit" name="Submit3" value="显示SQL" onClick="javascript:document.form1.opt.value='show';document.form1.submit();"/>
</form>
<?php
$mc=getValue("shangpinmingcheng");
$bh=getValue("shangpinbianhao");
$gg=getValue("guige");
  echo "<script>initCanPinXinXi('$mc','$bh','$gg')</script>";
?>
<p></p>
<p>老的产品名称信息</p>
<?php 

    if(getValue("opt")==="update" || getValue("opt")==="show"  ){
      $sqlUpdate="update ".$tablename." set ";
      $length=count($updateList);
      $hasEmpty=false;
      for($x=0;$x<$length;$x++){
        if(getValue($updateList[$x])===""){
          
          $hasEmpty=true;
          break;
        }   
      }
      if(!$hasEmpty){
        for($x=0;$x<$length;$x++){
          if($x!=0){
            $sqlUpdate=$sqlUpdate.",";
          }
          $nreq=getValue($updateList[$x]);
          $sqlUpdate=$sqlUpdate.$updateList[$x]." = '$nreq' ";      
        }
        $sqlUpdate=$sqlUpdate." where 1=1";
        $length=count($searchList);
        for($x=0;$x<$length;$x++){
            if (getValue($searchList[$x]."2")!=""){
    
                $nreq=getValue($searchList[$x]."2");
                $sqlUpdate=$sqlUpdate." and ".$searchList[$x]." like '%$nreq%'";
              
            }
        }
        if(getValue("opt")!=="show"){
          $suc=$conn->query($sqlUpdate);
          if($conn->error){
  
            echo "修改失败 error:".$conn->error;
          }else {
            echo "修改成功";
          }
        }else{
          echo "SQL=".$sqlUpdate;
        }

      }else{
        echo "修改值不能为空";
      }

    }
    $sql="select * from ".$tablename." where 1=1";

    $length=count($searchList);
    for($x=0;$x<$length;$x++){
        if (getValue($searchList[$x]."2")!=""){

            $nreq=getValue($searchList[$x]."2");
            $sql=$sql." and ".$searchList[$x]." like '%$nreq%'";
          
        }
    }

    $tables=new Tables();
    $key="id";

    $sql=$sql."  order by ".$key." desc";
    
    //echo $sql;
    $arrOpts=array();

    $tables->getListTable($tablename,$sql,$arrOpts,array(),null);

  ?>

</p>

</body>
</html>

