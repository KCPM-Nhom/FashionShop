<?php session_start(); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/auth.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <title>TRANG ĐĂNG NHẬP</title>
</head>

<body>

    <div class="form-container">

        <h1>Đăng Nhập</h1>

        <div class="auth-bg"></div>
        <div class="form-box">

            <?php if (isset($_SESSION['error'])): ?>
                <div class="error-msg">
                    <i class="fa fa-exclamation-circle"></i>
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']); // Xóa ngay sau khi hiển thị để lúc F5 không bị hiện lại
                    ?>
                </div>
            <?php endif; ?>

            <form action="process/auth.php" method="POST">

                <input type="hidden" name="action" value="login">

                <div class="input-group">
                    <i class="fa fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email" required>
                </div>

                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input id="password" name="password" type="password" placeholder="Mật Khẩu" required>
                </div>

                <div class="forgot">
                    <a href="#">Quên mật khẩu?</a>
                </div>

                <button type="submit">
                    <i class="fa fa-sign-in-alt"></i> Đăng Nhập
                </button>

            </form>
        </div>

        <div class="link">
            <p>Chưa có tài khoản?</p>
            <a href="register.php">
                <p>Đăng Ký</p>
            </a>
        </div>
    </div>

</body>

</html>