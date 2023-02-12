
<?php
include_once '../conn.php';
include_once '../commonscript.php';
if(!isset($_SESSION)){
    session_start();
}
$sql=getKehuxinxiSql();
$query=$conn->query($sql);
if(!$query){
    $baris = array("error"=>"Error: ".$sql."<br>".$conn->error) ;
    header('Access-Control-Allow-Origin:*');
    print json_encode($baris);
    return;
}
$arr = $query->fetch_all(MYSQLI_ASSOC);

////////////////////canpinxinxi//////////////////
$sql2=getCanpinxinxiSql();
$query2=$conn->query($sql2);
if(!$query2){
    $baris= array("error"=>"Error: ".$sql2."<br>".$conn->error) ;
    header('Access-Control-Allow-Origin:*');
    print json_encode($baris);
    return;
}
$arr2 = $query2->fetch_all(MYSQLI_ASSOC);
$baris = array('kehuxinxi' => $arr,"caninxinxi"=>$arr2);
header('Access-Control-Allow-Origin:*');
print json_encode($baris);
?>
