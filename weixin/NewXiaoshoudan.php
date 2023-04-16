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

$suc=$table->setRecord("xiaoshoudan",$rec,true);
$baris = array("suc" => $suc,"id"=>$rec["id"]);
header('Access-Control-Allow-Origin:*');
print json_encode($baris);
?>
