<?php
include_once '../conn.php';
include_once '../tables.php';
$suc=initLoginSession();
if(!$suc){
    print json_encode("登录失败");
    return;
}
$id=$_GET['id'];
$table=$_GET['table'];
$col=$_GET['column'];
$suc=$table->uploadFile($table,$col,$id);
header('Access-Control-Allow-Origin:*');
print json_encode($suc);
?>
