-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 11, 2026 lúc 07:55 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `fashion`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `fullname`, `email`, `phone`, `password`, `created_at`) VALUES
(1, 'Nguyễn Quang Trung', 'admin@gmail.com', '0352493970', 'trung7474', '2026-04-02 16:25:24'),
(4, 'adminFashionShop', 'adminFashionShop@gmail.com', '0123456789', 'admin', '2026-04-03 23:56:11'),
(5, 'Nguyễn Văn Trường', 'truongadmin@gmail.com', '0334327457', 'admin', '2026-04-14 11:57:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `size` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `ten_danh_muc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `ten_danh_muc`) VALUES
(1, 'Quần Tây'),
(2, 'Quần Jean'),
(3, 'Quần Kaki'),
(4, 'Quần Short'),
(5, 'Áo Polo'),
(6, 'Áo Sơ Mi'),
(7, 'Áo khoác');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(50) DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contacts`
--

INSERT INTO `contacts` (`id`, `fullname`, `email`, `message`, `status`, `created_at`) VALUES
(1, 'Nguyễn Trưởng', 'quoctruong29@gmail.com', 'Tôi cần hỗ trợ về phần thông báo sản phẩm', 'read', '2026-04-08 18:22:20'),
(2, 'Nguyễn Trưởng', 'quoctruong29@gmail.com', 'Tôi cần hỗ trợ về phần thông báo sản phẩm', 'read', '2026-04-08 18:24:13'),
(3, 'Nguyễn Trưởng', 'quoctruong29@gmail.com', 'Tôi cần hỗ trợ thanh toán ', 'read', '2026-04-09 09:22:25'),
(4, 'Nguyễn Trưởng', 'quoctruong29@gmail.com', 'sản phẩm bị lỗi', 'read', '2026-04-10 09:51:53');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fullname` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `payment` varchar(50) NOT NULL,
  `total` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Chờ xử lý',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `fullname`, `phone`, `address`, `payment`, `total`, `status`, `created_at`) VALUES
(6, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'B4 Nguyễn Ảnh Thủ', 'COD', 0, 'Chờ xử lý', '2026-04-06 12:09:24'),
(7, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'aaaaa', 'COD', 280000, 'Chờ xử lý', '2026-04-06 12:14:15'),
(8, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'qqqqq', 'COD', 312000, 'Chờ xử lý', '2026-04-06 12:55:20'),
(9, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'ádasdasd', 'COD', 240000, 'Chờ xử lý', '2026-04-06 12:56:09'),
(10, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'qqqq', 'COD', 365000, 'Chờ xử lý', '2026-04-06 12:57:15'),
(11, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'fgfgfgfg', 'COD', 275000, 'Chờ xử lý', '2026-04-06 13:01:36'),
(12, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'aaaaa', 'COD', 275000, 'Chờ xử lý', '2026-04-06 17:15:35'),
(13, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'b4', 'COD', 482000, 'Chờ xử lý', '2026-04-06 17:47:44'),
(14, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'b4', 'Chuyển khoản', 375000, 'completed', '2026-04-06 18:12:03'),
(15, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'b4', 'COD', 365000, 'pending', '2026-04-08 16:49:34'),
(16, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'b4', 'COD', 586000, 'shipping', '2026-04-08 19:28:12'),
(17, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'b4', 'COD', 266000, 'shipping', '2026-04-08 19:38:13'),
(18, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'b4', 'COD', 350000, 'Chờ xử lý', '2026-04-08 19:54:43'),
(29, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'b4', 'Chuyển khoản', 476000, 'Hoàn thành', '2026-04-10 19:26:58'),
(30, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'b4', 'COD', 240000, 'Chờ xử lý', '2026-04-10 19:34:18'),
(31, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'b4', 'Chuyển khoản', 522000, 'Chờ xử lý', '2026-04-10 19:46:19'),
(32, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'b4', '', 648000, 'pending', '2026-04-10 20:43:35'),
(33, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'b4', 'COD', 286000, 'Chờ xử lý', '2026-04-10 20:44:12'),
(34, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'b4', 'Chuyển khoản', 612000, 'Đang giao', '2026-04-10 20:46:26'),
(35, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'b4', 'COD', 313000, 'Đang giao', '2026-04-10 20:56:20'),
(36, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'b4', 'COD', 240000, 'Hoàn thành', '2026-04-10 21:01:41'),
(37, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'b4', 'COD', 240000, 'Đã hủy', '2026-04-10 21:06:06'),
(39, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'b4', 'COD', 245000, 'Hoàn thành', '2026-04-11 17:36:02'),
(40, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'b4', 'COD', 1388000, 'Hoàn thành', '2026-04-11 17:40:28'),
(41, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'b4', 'Chuyển khoản', 617000, 'Đã hủy', '2026-04-11 17:52:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `size` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`, `size`) VALUES
(3, 6, 127, 1, 345000, 'XL'),
(4, 6, 126, 1, 245000, 'XL'),
(5, 7, 128, 1, 250000, 'XL'),
(6, 8, 38, 1, 282000, 'XL'),
(7, 9, 88, 1, 210000, 'XL'),
(8, 10, 108, 1, 335000, 'M'),
(9, 11, 126, 1, 245000, 'M'),
(10, 12, 126, 1, 245000, 'M'),
(11, 13, 89, 1, 242000, 'M'),
(12, 13, 88, 1, 210000, 'XL'),
(13, 14, 127, 1, 345000, 'M'),
(14, 15, 108, 1, 335000, 'M'),
(15, 16, 88, 1, 210000, 'M'),
(16, 16, 123, 1, 110000, 'M'),
(17, 16, 87, 1, 236000, 'M'),
(18, 17, 87, 1, 236000, 'M'),
(19, 18, 90, 1, 320000, 'M'),
(34, 29, 88, 1, 210000, 'M'),
(35, 29, 87, 1, 236000, 'M'),
(36, 30, 88, 1, 210000, 'M'),
(37, 31, 88, 1, 210000, 'M'),
(38, 31, 38, 1, 282000, 'M'),
(39, 32, 108, 1, 335000, 'M'),
(40, 32, 18, 1, 283000, 'M'),
(41, 33, 39, 1, 256000, 'M'),
(42, 34, 38, 1, 282000, 'M'),
(43, 34, 40, 1, 300000, 'M'),
(44, 35, 18, 1, 283000, 'M'),
(45, 36, 88, 1, 210000, 'M'),
(46, 37, 88, 1, 210000, 'M'),
(49, 39, 107, 1, 215000, 'M'),
(50, 40, 88, 1, 210000, 'M'),
(51, 40, 87, 3, 236000, 'M'),
(52, 40, 84, 1, 120000, 'M'),
(53, 40, 90, 1, 320000, 'M'),
(54, 41, 127, 1, 345000, 'XL'),
(55, 41, 89, 1, 242000, 'XL');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `ten_sp` varchar(255) NOT NULL,
  `gia` int(11) NOT NULL,
  `gia_cu` int(11) NOT NULL DEFAULT 0,
  `mo_ta` text NOT NULL,
  `so_luong` int(11) NOT NULL,
  `gioi_tinh` tinyint(4) NOT NULL DEFAULT 1,
  `category_id` int(11) NOT NULL,
  `hinh_anh` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `ten_sp`, `gia`, `gia_cu`, `mo_ta`, `so_luong`, `gioi_tinh`, `category_id`, `hinh_anh`) VALUES
(1, 'Quần Tây Nam Ống Suông', 320000, 0, 'Quần tây nam ống suông màu kem, thiết kế xếp ly tôn dáng và thoải mái. Chất vải bền đẹp, giữ form tốt với đai chỉnh hông thanh lịch. Dễ phối đồ, phù hợp đi học, đi chơi hoặc đi làm.', 52, 1, 1, 'quantayongxuongnam.png'),
(2, 'Quần Tây Nam Cạp Cao', 210000, 0, 'Quần tây nam cạp cao ống suông màu nâu tây, thiết kế xếp ly tôn dáng và che khuyết điểm tốt. Chất vải mềm mịn, đứng form, dễ phối đồ, phù hợp đi học, đi chơi hoặc đi làm.', 54, 1, 1, 'quantaycapcaonam.png'),
(3, 'Quần Tây Nam Slim Fit', 264000, 0, 'Quần tây nam slim fit màu ghi xám, form ôm tôn dáng, chất vải co giãn nhẹ và thoải mái. Thiết kế trẻ trung, dễ phối đồ, phù hợp đi học, đi chơi hoặc đi làm.', 72, 1, 1, 'quantaynamslimfit.png'),
(4, 'Quần Tây Nam Co Giãn', 185000, 0, 'Quần tây nam màu kem co giãn, form ôm gọn gàng tôn dáng và thoải mái khi vận động. Chất liệu vải mềm mịn, ít nhăn và bền màu. Thiết kế trẻ trung, dễ phối đồ, phù hợp đi học, đi chơi hoặc đi làm.', 78, 1, 1, 'quantaynamcogian.png'),
(5, 'Quần Tây Nam Xếp Ly', 227000, 0, 'Quần tây nam màu nâu bò, thiết kế xếp ly tôn dáng và che khuyết điểm tốt. Chất vải bền đẹp, đứng form với đai chỉnh hông thanh lịch. Dễ phối đồ, phù hợp đi học, đi chơi hoặc đi làm.', 51, 1, 1, 'quantayxeplynam.png'),
(6, 'Quần Tây Nam Ống Rộng', 230000, 258000, 'Quần tây nam ống rộng màu đen, thiết kế xếp ly thoải mái và tôn dáng. Chất vải mềm mịn, đứng form, dễ phối đồ, phù hợp đi học, đi chơi hoặc đi làm.', 64, 1, 1, 'quantaynamongrong.png'),
(7, 'Quần Tây Nam Lưng Thun', 252000, 0, 'Quần tây nam lưng thun màu đen, ống rộng thoải mái và tôn dáng. Chất vải mềm mịn, đứng form, dễ phối đồ, phù hợp đi học, đi chơi hoặc đi làm.', 90, 1, 1, 'quantaylungthunnam.png'),
(8, 'Quần Tây Nam Hàn Quốc', 294000, 320000, 'Quần tây nam Hàn Quốc màu kem, form dáng trẻ trung và tôn dáng. Chất vải cao cấp, đứng form, dễ phối đồ, phù hợp đi học, đi chơi hoặc đi làm.', 87, 1, 1, 'quantaynamhanquoc.jpg'),
(9, 'Quần Tây Nam Ống Ôm', 241000, 0, 'Quần tây nam ống ôm màu xanh đen, form tôn dáng và trẻ trung. Chất vải cao cấp, đứng form, dễ phối đồ, phù hợp đi học, đi chơi hoặc đi làm.', 90, 1, 1, 'quantaynamongom.png'),
(10, 'Quần Tây Nam Side Tap', 357000, 0, 'Quần tây nam màu ghi xám, thiết kế Side Tab chỉnh hông thanh lịch và xếp ly tôn dáng. Chất vải đứng form, bền đẹp, dễ phối đồ, phù hợp đi học, đi chơi hoặc đi làm.', 53, 1, 1, 'quantaynamsidetap.png'),
(11, 'Quần Tây Nữ Ống Đứng', 332000, 364000, 'Quần tây nữ ống đứng màu xám nhạt, form dáng thanh lịch và tôn dáng. Chất vải đứng form, bền đẹp, dễ phối đồ, phù hợp đi học, đi chơi hoặc đi làm.', 73, 0, 1, 'quantaynuongdung.png'),
(12, 'Quần Tây Nữ Xếp Ly', 275000, 0, 'Quần tây nữ xếp ly màu hồng be, cạp cao ống rộng giúp tôn dáng và che khuyết điểm tốt. Chất vải mềm mại, đứng form, dễ phối đồ, phù hợp đi học, đi chơi hoặc đi làm.', 77, 0, 1, 'quantayxeplynu.png'),
(13, 'Quần Tây Nữ Ống Rộng', 235000, 0, 'Quần tây nữ ống rộng màu xanh đen, thiết kế xếp ly tôn dáng với điểm nhấn thêu ống quần. Chất vải đứng form, dễ phối đồ, phù hợp đi học, đi chơi hoặc đi làm.', 57, 0, 1, 'quantayongrongnu.png'),
(14, 'Quần Tây Nữ Công Sở', 162000, 193000, 'Quần tây nữ công sở màu đen, thiết kế ống rộng thanh lịch và tôn dáng. Chất vải cao cấp, đứng form, ít nhăn, dễ phối đồ, phù hợp đi làm, đi học hoặc đi chơi.', 73, 0, 1, 'quantaynucongso.png'),
(15, 'Quần Tây Nữ Ống Suông', 262000, 0, 'Quần tây nữ ống suông màu rêu, thiết kế cạp cao xếp ly giúp tôn dáng và che khuyết điểm tốt. Chất vải đứng form, mềm mịn, dễ phối đồ, phù hợp đi học, đi chơi hoặc đi làm.', 65, 0, 1, 'quantaynuongsuong.png'),
(16, 'Quần Tây Nữ Ống Loe', 327000, 390000, 'Quần tây nữ ống loe màu kem, thiết kế cạp cao tôn dáng và kéo dài chân hiệu quả. Chất vải cao cấp, đứng form, dễ phối đồ, phù hợp đi học, đi chơi hoặc đi làm.', 65, 0, 1, 'quantaynuongloe.png'),
(17, 'Quần Tây Nữ Ôm', 295000, 0, 'Quần tây nữ ống ôm màu đen, thiết kế xẻ gấu nhẹ tạo điểm nhấn trẻ trung và tôn dáng. Chất vải cao cấp, đứng form, dễ phối đồ, phù hợp đi học, đi chơi hoặc đi làm.', 56, 0, 1, 'quantaynuom.png'),
(18, 'Quần Tây Nữ Baggy', 283000, 323000, 'Quần tây nữ baggy màu đen, cạp cao kèm đai tôn dáng và che khuyết điểm tốt. Chất vải đứng form, dễ phối đồ, phù hợp đi học, đi chơi hoặc đi làm.', 55, 0, 1, 'quantaynubaggy.png'),
(19, 'Quần Tây Nữ Hàn Quốc', 351000, 0, 'Quần tây nữ Hàn Quốc màu đen, form dáng trẻ trung và tôn dáng. Chất vải đứng form, dễ phối đồ, phù hợp đi học, đi chơi hoặc đi làm.', 88, 0, 1, 'quantaynuhanquoc.png'),
(20, 'Quần Tây Nữ Kẻ Sọc', 192000, 0, 'Quần tây nữ kẻ sọc màu xám đậm, thiết kế ống đứng thanh lịch và hiện đại. Chất vải đứng form, ít nhăn, dễ phối đồ, phù hợp đi học, đi chơi hoặc đi làm.', 93, 0, 1, 'quantaynukesoc.png'),
(21, 'Quần Jean Nam Slim Fit', 250000, 300000, 'Quần jean nam slim fit màu xanh denim, form ôm gọn gàng tôn dáng, chất liệu jean bền và thoải mái. Thiết kế trẻ trung, dễ phối với nhiều loại áo, phù hợp đi học, đi chơi hoặc đi làm.', 60, 1, 2, 'quanjeannamslimfit.png'),
(22, 'Quần Jean Nam Wash', 238000, 0, 'Quần jean nam xanh nhạt wash sáng, thiết kế rách gối bụi bặm và trẻ trung. Form ôm tôn dáng, chất denim bền đẹp, phù hợp đi chơi hoặc dạo phố.', 72, 1, 2, 'quanjeanwashnam.png'),
(23, 'Quần Jean Nam Skinny', 365000, 384000, 'Quần jean nam skinny màu xanh đậm, thiết kế mài rách và vẩy sơn tạo phong cách bụi bặm, cá tính. Form ôm tôn dáng, chất denim co giãn thoải mái, phù hợp đi chơi hoặc dạo phố.', 96, 1, 2, 'quanjeanskinnynam.png'),
(24, 'Quần Jean Nam Unisex', 189000, 0, 'Quần jean nam Unisex xanh nhạt wash sáng, thiết kế ống suông rộng rách gối cá tính. Chất denim bền đẹp, dễ phối đồ, phù hợp cho cả nam và nữ đi chơi, dạo phố.', 80, 1, 2, 'quanjeannamunisex.png'),
(25, 'Quần Jean Nam Ống Đứng', 234000, 0, 'Quần jean nam ống đứng màu xanh trung tính, thiết kế wash sáng nhẹ nhàng và hiện đại. Chất denim bền đẹp, form dáng thanh lịch, dễ phối đồ, phù hợp đi học, đi làm hoặc đi chơi.', 96, 1, 2, 'quanjeanongdungnam.png'),
(26, 'Quần Jean Nam Ống Suông', 256000, 280000, 'Quần jean nam ống suông màu xám nhạt, form dáng trẻ trung, hiện đại. Chất denim bền đẹp, dễ phối đồ, phù hợp đi học hoặc đi chơi.', 80, 1, 2, 'quanjeannamongsuong.png'),
(27, 'Quần Jean Nam Dolce', 380000, 0, 'Quần jean nam Dolce màu xanh đen, thiết kế wash sáng và mài xước cá tính. Form ôm tôn dáng, chất denim cao cấp, phù hợp đi chơi hoặc dạo phố.', 75, 1, 2, 'quanjeannamdolce.png'),
(28, 'Quần Jean Nam Rách Gối', 196000, 0, 'Quần jean nam xanh wash, thiết kế rách gối bụi bặm, cá tính. Form ôm tôn dáng, chất denim bền đẹp, phù hợp đi chơi hoặc dạo phố.', 49, 1, 2, 'quanjeannamrachgoi.png'),
(29, 'Quần Jean Nam Baggy', 176000, 198000, 'Quần jean nam baggy xanh nhạt, ống rộng thoải mái và trẻ trung. Chất denim bền đẹp, dễ phối đồ, phù hợp đi học hoặc đi chơi.', 47, 1, 2, 'quanjeannambaggy.png'),
(30, 'Quần Jean Nam DS', 162000, 0, 'Quần jean nam DS màu xanh đen, thiết kế wash sáng và mài xước cá tính. Form ôm tôn dáng, chất denim bền đẹp, phù hợp đi chơi hoặc dạo phố.', 77, 1, 2, 'quanjeannamds.png'),
(31, 'Quần Jean Nữ Ống Loe', 230000, 0, 'Quần jean nữ ống loe màu đen wash, thiết kế cạp cao tôn dáng và kéo dài chân cực đỉnh. Chất denim đứng form, phong cách hiện đại, dễ phối đồ, phù hợp đi chơi hoặc dạo phố.', 71, 0, 2, 'quanongloenu.png'),
(32, 'Quần Jean Nữ Ống Rộng', 230000, 0, 'Quần jean nữ ống rộng màu xanh wash sáng, thiết kế cạp cao tôn dáng và che khuyết điểm chân hiệu quả. Chất denim đứng form, phong cách trẻ trung, phù hợp đi học hoặc dạo phố.', 85, 0, 2, 'quanjeannuongrong.png'),
(33, 'Quần Jean Nữ Ống Đứng', 190000, 0, 'Quần jean nữ ống đứng màu xanh đen trơn, thiết kế thanh lịch và tôn dáng. Chất denim co giãn thoải mái, dễ phối đồ, phù hợp đi học, đi làm hoặc đi chơi.', 51, 0, 2, 'quanjeannuongdung.png'),
(34, 'Quần Jean Nữ Lưng Cao', 320000, 0, 'Quần jean lưng cao màu xanh trung tính, thiết kế ống rộng thời thượng giúp tôn dáng và kéo dài chân. Chất denim đứng form, phù hợp đi học, đi chơi.', 92, 0, 2, 'quanjeanlungcaonu.png'),
(35, 'Quần Jean Nữ Skinny', 350000, 0, 'Quần jean nữ skinny màu xanh đen, thiết kế cạp cao ôm sát tôn dáng cực đỉnh. Chất denim co giãn tốt, thoải mái, dễ phối đồ, phù hợp đi học, đi chơi hoặc dạo phố.', 67, 0, 2, 'quanjeanskinnynu.png'),
(36, 'Quần Jean Nữ Ống Suông', 290000, 0, 'Quần jean nữ ống suông xanh nhạt, wash sáng trẻ trung. Form rộng thoải mái, tôn dáng, dễ phối đồ, phù hợp đi học hoặc dạo phố.', 70, 0, 2, 'quanjeannuongsuong.png'),
(37, 'Quần Jean Nữ Rách Gối', 220000, 0, 'Quần jean nữ rách gối, xanh wash bụi bặm. Form ôm skinny tôn dáng, chất denim co giãn, cá tính, dễ phối đồ, phù hợp đi học hoặc dạo phố.', 76, 0, 2, 'quanjeannurachgoi.png'),
(38, 'Quần Jean Nữ Wash', 282000, 0, 'Quần jean nữ wash vàng rách gối, ống suông rộng cực chất. Thiết kế bụi bặm, phong cách thời thượng, phù hợp đi chơi, dạo phố.', 67, 0, 2, 'quanjeannuwash.png'),
(39, 'Quần Jean Nữ Slim Fit', 256000, 0, 'Quần jean nữ slim fit màu xanh đen, thiết kế ôm vừa vặn tôn dáng thanh lịch. Chất denim co giãn thoải mái, dễ phối đồ, phù hợp đi học, đi làm hoặc dạo phố.', 49, 0, 2, 'quanjeannuslimfit.png'),
(40, 'Quần Jean Nữ Baggy', 300000, 340000, 'Quần jean nữ baggy màu đen trơn, ống rộng thoải mái và trẻ trung. Chất denim đứng form, che khuyết điểm tốt, dễ phối đồ, phù hợp đi học hoặc dạo phố.', 49, 0, 2, 'quanjeannubaggy.png'),
(41, 'Quần Kaki Nam Uniqlo', 200000, 0, 'Quần kaki nam Uniqlo màu xanh rêu, thiết kế ống đứng lịch lãm và hiện đại. Chất vải kaki cao cấp, bền đẹp, giữ form tốt, phù hợp đi làm, đi học hoặc dạo phố.', 84, 1, 3, 'QuanKakiNamUniqlo.png'),
(42, 'Quần Kaki Nam Ống Suông', 180000, 0, 'Quần kaki nam ống suông màu đen, thiết kế trẻ trung và thoải mái. Chất vải kaki bền đẹp, đứng form, dễ dàng phối đồ, phù hợp cho đi học, đi làm hoặc dạo phố.', 79, 1, 3, 'quankakinamongsuong.png'),
(43, 'Quần Kaki Nam Ống Rộng', 185000, 0, 'Quần kaki nam ống rộng màu trắng, thiết kế trẻ trung, ống suông thoải mái. Chất vải kaki đứng form, dễ phối đồ, phù hợp đi học hoặc dạo phố.', 72, 1, 3, 'quankakinamongrong.png'),
(44, 'Quần Kaki Nam Ống Ôm', 168000, 0, 'Quần kaki nam ống ôm màu be trung tính, thiết kế trẻ trung và tôn dáng. Chất vải bền đẹp, co giãn nhẹ, phù hợp đi học, đi làm hoặc dạo phố.', 85, 1, 3, 'quankakinamongom.png'),
(45, 'Quần Kaki Nam Baggy', 126000, 149000, 'Quần kaki nam baggy màu cam đất, thiết kế ống rộng thoải mái và năng động. Chất vải kaki bền đẹp, lưng thun co giãn, phù hợp đi chơi, dạo phố hoặc mặc ở nhà.', 56, 1, 3, 'quankakinambaggy.png'),
(46, 'Quần Kaki Nam Jogger', 138000, 148000, 'Quần kaki nam jogger màu xám sáng, thiết kế bo gấu trẻ trung và năng động. Chất vải kaki bền đẹp, lưng thun thoải mái, phù hợp đi chơi, tập thể thao hoặc dạo phố.', 51, 1, 3, 'quankakinamjogger.png'),
(47, 'Quần Kaki Nam Túi Hộp', 144000, 0, 'Quần kaki nam túi hộp đen, phong cách cargo bụi bặm và năng động. Chất vải dày dặn, nhiều túi tiện dụng, phù hợp đi chơi hoặc dạo phố.', 78, 1, 3, 'quankakituihopnam.png'),
(48, 'Quần Kaki Nam Công Sở', 109000, 0, 'Quần kaki nam công sở màu xanh navy, thiết kế ống ôm thanh lịch. Chất vải cao cấp, đứng form, phù hợp đi làm, đi học hoặc các sự kiện trang trọng.', 84, 1, 3, 'quankakinamcongso.png'),
(49, 'Quần Kaki Nam Basic', 125000, 0, 'Quần kaki nam basic màu xám xanh, thiết kế ống ôm nhẹ thanh lịch. Chất vải bền đẹp, dễ phối đồ, phù hợp đi học, đi làm hoặc dạo phố.', 73, 1, 3, 'quankakinambasic.png'),
(50, 'Quần Kaki Nam Dobby', 285000, 0, 'Quần kaki nam dobby màu kem sáng, chất vải có bề mặt đanh mịn, đứng form. Thiết kế ống suông thanh lịch, dễ phối đồ, phù hợp đi học, đi làm hoặc dạo phố.', 51, 1, 3, 'quankakinamdobby.png'),
(51, 'Quần Kaki Nữ Lưng Cao', 172000, 0, 'Quần kaki nữ lưng cao xanh đen, form ống rộng thời thượng. Thiết kế tôn dáng, che khuyết điểm tốt, phù hợp đi học, đi làm hoặc dạo phố.', 68, 0, 3, 'quankakinulungcao.png'),
(52, 'Quần Kaki Nữ Túi Hộp', 134000, 0, 'Quần kaki nữ túi hộp màu đen, thiết kế cargo năng động với nhiều túi tiện dụng. Chất vải kaki dày dặn, đứng form, mang đến phong cách cá tính, phù hợp đi chơi hoặc dạo phố.', 84, 0, 3, 'quankakinukakituihop.png'),
(53, 'Quần Kaki Nữ Xếp Ly', 245000, 0, 'Quần kaki nữ xếp ly màu kem, thiết kế ống rộng thời thượng với điểm nhấn xếp ly tinh tế. Chất vải kaki đứng form, tôn dáng, phù hợp đi học, đi làm hoặc dạo phố.', 75, 0, 3, 'quankakinuxeply.png'),
(54, 'Quần Kaki Nữ Ống Đứng', 195000, 234000, 'Quần kaki nữ ống đứng màu hồng nhạt, thiết kế trẻ trung và thanh lịch. Chất vải kaki bền đẹp, giữ form tốt, giúp tôn dáng người mặc, phù hợp đi học, đi chơi hoặc dạo phố.', 62, 0, 3, 'quankakinuongdung.png'),
(55, 'Quần Kaki Nữ Jogger', 243000, 0, 'Quần kaki nữ jogger màu xanh lá đậm, thiết kế bo gấu trẻ trung và năng động. Chất vải kaki bền đẹp, lưng thun co giãn thoải mái, phù hợp đi chơi, tập thể thao hoặc dạo phố.', 73, 0, 3, 'quankakinujogger.png'),
(56, 'Quần Kaki Nữ Baggy', 185000, 0, 'Quần kaki nữ baggy màu đen trơn, thiết kế ống rộng thoải mái và trẻ trung. Chất vải kaki đứng form, che khuyết điểm tốt, dễ dàng phối đồ, phù hợp đi học, đi làm hoặc dạo phố.', 61, 0, 3, 'quankakinubaggy.png'),
(57, 'Quần Kaki Nữ Ống Ôm', 168000, 0, 'Quần kaki nữ ống ôm màu xám nhạt, thiết kế trẻ trung và tôn dáng. Chất vải co giãn nhẹ, đứng form, phù hợp đi học, đi làm hoặc dạo phố.', 69, 0, 3, 'quankakinuongom.png'),
(58, 'Quần Kaki Nữ Basic', 112000, 0, 'Quần kaki nữ basic màu be, thiết kế ống suông nhẹ nhàng và thanh lịch. Chất vải kaki đứng form, dễ phối đồ, phù hợp đi học, đi làm hoặc dạo phố.', 73, 0, 3, 'quankakinubasic.png'),
(59, 'Quần Kaki Nữ Col Thụng', 169000, 0, 'Quần kaki nữ dáng thụng màu cam đất, thiết kế trẻ trung và thoải mái. Chất vải kaki bền đẹp, đứng form, che khuyết điểm tốt, phù hợp đi học, đi chơi hoặc dạo phố.', 57, 0, 3, 'quankakinucolthung.png'),
(60, 'Quần Kaki Nữ Lưng Thun', 246000, 300000, 'Quần kaki nữ màu xanh rêu, thiết kế lưng Thun tôn dáng và ống rộng thoải mái. Chất vải kaki dày dặn, đứng form, phù hợp đi học, đi chơi hoặc dạo phố.', 80, 0, 3, 'quankakinulungthun.png'),
(61, 'Quần Short Nam Tây', 140000, 170000, 'Quần short nam tây màu xám đậm, thiết kế xếp ly thanh lịch và trẻ trung. Chất vải đanh mịn, đứng form, chiều dài ngang đùi thoải mái, phù hợp đi chơi, dạo phố hoặc mặc hàng ngày.', 72, 1, 4, 'quanshorttaynam.png'),
(62, 'Quần Short Nam Denim', 235000, 0, 'Quần short nam denim màu xanh đậm, thiết kế mài bạc và rách gối cá tính. Chất vải jean dày dặn, bền đẹp, phong cách bụi bặm và năng động, phù hợp đi chơi, dạo phố hoặc dã ngoại.', 64, 1, 4, 'quanshortnamdenim.png'),
(63, 'Quần Short Nam Túi Hộp', 160000, 0, 'Quần short nam túi hộp màu đen, thiết kế phong cách cargo năng động với hai túi hộp bên hông tiện dụng. Chất vải dày dặn, phù hợp cho các hoạt động dã ngoại hoặc dạo phố.', 80, 1, 4, 'quanshorttuihopnam.png'),
(64, 'Quần Short Nam Kaki', 220000, 0, 'Quần short nam kaki màu xanh than, thiết kế lưng thun có dây rút mang lại sự thoải mái tối đa. Chất vải kaki mềm mịn, bền màu, kiểu dáng trẻ trung, phù hợp mặc nhà, đi chơi hoặc tập thể thao.', 90, 1, 4, 'quanshortkakinam.png'),
(65, 'Quần Short Nam Đi Biển', 124000, 0, 'Quần short nam đi biển họa tiết lá xanh nhiệt đới, thiết kế lưng thun dây rút thoải mái. Chất vải nhẹ, nhanh khô, mang lại vẻ ngoài năng động, phù hợp cho các chuyến du lịch biển.', 80, 1, 4, 'quanshortnamdibien.png'),
(66, 'Quần Short Nam Thể Thao', 229000, 253000, 'Quần short nam thể thao màu đen, thiết kế lưng thun dây rút và họa tiết kẻ sọc năng động. Chất vải nhẹ, thoáng khí, phù hợp cho việc tập luyện hoặc mặc hàng ngày.', 73, 1, 4, 'quanshortthethaonam.png'),
(67, 'Quần Short Nam Vải Dù', 212000, 0, 'Quần short nam vải dù màu xanh rêu, thiết kế lưng thun thoải mái và năng động. Chất vải dù nhẹ, bền, ít nhăn, phù hợp cho các hoạt động thể thao, dã ngoại hoặc mặc ở nhà hàng ngày.', 66, 1, 4, 'quanshortnamvaidu.png'),
(68, 'Quần Short Nam Nỉ', 140000, 0, 'Quần short nam nỉ màu xanh rêu, thiết kế lưng thun dây rút mang lại sự thoải mái Chất vải nỉ mềm mại, giữ ấm nhẹ, phong cách năng động, phù hợp mặc nhà, đi chơi hoặc tập thể thao.', 96, 1, 4, 'quanshortninam.png'),
(69, 'Quần Short Nam Thun', 135000, 0, 'Quần short nam thun màu đen, thiết kế lưng thun dây rút thoải mái. Chất vải co giãn, thấm hút mồ hôi, phù hợp mặc nhà hoặc tập thể thao.', 73, 1, 4, 'quanshortnamthun.png'),
(70, 'Quần Short Nam Lưng Thun', 228000, 0, 'Quần short nam lưng thun màu xám khói, thiết kế dây rút thoải mái. Chất vải jean bền đẹp, phong cách trẻ trung, phù hợp dạo phố hoặc mặc hàng ngày.', 88, 1, 4, 'quanshortlungthunnam.png'),
(71, 'Quần Short Nữ Jean', 186000, 0, 'Quần short nữ jean màu xanh nhạt, thiết kế mài bạc trẻ trung và năng động. Chất vải denim bền đẹp, form dáng thoải mái, phù hợp cho dạo phố hoặc đi chơi.', 50, 0, 4, 'quanshortjeannu.png'),
(72, 'Quần Short Nữ Cạp Thun', 136000, 0, 'Quần short nữ cạp thun màu nâu, thiết kế dáng rộng thoải mái với túi hộp cách điệu. Chất vải đứng form, trẻ trung, phù hợp mặc nhà hoặc dạo phố.', 67, 0, 4, 'quanshortnucapthun.png'),
(73, 'Quần Short Nữ Giả Váy', 231000, 0, 'Quần short nữ giả váy màu đen, thiết kế xếp ly xòe điệu đà và nữ tính. Chất vải dày dặn, đứng form, phù hợp mặc đi làm, đi chơi hoặc dự tiệc.', 78, 0, 4, 'quanshortnugiavay.png'),
(74, 'Quần Short Nữ Baggy', 148000, 0, 'Quần short nữ dáng baggy màu xanh mài, thiết kế ống rộng . Chất vải denim dày dặn, bền đẹp, phong cách cá tính, dễ dàng phối đồ để dạo phố hoặc đi chơi.', 84, 0, 4, 'quanshortbaggynu.png'),
(75, 'Quần Short Jean Nữ Ôm', 186000, 0, 'Quần short nữ jean ôm màu xám khói, thiết kế rách gấu và mài bạc cá tính. Chất vải denim co giãn nhẹ, tôn dáng, mang lại vẻ ngoài năng động và sành điệu cho phái nữ.', 48, 0, 4, 'quanshortjeanomnu.png'),
(76, 'Quần Short Nữ Kaki', 244000, 0, 'Quần short nữ kaki màu đen, thiết kế cạp cao tôn dáng và trẻ trung. Chất vải kaki dày dặn, đứng form, dễ dàng phối hợp với nhiều loại trang phục để dạo phố hoặc đi chơi.', 75, 0, 4, 'quanshortkakinu.png'),
(77, 'Quần Short Nữ Ren', 263000, 0, 'Quần short nữ ren màu đen, thiết kế phối tầng điệu đà cùng nơ thắt xinh xắn. Chất vải ren mềm mại, mang lại vẻ ngoài nữ tính và quyến rũ, phù hợp mặc nhà.', 76, 0, 4, 'quanshortrennu.png'),
(78, 'Quần Short Nữ Ống Rộng', 272000, 0, 'Quần short nữ ống rộng màu đen, thiết kế xếp ly thanh lịch và hiện đại. Chất vải mềm mịn, đứng form, phù hợp để phối đồ đi làm, đi chơi hoặc dạo phố.', 82, 0, 4, 'quanshortongrongnu.png'),
(79, 'Quần Short Nữ Lưng Thun', 227000, 0, 'Quần short nữ lưng thun màu hồng pastel, chất vải đũi nhăn nhẹ nhàng và thoáng mát. Thiết kế cạp thun co giãn thoải mái, phù hợp mặc nhà hoặc đi dạo phố.', 91, 0, 4, 'quanshortlungthunnu.png'),
(80, 'Quần Short Nữ Thể Thao', 133000, 150000, 'Quần short nữ thể thao màu hồng, thiết kế lưng thun co giãn và xẻ hông năng động. Chất vải nhẹ, thoáng khí, hỗ trợ vận động tối ưu, phù hợp cho việc tập gym, chạy bộ hoặc yoga.', 64, 0, 4, 'quanshortthethaonu.png'),
(81, 'Áo Polo Nam Slim Fit', 150000, 190000, 'Áo polo nam slim fit màu xanh đen, thiết kế cổ bẻ thanh lịch với logo thêu nổi bật. Chất vải thun cá sấu co giãn, ôm dáng nhẹ nhàng, phù hợp mặc đi làm hoặc đi chơi.', 75, 1, 5, 'aolonamslimfit.png'),
(82, 'Áo Polo Nam Cổ V', 150000, 0, 'Áo polo nam cổ V màu trắng, thiết kế bo cổ và tay áo phối sọc màu trẻ trung. Chất vải thun co giãn, thoáng mát, mang lại phong cách năng động và lịch sự cho người mặc.', 49, 1, 5, 'aopolocoV.png'),
(83, 'Áo Polo Nam Thun', 125000, 0, 'Áo polo nam thun đen, thiết kế cổ bẻ phối sọc cam nổi bật. Chất vải co giãn, thấm hút mồ hôi, mang lại vẻ ngoài năng động và nam tính.', 77, 1, 5, 'aopolonamthun.png'),
(84, 'Áo Polo Nam Basic', 120000, 150000, 'Áo polo nam basic màu xám nhạt, thiết kế cổ bẻ và bo tay phối viền đen tinh tế. Chất vải thun cá sấu bền đẹp, thoáng mát, mang lại phong cách lịch sự và trẻ trung.', 71, 1, 5, 'aopolobasicnam.png'),
(85, 'Áo Polo Nam Tay Lỡ', 115000, 0, 'Áo polo nam tay lỡ màu đen, thiết kế form rộng hiện đại với cổ bẻ thanh lịch. Chất vải dày dặn, thoáng mát, mang lại phong cách trẻ trung và thoải mái cho người mặc.', 93, 1, 5, 'aopolotaylonam.png'),
(86, 'Áo Polo Nam Unisex', 220000, 0, 'Áo polo nam unisex phối màu trắng đen, thiết kế tay raglan và cổ bẻ trẻ trung. Chất vải thun thoáng mát, form dáng thoải mái, dễ dàng phối đồ theo phong cách năng động và cá tính.', 77, 1, 5, 'aopolounisex.png'),
(87, 'Áo Polo Nam Vải Gân', 236000, 0, 'Áo polo nam vải gân màu xanh xám, thiết kế cổ bẻ và bo tay phối màu xanh navy nổi bật. Chất vải gân dày dặn, thoáng mát, mang lại phong cách hiện đại và thanh lịch.', 72, 1, 5, 'aopolonamvaigan.png'),
(88, 'Áo Polo Nam Kẻ Sọc', 210000, 0, 'Áo polo nam kẻ sọc ngang trắng đen, thiết kế cổ bẻ trơn màu xanh navy và họa tiết thêu nhỏ  Chất vải thun thoáng mát, form dáng thoải mái, mang lại phong cách trẻ trung và năng động.', 47, 1, 5, 'aopolokesocnam.png'),
(89, 'Áo Polo Nam Color Block', 242000, 0, 'Áo polo nam phối màu (color block) xanh navy, trắng và đỏ đô, thiết kế cổ bẻ cùng logo thêu tinh tế. Chất vải thun cá sấu bền đẹp, form dáng trẻ trung, tạo điểm nhấn cá tính.', 66, 1, 5, 'aopolocolorblock.png'),
(90, 'Áo Polo Nam Burberry', 320000, 342000, 'Áo polo nam Burberry màu đen, thiết kế cổ bẻ phối họa tiết kẻ ô đặc trưng của thương hiệu. Chất vải thun cao cấp, form dáng chuẩn, mang lại vẻ ngoài sang trọng và đẳng cấp.', 78, 1, 5, 'aopolonamburberry.png'),
(91, 'Áo Sơ Mi Nam Regular Fit', 300000, 0, 'Áo sơ mi nam regular fit màu xanh xám, thiết kế tay dài thanh lịch có túi ngực. Form dáng suông thoải mái, phù hợp cho môi trường công sở hoặc sự kiện.', 95, 1, 6, 'aosominamregularfit.png'),
(92, 'Áo Sơ Mi Nam Slim Fit', 120000, 0, 'Áo sơ mi nam slim fit màu kem, thiết kế tay dài với form ôm dáng vừa vặn và logo thêu ngực tinh tế. Chất vải cao cấp, ít nhăn, mang lại vẻ ngoài lịch lãm và trẻ trung.', 77, 1, 6, 'aosominamslimfit.png'),
(93, 'Áo Sơ Mi Nam Trắng', 250000, 0, 'Áo sơ mi nam màu trắng, thiết kế tay dài cổ điển với form dáng thanh lịch. Chất vải mềm mịn, thoáng mát, dễ dàng kết hợp cùng quần tây hoặc jean.', 91, 1, 6, 'aosomitrangnam.png'),
(94, 'Áo Sơ Mi Nam Caro', 320000, 0, 'Áo sơ mi nam kẻ caro tone màu xám đen trung tính, thiết kế tay dài với form dáng rộng rãi, thoải mái. Chất vải cotton bền đẹp, mang lại phong cách trẻ trung và bụi bặm.', 49, 1, 6, 'aosomicaronam.png'),
(95, 'Áo Sơ Mi Nam Oxford', 260000, 0, 'Áo sơ mi nam Oxford màu xanh nhạt, thiết kế tay dài với form dáng chỉn chu. Chất vải dày dặn, thoáng mát, mang lại phong cách thanh lịch và hiện đại.', 69, 1, 6, 'aosomioxfordnam.png'),
(96, 'Áo Sơ Mi Nam Linen', 220000, 0, 'Áo sơ mi nam linen màu be, thiết kế tay dài với form dáng suông thoải mái và túi ngực tiện lợi. Chất vải linen mộc mạc, thoáng khí và thấm hút tốt, mang lại vẻ ngoài lãng tử và nhẹ nhàng.', 65, 1, 6, 'aosomilinennam.png'),
(97, 'Áo Sơ Mi Nam Họa Tiết', 270000, 0, 'Áo sơ mi nam họa tiết ngắn tay với hoa văn trừu tượng tinh tế. Chất vải nhẹ, thoáng mát, mang lại phong cách hiện đại và trẻ trung cho các buổi dạo phố.', 75, 1, 6, 'aosomihoatietnam.png'),
(98, 'Áo Sơ Mi Nam Flannel', 350000, 0, 'Áo sơ mi nam flannel kẻ caro đỏ đen, thiết kế tay dài với túi ngực tiện lợi. Chất vải dày dặn, giữ ấm tốt, mang lại phong cách trẻ trung, bụi bặm và năng động.', 55, 1, 6, 'aosomiflannelnam.png'),
(99, 'Áo Sơ Mi Nam Kẻ Sọc', 210000, 0, 'Áo sơ mi nam kẻ sọc dọc đen trắng, thiết kế tay dài với điểm nhấn băng kẻ sọc màu ở bắp tay. Form dáng chỉn chu, chất vải bền đẹp, mang lại phong cách hiện đại và lịch lãm.', 70, 1, 6, 'aosomikesocnam.png'),
(100, 'Áo Sơ Mi Nam Denim', 245000, 0, 'Áo sơ mi nam denim màu xanh đậm, thiết kế tay dài với túi ngực tiện lợi. Chất vải denim dày dặn, bền đẹp, mang lại phong cách bụi bặm, khỏe khoắn và đầy nam tính.', 97, 1, 6, 'aosomidenimnam.png'),
(101, 'Áo Sơ Mi Nữ Cổ V', 170000, 0, 'Áo sơ mi nữ màu trắng, thiết kế cổ V cách điệu với chi tiết xếp ly dọc tinh tế và hàng nút bọc nhỏ nhắn. Chất vải mềm nhẹ, tay dài bo thun, mang lại vẻ ngoài thanh lịch, dịu dàng cho phái đẹp.', 52, 0, 6, 'aosominucoV.png'),
(102, 'Áo Sơ Mi Nữ Denim', 210000, 0, 'Áo sơ mi nữ denim màu xanh đậm, thiết kế ngắn tay với túi ngực tiện dụng. Chất vải denim bền đẹp, form dáng rộng rãi, mang lại phong cách trẻ trung, năng động và cá tính.', 55, 0, 6, 'aosomidenimnu.png'),
(103, 'Áo Sơ Mi Nữ Crop Top', 115000, 0, 'Áo sơ mi nữ kiểu dáng crop top màu hồng phấn, thiết kế tay dài thanh lịch với họa tiết thêu chữ trước ngực. Form dáng ngắn trẻ trung, hiện đại.', 85, 0, 6, 'aosominucroptop.png'),
(104, 'Áo Sơ Mi Nữ Trắng', 125000, 0, 'Áo sơ mi nữ trắng ngắn tay với form dáng ôm nhẹ thanh lịch. Chất vải mềm mịn, thoáng mát, mang lại vẻ ngoài chuyên nghiệp và trẻ trung.', 90, 0, 6, 'aosomitrangnu.png'),
(105, 'Áo Sơ Mi Nữ Tay Phồng', 240000, 0, 'Áo sơ mi nữ màu xanh ghi, thiết kế tay phồng cổ điển với điểm nhấn bo cổ tay điệu đà. Form dáng rộng thoải mái, chất vải mềm mại, mang lại vẻ ngoài thanh lịch và nữ tính.', 48, 0, 6, 'aosomitayphong.png'),
(106, 'Áo Sơ Mi Nữ Họa Tiết', 247000, 0, 'Áo sơ mi nữ họa tiết hoa hồng lãng tử trên nền vải sáng màu, thiết kế tay dài thanh lịch. Chất vải voan hoặc lụa mềm nhẹ, bay bổng, mang lại vẻ ngoài dịu dàng và đầy nữ tính.', 68, 0, 6, 'aosomihoatietnu.png'),
(107, 'Áo Sơ Mi Nữ Chấm Bi', 215000, 0, 'Áo sơ mi nữ trắng họa tiết chấm bi đen, thiết kế ngắn tay trẻ trung. Form dáng suông vừa vặn, chất vải nhẹ mát, mang lại phong cách cổ điển và thanh lịch.', 47, 0, 6, 'aosomichambinu.png'),
(108, 'Áo Sơ Mi Nữ Lụa', 335000, 0, 'Áo sơ mi nữ lụa màu tím nhạt, thiết kế bèo nhún dọc thân áo và tay loe điệu đà. Chất lụa bóng nhẹ, mềm mại, mang lại vẻ ngoài sang trọng, quý phái và nữ tính.', 55, 0, 6, 'aosomiluanu.png'),
(109, 'Áo Sơ Mi Nữ Form Rộng', 110000, 140000, 'Áo sơ mi nữ màu trắng với thiết kế form rộng (oversize) trẻ trung. Chất vải mềm nhẹ, thoáng mát, mang lại cảm giác thoải mái và phong cách hiện đại, năng động.', 82, 0, 6, 'aosomioversizenu.png'),
(110, 'Áo Sơ Mi Nữ Chiết Eo', 285000, 312000, 'Áo sơ mi nữ màu xanh xám với thiết kế chiết eo bằng dây rút độc đáo, tạo điểm nhấn tôn dáng. Form áo hiện đại, có túi ngực tiện lợi, mang lại vẻ ngoài trẻ trung và cá tính.', 49, 0, 6, 'aosomichieteo.png'),
(111, 'Áo Khoác Nam Bomber', 340000, 480000, 'Áo khoác nam bomber màu xanh đen với thiết kế bo thun cổ tay và gấu áo đặc trưng. Kiểu dáng năng động, chất vải bền đẹp, phù hợp cho phong cách trẻ trung và mạnh mẽ.', 76, 1, 7, 'aokhoacbombernam.png'),
(112, 'Áo Khoác Nam Blazer', 290000, 0, 'Áo khoác nam blazer màu be với thiết kế cổ bẻ cổ điển và hai hàng nút thanh lịch. Form dáng trẻ trung, tích hợp túi ốp tiện lợi, mang lại vẻ ngoài lịch sự và hiện đại cho các quý ông.', 53, 1, 7, 'aokhoacblazernam.png'),
(113, 'Áo Khoác Nam Hoodie', 176000, 0, 'Áo khoác nam hoodie màu đen với thiết kế khóa kéo (zip) tiện lợi và mũ trùm đầu năng động. Chất vải nỉ dày dặn, ấm áp, mang lại phong cách thể thao, trẻ trung và cá tính.', 72, 1, 7, 'aohoodienam.png'),
(114, 'Áo Khoác Nam Gió', 118000, 138000, 'Áo khoác gió nam màu xanh rêu với thiết kế mũ trùm đầu và khóa kéo tiện lợi. Chất vải dù cao cấp có khả năng cản gió, chống thấm nhẹ, mang lại phong cách thể thao và năng động.', 88, 1, 7, 'aokhoacgionam.png'),
(115, 'Áo Khoác Nam Uniqlo', 285000, 297000, 'Áo khoác nam Uniqlo màu đen với thiết kế mũ trùm và khóa kéo chống thấm nước. Chất liệu siêu nhẹ, giữ nhiệt tối ưu, mang lại phong cách hiện đại và sự ấm áp tuyệt đối.', 97, 1, 7, 'aokhoacnamuniqlo.png'),
(116, 'Áo Khoác Nam Da', 376000, 0, 'Áo khoác da nam đen phong cách Biker mạnh mẽ với thiết kế cổ bẻ rộng và khóa kéo chéo. Chất liệu da bền bỉ, phối chi tiết kim loại cá tính và thời thượng.', 81, 1, 7, 'aokhoacdanam.png'),
(117, 'Áo Khoác Nam Thể Thao', 246000, 0, 'Áo khoác thể thao nam màu xanh navy phối sọc trắng năng động. Thiết kế cổ đứng, khóa kéo chắc chắn với chất vải co giãn, thoáng mát, mang lại vẻ ngoài khỏe khoắn.', 50, 1, 7, 'aokhoacthethaonam.png'),
(118, 'Áo Khoác Nam Trench Coat', 247000, 0, 'Áo khoác Trench Coat nam màu be với thiết kế hai hàng khuy cổ điển và đai thắt ngang eo thanh lịch. Kiểu dáng dài thời thượng, mang lại vẻ ngoài lịch lãm và sang trọng.', 48, 1, 7, 'aokhoactrenchcoatnam.png'),
(119, 'Áo Khoác Nam Jean', 280000, 0, 'Áo khoác Jean nam màu xám đen với thiết kế túi ngực và hàng nút cài cổ điển. Chất liệu denim dày dặn, bền bỉ, mang lại phong cách bụi bặm, khỏe khoắn và cực kỳ nam tính.', 92, 1, 7, 'aokhoacjeannam.png'),
(120, 'Áo Khoác Nam Phao', 140000, 0, 'Áo khoác phao nam màu xám chì phối lót trắng tương phản, thiết kế mũ trùm đầu ấm áp. Điểm nhấn sọc trắng chạy dọc ống tay tạo phong cách thể thao, năng động và trẻ trung.', 92, 1, 7, 'aokhoacphaonam.png'),
(121, 'Áo Khoác Nữ Cardigan', 105000, 0, 'Áo khoác cardigan nữ màu nâu be với thiết kế cổ chữ V và hàng nút cài thanh lịch. Chất liệu len gân mềm mại, form dáng ôm vừa vặn, mang lại vẻ ngoài nhẹ nhàng, nữ tính và ấm áp.', 91, 0, 7, 'aokhoaccardigan.png'),
(122, 'Áo Khoác Nữ Blazer', 274000, 0, 'Áo khoác blazer nữ màu nâu tây với thiết kế cổ bẻ thanh lịch và hàng nút cài tinh tế. Form dáng hiện đại, đường may sắc sảo, mang lại vẻ ngoài chuyên nghiệp, sang trọng và thời thượng.', 55, 0, 7, 'aokhoacblazernu.png'),
(123, 'Áo Khoác Nữ Hoodie', 110000, 0, 'Áo khoác hoodie nữ màu xanh bơ nhạt với thiết kế khóa kéo tiện lợi và mũ trùm đầu trẻ trung. Chất vải nỉ mềm mại, form dáng rộng rãi mang lại cảm giác thoải mái, năng động và dễ thương.', 79, 0, 7, 'aohoodienu.png'),
(124, 'Áo Khoác Nữ Gió', 104000, 0, 'Áo khoác gió nữ màu hồng nhạt với thiết kế mũ trùm đầu và khóa kéo tiện lợi. Chất vải dù mỏng nhẹ, có khả năng cản gió và chống thấm nhẹ, mang lại phong cách trẻ trung, năng động .', 68, 0, 7, 'aokhoacgionu.png'),
(125, 'Áo Khoác Nữ Len', 224000, 0, 'Áo khoác len nữ màu nâu nhạt với thiết kế cổ chữ V và hàng nút cài gỗ cổ điển. Chất liệu len dày dặn, ấm áp phối túi ốp hai bên tiện lợi, mang lại vẻ ngoài nhẹ nhàng, thanh lịch và gần gũi.', 87, 0, 7, 'aokhoaclennu.png'),
(126, 'Áo Khoác Dạ Nữ', 245000, 0, 'Áo khoác dạ nữ màu nâu bò với thiết kế mũ trùm lót lông cừu ấm áp và hàng nút cài tròn bọc vải đồng màu. Điểm nhấn họa tiết trái tim, quả bông trắng và chi tiết thắt dây nơ xinh xắn.', 93, 0, 7, 'aokhoacdanu.png'),
(127, 'Áo Khoác Nữ Măng Tô', 345000, 0, 'Áo măng tô nữ màu kem thanh lịch với thiết kế cổ bẻ phối màu và hàng khuy kép cổ điển. Kiểu dáng dài thời thượng, thắt đai eo tinh tế, mang lại vẻ ngoài sang trọng và hiện đại.', 77, 0, 7, 'aokhoacmangtonu.png'),
(128, 'Áo Khoác Nữ Tweed', 250000, 0, 'Áo khoác dạ tweed nữ màu xám sang trọng với điểm nhấn viền đen ở cổ và cổ tay. Thiết kế dáng ngắn thanh lịch, kết hợp hàng nút vàng nổi bật, mang lại vẻ ngoài quý phái và thời thượng.', 74, 0, 7, 'aokhoactweednu.png'),
(129, 'Áo Khoác Nữ Phao', 210000, 0, 'Áo khoác phao nữ màu đen với thiết kế mũ trùm và khóa kéo chắc chắn. Chất liệu phao dày dặn, giữ nhiệt tốt cùng form dáng bồng bềnh, mang lại vẻ ngoài ấm áp, hiện đại và trẻ trung.', 85, 0, 7, 'aokhoacphaonu.png'),
(130, 'Áo Khoác Nữ Lông', 360000, 400000, 'Áo khoác lông nữ màu xanh rêu đậm với thiết kế cổ cao và khóa kéo đồng màu. Chất liệu lông cừu nhân tạo mềm mịn, giữ ấm tốt, mang lại vẻ ngoài trẻ trung, ấm áp và vô cùng thoải mái.', 86, 0, 7, 'aokhoaclongnu.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT 5,
  `comment` text DEFAULT NULL,
  `shop_reply` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `rating`, `comment`, `shop_reply`, `created_at`) VALUES
(8, 88, 25, 4, 'Sản phẩm này khá tốt', 'Cảm ơn bạn đã phản hồi ', '2026-04-09 09:25:52'),
(9, 90, 25, 4, 'Sản phẩm ổn ', NULL, '2026-04-09 17:42:17'),
(10, 127, 25, 4, 'Sản phẩm ổn, còn nhiều chỉ thừa', 'aaaa', '2026-04-10 02:35:17'),
(11, 12, 25, 4, 'Sản phẩm tốt còn nhiều chỉ thừa', 'Cảm ơn bạn đã mua sản phẩm bên mình, xin lỗi về việc trải nghiệm sử dụng sản phẩm chưa tốt', '2026-04-10 02:37:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `fullname`, `email`, `gender`, `phone`, `password`, `created_at`) VALUES
(22, 'NQT', 'nguyenquangtrung004@gmail.com', 'Nam', '0792112370', 'NQT123', '2026-04-03 11:21:20'),
(23, 'Nguyễn Quốc Trưởng', 'qtr29@gmail.com', 'Nam', '0123456789', 'qtr29@', '2026-04-03 16:58:55'),
(25, 'Nguyễn Trưởng', 'quoctruong29@gmail.com', 'Nam', '0388228192', 'truongbao123', '2026-04-03 22:31:47'),
(26, 'Lê Anh', 'lethingocanh@gmail.com', 'Nữ', '0961611081', 'ngocanh123', '2026-04-04 00:46:55'),
(27, 'Nguyễn trung', 'nqt@gmail.com', 'Nam', '0352493970', 'trung7474', '2026-04-10 08:48:56'),
(28, 'Nguyen Truong', 'truongnguyen29@gmail.com', 'Nam', '0388228192', 'truongbao123', '2026-04-10 10:07:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address_details` text NOT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user_addresses`
--

INSERT INTO `user_addresses` (`id`, `user_id`, `fullname`, `phone`, `address_details`, `is_default`, `created_at`) VALUES
(1, 25, 'Nguyễn Quốc Trưởng', '0388228192', 'b4', 1, '2026-04-06 17:31:01');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
