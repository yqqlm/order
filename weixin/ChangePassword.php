<?php
include_once '../conn.php';
$suc=initLoginSession();
$context=getLoginContext();
if(!$suc){
    print json_encode("登录失败");
    return;
}
$rec=$_GET["record"];
$rec = json_decode($rec,true);
$username=$context["username"];
$changeUser=$rec['username'];
if($username!==$changeUser){
    print json_encode("用户名错");
    return;
}
$pwd=$rec['newpwd'];
$cx=$context['role'];
$suc=ChangePassword($username,$cx,$pwd);
$baris = array("suc" => $suc);
header('Access-Control-Allow-Origin:*');
print json_encode($baris);
?>