<?php
session_start();
include('../config/database.php');

if (isset($_GET['action']) && isset($_GET['cart_id']) && isset($_SESSION['user_id'])) {
    $action = $_GET['action'];
    $cart_id = (int)$_GET['cart_id'];
    $user_id = $_SESSION['user_id'];

    // Kiểm tra xem sản phẩm trong giỏ có đúng là của user này không (Bảo mật)
    $check_sql = "SELECT quantity FROM cart WHERE id = $cart_id AND user_id = $user_id";
    $result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $current_qty = $row['quantity'];

        if ($action == 'increase') {
            $new_qty = $current_qty + 1;
            mysqli_query($conn, "UPDATE cart SET quantity = $new_qty WHERE id = $cart_id");
        } elseif ($action == 'decrease') {
            $new_qty = $current_qty - 1;
            if ($new_qty > 0) {
                mysqli_query($conn, "UPDATE cart SET quantity = $new_qty WHERE id = $cart_id");
            } else {
                // Nếu giảm về 0 thì tự động xóa luôn
                mysqli_query($conn, "DELETE FROM cart WHERE id = $cart_id");
            }
        }
    }
}
header("Location: ../shopping_cart.php");
exit();
