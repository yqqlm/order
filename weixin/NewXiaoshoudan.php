<?php
include_once '../conn.php';
include_once '../tables.php';
if(!isset($_SESSION)){
    session_start();
}
$rec=$_GET["record"];
$rec = json_decode($rec,true);

$suc=$table->setRecord("xiaoshoudan",$rec);
print $suc;
?>
