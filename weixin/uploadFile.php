<?php
include_once '../conn.php';
include_once '../tables.php';
$suc=initLoginSession();
if(!$suc){
    print json_encode("登录失败");
    return;
}
$id=$_GET['id'];
$tableName=$_GET['table'];
$col=$_GET['column'];
$suc=$table->uploadFile($tableName,$col,$id);
header('Access-Control-Allow-Origin:*');
print json_encode($suc);
?>
