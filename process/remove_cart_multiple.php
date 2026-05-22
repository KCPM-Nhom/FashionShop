<?php
session_start();
include('../config/database.php');

if (isset($_GET['ids']) && isset($_SESSION['user_id'])) {
    $ids = $_GET['ids'];
    $user_id = $_SESSION['user_id'];

    // Lọc dữ liệu an toàn: Chỉ giữ lại các số và dấu phẩy (vd: "1,4,7")
    $clean_ids = preg_replace('/[^0-9,]/', '', $ids);

    if (!empty($clean_ids)) {
        // Lệnh xóa cùng lúc nhiều giỏ hàng trong Database
        $sql = "DELETE FROM cart WHERE id IN ($clean_ids) AND user_id = '$user_id'";
        mysqli_query($conn, $sql);
    }
}

// Chuyển hướng về lại giỏ hàng
header("Location: ../shopping_cart.php");
exit();
