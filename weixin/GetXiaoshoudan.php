
<?php
include_once '../conn.php';
include_once '../commonscript.php';
$suc=initLoginSession();
if(!$suc){
    print json_encode("登录失败");
    return;
}
$p=$_GET['page'];
$page=($p!='')?intval($p):1;
$rows=5;
$offset=($page-1)*$rows;

$sql=getXiaoshoudanSql();
$sql=$sql.' group by id ';
$query_count=$conn->query($sql);
$all = $query_count->fetch_all(MYSQLI_ASSOC);
if(!$query_count){
    $baris = array("error"=>"Error: ".$sql."<br>".$conn->error) ;
    header('Access-Control-Allow-Origin:*');
    print json_encode($baris);
    return;
}
$sql=$sql." order by dingdandate desc";
$sql=$sql.' limit '.$offset.','.$rows;
$query=$conn->query($sql);
if(!$query){
    $baris = array("error"=>"Error: ".$sql."<br>".$conn->error) ;
    header('Access-Control-Allow-Origin:*');
    print json_encode($baris);
    return;
}
$arr = $query->fetch_all(MYSQLI_ASSOC);
$baris = array('total' => count($all),"list"=>$arr);
header('Access-Control-Allow-Origin:*');
print json_encode($baris);
?>