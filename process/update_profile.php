<?php
session_start();
include('../config/database.php');

$user_id = $_SESSION['user_id'];

// TRƯỜNG HỢP 1: CẬP NHẬT THÔNG TIN HỒ SƠ
if (isset($_POST['update_info'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);

    // KIỂM TRA SỐ ĐIỆN THOẠI
    if (!preg_match('/^[0-9]{10}$/', $phone)) {

        $alert_title = "Thất bại!";
        $alert_theme = "danger";
        $alert_message = "Số điện thoại không hợp lệ";
        $redirect_url = "javascript:history.back()";

        include('../includes/alert_message.php');
        exit();
    }

    $sql = "UPDATE user SET email='$email', phone='$phone', gender='$gender' WHERE id='$user_id'";

    if (mysqli_query($conn, $sql)) {
        $alert_title = "Thành công!";
        $alert_theme = "success";
        $alert_message = "Cập nhật thông tin hồ sơ thành công!";
        $redirect_url = "../profile.php";
        include('../includes/alert_message.php');
        exit();
    }
}

// TRƯỜNG HỢP 2: ĐỔI MẬT KHẨU
if (isset($_POST['change_pass'])) {
    $old_pass = mysqli_real_escape_string($conn, $_POST['old_password']);
    $new_pass = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_pass = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // 1. Kiểm tra mật khẩu cũ có đúng không (Dùng id=$user_id thay vì fullname)
    $check_sql = "SELECT password FROM user WHERE id='$user_id'";
    $res = mysqli_query($conn, $check_sql);
    $user = mysqli_fetch_assoc($res);

    if ($old_pass !== $user['password']) {
        $alert_title = "Thất bại!";
        $alert_theme = "danger";
        $alert_message = "Mật khẩu hiện tại không chính xác!";
        $redirect_url = "javascript:history.back()";
        include('../includes/alert_message.php');
        exit();
    }

    // 2. Kiểm tra mật khẩu mới và xác nhận có khớp không
    if ($new_pass !== $confirm_pass) {
        $alert_title = "Thất bại!";
        $alert_theme = "danger";
        $alert_message = "Mật khẩu mới không khớp nhau!";
        $redirect_url = "javascript:history.back()";
        include('../includes/alert_message.php');
        exit();
    }

    // 3. Tiến hành cập nhật (Dùng id=$user_id thay vì fullname)
    $update_sql = "UPDATE user SET password='$new_pass' WHERE id='$user_id'";

    if (mysqli_query($conn, $update_sql)) {
        $alert_title = "Thành công!";
        $alert_theme = "success";
        $alert_message = "Đổi mật khẩu thành công!";
        $redirect_url = "../profile.php";
        include('../includes/alert_message.php');
        exit();
    }
}
