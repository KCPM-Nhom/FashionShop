<?php
session_start();
include('../config/database.php');

// --- XỬ LÝ THÊM SẢN PHẨM ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $ten_sp = mysqli_real_escape_string($conn, $_POST['ten_sp']);
    $gia = (int)$_POST['gia'];
    $gia_cu = (int)$_POST['gia_cu'];

    $hinh_anh = '';
    if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] == 0) {
        $hinh_anh = time() . '_' . $_FILES['hinh_anh']['name'];
        $target_dir = "../assets/images/";
        move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_dir . $hinh_anh);
    }

    $sql_insert = "INSERT INTO products (ten_sp, gia, gia_cu, hinh_anh) VALUES ('$ten_sp', $gia, $gia_cu, '$hinh_anh')";
    if (mysqli_query($conn, $sql_insert)) {
        $msg = "Thêm sản phẩm thành công!";
    } else {
        $err = "Lỗi: " . mysqli_error($conn);
    }
}

// --- XỬ LÝ XÓA SẢN PHẨM ---
if (isset($_GET['delete_id'])) {
    $del_id = (int)$_GET['delete_id'];
    $sql_del = "DELETE FROM products WHERE id = $del_id";
    if (mysqli_query($conn, $sql_del)) {
        header("Location: products.php");
        exit();
    }
}

// --- XỬ LÝ TÌM KIẾM SẢN PHẨM ---
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_query = mysqli_real_escape_string($conn, $search);

if ($search != '') {
    $sql_products = "SELECT * FROM products WHERE ten_sp LIKE '%$search_query%' ORDER BY id DESC";
} else {
    $sql_products = "SELECT * FROM products ORDER BY id DESC";
}
$result_products = mysqli_query($conn, $sql_products);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản Lý Sản Phẩm - FashionShop</title>
    <link rel="stylesheet" href="../assets/css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="admin-wrapper">
        <?php include('sidebar.php'); ?>

        <main class="main-content">
            <header>
                <h1>Danh Sách Sản Phẩm</h1>
                <button onclick="document.getElementById('addForm').style.display='block'" class="btn-edit green" style="color: white; border: none; cursor: pointer;">
                    <i class="fa fa-plus"></i> Thêm sản phẩm
                </button>
            </header>

            <div id="addForm" class="form-add">
                <h2>Thêm Sản Phẩm Mới</h2>
                <form action="products.php" method="POST" enctype="multipart/form-data">
                    <input type="text" name="ten_sp" placeholder="Tên sản phẩm" required>
                    <div style="display: flex; gap: 10px;">
                        <input type="number" name="gia" placeholder="Giá bán (VNĐ)" required>
                        <input type="number" name="gia_cu" placeholder="Giá cũ">
                    </div>
                    <label>Hình ảnh sản phẩm:</label>
                    <input type="file" name="hinh_anh" accept="image/*" required>
                    <div>
                        <button type="submit" name="add_product" class="btn-edit blue" style="color: white; border: none; cursor: pointer; padding: 10px 20px;">Lưu</button>
                        <button type="button" onclick="document.getElementById('addForm').style.display='none'" class="btn-edit red" style="color: white; border: none; cursor: pointer; padding: 10px 20px;">Hủy</button>
                    </div>
                </form>
            </div>

            <?php if (isset($msg)) echo "<p style='color: #2ecc71; font-weight: bold; margin-bottom: 15px;'>$msg</p>"; ?>
            <?php if (isset($err)) echo "<p style='color: #C05F5F; font-weight: bold; margin-bottom: 15px;'>$err</p>"; ?>

            <section class="recent-orders">
                <div class="section-header flex-wrap">
                    <h2>Tất cả sản phẩm</h2>

                    <form action="products.php" method="GET" class="search-bar">
                        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Nhập tên sản phẩm...">
                        <button type="submit" class="btn-edit blue" style="color: white; border: none; cursor: pointer; padding: 10px 15px;">
                            <i class="fa fa-search"></i> Tìm
                        </button>
                        <?php if ($search != ''): ?>
                            <a href="products.php" class="btn-edit red" style="color: white; text-decoration: none; padding: 10px 15px; display: inline-block;">
                                <i class="fa fa-times"></i> Hủy lọc
                            </a>
                        <?php endif; ?>
                    </form>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá bán</th>
                            <th>Giá cũ</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result_products && mysqli_num_rows($result_products) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result_products)): ?>
                                <tr>
                                    <td>#<?php echo $row['id']; ?></td>
                                    <td>
                                        <img src="../assets/images/<?php echo htmlspecialchars($row['hinh_anh']); ?>" width="60" style="border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                    </td>
                                    <td><strong><?php echo htmlspecialchars($row['ten_sp']); ?></strong></td>
                                    <td style="color: #e74c3c; font-weight: bold;">
                                        <?php echo number_format($row['gia'], 0, ',', '.'); ?>đ
                                    </td>
                                    <td style="text-decoration: line-through; color: #999;">
                                        <?php echo !empty($row['gia_cu']) ? number_format($row['gia_cu'], 0, ',', '.') . 'đ' : ''; ?>
                                    </td>
                                    <td>
                                        <a href="products.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">
                                            <button class="btn-edit red" style="color: white; border: none; cursor: pointer;">
                                                <i class="fa fa-trash"></i> Xóa
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 30px; color: #888;">
                                    <?php echo ($search != '') ? 'Không tìm thấy sản phẩm nào phù hợp với từ khóa.' : 'Chưa có sản phẩm nào trong kho.'; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>

</html>