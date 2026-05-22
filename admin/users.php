<?php
session_start();
include('../config/database.php');

// --- XỬ LÝ XÓA KHÁCH HÀNG ---
if (isset($_GET['delete_id'])) {
    $del_id = (int)$_GET['delete_id'];
    $sql_del = "DELETE FROM user WHERE id = $del_id";
    if (mysqli_query($conn, $sql_del)) {
        header("Location: users.php");
        exit();
    } else {
        $err = "Không thể xóa khách hàng này (Có thể do họ có dữ liệu liên quan).";
    }
}

// --- XỬ LÝ TÌM KIẾM KHÁCH HÀNG ---
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_query = mysqli_real_escape_string($conn, $search);

if ($search != '') {
    $sql_users = "SELECT * FROM user WHERE fullname LIKE '%$search_query%' OR email LIKE '%$search_query%' OR phone LIKE '%$search_query%' ORDER BY id DESC";
} else {
    $sql_users = "SELECT * FROM user ORDER BY id DESC";
}
$result_users = mysqli_query($conn, $sql_users);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản Lý Khách Hàng - FashionShop</title>
    <link rel="stylesheet" href="../assets/css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="admin-wrapper">
        <?php include('sidebar.php'); ?>

        <main class="main-content">
            <header>
                <h1>Quản Lý Khách Hàng</h1>
                <div class="admin-info">Chào, Admin <i class="fa fa-user-circle"></i></div>
            </header>

            <?php if (isset($err)) echo "<p style='color: white; background: #C05F5F; padding: 15px; border-radius: 8px;'>$err</p>"; ?>

            <section class="recent-orders">
                <div class="section-header flex-wrap">
                    <h2>Danh sách thành viên</h2>
                    <form action="users.php" method="GET" class="search-bar">
                        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Tìm tên, email, SĐT...">
                        <button type="submit" class="btn-edit blue" style="color: white; border: none; cursor: pointer; padding: 10px 15px;">
                            <i class="fa fa-search"></i> Tìm
                        </button>
                        <?php if ($search != ''): ?>
                            <a href="users.php" class="btn-edit red" style="color: white; text-decoration: none; padding: 10px 15px; display: inline-block;"><i class="fa fa-times"></i></a>
                        <?php endif; ?>
                    </form>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Họ và Tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Giới tính</th>
                            <th>Ngày đăng ký</th>
                            <th style="text-align: center;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result_users && mysqli_num_rows($result_users) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result_users)): ?>
                                <tr>
                                    <td>#<?php echo $row['id']; ?></td>
                                    <td><strong><?php echo htmlspecialchars($row['fullname']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                    <td><?php echo htmlspecialchars($row['gender']); ?></td>
                                    <td>
                                        <?php echo date("d/m/Y H:i", strtotime($row['created_at'])); ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="users.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?');">
                                            <button class="btn-edit red" style="color: white; border: none; padding: 8px 15px; cursor: pointer;">
                                                <i class="fa fa-trash"></i> Xóa
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 30px; color: #888;">Không tìm thấy kết quả.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>

</html>