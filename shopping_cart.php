<?php
session_start();
include('config/database.php');

// KIỂM TRA ĐĂNG NHẬP
$user_id = 0;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} elseif (isset($_SESSION['user'])) {
    if (is_array($_SESSION['user']) && isset($_SESSION['user']['id'])) {
        $user_id = $_SESSION['user']['id'];
    } else {
        $user_id = $_SESSION['user'];
    }
}

if (empty($user_id)) {
    echo "<script>alert('Vui lòng đăng nhập để xem giỏ hàng!'); window.location.href='login.php';</script>";
    exit();
}
// Biến tính tổng tiền đơn hàng
$total_price = 0;
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="assets/css/global.css">
<link rel="sylesheet" href="assets/css/sanphamchitiet.css">
<link rel="stylesheet" href="assets/css/shopping_cart.css">

<?php include('includes/header.php'); ?>

<main>
    <h2 class="section-title" style="text-align: center; margin-top: 40px; color: #000;">GIỎ HÀNG CỦA BẠN</h2>
    <div class="section-line" style="width: 80px; height: 3px; background: #000; margin: 10px auto 40px auto;"></div>

    <div class="cart-container">
        <div class="cart-left">
            <div class="cart-controls">
                <label class="select-all-label">
                    <input type="checkbox" id="selectAll"> <span>Chọn tất cả</span>
                </label>
                <button class="btn-delete-selected" id="deleteSelected" disabled>
                    <i class="fa-solid fa-trash-can"></i> Xóa sản phẩm đã chọn
                </button>
            </div>

            <?php
            $sql_cart = "SELECT c.id as cart_id, c.quantity, c.size, p.id as product_id, p.ten_sp, p.gia, p.hinh_anh 
                 FROM cart c 
                 JOIN products p ON c.product_id = p.id 
                 WHERE c.user_id = '$user_id' ORDER BY c.id DESC";
            $result_cart = mysqli_query($conn, $sql_cart);

            if (mysqli_num_rows($result_cart) > 0) {
                while ($item = mysqli_fetch_assoc($result_cart)) {
                    // Biến tính tổng tiền phụ cho từng món
                    $subtotal = $item['gia'] * $item['quantity'];
                    $total_price += $subtotal;
            ?>

                    <div class="cart-item">
                        <input type="checkbox" class="item-checkbox" value="<?php echo $item['cart_id']; ?>">
                        <img src="assets/images/<?php echo $item['hinh_anh']; ?>" alt="Sản phẩm">
                        <div class="cart-info">
                            <h3 style="margin-bottom: 5px;"><?php echo $item['ten_sp']; ?></h3>
                            <p style="font-size: 14px; color: #666; margin-bottom: 10px; font-weight: bold;">
                                Size: <?php echo isset($item['size']) ? $item['size'] : 'M'; ?>
                            </p>
                            <p class="cart-price"><?php echo number_format($item['gia'], 0, ',', '.'); ?>đ</p>
                            <div class="tg" style="margin-bottom: 0;">
                                <a href="process/update_cart.php?action=decrease&cart_id=<?php echo $item['cart_id']; ?>" class="btn-qty" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; color: black;">-</a>

                                <span class="qty-number"><?php echo $item['quantity']; ?></span>

                                <a href="process/update_cart.php?action=increase&cart_id=<?php echo $item['cart_id']; ?>" class="btn-qty" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; color: black;">+</a>
                            </div>
                        </div>
                        <a href="process/remove_cart.php?cart_id=<?php echo $item['cart_id']; ?>" class="cart-delete" title="Xóa sản phẩm này" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </div>
            <?php
                } // Đóng vòng lặp foreach
            } else {
                echo "<p style='text-align: center; padding: 30px; font-size: 18px;'>Giỏ hàng của bạn đang trống!</p>";
            }
            ?>
        </div>

        <div class="cart-right">
            <h3>TÓM TẮT ĐƠN HÀNG</h3>
            <div class="summary-item">
                <span>Tạm tính:</span>
                <span><?php echo number_format($total_price, 0, ',', '.'); ?>đ</span>
            </div>
            <div class="summary-item">
                <span>Phí giao hàng:</span>
                <span><?php echo ($total_price > 0) ? '30.000đ' : '0đ'; ?></span>
            </div>
            <hr>
            <div class="summary-item total">
                <span>Tổng cộng:</span>
                <span class="total-price">
                    <?php
                    $final_total = ($total_price > 0) ? ($total_price + 30000) : 0;
                    echo number_format($final_total, 0, ',', '.');
                    ?>đ
                </span>
            </div>

            <?php if ($total_price > 0): ?>
                <a href="checkout.php" style="text-decoration: none;">
                    <button class="cart-checkout" style="width: 100%;">TIẾN HÀNH THANH TOÁN</button>
                </a>
            <?php else: ?>
                <button class="cart-checkout" disabled style="background-color: #ccc; cursor: not-allowed;">TIẾN HÀNH THANH TOÁN</button>
            <?php endif; ?>

        </div>
    </div>

    <script src="assets/js/cart.js"></script>
</main>

<?php include('includes/footer.php'); ?>