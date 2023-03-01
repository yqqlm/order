<?php
include_once '../conn.php';
include_once '../tables.php';
$suc=initLoginSession();
if(!$suc){
    print json_encode("登录失败");
    return;
}
$rec=$_GET["record"];
$rec = json_decode($rec,true);
$products=$rec["kucun_add_products"];

$length=count($products);
$err="";
for($x=0;$x<$length;$x++){
    $item = $products[$x];
    $sql=$this->getAddSql("kucunhistory",$item);
    $suc=$conn->query($sql);//add record to kucunhistory
    if(!$suc){
        $err = $err. " Error: ".$sql."<br>".$conn->error;
    }
}
print $err;
?>