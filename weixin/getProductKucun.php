<?php
include_once '../conn.php';
include_once '../tables.php';
$suc=initLoginSession();
if(!$suc){
    print json_encode("登录失败");
    return;
}
$mc=$_GET['shangpinmingcheng'];
$bh=$_GET['shangpinbianhao'];
$gg=$_GET['guige'];
$sql="select * from kucun where 1=1";
$sql=$sql." and shangpinmingcheng = '$mc'";
$sql=$sql." and shangpinbianhao = '$bh'";
$sql=$sql." and guige = '$gg'";
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