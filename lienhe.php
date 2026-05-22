<?php
session_start();
include('config/database.php'); // Đảm bảo đường dẫn file database.php đúng nhé

// Xử lý khi khách hàng bấm nút Gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_contact'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql_insert = "INSERT INTO contacts (fullname, email, message) VALUES ('$fullname', '$email', '$message')";

    if (mysqli_query($conn, $sql_insert)) {
        echo "<script>alert('Cảm ơn bạn! Tin nhắn đã được gửi tới FashionShop thành công.'); window.location.href='lienhe.php';</script>";
    } else {
        echo "<script>alert('Lỗi: Không thể gửi tin nhắn.');</script>";
    }
}
?>



<title>TRANG LIÊN HỆ</title>
<?php include 'includes/header.php'; ?>


<link rel="stylesheet" href="assets/css/header.css">
<link rel="stylesheet" href="assets/css/footer.css">
<link rel="stylesheet" href="assets/css/lienhe.css">

<main>
    <section>
        <h1>Phản Hồi Cho Chúng Tôi</h1>
        <div class="contact-container">
            <div class="contact-grid">
                <div class="card">
                    <h2>Để Lại Lời Nhắn</h2>
                    <form id="contactForm" action="" method="POST">
                        <div class="form-group">
                            <label>Họ và tên</label>
                            <input type="text" name="fullname" class="form-control" placeholder="Nhập tên của bạn..." required
                                value="<?php echo isset($_SESSION['fullname']) ? htmlspecialchars($_SESSION['fullname']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Nhập email của bạn..." required
                                value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea name="message" class="form-control" rows="5" placeholder="Bạn cần hỗ trợ điều gì?" required></textarea>
                        </div>

                        <button type="submit" name="send_contact" class="btn-submit">
                            <i class="fa-solid fa-paper-plane"></i> Gửi Tin Nhắn
                        </button>
                    </form>
                </div>

                <div class="card">
                    <h2>Thông Tin Liên Lạc</h2>

                    <div class="info-item">
                        <i class="fa-solid fa-phone"></i>
                        <div class="info-text">
                            <p>0352493970</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fa-solid fa-envelope"></i>
                        <div class="info-text">
                            <p>supportfashionstore123@gmail.com</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fa-solid fa-location-dot"></i>
                        <div class="info-text">
                            <p>123 Đường Lê Lợi, Quận 1, TP. Hồ Chí Minh</p>
                        </div>
                    </div>

                    <div class="map-box">
                        <iframe
                            src="https://www.google.com/maps?q=123+Lê+Lợi,+Quận+1,+TP+Hồ+Chí+Minh&output=embed"
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="/Frontend/user/activeuser/lienhe.js"></script>
</main>
<?php include 'includes/footer.php'; ?>