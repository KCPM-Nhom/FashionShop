<?php
// Khởi tạo session ở dòng đầu tiên của trang để lấy thông tin đăng nhập
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<link rel="stylesheet" href="assets/css/header.css">
<link rel="stylesheet" href="assets/css/footer.css">
<link rel="stylesheet" href="assets/css/responsive.css">
<link rel="icon" href="assets/images/bieutuong.png">
<title><?php echo isset($title) ? $title : 'FASHIONSTORE'; ?></title>



<header>
    <div class="logo">
        <a href="index.php">
            <h2>FASHIONSTORE</h2>
        </a>
    </div>

    <ul class="menu">
        <li><a href="index.php">Trang Chủ</a></li>
        <li class="dropdown">
            <a href="#">Sản Phẩm <i class="fa-solid fa-chevron-down"></i></a>
            <ul class="sub-menu">

                <li class="dropdown-item">
                    <a href="#">Áo <i class="fa-solid fa-caret-right"></i></a>
                    <ul class="sub-menu-level-2">
                        <li><a href="category.php?id=5">Áo Polo</a></li>
                        <li><a href="category.php?id=6">Áo Sơ Mi</a></li>
                        <li><a href="category.php?id=7">Áo Khoác</a></li>
                    </ul>
                </li>

                <li class="dropdown-item">
                    <a href="#">Quần <i class="fa-solid fa-caret-right"></i></a>
                    <ul class="sub-menu-level-2">
                        <li><a href="category.php?id=1">Quần Tây</a></li>
                        <li><a href="category.php?id=2">Quần Jean</a></li>
                        <li><a href="category.php?id=3">Quần Kaki</a></li>
                        <li><a href="category.php?id=4">Quần Short</a></li>
                    </ul>
                </li>
            </ul>
        <li><a href="lienhe.php">Liên Hệ</a></li>
    </ul>

    <div class="header-icons">
        <div class="search-container">
            <form action="search.php" method="GET" class="search-form">
                <input type="text" name="keyword" class="search-input" placeholder="Tìm kiếm...">
                <i class="fa-solid fa-magnifying-glass" id="search-icon"></i>
            </form>
        </div>

        <a href="shopping_cart.php" style="color: inherit;"><i class="fa-solid fa-cart-shopping"></i></a>

        <?php if (isset($_SESSION['fullname'])): ?>
            <div class="user-dropdown">
                <a href="#" style="color: inherit;">
                    <i class="fa-solid fa-user"></i>
                    <span class="user-name">
                        <?php
                        // Cắt chuỗi fullname thành các từ rời rạc dựa vào khoảng trắng
                        $name_parts = explode(' ', trim($_SESSION['fullname']));
                        // Lấy từ cuối cùng trong mảng (chính là Tên) để hiển thị
                        $first_name = end($name_parts);

                        echo htmlspecialchars($first_name);
                        ?>
                    </span>
                </a>
                <ul class="user-sub-menu">
                    <li><a href="profile.php"><i class="fa-solid fa-id-card"></i> Thông tin cá nhân</a></li>
                    <li><a href="order.php"><i class="fa-solid fa-box-open"></i> Đơn hàng của tôi</a></li>
                    <li><a href="process/auth.php?action=logout" style="color: #C05F5F;"><i class="fa-solid fa-sign-out-alt"></i> Đăng xuất</a></li>
                </ul>
            </div>
        <?php else: ?>
            <a href="login.php" style="color: inherit;"><i class="fa-solid fa-user"></i></a>
        <?php endif; ?>

    </div>
</header>

<script src="assets/js/header.js"></script>