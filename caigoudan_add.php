<?php
session_start();
include_once 'conn.php';
include_once 'tables.php';
include_once 'commonscript.php';
checkSessionTimeOut();
$ndate =date("Y-m-d");
$addnew=getPostValue("addnew");
$fromProducts=getValue("fromProducts");
$orderId=getValue("orderid");
if ($addnew=="1" )
{
	$table->setCurrentRecordWithForm("caigoudan");
	$msg=$table->setRecord("caigoudan",null);
	if($msg==""){
		echo "<script>javascript:alert('添加成功');location.href='caigoudan_add.php';</script>";
	}else{
		echo $msg;
	}
}else if($fromProducts!="1"){
	$record=$table->getRecord("caigoudan","");
	$table->setCurrentRecord($record);
	if($orderId>0){
		
		$sql="select * from xiaoshoudan where id=".$orderId;
		global $conn;
		$query=$conn->query($sql);
		$arr = $query->fetch_all(MYSQLI_BOTH);
		if ($query->num_rows > 0) {
			//get order by order id
			$table->setCurrentRecordField("shouhuodizhi",$arr[0]["shouhuodizhi"]);
			$table->setCurrentRecordField("shouhuoren",$arr[0]["shouhuoren"]);
			$table->setCurrentRecordField("shouhuorenshouji",$arr[0]["shouhuorenshouji"]);
			$table->setCurrentRecordField("yaoqiudaohuoshijian",$arr[0]["yaoqiudaohuoshijian"]);
			$table->setCurrentRecordField("shifouxiehuo",$arr[0]["shifouxiehuo"]);
			
			//get products info
			$sql="select * from xiaoshoudanproducts where xiaoshoudanid=".$orderId;
			$query=$conn->query($sql);
			$arr = $query->fetch_all(MYSQLI_BOTH);
			if ($query->num_rows > 0) {
				for($i=0;$i<$query->num_rows;$i++)	
				{
					$arr[$i]["caigoudanid"]="";
					$arr[$i]["danjia"]=$arr[$i]["jinjia"]?$arr[$i]["jinjia"]:$table->getJinJia($arr[$i]["shangpinmingcheng"],$arr[$i]["shangpinbianhao"]);
					$table->pushCurrentRecordArrField("products",$arr[$i]);
				}
			}
		}
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>添加采购单</title><script language="javascript" src="js/Calendar.js"></script><link rel="stylesheet" href="css.css" type="text/css">
</head>
<?php echo getCommonScript();?>
<body>
<p>添加采购单 <?php echo $ndate; ?></p>
<script language="javascript">


	function calcJine()
	{
		document.form1.jine.value=document.form1.danjia.value*document.form1.shuliang.value;
	}

</script>
<form id="form1" name="form1" method="post" action=""  enctype="multipart/form-data">
<?php
echo $table->getDetail("caigoudan",1,null);
?>
</form>
<p>&nbsp;</p>
</body>
</html>

