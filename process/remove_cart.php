<?php
session_start();
include('../config/database.php');

if (isset($_GET['cart_id']) && isset($_SESSION['user_id'])) {
    $cart_id = (int)$_GET['cart_id'];
    $user_id = $_SESSION['user_id'];

    // Xóa khỏi database, chỉ xóa nếu đúng user_id để tránh hack
    mysqli_query($conn, "DELETE FROM cart WHERE id = $cart_id AND user_id = $user_id");
}
header("Location: ../shopping_cart.php");
exit();
