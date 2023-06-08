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

$suc=$table->setRecord("zhizhaoshang",$rec,true);
$id=isset($rec["name"])?$rec["name"]:"";
$baris = array("suc" => $suc,"id"=>$id);
header('Access-Control-Allow-Origin:*');
print json_encode($baris);
?>
