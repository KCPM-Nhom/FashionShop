<?php
if (session_status() == PHP_SESSION_NONE) {
    ob_start();
    session_start();
}
include('config/database.php');

// Lấy từ khóa và trang hiện tại
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Mặc định là trang 1
$limit = 8; // Số sản phẩm tối đa trên 1 trang (bạn có thể tăng lên 12 hoặc 16 tùy ý)
$offset = ($page - 1) * $limit; // Tính toán vị trí bắt đầu lấy trong Database

$searchResults = [];
$total_pages = 0; // Biến lưu tổng số trang

if ($keyword !== '') {
    $searchTerm = "%" . $keyword . "%";

    // 1. Đếm TỔNG SỐ sản phẩm tìm được trước
    $sql_count = "SELECT COUNT(id) as total FROM products WHERE ten_sp LIKE ?";
    $stmt_count = $conn->prepare($sql_count);
    $stmt_count->bind_param("s", $searchTerm);
    $stmt_count->execute();
    $total_records = $stmt_count->get_result()->fetch_assoc()['total'];
    $stmt_count->close();

    // Tính ra tổng số trang cần có
    $total_pages = ceil($total_records / $limit);

    // 2. Chỉ lấy đúng số sản phẩm của trang hiện tại (Dùng LIMIT và OFFSET)
    if ($total_records > 0) {
        $sql = "SELECT * FROM products WHERE ten_sp LIKE ? LIMIT ? OFFSET ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $searchTerm, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $searchResults = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    }
}
?>

<title>Kết quả tìm kiếm: <?php echo htmlspecialchars($keyword); ?></title>
<?php include('includes/header.php'); ?>
<link rel="stylesheet" href="assets/css/global.css">
<link rel="stylesheet" href="assets/css/search.css">

<main>
    <h2 class=" section-title" style="margin-top: 20px;">
        KẾT QUẢ TÌM KIẾM: <span style="color: #7499B4;">"<?php echo htmlspecialchars($keyword); ?>"</span>
    </h2>
    <div class="section-line"></div>

    <?php if ($keyword === ''): ?>
        <p style="text-align: center; color: #666; font-size: 18px; margin-top: 30px;">Vui lòng nhập tên sản phẩm bạn muốn tìm.</p>

    <?php elseif (count($searchResults) > 0): ?>
        <p style="text-align: center; margin-bottom: 30px; color: #555;">Đã tìm thấy <strong><?php echo count($searchResults); ?></strong> sản phẩm.</p>

        <div class="pd">
            <?php foreach ($searchResults as $row): ?>

                <div class="sp">
                    <?php if (isset($row['gia_cu']) && $row['gia_cu'] > $row['gia']): ?>
                        <?php $sale_percent = round((($row['gia_cu'] - $row['gia']) / $row['gia_cu']) * 100); ?>
                        <div class="sale-badge">-<?php echo $sale_percent; ?>%</div>
                    <?php endif; ?>

                    <a href="detail.php?id=<?php echo $row['id']; ?>" style="text-decoration: none; color: inherit; display: flex; flex-direction: column; flex-grow: 1;">

                        <img src="assets/images/<?php echo htmlspecialchars($row['hinh_anh']); ?>" alt="<?php echo htmlspecialchars($row['ten_sp']); ?>">

                        <h3><?php echo htmlspecialchars($row['ten_sp']); ?></h3>

                        <div class="price-container">
                            <span class="price-new"><?php echo number_format($row['gia'], 0, ',', '.'); ?>đ</span>
                            <?php if (isset($row['gia_cu']) && $row['gia_cu'] > 0): ?>
                                <span class="price-old"><?php echo number_format($row['gia_cu'], 0, ',', '.'); ?>đ</span>
                            <?php endif; ?>
                        </div>

                        <div class="star">
                            <?php
                            // Truy vấn lấy điểm trung bình của sản phẩm hiện tại
                            $sp_id = $row['id'];
                            $sql_star = "SELECT AVG(rating) as avg_rating FROM reviews WHERE product_id = $sp_id";
                            $res_star = mysqli_query($conn, $sql_star);
                            $star_row = mysqli_fetch_assoc($res_star);

                            // Làm tròn điểm. 
                            // Nếu chưa có ai đánh giá (null), mình tạm set mặc định là 5 sao cho đẹp web 
                            $diem_tb = round($star_row['avg_rating'] ?? 5);

                            // 3. Vòng lặp vẽ 5 ngôi sao
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $diem_tb) {
                                    // Sao vàng (đã đánh giá)
                                    echo '<i class="fa-solid fa-star" style="color: #FFD43B;"></i> ';
                                } else {
                                    // Sao xám (sao rỗng)
                                    echo '<i class="fa-regular fa-star" style="color: #ccc;"></i> ';
                                }
                            }
                            ?>
                        </div>
                    </a>
                    <form action="process/add_to_cart.php" method="POST" class="add-to-cart-form">
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
            <?php endforeach; ?>
        </div>

    <?php else: ?>
        <p style="text-align: center; color: #666; font-size: 18px; margin-top: 50px;">
            <i class="fa-solid fa-box-open" style="font-size: 40px; margin-bottom: 15px; display: block; color: #ccc;"></i>
            Rất tiếc, không tìm thấy sản phẩm nào.
        </p>
    <?php endif; ?>

    <?php if ($total_pages > 1): ?>
        <div style="text-align: center; margin-top: 40px; margin-bottom: 20px;">
            <?php if ($page > 1): ?>
                <a href="?keyword=<?php echo urlencode($keyword); ?>&page=<?php echo $page - 1; ?>"
                    style="padding: 10px 15px; margin: 0 5px; border: 1px solid #7499B4; text-decoration: none; color: #7499B4; border-radius: 5px;">&laquo; Trước</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?keyword=<?php echo urlencode($keyword); ?>&page=<?php echo $i; ?>"
                    style="padding: 10px 15px; margin: 0 5px; border: 1px solid #7499B4; text-decoration: none; border-radius: 5px; 
                   <?php echo ($i == $page) ? 'background-color: #7499B4; color: white;' : 'color: #7499B4;'; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?keyword=<?php echo urlencode($keyword); ?>&page=<?php echo $page + 1; ?>"
                    style="padding: 10px 15px; margin: 0 5px; border: 1px solid #7499B4; text-decoration: none; color: #7499B4; border-radius: 5px;">Sau &raquo;</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</main>

<?php include('includes/footer.php'); ?>