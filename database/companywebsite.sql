-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2026
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

DROP DATABASE IF EXISTS `companywebsite`;
CREATE DATABASE `companywebsite`;
USE `companywebsite`;

-- --------------------------------------------------------

CREATE TABLE `about_content` (
  `id` int(11) NOT NULL,
  `content_key` varchar(100) NOT NULL,
  `content_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `about_content` (`id`, `content_key`, `content_value`) VALUES
(1, 'company_name', 'Công ty TNHH ABC Việt Nam'),
(2, 'company_history', 'Thành lập năm 2010, trải qua 15 năm phát triển, chúng tôi đã khẳng định vị thế hàng đầu trong lĩnh vực cung cấp giải pháp công nghệ.'),
(3, 'mission', 'Sứ mệnh của chúng tôi là mang đến những sản phẩm chất lượng cao, dịch vụ hoàn hảo và giá trị bền vững cho khách hàng.'),
(4, 'vision', 'Trở thành công ty công nghệ hàng đầu khu vực, được khách hàng tin tưởng và đối tác tôn trọng.'),
(5, 'core_values', 'Chuyên nghiệp - Sáng tạo - Uy tín - Tận tâm'),
(6, 'about_image', ''),
(7, 'why_choose_us', 'Đội ngũ chuyên nghiệp, giá cả cạnh tranh, hỗ trợ 24/7, bảo hành dài hạn.');

-- --------------------------------------------------------

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'chua_doc',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `order_num` int(11) DEFAULT 0,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `faq` (`id`, `question`, `answer`, `order_num`, `status`, `created_at`) VALUES
(1, 'Công ty hoạt động trong lĩnh vực nào?', 'Chúng tôi hoạt động trong lĩnh vực cung cấp giải pháp công nghệ, thiết kế web, phát triển phần mềm và digital marketing.', 1, 1, '2026-04-28 16:18:21'),
(2, 'Làm thế nào để nhận báo giá?', 'Quý khách vui lòng liên hệ qua số điện thoại 0123456789 hoặc gửi yêu cầu qua form liên hệ trên website.', 2, 1, '2026-04-28 16:18:21'),
(3, 'Công ty có hỗ trợ bảo hành không?', 'Có, chúng tôi có chính sách bảo hành và hỗ trợ kỹ thuật dài hạn cho tất cả sản phẩm và dịch vụ.', 3, 1, '2026-04-28 16:18:21'),
(4, 'Thời gian phản hồi khách hàng là bao lâu?', 'Chúng tôi cam kết phản hồi trong vòng 24h làm việc kể từ khi nhận được yêu cầu.', 4, 1, '2026-04-28 16:18:21');

-- --------------------------------------------------------

CREATE TABLE `home_content` (
  `id` int(11) NOT NULL,
  `content_key` varchar(100) NOT NULL,
  `content_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `home_content` (`id`, `content_key`, `content_value`) VALUES
(1, 'hero_title', 'Chào mừng đến với công ty chúng tôi'),
(2, 'hero_subtitle', 'Chúng tôi cung cấp giải pháp tốt nhất'),
(3, 'about_text', 'Đây là nội dung giới thiệu công ty'),
(4, 'phone', '0123456789'),
(5, 'email', 'contact@company.com'),
(6, 'address', 'Số 456 Đường XYZ, Quận 2, TP.HCM'),
(7, 'hero_image', ''),
(8, 'about_image', '');

-- --------------------------------------------------------

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'member',
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `fullname`, `avatar`, `role`, `status`) VALUES
(1, 'admin', 'admin@company.com', '$2y$10$92IXUNpkjO0rO0rQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Quản trị viên', NULL, 'admin', 1);

-- --------------------------------------------------------

ALTER TABLE `about_content`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `home_content`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `about_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `home_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;