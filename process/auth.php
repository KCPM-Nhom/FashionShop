<?php
session_start();

include('../config/database.php');


// HELPER: Đọc input từ raw JSON hoặc form-data

function getInput() {
    $rawBody = file_get_contents('php://input');
    if (!empty($rawBody)) {
        $decoded = json_decode($rawBody, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }
    }
    return $_POST;
}

// XỬ LÝ ĐĂNG XUẤT (Nhận qua phương thức GET)

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
}


// XỬ LÝ ĐĂNG NHẬP / ĐĂNG KÝ (Nhận qua phương thức POST)

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $input  = getInput();
    $action = isset($input['action']) ? $input['action'] : '';


    // XỬ LÝ ĐĂNG NHẬP (SỬ DỤNG EMAIL)
   
    if ($action == 'login') {

        $email    = mysqli_real_escape_string($conn, $input['email']    ?? '');
        $password = mysqli_real_escape_string($conn, $input['password'] ?? '');

        // --- HÀM KIỂM TRA CHỮ IN HOA NGAY TRONG LOGIN ---
        if (!preg_match('/[A-Z]/', $password)) {
            $_SESSION['error'] = "Mật khẩu phải có ít nhất một chữ cái in hoa!";
            header("Location: ../login.php");
            exit();
        }

        // Kiểm tra trong bảng ADMIN trước (Bằng Email)
        $sql_admin    = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
        $result_admin = mysqli_query($conn, $sql_admin);

        if (mysqli_num_rows($result_admin) > 0) {
            $row = mysqli_fetch_assoc($result_admin);
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['role']     = 'admin';

            header("Location: ../admin/index.php");
            exit();
        }

        // Nếu không phải Admin, kiểm tra tiếp trong bảng USER (Bằng Email)
        $sql_user    = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
        $result_user = mysqli_query($conn, $sql_user);

        if (mysqli_num_rows($result_user) > 0) {
            $row = mysqli_fetch_assoc($result_user);
            $_SESSION['user_id']  = $row['id'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['role']     = 'user';

            header("Location: ../index.php");
            exit();
        }

        // Sai cả 2 bảng
        $_SESSION['error'] = "Email hoặc mật khẩu không chính xác!";
        header("Location: ../login.php");
        exit();
    }

   
    // XỬ LÝ ĐĂNG KÝ
  
    if ($action == 'register') {

        $lastname  = mysqli_real_escape_string($conn, $input['lastname']  ?? '');
        $firstname = mysqli_real_escape_string($conn, $input['firstname'] ?? '');
        $fullname  = trim($lastname . ' ' . $firstname);

        $email    = mysqli_real_escape_string($conn, $input['email']    ?? '');
        $phone    = mysqli_real_escape_string($conn, $input['phone']    ?? '');
        $gender   = mysqli_real_escape_string($conn, $input['gender']   ?? '');
        $password = mysqli_real_escape_string($conn, $input['password'] ?? '');

        if (strlen($phone) !== 10) {
            $_SESSION['error'] = "Số điện thoại phải chứa đúng 10 chữ số!";
            header("Location: ../register.php");
            exit();
        }


        // Kiểm tra xem Email đã tồn tại chưa
        $check_exist  = "SELECT * FROM user WHERE email = '$email'";
        $result_check = mysqli_query($conn, $check_exist);

        if (mysqli_num_rows($result_check) > 0) {
            $_SESSION['error'] = "Email này đã được sử dụng!";
            header("Location: ../register.php");
            exit();
        }

        // Thêm vào Database
        $sql_insert = "INSERT INTO user (fullname, email, phone, gender, password) 
                       VALUES ('$fullname', '$email', '$phone', '$gender', '$password')";

        if (mysqli_query($conn, $sql_insert)) {
            $alert_title   = "Tuyệt vời!";
            $alert_theme   = "success";
            $alert_message = "Đăng ký thành công! Vui lòng đăng nhập.";
            $redirect_url  = "../login.php";
            include('../includes/alert_message.php');
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra. Vui lòng thử lại!";
            header("Location: ../register.php");
        }
        exit();
    }
}