<?php 

$id=$_GET["id"];
include_once 'conn.php';
include_once 'tables.php';
include_once 'commonscript.php';

$ndate =date("Y-m-d");
$id=getValue("id");
checkSessionTimeOut();
$record=$table->getRecord("xiaoshoudan",$id);
$table->setCurrentRecord($record);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>销售单详细信息</title><link rel="stylesheet" href="css.css" type="text/css">
</head>
<?php echo getCommonScript();?>
<body>
<p>销售单详细信息 当前日期： <?php echo $ndate; ?></p>

<?php $tables=new Tables();echo $tables->getDetail("xiaoshoudan",0,null);?>
<br>
<?php
if($_SESSION['cx']==="系统管理员" || $_SESSION['cx']==="营业录入员" ){
    $khmc=$record["kehumingcheng"];
    $hkje=0;
    $arr=$record["products"];
    for($x=0;$x<count($arr);$x++){
       if(isset($arr[$x]["danjia"]) && isset($arr[$x]["shuliang"])){
           $hkje=$hkje+$arr[$x]["danjia"]*$arr[$x]["shuliang"];
       }
    }
?>
<input type="button" id="Submit3" name="Submit3" onclick="location.href='products_chuku.php?id=<?php echo $id; ?>';" value="产品批量出库"  />
<script>
<?php
    echo "document.getElementById('Submit3').disabled=".isChuKu($id);
?>
</script>
<input type="button" name="Submit4" onclick="location.href='caigoudan_add.php?orderid=<?php echo $id; ?>';" value="添加采购单" />
    <?php
        $showHuiKuan=false;
        if(isset($record["fukuanzhuangtai"]) && $record["fukuanzhuangtai"]=="是"){
            global $conn;
            $sql="select xiaoshoudanid from huikuan where xiaoshoudanid=".$id;
            $query=$conn->query($sql);
            if ($query->num_rows<= 0) {
                $showHuiKuan=true;
            }
        }
        if($showHuiKuan){
    ?>
    <input type="button" name="Submit5" onclick="location.href='insert_from_get.php?tablename=huikuan&huikuanriqi=<?php echo $ndate; ?>&huikuanjine=<?php echo $hkje; ?>&kehumingcheng=<?php echo $khmc; ?>&xiaoshoudanid=<?php echo $id; ?>';" value="添加回款" />
    <?php
        }
    ?>
<?php
}
?>
<p>&nbsp;</p>
</body>
</html>

