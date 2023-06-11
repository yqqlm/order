
<?php
include_once '../conn.php';
include_once '../commonscript.php';
include_once '../tables.php';
$suc=initLoginSession();
if(!$suc){
    print json_encode("登录失败");
    return;
}
$p=$_GET['page'];
$search=$_GET['searchValue'];
$timeValue=$_GET['timeValue'];
$orderValue=$_GET['orderValue'];

$page=($p!='')?intval($p):1;
$rows=5;
$offset=($page-1)*$rows;

$sql=getXiaoshoudanSql($search, $timeValue);
$sql=$sql.' group by id ';
$query_count=$conn->query($sql);
if(!$query_count){
    $baris = array("error"=>"Error: ".$sql."<br>".$conn->error) ;
    header('Access-Control-Allow-Origin:*');
    print json_encode($baris);
    return;
}
$all = $query_count->fetch_all(MYSQLI_ASSOC);
if($orderValue==="倒序"){
    $sql=$sql." order by dingdandate desc";
}else{
    $sql=$sql." order by dingdandate asc";
}

$sql=$sql.' limit '.$offset.','.$rows;
$query=$conn->query($sql);
if(!$query){
    $baris = array("error"=>"Error: ".$sql."<br>".$conn->error) ;
    header('Access-Control-Allow-Origin:*');
    print json_encode($baris);
    return;
}
$arr = $query->fetch_all(MYSQLI_ASSOC);
$totals=$tables->getTotal($arr,array("xiaoshoujine","yunfei","xiaoshoulirun"),"xiaoshoudan");
$baris = array('total' => count($all),"list"=>$arr,"totals",$totals);
header('Access-Control-Allow-Origin:*');
print json_encode($baris);
?>