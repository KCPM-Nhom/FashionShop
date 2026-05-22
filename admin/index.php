<?php
session_start();
include('../config/database.php');

// --- XỬ LÝ CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG NGAY TẠI TRANG CHỦ ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $order_id = (int)$_POST['order_id'];
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);

    $sql_update = "UPDATE orders SET status = '$new_status' WHERE id = $order_id";
    if (mysqli_query($conn, $sql_update)) {
        $msg = "Cập nhật đơn hàng #$order_id thành công!";
    } else {
        $err = "Lỗi: " . mysqli_error($conn);
    }
}

// --- LẤY SỐ LIỆU THỐNG KÊ (DỮ LIỆU THẬT TỪ DATABASE) ---
// Tổng doanh thu (Chỉ tính các đơn đã 'completed', sử dụng cột 'total' chuẩn theo DB của bạn)
$sql_revenue = "SELECT SUM(total) as revenue FROM orders WHERE status = 'Hoàn thành'";
$res_revenue = mysqli_query($conn, $sql_revenue);
if ($res_revenue) {
    $row_revenue = mysqli_fetch_assoc($res_revenue);
    $total_revenue = $row_revenue['revenue'] ?? 0;
} else {
    $total_revenue = 0;
}

// Tổng số đơn hàng
$sql_total_orders = "SELECT COUNT(id) as count_orders FROM orders";
$res_total_orders = mysqli_query($conn, $sql_total_orders);
$row_total_orders = mysqli_fetch_assoc($res_total_orders);
$total_orders_count = $row_total_orders['count_orders'] ?? 0;

// Tổng số khách hàng
$sql_total_users = "SELECT COUNT(id) as count_users FROM user";
$res_total_users = mysqli_query($conn, $sql_total_users);
$row_total_users = mysqli_fetch_assoc($res_total_users);
$total_users_count = $row_total_users['count_users'] ?? 0;

// --- LẤY 5 ĐƠN HÀNG MỚI NHẤT ---
// Do bảng orders của bạn đã có sẵn cột fullname, không cần dùng LEFT JOIN nữa.
$sql_recent_orders = "SELECT * FROM orders ORDER BY id DESC LIMIT 7";
$result_recent_orders = mysqli_query($conn, $sql_recent_orders);

// Hàm hiển thị Badge Trạng thái
function getStatusBadge($status)
{
    switch ($status) {
        case 'Đang giao':
            return '<span class="status" style="background:#cce5ff; color:#004085; padding:5px 10px; border-radius:5px; font-weight:bold;">Đang giao</span>';
        case 'Hoàn thành':
            return '<span class="status" style="background:#d4edda; color:#155724; padding:5px 10px; border-radius:5px; font-weight:bold;">Hoàn thành</span>';
        case 'Đã hủy':
            return '<span class="status" style="background:#f8d7da; color:#721c24; padding:5px 10px; border-radius:5px; font-weight:bold;">Đã hủy</span>';
        default:
            return '<span class="status pending" style="background:#fff3cd; color:#856404; padding:5px 10px; border-radius:5px; font-weight:bold;">Chờ xử lý</span>';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản Trị Hệ Thống - FashionShop</title>
    <link rel="stylesheet" href="../assets/css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>

    </style>
</head>

<body>
    <div class="admin-wrapper">
        <?php include('sidebar.php'); ?>

        <main class="main-content">
            <header>
                <h1>Bảng Điều Khiển</h1>
                <div class="admin-info">Chào, Admin <i class="fa fa-user-circle" style="font-size: 24px; margin-left: 10px; color: #7499B4;"></i></div>
            </header>

            <?php if (isset($msg)) echo "<p style='color: #155724; background: #d4edda; padding: 15px; border-radius: 8px; font-weight: bold; margin-bottom: 20px;'>$msg</p>"; ?>
            <?php if (isset($err)) echo "<p style='color: #721c24; background: #f8d7da; padding: 15px; border-radius: 8px; font-weight: bold; margin-bottom: 20px;'>$err</p>"; ?>

            <section class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fa fa-wallet"></i>
                    </div>
                    <div class="stat-data">
                        <h3><?php echo number_format($total_revenue, 0, ',', '.'); ?>đ</h3>
                        <p>Doanh thu</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon yellow">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="stat-data">
                        <h3><?php echo $total_orders_count; ?></h3>
                        <p>Đơn hàng</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="stat-data">
                        <h3><?php echo $total_users_count; ?></h3>
                        <p>Thành viên</p>
                    </div>
                </div>
            </section>

            <section class="recent-orders" style="margin-top: 30px;">
                <div class="section-header">
                    <h2>Đơn hàng mới nhất (7 đơn gần đây)</h2>
                    <a href="orders.php" class="view-all" style="font-weight: bold;">Xem tất cả <i class="fa fa-arrow-right"></i></a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result_recent_orders && mysqli_num_rows($result_recent_orders) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result_recent_orders)): ?>
                                <tr>
                                    <td><strong>#<?php echo $row['id']; ?></strong></td>
                                    <td><?php echo htmlspecialchars($row['fullname'] ?? 'Khách vãng lai'); ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($row['created_at'])); ?></td>

                                    <td style="color: #e74c3c; font-weight: bold;">
                                        <?php echo number_format($row['total'] ?? 0, 0, ',', '.'); ?>đ
                                    </td>

                                    <td>
                                        <?php echo getStatusBadge($row['status'] ?? 'pending'); ?>
                                    </td>
                                    <td>
                                        <form action="index.php" method="POST" style="display: flex; gap: 5px; align-items: center; margin: 0;">
                                            <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                                            <?php
                                            // Chuẩn hóa trạng thái từ Database để so sánh
                                            $current_status = strtolower(trim($row['status']));
                                            ?>
                                            <select name="status" class="status-select">
                                                <!-- <option value="Chờ xử lý" <?php echo ($current_status == 'Chờ xử lý' || $current_status == 'pending' || $current_status == '') ? 'selected' : ''; ?>>Chờ xử lý</option> -->
                                                <option value="Đang giao" <?php echo ($current_status == 'Đang giao' || $current_status == 'shipping') ? 'selected' : ''; ?>>Đang giao</option>
                                                <option value="Hoàn thành" <?php echo ($current_status == 'Hoàn thành' || $current_status == 'completed') ? 'selected' : ''; ?>>Hoàn thành</option>
                                                <option value="Đã hủy" <?php echo ($current_status == 'Đã hủy' || $current_status == 'cancelled') ? 'selected' : ''; ?>>Đã hủy</option>
                                            </select>
                                            <button type="submit" name="update_status" class="btn-edit blue" style="border: none; padding: 6px 12px; cursor: pointer;">Lưu</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 30px; color: #888;">Chưa có đơn hàng nào mới.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>

</html>