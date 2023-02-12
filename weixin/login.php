
<?php
include_once '../conn.php';
if(!isset($_SESSION)){
    session_start();
}
$username=$_GET['username'];
$pwd=$_GET['password'];
$cx=$_GET['role'];
$suc=login($username,$pwd,$cx);
header('Access-Control-Allow-Origin:*');
print json_encode($suc);
?>
