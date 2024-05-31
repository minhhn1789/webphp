<?php
// Chúng tôi cần sử dụng phiên, vì vậy bạn phải luôn bắt đầu phiên bằng mã bên dưới.
session_start();
// Nếu người dùng chưa đăng nhập sẽ chuyển hướng đến trang đăng nhập...
if (isset($_SESSION['loggedin'])) {
    header('Location: home.php');
    exit;
}
?>
