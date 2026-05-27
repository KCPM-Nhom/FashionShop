<?php
session_start();
include('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = (int)$_POST['product_id'];
    $rating = (int)$_POST['rating'];
    
    if ($rating < 1 || $rating > 5) {
        $alert_title = "Thất bại!";
        $alert_theme = "danger";
        $alert_message = "Số sao đánh giá không hợp lệ!";
        $redirect_url = "../detail.php?id=$product_id";
        include('../includes/alert_message.php');
        exit();
    }

 // 1. Lấy dữ liệu comment và dùng trim() để loại bỏ các dấu cách thừa ở đầu/cuối
$raw_comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

// 2. Kiểm tra nếu comment bị rỗng sau khi đã xóa dấu cách
if (empty($raw_comment)) {
    $alert_title = "Thất bại!";
    $alert_theme = "danger"; // Hiện thông báo màu đỏ
    $alert_message = "Vui lòng nhập nội dung bình luận, không được để trống!";
    $redirect_url = "../detail.php?id=$product_id";
    include('../includes/alert_message.php');
    exit(); // Dừng ngay lập tức, không cho lưu vào Database
}

// 3. Nếu hợp lệ thì mới dùng mysqli_real_escape_string để chống SQL Injection
$comment = mysqli_real_escape_string($conn, $raw_comment);

// Kiểm tra xem sản phẩm có tồn tại không
$check_product = "SELECT id FROM products WHERE id = '$product_id'";
$result_product = mysqli_query($conn, $check_product);

if (mysqli_num_rows($result_product) == 0) {

    http_response_code(400);

    $alert_title = "Thất bại!";
    $alert_theme = "danger";
    $alert_message = "Sản phẩm không tồn tại!";
    $redirect_url = "../index.php";

    include('../includes/alert_message.php');
    exit();
}
    // Thêm NOW() để cột created_at có dữ liệu, giúp detail.php lấy được ngày
    $sql = "INSERT INTO reviews (product_id, user_id, rating, comment, created_at) 
            VALUES ('$product_id', '$user_id', '$rating', '$comment', NOW())";

    if (mysqli_query($conn, $sql)) {
        $alert_title = "Thành công!";
        $alert_theme = "success"; // Hiện màu xanh lá
        $alert_message = "Cảm ơn bạn đã đánh giá sản phẩm!";
        $redirect_url = "../detail.php?id=$product_id";
        include('../includes/alert_message.php');
        exit();
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
} else {
    header("Location: ../index.php");
}
