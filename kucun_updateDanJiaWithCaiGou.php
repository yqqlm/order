<?php

include_once 'conn.php';
include_once 'tables.php';
include_once 'commonscript.php';
checkSessionTimeOut();
global $conn;
$rtn=updateKucunDanjia("caigou");
if($rtn!==""){
    echo "<script>javascript:alert('更新失败，error:$rtn');location.href='".$_SESSION['ListUrl']."'".";</script>";
    
}
echo "<script>javascript:alert('库存单价更新成功');location.href='".$_SESSION['ListUrl']."'".";</script>";
?>