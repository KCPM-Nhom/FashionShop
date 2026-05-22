<?php
session_start();
include('config/database.php');

// KIỂM TRA ĐĂNG NHẬP
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

if (empty($user_id)) {
    // echo "<script>alert('Vui lòng đăng nhập!'); window.location.href='login.php';</script>";
    include('includes/alert_login.php');
    exit();
}

// LẤY ID ĐƠN HÀNG TỪ URL
if (!isset($_GET['id'])) {
    header("Location: order.php");
    exit();
}
$order_id = mysqli_real_escape_string($conn, $_GET['id']);

// TRUY VẤN THÔNG TIN ĐƠN HÀNG (Bảo mật: Chỉ user đó mới xem được đơn của họ)
$sql_order = "SELECT * FROM orders WHERE id = '$order_id' AND user_id = '$user_id'";
$result_order = mysqli_query($conn, $sql_order);

if (mysqli_num_rows($result_order) == 0) {
    echo "<script>alert('Không tìm thấy đơn hàng!'); window.location.href='order.php';</script>";
    exit();
}
$order = mysqli_fetch_assoc($result_order);

// LẤY CHI TIẾT SẢN PHẨM TRONG ĐƠN HÀNG
$sql_detail = "SELECT od.*, p.ten_sp, p.hinh_anh 
               FROM order_details od 
               JOIN products p ON od.product_id = p.id 
               WHERE od.order_id = '$order_id'";
$result_detail = mysqli_query($conn, $sql_detail);
?>


<title>Chi Tiết Đơn Hàng #<?php echo $order_id; ?> - FASHIONSTORE</title>
<?php include('includes/header.php'); ?>

<link rel="stylesheet" href="assets/css/global.css">
<link rel="stylesheet" href="assets/css/order.css">
<link rel="stylesheet" href="assets/css/order_details.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


<main>
    <div class="details-container">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <a href="order.php" class="back-link" style="margin-bottom: 0;">
                <i class="fa fa-arrow-left"></i> Quay lại danh sách đơn hàng
            </a>

            <?php if ($order['status'] == 'Chờ xử lý'): ?>
                <form action="process/cancel_order.php" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không? Hành động này không thể hoàn tác.');" style="margin: 0;">
                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                    <button type="submit" style="background-color: #dc3545; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; font-weight: bold; transition: 0.3s;">
                        <i class="fa fa-times"></i> Hủy Đơn Hàng
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <div class="details-header-top">
            <h2 style="display: flex; align-items: center; gap: 15px;">
                CHI TIẾT ĐƠN HÀNG #<?php echo $order['id']; ?>
                <?php if ($order['status'] == 'Đã hủy'): ?>
                    <span style="font-size: 14px; padding: 5px 12px; border-radius: 5px; font-weight: normal; background-color: #ffe1e1; color: #dc3545;">
                        Đã hủy
                    </span>
                <?php endif; ?>
            </h2>
        </div>

        <?php if ($order['status'] == 'Đã hủy'): ?>
            <div style="text-align: center; padding: 20px; background: #fff5f5; border: 1px dashed #dc3545; border-radius: 8px; color: #dc3545; margin-bottom: 25px;">
                <i class="fa fa-exclamation-circle" style="font-size: 24px; margin-bottom: 10px;"></i>
                <p style="margin: 0;">Đơn hàng này đã được hủy.</p>
            </div>
        <?php else: ?>
            <?php
            $status = $order['status'];
            $step = 1; // Mặc định là Chờ xử lý
            if ($status == 'Đang giao') $step = 2;
            if ($status == 'Đã giao' || $status == 'Hoàn thành') $step = 3;
            ?>
            <div class="status-timeline-container">
                <div class="status-step <?php echo ($step >= 1) ? 'active' : ''; ?>">
                    <div class="step-icon"><i class="fa fa-box"></i></div>
                    <div class="step-text">Chờ xử lý</div>
                </div>

                <div class="step-line <?php echo ($step >= 2) ? 'active-line' : ''; ?>"></div>

                <div class="status-step <?php echo ($step >= 2) ? 'active' : ''; ?>">
                    <div class="step-icon"><i class="fa fa-truck"></i></div>
                    <div class="step-text">Đang giao</div>
                </div>

                <div class="step-line <?php echo ($step >= 3) ? 'active-line' : ''; ?>"></div>

                <div class="status-step <?php echo ($step >= 3) ? 'active' : ''; ?>">
                    <div class="step-icon"><i class="fa fa-check"></i></div>
                    <div class="step-text">Hoàn thành</div>
                </div>
            </div>
        <?php endif; ?>

        <div class="info-box">
            <div class="info-col">
                <h3><i class="fa fa-map-marker-alt"></i> Thông tin giao hàng</h3>
                <p><strong>Người nhận:</strong> <?php echo $order['fullname']; ?></p>
                <p><strong>Số điện thoại:</strong> <?php echo $order['phone']; ?></p>
                <p><strong>Địa chỉ:</strong> <?php echo $order['address']; ?></p>
            </div>
            <div class="info-col">
                <h3><i class="fa fa-credit-card"></i> Thông tin thanh toán</h3>
                <p><strong>Phương thức:</strong> <?php echo $order['payment']; ?></p>
                <p><strong>Ngày đặt hàng:</strong> <?php echo date('d/m/Y H:i:s', strtotime($order['created_at'])); ?></p>
            </div>
        </div>

        <?php
        if ($order['payment'] == 'Chuyển khoản' && in_array($order['status'], ['Chờ xử lý', 'Chờ xác nhận', 'Chờ thanh toán'])):
        ?>
            <div class="momo-payment-box">
                <h3>
                    <img src="assets/images/momo_logo.png" alt="MoMo Logo">
                    THANH TOÁN QUA MOMO
                </h3>
                <p class="momo-desc">Quét mã QR dưới đây bằng ứng dụng MoMo để hoàn tất thanh toán</p>

                <img src="assets/images/momo_qr.jpg" alt="QR MoMo" class="momo-qr-img">

                <p class="momo-amount">Số tiền cần chuyển: <strong><?php echo number_format($order['total'], 0, ',', '.'); ?>đ</strong></p>

                <div class="momo-transfer-content">
                    Nội dung CK: <span>THANHTOAN <?php echo $order['id']; ?></span>
                </div>

                <p class="momo-note">
                    * Vui lòng nhập chính xác nội dung chuyển khoản. Đơn hàng sẽ được tự động xử lý sau khi nhận được tiền.
                </p>
            </div>
        <?php endif; ?>

        <div class="order-card">
            <div class="order-header" style="background: #f8f9fa;">
                <strong>Sản phẩm đã mua</strong>
            </div>
            <div class="order-body">
                <?php while ($item = mysqli_fetch_assoc($result_detail)): ?>
                    <div class="order-item">
                        <img src="assets/images/<?php echo $item['hinh_anh']; ?>" alt="Sản phẩm">
                        <div class="item-details">
                            <div class="item-name"><?php echo $item['ten_sp']; ?></div>
                            <div class="item-meta">
                                Phân loại: Size <?php echo $item['size']; ?>
                                | Số lượng: <?php echo $item['quantity']; ?>
                            </div>
                        </div>
                        <div class="item-price">
                            <?php echo number_format($item['price'], 0, ',', '.'); ?>đ
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="order-summary-footer">
                <div class="summary-row">
                    <span>Tổng tiền hàng:</span>
                    <span>
                        <?php
                        $tong_tien_hang = ($order['total'] > 30000) ? ($order['total'] - 30000) : 0;
                        echo number_format($tong_tien_hang, 0, ',', '.');
                        ?>đ
                    </span>
                </div>
                <div class="summary-row">
                    <span>Phí giao hàng:</span>
                    <span>30.000đ</span>
                </div>
                <div class="summary-total">
                    <span>Tổng thanh toán:</span>
                    <span class="order-total-price">
                        <?php echo number_format($order['total'], 0, ',', '.'); ?>đ
                    </span>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include('includes/footer.php'); ?>