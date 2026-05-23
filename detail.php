<?php
if (session_status() == PHP_SESSION_NONE) {
    ob_start();
    session_start();
}
include('config/database.php');
$id_sp = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT * FROM products WHERE id = $id_sp";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
    $title = mb_strtoupper($product['ten_sp'], 'UTF-8') . " - FASHIONSTORE";
    include('includes/header.php');
?>
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/sanphamchitiet.css">

    <main>
        <section class="ct">
            <div class="product">
                <img src="assets/images/<?php echo $product['hinh_anh']; ?>" alt="<?php echo $product['ten_sp']; ?>">
            </div>

            <div class="info">
                <h1><?php echo $product['ten_sp']; ?></h1>
                <div class="price-container">
                    <span class="price-new"><?php echo number_format($product['gia'], 0, ',', '.'); ?> VNĐ</span>
                    <?php if (!empty($product['gia_cu']) && $product['gia_cu'] > $product['gia']): ?>
                        <span class="price-old"><?php echo number_format($product['gia_cu'], 0, ',', '.'); ?> VNĐ</span>
                    <?php endif; ?>
                </div>

                <div class="star">
                    <?php
                    // Truy vấn lấy điểm trung bình của sản phẩm hiện tại
                    $sp_id = $product['id'];
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

                <div class="mt">
                    <h2>Mô Tả Sản Phẩm</h2>
                    <p><?php echo nl2br($product['mo_ta']); ?></p>

                    <form action="process/add_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                        <div class="size-mini" style="margin-bottom: 25px;">
                            <input type="radio" name="size" id="size-S-main" value="S" required>
                            <label for="size-S-main">S</label>

                            <input type="radio" name="size" id="size-M-main" value="M" checked required>
                            <label for="size-M-main">M</label>

                            <input type="radio" name="size" id="size-L-main" value="L" required>
                            <label for="size-L-main">L</label>

                            <input type="radio" name="size" id="size-XL-main" value="XL" required>
                            <label for="size-XL-main">XL</label>
                        </div>

                        <div class="tg" style="margin-bottom: 35px;">
                            <button type="button" class="tru" onclick="updateQty(-1)"><i class="fa-solid fa-minus"></i></button>

                            <input type="text" name="quantity" id="qty_input" value="1" readonly
                                style="width: 40px; text-align: center; border: none; font-size: 16px; font-weight: bold; background: transparent; outline: none; padding: 0;">

                            <button type="button" class="cong" onclick="updateQty(1)"><i class="fa-solid fa-plus"></i></button>
                        </div>

                        <div class="hd" style="margin-top: 35px;">
                            <button type="submit" name="add_to_cart" class="cart">Thêm Giỏ Hàng</button>
                            <button type="submit" name="buy_now" class="buy">Mua Ngay</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section class="size-chart">
            <h2>Bảng size quần áo Nam / Nữ (Chuẩn)</h2>
            <table>
                <tr>
                    <th>Size</th>
                    <th>Nam (Chiều cao)</th>
                    <th>Nam (Cân nặng)</th>
                    <th>Nữ (Chiều cao)</th>
                    <th>Nữ (Cân nặng)</th>
                </tr>
                <tr>
                    <td>S</td>
                    <td>155 - 165 cm</td>
                    <td>48 - 55 kg</td>
                    <td>145 - 155 cm</td>
                    <td>40 - 48 kg</td>
                </tr>
                <tr>
                    <td>L</td>
                    <td>165 - 175 cm</td>
                    <td>56 - 63 kg</td>
                    <td>160 - 165 cm</td>
                    <td>54 - 60 kg</td>
                </tr>
                <tr>
                    <td>XL</td>
                    <td>166 - 180 cm</td>
                    <td>60 - 75 kg</td>
                    <td>165 - 170 cm</td>
                    <td>56 - 65 kg</td>
                </tr>
                <tr>
                    <td>XXL</td>
                    <td>180 - 185 cm</td>
                    <td>82 - 90 kg</td>
                    <td>170 - 175 cm</td>
                    <td>65 - 70 kg</td>
                </tr>
            </table>
        </section>

        <section class="bh">
            <h1>CHÍNH SÁCH BẢO HÀNH</h1>
            <div class="line"></div>
            <div class="tt">
                <p>• Sản phẩm được bảo hành trong vòng 7 ngày nếu có lỗi từ nhà sản xuất như lỗi đường may, bung chỉ hoặc lỗi vải.</p>
                <p>• Trong thời gian bảo hành, cửa hàng sẽ hỗ trợ sửa chữa hoặc khắc phục lỗi để đảm bảo sản phẩm sử dụng tốt.</p>
                <p>• Chính sách bảo hành không áp dụng đối với các trường hợp hư hỏng do người sử dụng, giặt sai cách hoặc đã tự ý chỉnh sửa sản phẩm.</p>
            </div>

            <h1>CHÍNH SÁCH ĐỔI TRẢ</h1>
            <div class="line"></div>
            <div class="tt">
                <p>• Khách hàng có thể đổi hoặc trả sản phẩm trong vòng 7 ngày kể từ khi nhận hàng nếu sản phẩm bị lỗi, giao sai mẫu, kích thước.</p>
                <p>• Sản phẩm cần còn mới, chưa qua sử dụng và còn đầy đủ tem mác.</p>
            </div>

            <h1>CHÍNH SÁCH VẬN CHUYỂN</h1>
            <div class="line"></div>
            <div class="tt">
                <p>• Chúng tôi hỗ trợ giao hàng trên toàn quốc thông qua các đơn vị vận chuyển uy tín.</p>
                <p>• Thời gian giao hàng thường từ 2–5 ngày tùy khu vực.</p>
            </div>
        </section>

        <section class="bl" style="max-width: 1200px; margin: 40px auto; padding: 0 20px;">
            <div class="tt">
                <h2>ĐÁNH GIÁ SẢN PHẨM</h2>
            </div>

            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="write-review-container" style="background: #f9f9f9; padding: 20px; border-radius: 15px; margin-bottom: 30px; border: 1px solid #eee;">
                    <h3 style="margin-bottom: 15px; font-size: 18px;">Để lại đánh giá của bạn</h3>
                    <form action="process/add_review.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">

                        <div style="margin-bottom: 15px;">
                            <label>Chọn mức độ hài lòng: </label>
                            <select name="rating" style="padding: 8px; border-radius: 5px; border: 1px solid #ddd;">
                                <option value="5">⭐⭐⭐⭐⭐ (Rất tốt)</option>
                                <option value="4">⭐⭐⭐⭐ (Tốt)</option>
                                <option value="3">⭐⭐⭐ (Bình thường)</option>
                                <option value="2">⭐⭐ (Tệ)</option>
                                <option value="1">⭐ (Rất tệ)</option>
                            </select>
                        </div>

                        <textarea name="comment" rows="3" style="width: 100%; padding: 15px; border-radius: 10px; border: 1px solid #ddd; margin-bottom: 15px; font-family: inherit;" placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm..." required></textarea>

                        <button type="submit" style="background: #000; color: #fff; border: none; padding: 10px 25px; border-radius: 5px; cursor: pointer; font-weight: bold;">Gửi Đánh Giá</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="sl">
                    <p style="margin: 0;">Vui lòng <a href="login.php" style="font-weight:bold; color: #000;">Đăng nhập</a> để viết đánh giá.</p>
                </div>
            <?php endif; ?>

            <div class="review-list">
                <?php
                $sql_reviews = "SELECT r.*, u.fullname FROM reviews r 
                    LEFT JOIN user u ON r.user_id = u.id 
                    WHERE r.product_id = $id_sp 
                    ORDER BY r.created_at DESC";

                $result_reviews = mysqli_query($conn, $sql_reviews);

                if ($result_reviews && mysqli_num_rows($result_reviews) > 0):
                    while ($review = mysqli_fetch_assoc($result_reviews)):
                        $stars = str_repeat('⭐', $review['rating']);
                ?>
                        <div class="review-item" style="border-bottom: 1px solid #eee; padding: 20px 0;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <strong><?php echo htmlspecialchars($review['fullname'] ?? 'Khách hàng'); ?></strong>
                                <span style="color: #999; font-size: 12px;"><?php echo date('d/m/Y', strtotime($review['created_at'])); ?></span>
                            </div>
                            <div style="color: #ffcc00; margin-bottom: 10px; font-size: 14px;"><?php echo $stars; ?></div>
                            <p style="color: #444; line-height: 1.6;"><?php echo htmlspecialchars($review['comment']); ?></p>

                            <?php if (!empty($review['shop_reply'])): ?>
                                <div style="margin-top: 15px; padding: 12px; background: #fdfae6; border-left: 4px solid #f1c40f; border-radius: 4px;">
                                    <strong style="color: #0B1E34;"><i class="fa fa-reply"></i> FashionShop phản hồi:</strong>
                                    <p style="margin: 5px 0 0 0; color: #555;">
                                        <?php echo htmlspecialchars($review['shop_reply']); ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php
                    endwhile;
                else:
                    ?>
                    <div style="text-align: center; padding: 50px; color: #999;">
                        Chưa có đánh giá nào cho sản phẩm này.
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="spk">
            <h1>CÁC SẢN PHẨM KHÁC</h1>
            <div class="line"></div>
            <div class="pd">
                <?php
                $gt_sp = $product['gioi_tinh'];
                $sql_other = "SELECT * FROM products WHERE gioi_tinh = $gt_sp AND id != $id_sp LIMIT 4";
                $res_other = $conn->query($sql_other);
                while ($row_o = $res_other->fetch_assoc()) {
                ?>
                    <div class="sp">
                        <?php
                        // Tính % Sale cho sản phẩm khác
                        if (!empty($row_o['gia_cu']) && $row_o['gia_cu'] > $row_o['gia']) {
                            $phan_tram = round((($row_o['gia_cu'] - $row_o['gia']) / $row_o['gia_cu']) * 100);
                            echo '<div class="sale-badge">-' . $phan_tram . '%</div>';
                        }
                        ?>
                        <a href="detail.php?id=<?php echo $row_o['id']; ?>" style="text-decoration: none; color: inherit;">
                            <div class="pt">
                                <img src="assets/images/<?php echo $row_o['hinh_anh']; ?>" alt="<?php echo $row_o['ten_sp']; ?>">
                            </div>
                            <h3><?php echo $row_o['ten_sp']; ?></h3>

                            <div class="price-container">
                                <span class="price-new"><?php echo number_format($row_o['gia'], 0, ',', '.'); ?>đ</span>
                                <?php if (isset($row_o['gia_cu']) && $row_o['gia_cu'] > $row_o['gia']): ?>
                                    <span class="price-old"><?php echo number_format($row_o['gia_cu'], 0, ',', '.'); ?>đ</span>
                                <?php endif; ?>
                            </div>

                            <div class="star">
                                <?php
                                // Truy vấn lấy điểm trung bình của sản phẩm hiện tại
                                $sp_id = $row_o['id'];
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

                        <?php
                        // Tạo ID duy nhất cho các nút size ở phần "Sản phẩm khác"
                        $unique_id_other = $row_o['id'] . '-other-' . uniqid();
                        ?>

                        <form action="process/add_cart.php" method="POST" style="width: 100%; display: flex; flex-direction: column;">
                            <input type="hidden" name="product_id" value="<?php echo $row_o['id']; ?>">
                            <div class="size-picker">
                            </div>
                            <input type="hidden" name="quantity" value="1">

                            <div class="size-mini">
                                <input type="radio" name="size" id="size-S-<?php echo $unique_id_other; ?>" value="S" required>
                                <label for="size-S-<?php echo $unique_id_other; ?>">S</label>

                                <input type="radio" name="size" id="size-M-<?php echo $unique_id_other; ?>" value="M" checked required>
                                <label for="size-M-<?php echo $unique_id_other; ?>">M</label>

                                <input type="radio" name="size" id="size-L-<?php echo $unique_id_other; ?>" value="L" required>
                                <label for="size-L-<?php echo $unique_id_other; ?>">L</label>

                                <input type="radio" name="size" id="size-XL-<?php echo $unique_id_other; ?>" value="XL" required>
                                <label for="size-XL-<?php echo $unique_id_other; ?>">XL</label>
                            </div>

                            <div class="hd" style="display: flex; gap: 5px;">
                                <button type="submit" name="add_to_cart" class="cart" style="flex: 1;">Thêm Giỏ</button>
                                <button type="submit" name="buy_now" class="buy" style="flex: 1;">Mua Ngay</button>
                            </div>
                        </form>
                    </div>
                <?php } ?>
            </div>
        </section>
    </main>

    <script src="assets/js/cart.js"></script>
<?php
    include('includes/footer.php');
} else {
    echo "<p style='text-align:center; padding:100px;'>Sản phẩm không tồn tại!</p>";
}
?>