<?php
// Lấy tên file hiện tại (ví dụ: đang ở index.php thì nó lấy chữ 'index.php')
$current_page = basename($_SERVER['PHP_SELF']);
?>
<aside class="sidebar">
    <div class="logo">
        <h2>FashionShop</h2>
    </div>
    <nav>
        <ul>
            <li class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                <a href="index.php"><i class="fa fa-home"></i> Tổng quan</a>
            </li>

            <li class="<?php echo ($current_page == 'products.php') ? 'active' : ''; ?>">
                <a href="products.php"><i class="fa fa-box"></i> Sản phẩm</a>
            </li>

            <li class="<?php echo ($current_page == 'orders.php' || $current_page == 'order_details.php') ? 'active' : ''; ?>">
                <a href="orders.php"><i class="fa fa-shopping-cart"></i> Đơn hàng</a>
            </li>

            <li class="<?php echo ($current_page == 'users.php') ? 'active' : ''; ?>">
                <a href="users.php"><i class="fa fa-users"></i> Khách hàng</a>
            </li>

            <li class="<?php echo ($current_page == 'reviews.php') ? 'active' : ''; ?>">
                <a href="reviews.php"><i class="fa fa-star"></i> Đánh giá</a>
            </li>

            <li class="<?php echo ($current_page == 'contacts.php') ? 'active' : ''; ?>">
                <a href="contacts.php"><i class="fa fa-envelope"></i> Tin nhắn</a>
            </li>

            <li class="logout">
                <a href="../process/auth.php?action=logout"><i class="fa fa-sign-out"></i> Thoát</a>
            </li>
        </ul>
    </nav>
</aside>