<?php
session_start();
include('../config/database.php');

// --- XỬ LÝ CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $order_id = (int)$_POST['order_id'];
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);

    // Cập nhật trạng thái vào Database
    $sql_update = "UPDATE orders SET status = '$new_status' WHERE id = $order_id";

    if (mysqli_query($conn, $sql_update)) {
        $msg = "Cập nhật trạng thái đơn hàng #$order_id thành công!";
    } else {
        $err = "Lỗi cập nhật: " . mysqli_error($conn);
    }
}

// --- LẤY DANH SÁCH TẤT CẢ ĐƠN HÀNG TỪ DATABASE ---
// Gọi trực tiếp từ bảng orders (vì đã có sẵn fullname và total)
$sql_orders = "SELECT * FROM orders ORDER BY id DESC";
$result_orders = mysqli_query($conn, $sql_orders);

// --- LẤY DANH SÁCH ĐƠN HÀNG (CÓ KÈM BỘ LỌC TRẠNG THÁI) ---
$status_filter = isset($_GET['filter_status']) ? $_GET['filter_status'] : 'all';

$where_clause = "";
if ($status_filter != 'all') {
    $safe_status = mysqli_real_escape_string($conn, $status_filter);
    $where_clause = " WHERE status = '$safe_status'";
}

// Lấy dữ liệu từ bảng orders có điều kiện lọc
$sql_orders = "SELECT * FROM orders $where_clause ORDER BY id DESC";
$result_orders = mysqli_query($conn, $sql_orders);

// Hàm hỗ trợ hiển thị màu sắc trạng thái đồng bộ với index.php
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
    <title>Quản Lý Đơn Hàng - FashionShop</title>
    <link rel="stylesheet" href="../assets/css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .action-flex {
            display: flex;
            gap: 10px;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="admin-wrapper">
        <?php include('sidebar.php'); ?>

        <main class="main-content">
            <header>
                <h1>Quản Lý Đơn Hàng</h1>

                <form action="orders.php" method="GET" style="display: flex; gap: 10px; align-items: center;">
                    <select name="filter_status" style="padding: 8px; border-radius: 5px; border: 1px solid #ddd; outline: none;">
                        <option value="all">Tất cả trạng thái</option>
                        <option value="Chờ xử lý" <?php if (isset($_GET['filter_status']) && $_GET['filter_status'] == 'Chờ xử lý') echo 'selected'; ?>>Chờ xử lý</option>
                        <option value="Đang giao" <?php if (isset($_GET['filter_status']) && $_GET['filter_status'] == 'Đang giao') echo 'selected'; ?>>Đang giao</option>
                        <option value="Hoàn thành" <?php if (isset($_GET['filter_status']) && $_GET['filter_status'] == 'Hoàn thành') echo 'selected'; ?>>Hoàn thành</option>
                        <option value="Đã hủy" <?php if (isset($_GET['filter_status']) && $_GET['filter_status'] == 'Đã hủy') echo 'selected'; ?>>Đã hủy</option>
                    </select>
                    <button type="submit" class="btn-edit blue" style="border: none; padding: 8px 15px; cursor: pointer; color: white; border-radius: 5px;">
                        <i class="fa fa-filter"></i> Lọc
                    </button>
                </form>
            </header>

            <?php if (isset($msg)) echo "<p style='color: #155724; background: #d4edda; padding: 15px; border-radius: 8px; font-weight: bold; margin-bottom: 20px;'>$msg</p>"; ?>
            <?php if (isset($err)) echo "<p style='color: #721c24; background: #f8d7da; padding: 15px; border-radius: 8px; font-weight: bold; margin-bottom: 20px;'>$err</p>"; ?>

            <section class="recent-orders">
                <div class="section-header">
                    <h2>Tất cả đơn hàng</h2>
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
                        <?php if ($result_orders && mysqli_num_rows($result_orders) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result_orders)): ?>
                                <tr>
                                    <td><strong>#<?php echo $row['id']; ?></strong></td>
                                    <td><?php echo htmlspecialchars($row['fullname'] ?? 'Khách vãng lai'); ?></td>

                                    <td><?php echo date("d/m/Y H:i", strtotime($row['created_at'])); ?></td>

                                    <td style="color: #e74c3c; font-weight: bold;">
                                        <?php echo number_format($row['total'] ?? 0, 0, ',', '.'); ?>đ
                                    </td>

                                    <td>
                                        <?php echo getStatusBadge($row['status'] ?? 'Chờ xử lý'); ?>
                                    </td>

                                    <td>
                                        <div class="action-flex">
                                            <form action="orders.php" method="POST" style="margin: 0; display: flex; gap: 5px;">
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
                                                <button type="submit" name="update_status" class="btn-edit" style="border: none; padding: 6px 12px; cursor: pointer;">Lưu</button>
                                            </form>

                                            <a href="order_details.php?id=<?php echo $row['id']; ?>" class="btn-edit" style="text-decoration: none; background: #888888; padding: 6px 12px; color: white;">Chi tiết</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 30px; color: #888;">Chưa có đơn hàng nào trong hệ thống.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>

</html>