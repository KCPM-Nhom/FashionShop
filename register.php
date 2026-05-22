<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/auth.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <title>TRANG ĐĂNG KÝ</title>
</head>

<body>
    <div class="form-container">
        <h1>Đăng Ký Tài Khoản</h1>

        <div class="auth-bg"></div>

        <div class="form-box">

            <?php if (isset($_SESSION['error'])): ?>
                <div class="error-msg">
                    <i class="fa fa-exclamation-circle"></i>
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']); // Xóa ngay sau khi hiển thị
                    ?>
                </div>
            <?php endif; ?>

            <form id="registerForm" action="process/auth.php" method="POST">

                <input type="hidden" name="action" value="register">

                <div class="name-row">
                    <div class="input-group">
                        <i class="fa fa-user"></i>
                        <input type="text" name="lastname" placeholder="Họ" required>
                    </div>

                    <div class="input-group">
                        <input type="text" name="firstname" placeholder="Tên" required style="padding-left: 10px;">
                    </div>
                </div>

                <div class="input-group">
                    <i class="fa fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" required>
                </div>

                <div class="input-group">
                    <i class="fa fa-phone"></i>
                    <input type="text" name="phone" placeholder="Số điện thoại" required>
                </div>

                <div class="input-group gender-group">
                    <i class="fa fa-venus-mars"></i>
                    <div class="gender-options">
                        <label>
                            <input type="radio" name="gender" value="Nam" checked>
                            <span>Nam</span>
                        </label>
                        <label>
                            <input type="radio" name="gender" value="Nữ">
                            <span>Nữ</span>
                        </label>
                    </div>
                </div>

                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input id="pass1" name="password" type="password" placeholder="Mật khẩu" required>
                </div>

                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input id="pass2" type="password" placeholder="Nhập lại mật khẩu" required>
                </div>

                <button type="submit">
                    <i class="fa fa-user-plus"></i> Đăng Ký
                </button>
            </form>
        </div>

        <div class="link">
            <p>Đã có tài khoản?</p>
            <a href="login.php">
                <p>Đăng Nhập</p>
            </a>
        </div>
    </div>

    <script src="assets/js/auth.js"></script>
</body>

</html>