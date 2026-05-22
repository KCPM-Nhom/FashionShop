<?php
include('config/database.php');

// TÁCH BIỆT RÕ RÀNG: Gốc (trang chủ) và Lọc (nút bấm)
$id_dm = (isset($_GET['id']) && $_GET['id'] !== '') ? (int)$_GET['id'] : null;
$gioi_tinh = isset($_GET['gioi_tinh']) ? $_GET['gioi_tinh'] : null; // Biến Gốc (Căn phòng)
$loc_gt = isset($_GET['loc_gt']) ? $_GET['loc_gt'] : null;          // Biến Lọc (Nút bấm)
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'new';

// Đổi tiêu đề tự động nếu đi từ trang chủ vào
$ten_hien_thi = "SẢN PHẨM";
if ($id_dm === null) {
    if ($gioi_tinh === '1') $ten_hien_thi = "THỜI TRANG NAM";
    if ($gioi_tinh === '0') $ten_hien_thi = "THỜI TRANG NỮ";
}

$where_conditions = [];

// 1. Lọc theo Danh mục
if ($id_dm !== null) {
    $sql_dm = "SELECT ten_danh_muc FROM categories WHERE id = $id_dm";
    $res_dm = $conn->query($sql_dm);
    if ($res_dm->num_rows > 0) {
        $dm_data = $res_dm->fetch_assoc();
        $ten_hien_thi = $dm_data['ten_danh_muc'];
    }
    $where_conditions[] = "category_id = $id_dm";
}

// 2. KHÓA CHẶT "CĂN PHÒNG" (Giới tính gốc từ trang chủ)
if ($gioi_tinh !== null && $gioi_tinh !== '') {
    $where_conditions[] = "gioi_tinh = " . (int)$gioi_tinh;
}

// 3. ÁP DỤNG "NÚT BẤM" (Bộ lọc của khách)
if ($loc_gt !== null && $loc_gt !== '') {
    $where_conditions[] = "gioi_tinh = " . (int)$loc_gt;
}

$where_clause = count($where_conditions) > 0 ? "WHERE " . implode(" AND ", $where_conditions) : "";

// Sắp xếp
$order_clause = "ORDER BY id DESC";
if ($sort === 'asc') $order_clause = "ORDER BY gia ASC";
if ($sort === 'desc') $order_clause = "ORDER BY gia DESC";

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 8;
$offset = ($page - 1) * $limit;

$sql_count = "SELECT COUNT(id) as total FROM products $where_clause";
$res_count = $conn->query($sql_count);
$total_records = $res_count->fetch_assoc()['total'];
$total_pages = ceil($total_records / $limit);

$sql_sp = "SELECT * FROM products $where_clause $order_clause LIMIT $limit OFFSET $offset";
$result_sp = $conn->query($sql_sp);

// Lưu trạng thái chuyển trang
$url_params = "";
if ($id_dm !== null) $url_params .= "&id=$id_dm";
if ($gioi_tinh !== null && $gioi_tinh !== '') $url_params .= "&gioi_tinh=$gioi_tinh";
if ($loc_gt !== null && $loc_gt !== '') $url_params .= "&loc_gt=$loc_gt";
if (isset($_GET['sort'])) $url_params .= "&sort=" . $_GET['sort'];

$title = mb_strtoupper($ten_hien_thi, 'UTF-8') . " - FASHIONSTORE";
include('includes/header.php');
?>

<link rel="stylesheet" href="assets/css/global.css">

<main>
    <section class="category-page">
        <div class="dmn" style="text-align: center; margin-top: 30px;">
            <h1 class="section-title"><?php echo mb_strtoupper($ten_hien_thi, 'UTF-8'); ?></h1>
            <div style="width: 100px; height: 4px; background-color: #333; margin: 10px auto 40px auto; border-radius: 2px;"></div>
        </div>

        <div class="filter-bar">
            <div class="filter-group">
                <span class="filter-label">Dành cho:</span>
                <div class="gender-filter">
                    <?php
                    // XÂY DỰNG LINK CHUẨN MỚI
                    $query_parts = [];
                    if ($id_dm !== null) $query_parts[] = "id=$id_dm";
                    if ($gioi_tinh !== null && $gioi_tinh !== '') $query_parts[] = "gioi_tinh=$gioi_tinh"; // Giữ chặt phòng hiện tại
                    if (isset($_GET['sort']) && $_GET['sort'] !== 'new') $query_parts[] = "sort=" . $_GET['sort'];

                    $base_url = "category.php" . (count($query_parts) > 0 ? "?" . implode('&', $query_parts) : "");
                    $prefix = count($query_parts) > 0 ? "&" : "?";

                    $link_tatca = $base_url;
                    $link_nam = $base_url . $prefix . "loc_gt=1";
                    $link_nu = $base_url . $prefix . "loc_gt=0";

                    // Xử lý nút nào đang được sáng lên (Active)
                    $active_gt = isset($_GET['loc_gt']) ? $_GET['loc_gt'] : (isset($_GET['gioi_tinh']) ? $_GET['gioi_tinh'] : null);
                    ?>

                    <a href="<?php echo $link_tatca; ?>" class="<?php echo ($active_gt === null || $active_gt === '') ? 'active' : ''; ?>">Tất cả</a>
                    <a href="<?php echo $link_nam; ?>" class="<?php echo ($active_gt === '1') ? 'active' : ''; ?>">Nam</a>
                    <a href="<?php echo $link_nu; ?>" class="<?php echo ($active_gt === '0') ? 'active' : ''; ?>">Nữ</a>
                </div>
            </div>

            <div class="filter-group">
                <span class="filter-label">Sắp xếp:</span>
                <select class="sort-select" onchange="applySort(this.value)">
                    <option value="new" <?php if ($sort == 'new') echo 'selected'; ?>>Mới nhất</option>
                    <option value="asc" <?php if ($sort == 'asc') echo 'selected'; ?>>Giá: Thấp đến Cao</option>
                    <option value="desc" <?php if ($sort == 'desc') echo 'selected'; ?>>Giá: Cao đến Thấp</option>
                </select>
            </div>
        </div>

        <div class="pd">
            <?php
            if ($result_sp && $result_sp->num_rows > 0) {
                while ($row = $result_sp->fetch_assoc()) {
            ?>
                    <div class="sp">
                        <?php
                        if (!empty($row['gia_cu']) && $row['gia_cu'] > $row['gia']) {
                            $phan_tram_giam = round((($row['gia_cu'] - $row['gia']) / $row['gia_cu']) * 100);
                            echo '<div class="sale-badge">-' . $phan_tram_giam . '%</div>';
                        }
                        ?>
                        <a href="detail.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; color: inherit;">
                            <div class="pt">
                                <img src="assets/images/<?php echo $row['hinh_anh']; ?>" alt="<?php echo $row['ten_sp']; ?>">
                            </div>
                            <h3><?php echo $row['ten_sp']; ?></h3>
                            <div class="price-container">
                                <span class="price-new"><?php echo number_format($row['gia'], 0, ',', '.'); ?>đ</span>
                                <?php if ($row['gia_cu'] > $row['gia']): ?>
                                    <span class="price-old"><?php echo number_format($row['gia_cu'], 0, ',', '.'); ?>đ</span>
                                <?php endif; ?>
                            </div>
                            <div class="star">
                                <?php
                                $sp_id = $row['id'];
                                $sql_star = "SELECT AVG(rating) as avg_rating FROM reviews WHERE product_id = $sp_id";
                                $res_star = mysqli_query($conn, $sql_star);
                                $star_row = mysqli_fetch_assoc($res_star);
                                $diem_tb = round($star_row['avg_rating'] ?? 5);

                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $diem_tb) {
                                        echo '<i class="fa-solid fa-star" style="color: #FFD43B;"></i> ';
                                    } else {
                                        echo '<i class="fa-regular fa-star" style="color: #ccc;"></i> ';
                                    }
                                }
                                ?>
                            </div>
                        </a>

                        <form action="process/add_cart.php" method="POST" style="width: 100%; display: flex; flex-direction: column;">
                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="quantity" value="1">

                            <div class="size-mini">
                                <input type="radio" name="size" id="size-S-<?php echo $row['id']; ?>" value="S" required>
                                <label for="size-S-<?php echo $row['id']; ?>">S</label>

                                <input type="radio" name="size" id="size-M-<?php echo $row['id']; ?>" value="M" checked required>
                                <label for="size-M-<?php echo $row['id']; ?>">M</label>

                                <input type="radio" name="size" id="size-L-<?php echo $row['id']; ?>" value="L" required>
                                <label for="size-L-<?php echo $row['id']; ?>">L</label>

                                <input type="radio" name="size" id="size-XL-<?php echo $row['id']; ?>" value="XL" required>
                                <label for="size-XL-<?php echo $row['id']; ?>">XL</label>
                            </div>

                            <div class="hd" style="display: flex; gap: 5px;">
                                <button type="submit" name="add_to_cart" class="cart" style="flex: 1;">Thêm Giỏ</button>
                                <button type="submit" name="buy_now" class="buy" style="flex: 1;">Mua Ngay</button>
                            </div>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo "<p style='text-align:center; width: 100%; padding: 50px; color: #999;'>Rất tiếc, chưa có sản phẩm nào ở mục này.</p>";
            }
            ?>
        </div>

        <?php if ($total_pages > 1): ?>
            <div style="text-align: center; margin-top: 40px; margin-bottom: 30px;">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?><?php echo $url_params; ?>"
                        style="padding: 10px 15px; margin: 0 5px; border: 1px solid #7499B4; text-decoration: none; color: #7499B4; border-radius: 5px;">&laquo; Trước</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?><?php echo $url_params; ?>"
                        style="padding: 10px 15px; margin: 0 5px; border: 1px solid #7499B4; text-decoration: none; border-radius: 5px; 
                   <?php echo ($i == $page) ? 'background-color: #7499B4; color: white;' : 'color: #7499B4;'; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo $page + 1; ?><?php echo $url_params; ?>"
                        style="padding: 10px 15px; margin: 0 5px; border: 1px solid #7499B4; text-decoration: none; color: #7499B4; border-radius: 5px;">Sau &raquo;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </section>
</main>
<script src="assets/js/category.js"></script>

<?php include('includes/footer.php'); ?>