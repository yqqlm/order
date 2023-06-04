
<?php
include_once '../conn.php';
include_once '../commonscript.php';
$suc=initLoginSession();
if(!$suc){
    print json_encode("登录失败");
    return;
}
$p=$_GET['page'];
$search=$_GET['searchValue'];


$page=($p!='')?intval($p):1;
$rows=5;
$offset=($page-1)*$rows;

$sql=getKeHuSql($search);
$sql=$sql.' group by kehumingcheng ';
$query_count=$conn->query($sql);
if(!$query_count){
    $baris = array("error"=>"Error: ".$sql."<br>".$conn->error) ;
    header('Access-Control-Allow-Origin:*');
    print json_encode($baris);
    return;
}
$all = $query_count->fetch_all(MYSQLI_ASSOC);

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