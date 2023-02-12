
<?php
include_once '../conn.php';
include_once '../commonscript.php';
if(!isset($_SESSION)){
    session_start();
}
$id=$_GET['id'];

$query=$conn->query("select * from xiaoshoudan where id=".$id);
if(!$query){
    $baris = array("error"=>"Error: ".$sql."<br>".$conn->error) ;
    header('Access-Control-Allow-Origin:*');
    print json_encode($baris);
    return;
}
$rec = $query->fetch_all(MYSQLI_ASSOC);

$query=$conn->query("select * from xiaoshoudanproducts where xiaoshoudanid=".$id);
if(!$query){
    $baris = array("error"=>"Error: ".$sql."<br>".$conn->error) ;
    header('Access-Control-Allow-Origin:*');
    print json_encode($baris);
    return;
}
$products = $query->fetch_all(MYSQLI_ASSOC);
$baris = array('rec' => $rec[0],"products"=>$products);
header('Access-Control-Allow-Origin:*');
print json_encode($baris);
?>