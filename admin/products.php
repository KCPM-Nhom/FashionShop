<?php
session_start();
include('../config/database.php');

// --- XỬ LÝ THÊM SẢN PHẨM ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $ten_sp = mysqli_real_escape_string($conn, $_POST['ten_sp']);
    $gia = (int)$_POST['gia'];
    $gia_cu = (int)$_POST['gia_cu'];
    
    // Lấy các trường dữ liệu bổ sung
    $so_luong = isset($_POST['so_luong']) ? (int)$_POST['so_luong'] : 0; 
    $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 1;
    $gioi_tinh = isset($_POST['gioi_tinh']) ? (int)$_POST['gioi_tinh'] : 1;
    $mo_ta = isset($_POST['mo_ta']) ? mysqli_real_escape_string($conn, $_POST['mo_ta']) : '';

    $hinh_anh = '';
    if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] == 0) {
        $hinh_anh = time() . '_' . $_FILES['hinh_anh']['name'];
        $target_dir = "../assets/images/";
        // Đảm bảo thư mục tồn tại (tránh lỗi trên Postman)
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        move_uploaded_file($_FILES['hinh_anh']['tmp_name'], $target_dir . $hinh_anh);
    }

    // Câu lệnh INSERT đầy đủ vào Database
    $sql_insert = "INSERT INTO products (ten_sp, gia, gia_cu, mo_ta, so_luong, gioi_tinh, category_id, hinh_anh) 
                   VALUES ('$ten_sp', $gia, $gia_cu, '$mo_ta', $so_luong, $gioi_tinh, $category_id, '$hinh_anh')";
                   
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
                        <input type="number" name="so_luong" placeholder="Số lượng kho" required>
                    </div>

                    <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                        <select name="category_id" required style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                            <option value="">-- Chọn danh mục --</option>
                            <option value="1">Áo khoác</option>
                            <option value="2">Áo sơ mi</option>
                            <option value="3">Áo polo</option>
                            <option value="4">Quần tây</option>
                            <option value="5">Quần short</option>
                            <option value="6">Quần jean</option>
                            <option value="7">Quần kaki</option>
                        </select>

                        <select name="gioi_tinh" required style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                            <option value="">-- Chọn giới tính --</option>
                            <option value="1">Nam</option>
                            <option value="0">Nữ</option>
                        </select>
                    </div>

                    <textarea name="mo_ta" placeholder="Mô tả sản phẩm" required></textarea>
                    
                    <label style="font-weight: bold; display: block; margin-bottom: 5px;">Hình ảnh sản phẩm:</label>
                    <input type="file" name="hinh_anh" accept="image/*" required style="margin-bottom: 15px;">
                    
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
                        <button type="submit" class="btn-edit blue" style="color: white; border: none; cursor: pointer; padding: 10px 15px;"><i class="fa fa-search"></i> Tìm</button>
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
                                    <td><img src="../assets/images/<?php echo htmlspecialchars($row['hinh_anh']); ?>" width="60" style="border-radius: 5px;"></td>
                                    <td><strong><?php echo htmlspecialchars($row['ten_sp']); ?></strong></td>
                                    <td style="color: #e74c3c; font-weight: bold;"><?php echo number_format($row['gia'], 0, ',', '.'); ?>đ</td>
                                    <td style="text-decoration: line-through; color: #999;"><?php echo !empty($row['gia_cu']) ? number_format($row['gia_cu'], 0, ',', '.') . 'đ' : ''; ?></td>
                                    <td>
                                        <a href="products.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Xóa sản phẩm này?');">
                                            <button class="btn-edit red" style="color: white; border: none; cursor: pointer;"><i class="fa fa-trash"></i> Xóa</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="6" style="text-align: center;">Chưa có sản phẩm nào.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <script>
        document.querySelector('input[name="ten_sp"]').addEventListener('input', function(e) {
            let tenSp = e.target.value.toLowerCase();
            let gioiTinhSelect = document.querySelector('select[name="gioi_tinh"]');
            
            if (tenSp.includes('nữ') || tenSp.includes('nu ')) {
                gioiTinhSelect.value = '0'; // 0 là Nữ
            } else if (tenSp.includes('nam')) {
                gioiTinhSelect.value = '1'; // 1 là Nam
            }
        });
    </script>
</body>
</html>