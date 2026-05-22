# 👗 FashionShop - Cửa Hàng Thời Trang Trực Tuyến

> Một nền tảng thương mại điện tử chuyên về bán quần áo với giao diện thân thiện và tính năng đầy đủ.

[![PHP Version](https://img.shields.io/badge/PHP-8.0.30+-blue.svg)](https://www.php.net/)
[![MySQL Version](https://img.shields.io/badge/MySQL-10.4.32-orange.svg)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## 📋 Mục Lục

- [Giới Thiệu](#giới-thiệu)
- [Tính Năng](#tính-năng)
- [Yêu Cầu Hệ Thống](#yêu-cầu-hệ-thống)
- [Cài Đặt](#cài-đặt)
- [Cấu Trúc Dự Án](#cấu-trúc-dự-án)
- [Sử Dụng](#sử-dụng)
- [Cơ Sở Dữ Liệu](#cơ-sở-dữ-liệu)
- [Đóng Góp](#đóng-góp)
- [Tác Giả](#tác-giả)

## 📖 Giới Thiệu

**FashionShop** là một ứng dụng web thương mại điện tử được xây dựng bằng **PHP**, **CSS**, và **JavaScript**. Dự án cho phép khách hàng duyệt, tìm kiếm, và mua sắm các sản phẩm quần áo thời trang. Đồng thời, nó cung cấp một bảng điều khiển quản trị viên để quản lý sản phẩm, đơn hàng, người dùng, và các yêu cầu liên hệ từ khách hàng.

## ✨ Tính Năng

### 👥 Cho Khách Hàng
- ✅ **Đăng Ký & Đăng Nhập**: Xác thực người dùng an toàn với email
- ✅ **Duyệt Sản Phẩm**: Xem toàn bộ sản phẩm theo danh mục
  - Quần: Tây, Jean, Kaki, Short
  - Áo: Polo, Sơ Mi, Khoác
- ✅ **Tìm Kiếm Sản Phẩm**: Tìm kiếm nhanh theo tên sản phẩm
- ✅ **Xem Chi Tiết Sản Phẩm**: Thông tin đầy đủ, hình ảnh, giá cả, kích cỡ
- ✅ **Hệ Thống Đánh Giá**: Xem và bình luận đánh giá sản phẩm (5 sao)
- ✅ **Giỏ Hàng**: Thêm, xóa, cập nhật số lượng sản phẩm
- ✅ **Thanh Toán**: Quy trình thanh toán đơn giản
- ✅ **Quản Lý Đơn Hàng**: Xem lịch sử đơn hàng và trạng thái
- ✅ **Hồ Sơ Cá Nhân**: Cập nhật thông tin cá nhân, địa chỉ giao hàng
- ✅ **Liên Hệ**: Gửi thông điệp liên hệ đến cửa hàng
- ✅ **Khuyến Mãi**: Xem sản phẩm bán chạy, nổi bật, khuyến mãi

### 🔧 Cho Quản Trị Viên
- ✅ **Quản Lý Sản Phẩm**: Thêm, sửa, xóa sản phẩm
- ✅ **Quản Lý Danh Mục**: Quản lý các danh mục sản phẩm
- ✅ **Quản Lý Đơn Hàng**: Xem tất cả đơn hàng, cập nhật trạng thái
- ✅ **Quản Lý Người Dùng**: Xem danh sách người dùng đã đăng ký
- ✅ **Quản Lý Đánh Giá**: Duyệt và quản lý bình luận đánh giá
- ✅ **Quản Lý Yêu Cầu Liên Hệ**: Xử lý các tin nhắn từ khách hàng

## 💻 Yêu Cầu Hệ Thống

- **Server Web**: Apache hoặc Nginx
- **PHP**: Phiên bản 8.0.30 trở lên
- **Database**: MySQL 10.4.32 hoặc MariaDB tương đương
- **Browser**: Chrome, Firefox, Safari, Edge (phiên bản mới nhất)

## 🚀 Cài Đặt

### 1. Clone Repository
```bash
git clone https://github.com/KCPM-Nhom/FashionShop.git
cd FashionShop
```

### 2. Cấu Hình Database
- Mở **phpMyAdmin** và tạo database mới tên `fashion`
- Import file `config/fashion.sql` vào database
```sql
-- Hoặc chạy lệnh sau trong terminal MySQL:
mysql -u root -p fashion < config/fashion.sql
```

### 3. Cấu Hình Kết Nối Database
Chỉnh sửa file `config/database.php`:
```php
<?php
$host = "localhost";
$username = "root";  // Thay đổi username của bạn
$password = "";      // Thay đổi password nếu có
$database = "fashion";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8");
?>
```

### 4. Triển Khai Ứng Dụng
- Copy toàn bộ thư mục vào **htdocs** (nếu dùng XAMPP) hoặc **www** (nếu dùng WAMP)
- Ví dụ: `C:\xampp\htdocs\FashionShop`

### 5. Chạy Ứng Dụng
Truy cập trong trình duyệt:
```
http://localhost/FashionShop/
```

## 📁 Cấu Trúc Dự Án

```
FashionShop/
├── admin/                    # Bảng điều khiển quản trị viên
│   ├── index.php            # Trang chủ admin
│   ├── contacts.php         # Quản lý yêu cầu liên hệ
│   ├── orders.php           # Quản lý đơn hàng
│   ├── order_details.php    # Chi tiết đơn hàng
│   ├── products.php         # Quản lý sản phẩm
│   ├── reviews.php          # Quản lý đánh giá
│   ├── users.php            # Quản lý người dùng
│   └── sidebar.php          # Thanh bên điều hướng
│
├── assets/                   # Tài nguyên tĩnh
│   ├── css/                 # Các file CSS
│   │   ├── admin_style.css  # Style cho admin
│   │   ├── header.css       # Style header
│   │   ├── footer.css       # Style footer
│   │   ├── global.css       # Style toàn cầu
│   │   ├── auth.css         # Style đăng nhập/đăng ký
│   │   ├── trangchu.css     # Style trang chủ
│   │   ├── checkout.css     # Style thanh toán
│   │   ├── profile.css      # Style hồ sơ
│   │   ├── search.css       # Style tìm kiếm
│   │   ├── responsive.css   # Style responsive
│   │   └── ...
│   ├── images/              # Hình ảnh sản phẩm
│   └── js/                  # Các file JavaScript
│       ├── auth.js          # Logic đăng nhập
│       ├── cart.js          # Logic giỏ hàng
│       ├── category.js      # Logic danh mục
│       ├── checkout.js      # Logic thanh toán
│       ├── header.js        # Logic header
│       └── ...
│
├── config/                   # Cấu hình
│   ├── database.php         # Kết nối database
│   └── fashion.sql          # Script tạo database
│
├── includes/                # Các file include dùng chung
│   ├── header.php           # Header chung
│   ├── footer.php           # Footer chung
│   └── alert_message.php    # Thông báo lỗi/thành công
│
├── process/                 # Xử lý logic backend
│   ├── auth.php            # Xử lý đăng nhập/đăng ký
│   ├── add_cart.php        # Thêm vào giỏ hàng
│   ├── update_cart.php     # Cập nhật giỏ hàng
│   ├── remove_cart.php     # Xóa khỏi giỏ hàng
│   ├── place_order.php     # Đặt hàng
│   ├── add_review.php      # Thêm đánh giá
│   ├── update_profile.php  # Cập nhật hồ sơ
│   ├── cancel_order.php    # Hủy đơn hàng
│   └── ...
│
├── index.php                # Trang chủ
├── category.php             # Trang danh mục
├── detail.php               # Chi tiết sản phẩm
├── search.php               # Tìm kiếm
├── login.php                # Đăng nhập
├── register.php             # Đăng ký
├── shopping_cart.php        # Giỏ hàng
├── checkout.php             # Thanh toán
├── order.php                # Đơn hàng
├── order_details.php        # Chi tiết đơn hàng
├── profile.php              # Hồ sơ cá nhân
├── address.php              # Quản lý địa chỉ
├── lienhe.php               # Liên hệ
├── .git/                    # Git repository
└── README.md                # File này
```

## 🗄️ Cơ Sở Dữ Liệu

### Các Bảng Chính

| Bảng | Mô Tả |
|------|-------|
| `admin` | Tài khoản quản trị viên |
| `users` | Tài khoản người dùng khách hàng |
| `categories` | Danh mục sản phẩm |
| `products` | Thông tin sản phẩm |
| `cart` | Giỏ hàng của người dùng |
| `orders` | Đơn hàng |
| `order_items` | Chi tiết các mục trong đơn hàng |
| `reviews` | Đánh giá sản phẩm |
| `contacts` | Yêu cầu liên hệ |

## 👨‍💼 Sử Dụng

### Tài Khoản Mặc Định (Admin)

**Email**: `admin@gmail.com`  
**Password**: `trung7474`

Hoặc

**Email**: `adminFashionShop@gmail.com`  
**Password**: `admin`

> ⚠️ **Lưu ý**: Thay đổi mật khẩu ngay sau khi đăng nhập lần đầu tiên vì lý do bảo mật.

### Danh Mục Sản Phẩm

- **Quần**: Tây, Jean, Kaki, Short
- **Áo**: Polo, Sơ Mi, Khoác

### Quy Trình Mua Sắm

1. **Đăng Ký/Đăng Nhập**: Tạo tài khoản hoặc đăng nhập
2. **Duyệt Sản Phẩm**: Xem danh mục hoặc tìm kiếm sản phẩm
3. **Xem Chi Tiết**: Click vào sản phẩm để xem thông tin chi tiết
4. **Thêm Giỏ Hàng**: Chọn kích cỡ và số lượng, thêm vào giỏ
5. **Thanh Toán**: Xem giỏ hàng, cập nhật thông tin giao hàng, đặt hàng
6. **Theo Dõi**: Kiểm tra trạng thái đơn hàng trong hồ sơ

## 🔐 Bảo Mật

- ✅ Xác thực người dùng bằng session
- ✅ Mã hóa password (sử dụng hàm bảo mật)
- ✅ Xác minh dữ liệu input từ người dùng
- ✅ Chống SQL Injection với `mysqli_real_escape_string()`
- ⚠️ **Khuyến Nghị**: Sử dụng `password_hash()` và `password_verify()` để bảo mật mật khẩu tốt hơn

## 🛠️ Công Nghệ

| Công Nghệ | Phiên Bản | Mục Đích |
|-----------|----------|---------|
| PHP | 8.0.30+ | Backend |
| MySQL | 10.4.32+ | Database |
| HTML5 | - | Markup |
| CSS3 | - | Styling |
| JavaScript | ES6+ | Frontend Logic |
| Font Awesome | 6.5.0 | Icons |

## 📱 Tính Năng Responsive

- ✅ Thiết kế thích ứng cho mobile, tablet, desktop
- ✅ Menu di động cho thiết bị nhỏ
- ✅ Hình ảnh tự động điều chỉnh kích thước

## 🐛 Khắc Phục Sự Cố

### Lỗi: "Kết nối thất bại"
- Kiểm tra MySQL có đang chạy không
- Kiểm tra tên người dùng, mật khẩu, tên database trong `config/database.php`

### Lỗi: 404 Page Not Found
- Kiểm tra cấu hình RewriteRule trong `.htaccess`
- Đảm bảo tệp tồn tại trong thư mục

### Lỗi: Session không hoạt động
- Kiểm tra `session_start()` có được gọi ở đầu file không
- Kiểm tra quyền ghi trong thư mục session của PHP

### Lỗi: Hình ảnh không hiển thị
- Đảm bảo folder `assets/images/` tồn tại
- Kiểm tra tên file hình ảnh có khớp trong database không

## 📝 License

Dự án này được cấp phép dưới giấy phép **MIT**. Xem file [LICENSE](LICENSE) để biết thêm chi tiết.

## 👥 Tác Giả

- **Khang** ([KhangUTH](https://github.com/KhangUTH))
- **Humanoid1266** ([Humanoid1266](https://github.com/Humanoid1266))

### Đóng Góp

Chúng tôi hoan nghênh các đóng góp từ cộng đồng!

1. Fork dự án
2. Tạo nhánh tính năng (`git checkout -b feature/AmazingFeature`)
3. Commit thay đổi (`git commit -m 'Add some AmazingFeature'`)
4. Push lên nhánh (`git push origin feature/AmazingFeature`)
5. Mở Pull Request

## 📧 Liên Hệ

- **GitHub**: [KCPM-Nhom/FashionShop](https://github.com/KCPM-Nhom/FashionShop)
- **Email**: Sử dụng form liên hệ trên website

## 📊 Thống Kê Dự Án

- **Ngôn Ngữ**: PHP (70.9%), CSS (23.1%), JavaScript (5.4%), Hack (0.6%)
- **Database**: MariaDB 10.4.32
- **PHP Version**: 8.0.30+
- **Repository**: https://github.com/KCPM-Nhom/FashionShop

---

**Cảm ơn bạn đã sử dụng FashionShop!** 👗✨

Nếu bạn có bất kỳ câu hỏi hoặc gặp vấn đề, vui lòng mở một Issue trên GitHub.
