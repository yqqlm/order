<?php
session_start();
include_once 'conn.php';
include_once 'tables.php';


$index=getValue("id");
$editType=getValue("editType");
$table->removeCurrentRecordArrField("products",$index);

if($editType=="1" || $editType==1){
    echo "<script>location.href='caigoudan_add.php?fromProducts=1';</script>";
}else{
    echo "<script>location.href='caigoudan_updt.php?fromProducts=1';</script>";
}

?>
