include_once '../conn.php';
$suc=initLoginSession();
if(!$suc){
    print json_encode("登录失败");
    return;
}
$context=getLoginContext();
if($context["role"]!="系统管理员")
{
    print json_encode("不是系统管理员");
    return;
}

$username=$_GET['username'];
$pwd=$_GET['pwd'];
$cx=$_GET['cx'];
$suc=AddUser($username,$pwd,$cx);
$baris = array("suc" => $suc);
header('Access-Control-Allow-Origin:*');
print json_encode($baris);