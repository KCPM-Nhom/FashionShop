<?php
session_start();
include('../config/database.php');

if (isset($_GET['cart_id']) && isset($_SESSION['user_id'])) {
    $cart_id = (int)$_GET['cart_id'];
    $user_id = $_SESSION['user_id'];

    mysqli_query($conn, "DELETE FROM cart WHERE id = $cart_id AND user_id = $user_id");

    echo "Đã xóa sản phẩm thành công";
    exit();
}

echo "Xóa thất bại";
exit();