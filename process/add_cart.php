<?php
session_start();
include('../config/database.php');

// 1. KIỂM TRA ĐĂNG NHẬP
if (!isset($_SESSION['user_id'])) {
    // Trả lại thông báo Bootstrap khi chưa đăng nhập
    $alert_title = "Cảnh báo!";
    $alert_theme = "warning";
    $alert_message = "Vui lòng đăng nhập để tiếp tục mua sắm!";
    $redirect_url = '../login.php';

    // Lưu ý: Thay tên file 'alert_login.php' bằng đúng file bạn đang dùng
    include('../includes/alert_message.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// 2. BẮT SỰ KIỆN CỦA CẢ 2 NÚT (THÊM GIỎ HÀNG HOẶC MUA NGAY)
if (isset($_POST['add_to_cart']) || isset($_POST['buy_now'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    $size = isset($_POST['size']) ? mysqli_real_escape_string($conn, $_POST['size']) : 'M';

    // Truy vấn lấy thông tin sản phẩm
    $sql = "SELECT id, ten_sp, gia, hinh_anh FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {

        // KIỂM TRA SẢN PHẨM ĐÃ CÓ TRONG GIỎ HÀNG (CÙNG SIZE) CHƯA
        $check_sql = "SELECT id, quantity FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id' AND size = '$size'";
        $check_res = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_res) > 0) {
            // Nếu đã có -> Cập nhật cộng dồn số lượng
            $row = mysqli_fetch_assoc($check_res);
            $new_qty = $row['quantity'] + $quantity;
            $cart_id = $row['id'];
            mysqli_query($conn, "UPDATE cart SET quantity = '$new_qty' WHERE id = '$cart_id'");
        } else {
            // Nếu chưa có -> Thêm dòng mới vào Database
            mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity, size) VALUES ('$user_id', '$product_id', '$quantity', '$size')");
        }

        // =========================================================
        // KIỂM TRA NÚT BẤM ĐỂ ĐIỀU HƯỚNG MƯỢT MÀ
        // =========================================================
        if (isset($_POST['buy_now'])) {
            // Nếu khách bấm "MUA NGAY" -> Bỏ qua alert, đá thẳng sang thanh toán
            header("Location: ../checkout.php");
            exit();
        } else {
            // Nếu khách bấm "THÊM GIỎ HÀNG" -> Báo thành công bằng Bootstrap
            $alert_title = "Thêm thành công!";
            $alert_theme = "success";
            $alert_message = "Đã thêm sản phẩm (Size $size) vào giỏ hàng!";
            $redirect_url = $_SERVER['HTTP_REFERER']; // Trở lại đúng trang cũ

            // Lưu ý: ĐIỀN ĐÚNG TÊN FILE GỌI GIAO DIỆN ALERT CỦA BẠN VÀO ĐÂY
            include('../includes/alert_message.php');
            exit();
        }
    } else {
        // Thông báo lỗi nếu không tìm thấy SP
        $alert_title = "Lỗi!";
        $alert_theme = "danger";
        $alert_message = "Sản phẩm không tồn tại!";
        $redirect_url = $_SERVER['HTTP_REFERER'];

        include('../includes/alert_message.php');
        exit();
    }
}
