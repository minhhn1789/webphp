<!-- Hủy các phiên đăng nhập và chuyển hướng người dùng đến trang đăng nhập -->
<?php
session_start();
session_destroy();
// Redirect to the login page:
header('Location: index.php');
?>