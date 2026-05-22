<?php
session_start();
include('config/database.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM user WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$user_info = mysqli_fetch_assoc($result);

$title = 'Hồ sơ của tôi | FASHIONSTORE';
// Khai báo biến này để file header.php tự động nhét link profile.css vào thẻ <head>
?>

<?php include('includes/header.php'); ?>
<link rel="stylesheet" href="assets/css/profile.css">
<main>
    <div class="profile-container">
        <div class="profile-sidebar">
            <i class="fa-solid fa-circle-user user-big"></i>
            <h3><?php echo htmlspecialchars($user_info['fullname']); ?></h3>
            <ul class="sidebar-menu">
                <li><a href="#" class="active" onclick="showSection('info', this)"><i class="fa-solid fa-user-gear"></i> Hồ sơ của tôi</a></li>
                <li><a href="#" onclick="showSection('password', this)"><i class="fa-solid fa-lock"></i> Đổi mật khẩu</a></li>
            </ul>
        </div>

        <div class="profile-main">
            <div id="info" class="profile-section active">
                <h2>Hồ Sơ Của Tôi</h2>
                <form action="process/update_profile.php" method="POST">
                    <div class="form-group">
                        <label>Tên đăng nhập (Họ tên)</label>
                        <input type="text" value="<?php echo htmlspecialchars($user_info['fullname']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user_info['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($user_info['phone']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Giới tính</label>
                        <div class="gender-wrap">
                            <label><input type="radio" name="gender" value="Nam" <?php echo ($user_info['gender'] == 'Nam') ? 'checked' : ''; ?>> Nam</label>
                            <label><input type="radio" name="gender" value="Nữ" <?php echo ($user_info['gender'] == 'Nữ') ? 'checked' : ''; ?>> Nữ</label>
                        </div>
                    </div>
                    <button type="submit" name="update_info" class="btn-save">Lưu thay đổi</button>
                </form>
            </div>

            <div id="password" class="profile-section">
                <h2>Đổi Mật Khẩu</h2>
                <form action="process/update_profile.php" method="POST">
                    <div class="form-group">
                        <label>Mật khẩu hiện tại</label>
                        <input type="password" name="old_password" required placeholder="Nhập mật khẩu cũ">
                    </div>
                    <div class="form-group">
                        <label>Mật khẩu mới</label>
                        <input type="password" name="new_password" required placeholder="Nhập mật khẩu mới">
                    </div>
                    <div class="form-group">
                        <label>Xác nhận mật khẩu mới</label>
                        <input type="password" name="confirm_password" required placeholder="Nhập lại mật khẩu mới">
                    </div>
                    <button type="submit" name="change_pass" class="btn-save">Cập nhật mật khẩu</button>
                </form>
            </div>
        </div>
    </div>

    <script src="assets/js/profile.js"></script>
</main>

<?php include('includes/footer.php'); ?>