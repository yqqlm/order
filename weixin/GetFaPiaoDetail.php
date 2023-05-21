
<?php
include_once '../conn.php';
include_once '../commonscript.php';
$suc=initLoginSession();
if(!$suc){
    print json_encode("登录失败");
    return;
}
$id=$_GET['id'];

$query=$conn->query("select * from fapiao where id=".$id);
if(!$query){
    $baris = array("error"=>"Error: ".$sql."<br>".$conn->error) ;
    header('Access-Control-Allow-Origin:*');
    print json_encode($baris);
    return;
}
$rec = $query->fetch_all(MYSQLI_ASSOC);

$baris = array('rec' => $rec[0]);
header('Access-Control-Allow-Origin:*');
print json_encode($baris);
?>