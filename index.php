<?php
include('config/database.php');

// Nổi bật: Lấy sản phẩm mới nhất và KHÔNG giảm giá 
$sql_noibat = "SELECT * FROM products WHERE gia_cu = 0 OR gia_cu <= gia ORDER BY id DESC LIMIT 8";
$query_noibat = mysqli_query($conn, $sql_noibat);

// Bán chạy: Lấy sản phẩm bán chạy và KHÔNG giảm giá
$sql_banchay = "SELECT * FROM products WHERE gia_cu = 0 OR gia_cu <= gia ORDER BY so_luong DESC LIMIT 8";
$query_banchay = mysqli_query($conn, $sql_banchay);

// Khuyến mãi: Chỉ lấy những sản phẩm thực sự CÓ giảm giá 
$sql_khuyenmai = "SELECT * FROM products WHERE gia_cu > gia ORDER BY id DESC LIMIT 8";
$query_khuyenmai = mysqli_query($conn, $sql_khuyenmai);


// TẠO HÀM IN SẢN PHẨM (CHỈ SỬA NỘI DUNG TRONG NÀY ĐỂ THÊM SIZE)
function renderProduct($row)
{
    global $conn;
    // Tạo mã unique để không bị trùng ID radio button khi 1 SP hiện ở nhiều Tab
    $unique_id = $row['id'] . '-' . uniqid();
?>
    <div class="sp">
        <?php
        // Tính % Sale
        if (!empty($row['gia_cu']) && $row['gia_cu'] > $row['gia']) {
            $phan_tram = round((($row['gia_cu'] - $row['gia']) / $row['gia_cu']) * 100);
            echo '<div class="sale-badge">-' . $phan_tram . '%</div>';
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
                // Truy vấn lấy điểm trung bình của sản phẩm hiện tại
                $sp_id = $row['id'];
                $sql_star = "SELECT AVG(rating) as avg_rating FROM reviews WHERE product_id = $sp_id";
                $res_star = mysqli_query($conn, $sql_star);
                $star_row = mysqli_fetch_assoc($res_star);

                // Làm tròn điểm. 
                // Nếu chưa có ai đánh giá (null), mình tạm set mặc định là 5 sao cho đẹp web
                $diem_tb = round($star_row['avg_rating'] ?? 5);

                // Vòng lặp vẽ 5 ngôi sao
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

        <form action="process/add_cart.php" method="POST" style="width: 100%; display: flex; flex-direction: column;">
            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
            <input type="hidden" name="quantity" value="1">

            <div class="size-mini">
                <input type="radio" name="size" id="size-S-<?php echo $unique_id; ?>" value="S" required>
                <label for="size-S-<?php echo $unique_id; ?>">S</label>

                <input type="radio" name="size" id="size-M-<?php echo $unique_id; ?>" value="M" checked required>
                <label for="size-M-<?php echo $unique_id; ?>">M</label>

                <input type="radio" name="size" id="size-L-<?php echo $unique_id; ?>" value="L" required>
                <label for="size-L-<?php echo $unique_id; ?>">L</label>

                <input type="radio" name="size" id="size-XL-<?php echo $unique_id; ?>" value="XL" required>
                <label for="size-XL-<?php echo $unique_id; ?>">XL</label>
            </div>

            <div class="hd" style="display: flex; gap: 5px;">
                <button type="submit" name="add_to_cart" class="cart" style="flex: 1;">Thêm Giỏ</button>
                <button type="submit" name="buy_now" class="buy" style="flex: 1;">Mua Ngay</button>
            </div>
        </form>
    </div>
<?php
}
?>

<title>Trang Chủ - Cửa Hàng Thời Trang</title>
<?php include('includes/header.php'); ?>

<link rel="stylesheet" href="assets/css/global.css">
<link rel="stylesheet" href="assets/css/trangchu.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<main>
    <div class="title">
        <h1>THỜI TRANG 2026<br>Dành Cho Bạn</h1>
        <?php
        $kham_pha = isset($_SESSION['user_id']) ? 'category.php' : 'login.php';
        ?>
        <a href="<?php echo $kham_pha; ?>" style="text-decoration: none;">
            <button class="btn">Khám Phá Ngay</button>
        </a>
    </div>
    <div class="tt">
        <p>"Phong cách định hình cá tính"</p>
    </div>
</main>

<section class="first">
    <h1 class="section-title">Danh Mục Nổi Bật</h1>
    <div class="section-line"></div>
    <div class="thoitrang">
        <?php
        // Kiểm tra đăng nhập để gán link tương ứng
        $link_nam = isset($_SESSION['user_id']) ? 'category.php?gioi_tinh=1' : 'login.php';
        $link_nu  = isset($_SESSION['user_id']) ? 'category.php?gioi_tinh=0' : 'login.php';
        ?>
        <div class="nam">
            <h3>Thời Trang Nam</h3>
            <a href="<?php echo $link_nam; ?>">Khám Phá →</a>
        </div>
        <div class="nu">
            <h3>Thời Trang Nữ</h3>
            <a href="<?php echo $link_nu; ?>">Khám Phá →</a>
        </div>
    </div>
</section>

<section class="second">
    <div class="dv">
        <div class="sv">
            <img src="assets/images/freeship.png" alt="Giao Hàng">
            <h3>Miễn Phí Giao Hàng</h3>
            <p>Giao hàng miễn phí tận nơi không tốn phí.</p>
        </div>
        <div class="sv">
            <img src="assets/images/service.png" alt="Dịch Vụ">
            <h3>Dịch Vụ 24/7</h3>
            <p>Làm việc, hỗ trợ khách hàng 24/7 mọi lúc</p>
        </div>
        <div class="sv">
            <img src="assets/images/baohanh.png" alt="Bảo Hành">
            <h3>Bảo Hành</h3>
            <p>Hỗ trợ bảo hành từ 3 đến 4 tháng</p>
        </div>
        <div class="sv">
            <img src="assets/images/hoantien.png" alt="Hoàn Trả Tiền">
            <h3>Hoàn Trả Tiền</h3>
            <p>Đảm bảo hoàn trả sản phẩm uy tín</p>
        </div>
    </div>
</section>

<section class="third">
    <h1 class="section-title" id="main-title">Sản Phẩm Nổi Bật</h1>
    <div class="section-line"></div>

    <div class="ml">
        <button class="nb tab-btn active" onclick="openTab(event, 'tab-noibat')">Nổi Bật</button>
        <button class="bc tab-btn" onclick="openTab(event, 'tab-banchay')">Bán Chạy</button>
        <button class="km tab-btn" onclick="openTab(event, 'tab-khuyenmai')">Khuyến Mãi</button>
    </div>

    <div id="tab-noibat" class="pd tab-content active">
        <?php while ($row = mysqli_fetch_assoc($query_noibat)) {
            renderProduct($row);
        } ?>
    </div>

    <div id="tab-banchay" class="pd tab-content">
        <?php while ($row = mysqli_fetch_assoc($query_banchay)) {
            renderProduct($row);
        } ?>
    </div>

    <div id="tab-khuyenmai" class="pd tab-content">
        <?php while ($row = mysqli_fetch_assoc($query_khuyenmai)) {
            renderProduct($row);
        } ?>
    </div>
</section>
<script src="assets/js/index.js"></script>
<?php include('includes/footer.php'); ?>