<?php
session_start();
include('../config/database.php');

// Kiểm tra ID đơn hàng
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: orders.php");
    exit();
}

$order_id = (int)$_GET['id'];

// Xử lý cập nhật trạng thái đơn hàng
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    $sql_update = "UPDATE orders SET status = '$new_status' WHERE id = $order_id";
    if (mysqli_query($conn, $sql_update)) {
        $msg = "Cập nhật trạng thái đơn hàng thành công!";
    } else {
        $err = "Lỗi cập nhật: " . mysqli_error($conn);
    }
}

// Lấy thông tin chung của đơn hàng
$sql_order = "SELECT * FROM orders WHERE id = $order_id";
$res_order = mysqli_query($conn, $sql_order);
$order = mysqli_fetch_assoc($res_order);

if (!$order) {
    die("Đơn hàng không tồn tại!");
}

$sql_items = "
    SELECT 
        od.price, 
        od.quantity, 
        (od.quantity * od.price) AS total_money, 
        od.product_id, 
        od.size, 
        p.ten_sp AS product_name, 
        p.hinh_anh 
    FROM order_details od 
    LEFT JOIN products p ON od.product_id = p.id 
    WHERE od.order_id = $order_id
";
$res_items = mysqli_query($conn, $sql_items);

if (!$res_items) {
    echo "<div style='color:red; padding: 20px;'>Lỗi truy vấn SQL: " . mysqli_error($conn) . "</div>";
}

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
    <title>Chi tiết đơn hàng #<?php echo $order_id; ?></title>
    <link rel="stylesheet" href="../assets/css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="admin-wrapper">
        <?php include('sidebar.php'); ?>

        <main class="main-content">
            <header>
                <h1>Chi tiết đơn hàng #<?php echo $order_id; ?></h1>
                <a href="orders.php" class="btn-edit" style="background: #7499B4; color: white; text-decoration: none;"><i class="fa fa-arrow-left"></i> Quay lại</a>
            </header>

            <?php if (isset($msg)) echo "<p style='color: #155724; background: #d4edda; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold;'>$msg</p>"; ?>
            <?php if (isset($err)) echo "<p style='color: #721c24; background: #f8d7da; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold;'>$err</p>"; ?>

            <div class="detail-grid">
                <div class="info-card">
                    <h3><i class="fa fa-user"></i> Thông tin khách hàng</h3>
                    <div class="info-line"><strong>Họ tên:</strong> <?php echo htmlspecialchars($order['fullname'] ?? 'Không có'); ?></div>
                    <div class="info-line"><strong>Điện thoại:</strong> <?php echo htmlspecialchars($order['phone_number'] ?? 'Không có'); ?></div>
                    <div class="info-line"><strong>Email:</strong> <?php echo htmlspecialchars($order['email'] ?? 'Không có'); ?></div>
                    <div class="info-line"><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['address'] ?? 'Không có'); ?></div>
                </div>

                <div class="info-card">
                    <h3><i class="fa fa-file-invoice"></i> Trạng thái đơn hàng</h3>
                    <div class="info-line"><strong>Ngày đặt:</strong> <?php echo date("d/m/Y H:i", strtotime($order['created_at'])); ?></div>
                    <div class="info-line"><strong>Tổng tiền:</strong> <span style="color: #e74c3c; font-weight: bold; font-size: 18px;"><?php echo number_format($order['total'], 0, ',', '.'); ?>đ</span></div>
                    <div class="info-line"><strong>Trạng thái:</strong> <?php echo getStatusBadge($order['status']); ?></div>

                    <form action="" method="POST" style="margin-top: 20px; padding-top: 15px; border-top: 1px dashed #ddd;">
                        <label style="font-weight: bold; display: block; margin-bottom: 10px;">Thay đổi trạng thái:</label>
                        <?php
                        // Chuẩn hóa trạng thái từ Database để so sánh
                        $current_status = strtolower(trim($order['status']));
                        ?>

                        <select name="status" class="status-select" style="width: 100%; padding: 10px; margin-bottom: 10px;">
                            <!-- <option value="Chờ xử lý" <?php echo ($current_status == 'Chờ xử lý' || $current_status == 'pending' || $current_status == '') ? 'selected' : ''; ?>>Chờ xử lý</option> -->
                            <option value="Đang giao" <?php echo ($current_status == 'Đang giao' || $current_status == 'shipping') ? 'selected' : ''; ?>>Đang giao</option>
                            <option value="Hoàn thành" <?php echo ($current_status == 'Hoàn thành' || $current_status == 'completed') ? 'selected' : ''; ?>>Hoàn thành</option>
                            <option value="Đã hủy" <?php echo ($current_status == 'Đã hủy' || $current_status == 'cancelled') ? 'selected' : ''; ?>>Đã hủy</option>
                        </select>
                        <button type="submit" name="update_status" class="btn-edit blue" style="width: 100%; border: none; cursor: pointer; padding: 10px;">Cập nhật đơn hàng</button>
                    </form>
                </div>
            </div>

            <section class="recent-orders">
                <div class="section-header">
                    <h2>Sản phẩm trong đơn hàng</h2>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá bán</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($res_items && mysqli_num_rows($res_items) > 0): ?>
                            <?php while ($item = mysqli_fetch_assoc($res_items)): ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($item['hinh_anh'])): ?>
                                            <img src="../assets/images/<?php echo htmlspecialchars($item['hinh_anh']); ?>" class="product-img" alt="Ảnh SP" style="width: 60px; border-radius: 5px;">
                                        <?php else: ?>
                                            <span style="display:inline-block; width:50px; height:50px; background:#eee; border-radius:5px; text-align:center; line-height:50px; font-size:10px; color:#999;">Trống</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong>
                                            <?php echo htmlspecialchars($item['product_name'] ?? 'Sản phẩm đã bị xóa (Mã: ' . $item['product_id'] . ')'); ?>
                                        </strong>
                                        <div style="color: #666; font-size: 13px; margin-top: 5px;">Size: <b><?php echo htmlspecialchars($item['size'] ?? 'Không có'); ?></b></div>
                                    </td>
                                    <td><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</td>

                                    <td><?php echo $item['quantity']; ?></td>

                                    <td style="font-weight: bold; color: #e74c3c;">
                                        <?php echo number_format($item['total_money'], 0, ',', '.'); ?>đ
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 20px;">Không có dữ liệu sản phẩm chi tiết.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>

</html>