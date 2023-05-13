
<?php
include_once '../conn.php';
include_once '../commonscript.php';
$suc=initLoginSession();
if(!$suc){
    print json_encode("登录失败");
    return;
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

////////////////////gongyingshang xinxi//////////////////
$sql3=getGongyingshangxinxiSql();
$query3=$conn->query($sql3);
if(!$query3){
    $baris= array("error"=>"Error: ".$sql3."<br>".$conn->error) ;
    header('Access-Control-Allow-Origin:*');
    print json_encode($baris);
    return;
}
$arr3 = $query3->fetch_all(MYSQLI_ASSOC);

////////////////////users xinxi//////////////////
$sql4="select username, cx from allusers order by username asc";
$query4=$conn->query($sql4);
if(!$query4){
    $baris= array("error"=>"Error: ".$sql4."<br>".$conn->error) ;
    header('Access-Control-Allow-Origin:*');
    print json_encode($baris);
    return;
}
$arr4 = $query4->fetch_all(MYSQLI_ASSOC);
$baris = array('kehuxinxi' => $arr,"caninxinxi"=>$arr2, "gongyingshangxinxi"=>$arr3, "users"=>$arr4);
header('Access-Control-Allow-Origin:*');
print json_encode($baris);
?>
