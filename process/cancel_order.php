<?php
session_start();

// Cấu hình đường dẫn cho đúng vì file này nằm trong thư mục process
include('../config/database.php');

// ==========================================
// 1. KIỂM TRA ĐĂNG NHẬP
// ==========================================
$user_id = 0;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} elseif (isset($_SESSION['user'])) {
    if (is_array($_SESSION['user']) && isset($_SESSION['user']['id'])) {
        $user_id = $_SESSION['user']['id'];
    } else {
        $user_id = $_SESSION['user'];
    }
}

// Nếu chưa đăng nhập thì đẩy về trang login
if (empty($user_id)) {
    echo "<script>alert('Vui lòng đăng nhập!'); window.location.href='../login.php';</script>";
    exit();
}

// ==========================================
// 2. XỬ LÝ HỦY ĐƠN HÀNG
// ==========================================
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);

    // Kiểm tra bảo mật cực kỳ quan trọng:
    // - Đơn hàng phải ĐÚNG LÀ CỦA USER ĐANG ĐĂNG NHẬP (chống hack đổi ID)
    // - Chỉ cho phép hủy khi đang "Chờ xử lý" hoặc "Chờ xác nhận"
    $check_sql = "SELECT id FROM orders WHERE id = '$order_id' AND user_id = '$user_id' AND (status = 'Chờ xử lý' OR status = 'Chờ xác nhận')";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Đủ điều kiện -> Cập nhật trạng thái thành Đã hủy
        $update_sql = "UPDATE orders SET status = 'Đã hủy' WHERE id = '$order_id'";

        if (mysqli_query($conn, $update_sql)) {
            // Hủy thành công -> Quay lại trang chi tiết đơn hàng
            echo "<script>
                    alert('Hủy đơn hàng thành công!'); 
                    window.location.href='../order_details.php?id=$order_id';
                  </script>";
            exit();
        } else {
            // Lỗi Database
            echo "<script>
                    alert('Có lỗi hệ thống xảy ra, vui lòng thử lại sau!'); 
                    window.location.href='../order_details.php?id=$order_id';
                  </script>";
            exit();
        }
    } else {
        // Đơn hàng không hợp lệ (Không phải của mình, hoặc Admin đã duyệt/giao hàng)
        echo "<script>
                alert('Không thể hủy đơn hàng này! Có thể đơn hàng đã được admin xử lý.'); 
                window.location.href='../order_details.php?id=$order_id';
              </script>";
        exit();
    }
} else {
    // Nếu ai đó cố tình gõ link trực tiếp vào file này (không qua nút bấm POST)
    header("Location: ../order.php");
    exit();
}
