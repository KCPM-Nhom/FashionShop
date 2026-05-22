<?php
session_start();
include('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = (int)$_POST['product_id'];
    $rating = (int)$_POST['rating'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

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
