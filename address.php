<?php
session_start();
include('config/database.php');

// ĐỒNG BỘ CÁCH LẤY USER_ID
$user_id = 0;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} elseif (isset($_SESSION['user'])) {
    $user_id = is_array($_SESSION['user']) ? ($_SESSION['user']['id'] ?? 0) : $_SESSION['user'];
}

if (empty($user_id)) {
    echo "<script>alert('Vui lòng đăng nhập!'); window.location.href='login.php';</script>";
    exit();
}

// Xử lý POST (Thêm, Xóa, Mặc định)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'add') {
        if (!preg_match('/^[0-9]{9,11}$/', trim($_POST['phone']))) {
            echo "<script>alert('Số điện thoại không hợp lệ!'); history.back();</script>";
            exit();
        }
        $fullname = mysqli_real_escape_string($conn, trim($_POST['fullname']));
        $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
        $address_details = mysqli_real_escape_string($conn, trim($_POST['address_details']));
        $is_default = isset($_POST['is_default']) ? 1 : 0;
        if ($is_default == 1) mysqli_query($conn, "UPDATE user_addresses SET is_default = 0 WHERE user_id = '$user_id'");
        mysqli_query($conn, "INSERT INTO user_addresses (user_id, fullname, phone, address_details, is_default) VALUES ('$user_id', '$fullname', '$phone', '$address_details', '$is_default')");
    }

    if ($action == 'set_default') {
        $addr_id = mysqli_real_escape_string($conn, $_POST['address_id']);
        mysqli_query($conn, "UPDATE user_addresses SET is_default = 0 WHERE user_id = '$user_id'");
        mysqli_query($conn, "UPDATE user_addresses SET is_default = 1 WHERE id = '$addr_id' AND user_id = '$user_id'");
    }

    if ($action == 'delete') {
        $addr_id = mysqli_real_escape_string($conn, $_POST['address_id']);
        mysqli_query($conn, "DELETE FROM user_addresses WHERE id = '$addr_id' AND user_id = '$user_id'");
    }

    header("Location: address.php");
    exit();
}

$result_addr = mysqli_query($conn, "SELECT * FROM user_addresses WHERE user_id = '$user_id' ORDER BY is_default DESC, created_at DESC");
?>

<title>Sổ Địa Chỉ - FASHIONSTORE</title>
<?php include('includes/header.php'); ?>

<link rel="stylesheet" href="assets/css/global.css">
<link rel="stylesheet" href="assets/css/address.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<main>
    <h2 class="section-title" style="text-align: center; margin-top: 40px;">SỔ ĐỊA CHỈ</h2>

    <div style="max-width: 1000px; margin: 0 auto 20px; text-align: left;">
        <a href="checkout.php" style="display: inline-block; text-decoration: none; color: #333; font-weight: bold; font-size: 14px; padding: 10px 20px; background: #fff; transition: 0.3s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='#fff'">
            <i class="fa fa-arrow-left"></i> Quay lại Thanh toán
        </a>
    </div>
    <div class="address-container">
        <div class="address-list">
            <?php while ($row = mysqli_fetch_assoc($result_addr)): ?>
                <div class="address-card <?php echo ($row['is_default'] == 1) ? 'default' : ''; ?>">
                    <?php if ($row['is_default'] == 1): ?><span class="badge-default">Mặc định</span><?php endif; ?>
                    <div class="addr-name"><i class="fa fa-user"></i> <?php echo htmlspecialchars($row['fullname']); ?></div>
                    <div class="addr-phone"><i class="fa fa-phone"></i> <?php echo htmlspecialchars($row['phone']); ?></div>
                    <div class="addr-details"><i class="fa fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['address_details']); ?></div>
                    <div class="addr-actions">
                        <?php if ($row['is_default'] == 0): ?>
                            <form method="POST"><input type="hidden" name="action" value="set_default"><input type="hidden" name="address_id" value="<?php echo $row['id']; ?>"><button type="submit" class="btn-action">Mặc định</button></form>
                        <?php endif; ?>
                        <form method="POST" onsubmit="return confirm('Xóa địa chỉ này?');"><input type="hidden" name="action" value="delete"><input type="hidden" name="address_id" value="<?php echo $row['id']; ?>"><button type="submit" class="btn-action btn-delete">Xóa</button></form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="address-form-box">
            <h3 style="margin-top:0; border-bottom:1px solid #eee; padding-bottom:15px; margin-bottom:20px;">Thêm địa chỉ mới</h3>
            <form method="POST">
                <input type="hidden" name="action" value="add">

                <div class="form-group">
                    <label>Họ và tên người nhận</label>
                    <input type="text" name="fullname" placeholder="Nhập họ tên" required>
                </div>

                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="text" name="phone" placeholder="Nhập số điện thoại" required pattern="[0-9]{9,11}" title="Vui lòng nhập đúng số điện thoại">
                </div>

                <div class="form-group">
                    <label>Địa chỉ chi tiết (Số nhà, Phường, Quận, Tỉnh/TP)</label>
                    <textarea name="address_details" rows="3" placeholder="Nhập đầy đủ địa chỉ..." required></textarea>
                </div>

                <div class="form-group checkbox-group">
                    <input type="checkbox" name="is_default" id="is_default" value="1">
                    <label for="is_default">Đặt làm địa chỉ mặc định</label>
                </div>
                <button type="submit" class="btn-submit">LƯU ĐỊA CHỈ MỚI</button>
            </form>
        </div>
    </div>
</main>
<?php include('includes/footer.php'); ?>