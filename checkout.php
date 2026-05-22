<?php
session_start();
include('config/database.php');

// 1. ĐỒNG BỘ CÁCH LẤY USER_ID
$user_id = 0;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} elseif (isset($_SESSION['user'])) {
    $user_id = is_array($_SESSION['user']) ? ($_SESSION['user']['id'] ?? 0) : $_SESSION['user'];
}

// Kiểm tra nếu chưa đăng nhập thì bắt quay lại login
if ($user_id == 0) {
    header("Location: login.php");
    exit();
}

// 2. TRUY VẤN GIỎ HÀNG TỪ DATABASE THAY VÌ SESSION
$sql_cart = "SELECT c.*, p.ten_sp, p.gia, p.hinh_anh
FROM cart c
JOIN products p ON c.product_id = p.id
WHERE c.user_id = '$user_id'";
$result_cart = mysqli_query($conn, $sql_cart);

// Nếu giỏ hàng trong Database trống, đẩy về trang chủ hoặc giỏ hàng
if (mysqli_num_rows($result_cart) == 0) {
    header("Location: shopping_cart.php");
    exit();
}

// 3. TÍNH TỔNG TIỀN TỪ DỮ LIỆU DATABASE
$total_price = 0;
// Chúng ta sẽ lấy dữ liệu vào một mảng để tí nữa hiển thị ở phần HTML bên dưới
$cart_items = [];
while ($row = mysqli_fetch_assoc($result_cart)) {
    $total_price += $row['gia'] * $row['quantity'];
    $cart_items[] = $row;
}
$final_total = $total_price + 30000; // Cộng phí ship 30k
?>


<title>Thanh Toán - FASHIONSTORE</title>
<?php include('includes/header.php'); ?>

<link rel="stylesheet" href="assets/css/global.css">
<link rel="stylesheet" href="assets/css/checkout.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">



<main>
    <div class="checkout-container" style="margin-top: 40px;">
        <form action="process/place_order.php" method="POST" class="checkout-form">
            <div class="checkout-left">
                <h3><i class="fa fa-truck"></i> Thông tin giao hàng</h3>

                <?php
                $selected_addr = null;
                if ($user_id > 0):
                    $res_addr = mysqli_query($conn, "SELECT * FROM user_addresses WHERE user_id = '$user_id' ORDER BY is_default DESC");

                    if (mysqli_num_rows($res_addr) > 0): ?>
                        <div class="input-group">
                            <label style="font-weight:bold; font-size:14px;">Chọn từ địa chỉ đã lưu:</label>
                            <select id="address_selector" class="form-control" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; margin: 10px 0;">
                                <option value="">-- Sử dụng địa chỉ khác --</option>
                                <?php while ($addr = mysqli_fetch_assoc($res_addr)):
                                    $is_selected = $addr['is_default'] ? 'selected' : '';
                                    if ($addr['is_default']) $selected_addr = $addr;
                                ?>
                                    <option value="<?php echo $addr['id']; ?>" <?php echo $is_selected; ?>
                                        data-name="<?php echo $addr['fullname']; ?>"
                                        data-phone="<?php echo $addr['phone']; ?>"
                                        data-details="<?php echo $addr['address_details']; ?>">
                                        <?php echo $addr['fullname'] . " (" . $addr['phone'] . ")"; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <div style="text-align: right; margin-bottom: 20px;">
                        <a href="address.php" style="font-size: 13px; color: #d0011b; text-decoration: none; font-weight: bold;">
                            <i class="fa fa-edit"></i> Quản lý sổ địa chỉ
                        </a>
                    </div>
                <?php endif; ?>

                <div class="input-group">
                    <input type="text" name="fullname" id="fullname" placeholder="Họ và tên" value="<?php echo $selected_addr['fullname'] ?? ''; ?>" required>
                </div>
                <div class="input-group">
                    <input type="text" name="phone" id="phone" placeholder="Số điện thoại" value="<?php echo $selected_addr['phone'] ?? ''; ?>" required>
                </div>
                <div class="input-group">
                    <textarea name="address" id="address" placeholder="Địa chỉ chi tiết" rows="3" required><?php echo $selected_addr['address_details'] ?? ''; ?></textarea>
                </div>

                <h3 style="margin-top: 30px;"><i class="fa fa-credit-card"></i> Phương Thức Thanh Toán</h3>
                <div class="payment-methods">
                    <label><input type="radio" name="payment_method" value="COD" checked> COD</label>
                    <label><input type="radio" name="payment_method" value="Chuyển khoản"> Chuyển khoản</label>
                </div>
            </div>

            <div class="checkout-right">
                <h3>Đơn Hàng</h3>
                <?php foreach ($cart_items as $item): ?>
                    <div class="checkout-item">
                        <img src="assets/images/<?php echo $item['hinh_anh']; ?>" width="50">
                        <div class="item-info">
                            <h4><?php echo $item['ten_sp']; ?></h4>
                            <p>Size: <?php echo $item['size']; ?></p>
                            <p>SL: <?php echo $item['quantity']; ?> | <?php echo number_format($item['gia'], 0, ',', '.'); ?>đ</p>
                        </div>
                    </div>
                <?php endforeach; ?>
                <hr>
                <div class="summary-row">
                    <span>Tạm tính:</span>
                    <span><?php echo number_format($total_price, 0, ',', '.'); ?>đ</span>
                </div>
                <div class="summary-row">
                    <span>Phí vận chuyển:</span>
                    <span>30.000đ</span>
                </div>
                <hr>
                <div class="summary-row total">
                    <span>Tổng cộng:</span>
                    <input type="hidden" name="total_amount" value="<?php echo $final_total; ?>">
                    <span class="total-price"><?php echo number_format($final_total, 0, ',', '.'); ?>đ</span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 20px;">
                    <button type="submit" name="btn_place_order" class="btn-place-order" style="width: 100%;">ĐẶT HÀNG NGAY</button>

                    <a href="shopping_cart.php" style="display: block; text-align: center; color: #333; text-decoration: none; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-weight: bold; background: #fff; transition: 0.3s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='#fff'">
                        <i class="fa fa-arrow-left"></i> Quay lại giỏ hàng
                    </a>
                </div>
            </div>
        </form>
    </div>
</main>
<script src="assets/js/checkout.js"></script>
<?php include('includes/footer.php'); ?>