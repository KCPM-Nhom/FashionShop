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
    echo "<script>alert('Vui lòng đăng nhập để xem lịch sử đơn hàng!'); window.location.href='login.php';</script>";
    exit();
}

// LẤY DANH SÁCH TỔNG QUAN ĐƠN HÀNG
$sql_orders = "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY created_at DESC";
$result_orders = mysqli_query($conn, $sql_orders);
?>

<title>Lịch Sử Đơn Hàng - FASHIONSTORE</title>
<?php include('includes/header.php'); ?>

<link rel="stylesheet" href="assets/css/global.css">
<link rel="stylesheet" href="assets/css/order.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">



<main>
    <h2 class="section-title" style="text-align: center; margin-top: 40px; color: #000;">LỊCH SỬ ĐƠN HÀNG</h2>
    <div class="section-line" style="width: 80px; height: 3px; background: #000; margin: 10px auto 40px auto;"></div>

    <div class="orders-container">
        <?php if (mysqli_num_rows($result_orders) > 0): ?>
            <?php while ($order = mysqli_fetch_assoc($result_orders)): ?>
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <span class="order-id">Đơn hàng #<?php echo $order['id']; ?></span>
                            <span class="order-date"> | Đặt lúc: <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></span>
                        </div>

                        <?php
                        $statusClass = 'status-cho-xu-ly';
                        if ($order['status'] == 'Đang giao') $statusClass = 'status-dang-giao';
                        if ($order['status'] == 'Đã giao' || $order['status'] == 'Hoàn thành') $statusClass = 'status-hoan-thanh';
                        if ($order['status'] == 'Đã hủy') $statusClass = 'status-da-huy';
                        ?>
                        <div class="order-status <?php echo $statusClass; ?>">
                            <?php echo $order['status']; ?>
                        </div>
                    </div>

                    <div class="order-body">
                        <?php
                        $order_id = $order['id'];
                        $sql_detail = "SELECT od.*, p.ten_sp, p.hinh_anh 
                                           FROM order_details od 
                                           JOIN products p ON od.product_id = p.id 
                                           WHERE od.order_id = '$order_id'";
                        $result_detail = mysqli_query($conn, $sql_detail);

                        // Đã thêm if($result_detail) để chặn lỗi Fatal Error như trong ảnh của bạn
                        if ($result_detail && mysqli_num_rows($result_detail) > 0):
                            while ($item = mysqli_fetch_assoc($result_detail)):
                        ?>
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
                        <?php
                            endwhile;
                        else:
                            echo "<p style='color: red; padding: 10px;'>Không tải được sản phẩm (Có thể do lỗi truy vấn SQL).</p>";
                        endif;
                        ?>
                    </div>
                    <div class="order-footer" style="display: flex; justify-content: space-between; align-items: center; padding: 20px; border-top: 1px solid #eee;">
                        <div>
                            <a href="order_details.php?id=<?php echo $order['id']; ?>" class="btn-view-detail">Xem chi tiết</a>
                        </div>
                        <div class="order-total-price">
                            <span style="font-size: 14px; color: #666; font-weight: normal;">Thành tiền:</span>
                            <span style="color: #d0011b; font-size: 18px;"><?php echo number_format($order['total'], 0, ',', '.'); ?>đ</span>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="empty-order">
                <img src="assets/images/empty-cart.png" alt="Trống" style="width: 150px; opacity: 0.5; margin-bottom: 20px; display:inline-block;" onerror="this.style.display='none'">
                <h3>Bạn chưa có đơn hàng nào!</h3>
                <p style="margin-top: 10px;">Hãy tiếp tục mua sắm để lấp đầy lịch sử đơn hàng nhé.</p>
                <a href="index.php" class="btn-view-detail" style="margin-top: 20px;">MUA SẮM NGAY</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include('includes/footer.php'); ?>