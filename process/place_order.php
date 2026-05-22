<?php
session_start();
include('../config/database.php');

if (isset($_POST['btn_place_order'])) {

    // 1. KIỂM TRA ĐĂNG NHẬP & LẤY USER_ID
    $user_id = 0;
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } elseif (isset($_SESSION['user'])) {
        $user_id = is_array($_SESSION['user']) ? ($_SESSION['user']['id'] ?? 0) : $_SESSION['user'];
    }

    if ($user_id == 0) {
        header("Location: ../login.php");
        exit();
    }

    // 2. LẤY DỮ LIỆU GIỎ HÀNG TỪ DATABASE
    $sql_cart = "SELECT c.*, p.gia FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = '$user_id'";
    $result_cart = mysqli_query($conn, $sql_cart);

    if (mysqli_num_rows($result_cart) == 0) {
        $alert_title = "Cảnh báo!";
        $alert_theme = "warning";
        $alert_message = "Giỏ hàng của bạn đang trống!";
        $redirect_url = "../index.php";
        include('../includes/alert_message.php');
        exit();
    }

    // 3. LẤY THÔNG TIN TỪ FORM THANH TOÁN
    // (Bắt cả 'full_name' và 'fullname' để tránh lỗi sai chính tả từ form HTML)
    $fullname = mysqli_real_escape_string($conn, isset($_POST['full_name']) ? $_POST['full_name'] : $_POST['fullname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $payment = mysqli_real_escape_string($conn, $_POST['payment_method']);


    // Tính tổng tiền
    $total = 0;
    $items = [];
    while ($row = mysqli_fetch_assoc($result_cart)) {
        $total += ($row['gia'] * $row['quantity']);
        $items[] = $row;
    }
    $final_total = $total + 30000; // Cộng phí ship

    // =======================================================
    // BƯỚC 1: LƯU VÀO BẢNG ORDERS
    // =======================================================
    $sql_order = "INSERT INTO orders (user_id, fullname, phone, address, total, payment, status) 
                  VALUES ('$user_id', '$fullname', '$phone', '$address', '$final_total', '$payment', 'Chờ xử lý')";

    if (mysqli_query($conn, $sql_order)) {
        $order_id = mysqli_insert_id($conn); // Lấy ID đơn hàng vừa tạo
        $success = true;

        // =======================================================
        // BƯỚC 2: LƯU VÀO BẢNG ORDER_DETAILS
        // =======================================================
        foreach ($items as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $price = $item['gia'];
            $size = isset($item['size']) ? $item['size'] : 'M'; // Nếu không có size mặc định là M

            $sql_detail = "INSERT INTO order_details (order_id, product_id, quantity, price, size) 
                           VALUES ('$order_id', '$product_id', '$quantity', '$price', '$size')";

            if (!mysqli_query($conn, $sql_detail)) {
                $success = false;
                // IN RA LỖI ĐỂ DỄ BẮT BỆNH BẢNG CHI TIẾT
                die("<h3 style='color:red;'>LỖI LƯU CHI TIẾT ĐƠN HÀNG:</h3> " . mysqli_error($conn) . "<br><b>Câu lệnh:</b> " . $sql_detail);
            }
        }

        if ($success) {
            // =======================================================
            // BƯỚC 3: DỌN DẸP GIỎ HÀNG
            // =======================================================
            mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'");

            $alert_title = "Đặt hàng thành công!";
            $alert_theme = "success";
            $alert_message = "Cảm ơn bạn! Đơn hàng của bạn đã được tiếp nhận.";
            $redirect_url = "../order_details.php?id=$order_id";
            include('../includes/alert_message.php');
            exit();
        }
    } else {
        // IN RA LỖI ĐỂ DỄ BẮT BỆNH BẢNG ORDERS
        die("<div style='padding:20px; font-family:sans-serif;'>
                <h3 style='color:red;'>LỖI LƯU ĐƠN HÀNG VÀO BẢNG `orders`</h3>
                <p><b>Lý do:</b> " . mysqli_error($conn) . "</p>
                <p><b>Câu lệnh bị lỗi:</b> <i>" . $sql_order . "</i></p>
                <p style='color:blue;'>👉 Bạn hãy đối chiếu xem tên cột báo lỗi có giống hệt tên cột trong bảng Database không nhé!</p>
             </div>");
    }
}
