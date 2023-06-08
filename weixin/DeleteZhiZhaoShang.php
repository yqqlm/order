
<?php
include_once '../conn.php';
include_once '../commonscript.php';
$suc=initLoginSession();
if(!$suc){
    print json_encode("登录失败");
    return;
}
$id=$_GET['id'];

$query=$conn->query("delete  from zhizhaoshang where name='".$id."'");
if(!$query){
    $baris = array("error"=>"Error: <br>".$conn->error) ;
    header('Access-Control-Allow-Origin:*');
    print json_encode($baris);
    return;
}
print json_encode(true);
return;


?>