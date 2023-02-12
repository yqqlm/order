<?php
include_once '../conn.php';
include_once '../tables.php';
global $conn;
$tables=new Tables();
$sql = $_POST['sql'];
$strTotal = $_POST['sumarray'];
$arrTotal =explode(',',$strTotal);
$tableName = $_POST['tablename'];
$query=$conn->query($sql);
if(!$query){
    return array("error"=>"Error: ".$sql."<br>".$conn->error) ;
}
$arr = $query->fetch_all(MYSQLI_BOTH);
$totals=$tables->getTotal($arr,$arrTotal,$tableName);
$baris = array('data' => $arr,"totals"=>$totals);
header('Access-Control-Allow-Origin:*');
print json_encode($baris);
?>
