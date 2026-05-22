<?php
session_start();
include('../config/database.php');

// --- XỬ LÝ XÓA ĐÁNH GIÁ ---
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $sql_delete = "DELETE FROM reviews WHERE id = $delete_id";

    if (mysqli_query($conn, $sql_delete)) {
        echo "<script>alert('Đã xóa đánh giá thành công!'); window.location.href='reviews.php';</script>";
        exit();
    } else {
        echo "<script>alert('Lỗi khi xóa: " . mysqli_error($conn) . "');</script>";
    }
}

// --- XỬ LÝ KHI ADMIN BẤM LƯU PHẢN HỒI ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['review_id'])) {
    $review_id = (int)$_POST['review_id'];
    $shop_reply = mysqli_real_escape_string($conn, $_POST['shop_reply']);

    // Thêm dòng này để kiểm tra xem nó có chạy vào đây không
    $sql_update = "UPDATE reviews SET shop_reply = '$shop_reply' WHERE id = $review_id";

    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Đã lưu phản hồi thành công!'); window.location.href='reviews.php';</script>";
    } else {
        // Nếu hiện lỗi "Unknown column", bạn phải đổi 'shop_reply' thành tên cột đúng trong DB
        die("Lỗi SQL: " . mysqli_error($conn));
    }
}

// --- LẤY DANH SÁCH ĐÁNH GIÁ ---
// Join với bảng user để lấy tên, join với products để lấy tên sản phẩm
$sql_reviews = "SELECT r.*, u.fullname, p.ten_sp 
                FROM reviews r 
                LEFT JOIN user u ON r.user_id = u.id 
                LEFT JOIN products p ON r.product_id = p.id 
                ORDER BY r.created_at DESC";
$result_reviews = mysqli_query($conn, $sql_reviews);
?>



<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản Lý Đánh Giá - FashionShop</title>
    <link rel="stylesheet" href="../assets/css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="admin-wrapper">
        <?php include('sidebar.php'); ?>

        <main class="main-content">
            <header>
                <h1>Quản Lý Đánh Giá</h1>
                <div class="admin-info">Chào, Admin <i class="fa fa-user-circle"></i></div>
            </header>

            <section class="recent-orders">
                <div class="section-header">
                    <h2>Đánh giá từ khách hàng</h2>
                </div>

                <?php if (isset($msg)) echo "<p style='color: #2ecc71; font-weight: bold; margin-bottom: 15px;'>$msg</p>"; ?>
                <?php if (isset($err)) echo "<p style='color: #C05F5F; font-weight: bold; margin-bottom: 15px;'>$err</p>"; ?>

                <table>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Khách hàng</th>
                            <th>Đánh giá</th>
                            <th>Phản hồi của Shop</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result_reviews && mysqli_num_rows($result_reviews) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result_reviews)): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($row['ten_sp'] ?? 'Sản phẩm đã xóa'); ?></strong></td>
                                    <td>
                                        <?php echo htmlspecialchars($row['fullname'] ?? 'Khách ẩn danh'); ?><br>
                                        <small style="color: #888;"><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></small>
                                    </td>
                                    <td style="max-width: 250px;">
                                        <div style="color: #ffcc00; margin-bottom: 5px;"><?php echo str_repeat('⭐', $row['rating']); ?></div>
                                        <p style="margin: 0; font-size: 14px; line-height: 1.4; color: #444;"><?php echo htmlspecialchars($row['comment']); ?></p>
                                    </td>
                                    <td style="width: 300px;">
                                        <form action="" method="POST" style="display: flex; flex-direction: column; gap: 5px;">
                                            <input type="hidden" name="review_id" value="<?php echo $row['id']; ?>">
                                            <textarea name="shop_reply" rows="3" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit;" placeholder="Nhập câu trả lời..."><?php echo htmlspecialchars($row['shop_reply']); ?></textarea>
                                            <button type="submit" class="btn-edit green" style="color: white; border: none; align-self: flex-start; cursor: pointer;">
                                                <i class="fa fa-reply"></i> Lưu phản hồi
                                            </button>
                                        </form>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="reviews.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này không? Hành động này không thể hoàn tác!');">
                                            <button type="button" class="btn-edit red" style="color: white; border: none; cursor: pointer;">
                                                <i class="fa fa-trash"></i> Xóa
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: #888; padding: 30px;">Chưa có đánh giá nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>

</html>