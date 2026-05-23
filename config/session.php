<?php
// Khởi tạo session ở dòng đầu tiên của trang để lấy thông tin đăng nhập
if (session_status() == PHP_SESSION_NONE) {
    ob_start();
    session_start();
}
?>