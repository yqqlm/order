if(isset($_SESSION['expiretime'])) {
    if($_SESSION['expiretime'] < time()) {
        unset($_SESSION['expiretime']);
        header('Location: logout.php); // 登出
        exit(0);
    } else {
        $_SESSION['expiretime'] = time() + 1800; // 刷新时间戳
    }
}