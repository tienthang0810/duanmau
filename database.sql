-- Tạo database
CREATE DATABASE IF NOT EXISTS `poly_shop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `poly_shop`;

-- Tạo bảng categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm dữ liệu mẫu cho bảng categories
INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Áo nữ', 'Các loại áo dành cho nam'),
(2, 'Áo nam', 'Các loại áo dành cho nữ'),


-- Thêm dữ liệu mẫu cho bảng products
INSERT INTO `products` (`id`, `name`, `price`, `image`, `description`, `category_id`, `featured`) VALUES
(1, 'Áo thun nam', 299000, 'https://images.unsplash.com/photo-1576871337622-98d48d1cf531?q=80&w=387&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'Áo croptop ôm body, thích hợp tập gym hoặc mặc hàng ngày.', 1, 1),
(2, 'Áo sơ mi nam', 199000, 'https://images.unsplash.com/photo-1603252109303-2751441dd157?q=80&w=387&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'Áo sơ mi, kiểu dáng basic dễ phối đồ, chất vải mềm mại.', 1, 1),
(3, 'Áo hoodie unisex', 399000, 'https://media.istockphoto.com/id/2154756692/vi/anh/template-blank-flat-black-hoodie-top-view-isolated-on-white-background.jpg?s=612x612&w=0&k=20&c=E1_BG5TWvHVc3qA9zySngDKctYwVl5rmqu7KJgkXdoE=', 'Áo hoodie thời trang unisex, nỉ bông ấm áp, phù hợp mùa đông.', 1, 1),
(4, 'Áo khoác mùa đông', 359000, 'https://images.unsplash.com/photo-1654719796836-62b889d4598d?q=80&w=387&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'Áo khoác dành cho giới trẻ. Chất liệu mềm mại', 1, 0),
(5, 'Áo đá bóng', 259000, 'https://images.unsplash.com/photo-1577212017184-80cc0da11082?q=80&w=387&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'Áo đá bóng mát mẻ, mẫu mã mới.', 1, 0),
(6, 'Áo khoác jean nam', 499000, 'https://images.unsplash.com/photo-1543076447-215ad9ba6923?q=80&w=774&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'Áo jen mặc phối đồ cực đỉnh', 1, 0),
(7, 'Áo nữ công sở', 599000, 'https://down-vn.img.susercontent.com/file/vn-11134207-7ras8-mb1wole5swjl65.webp', 'Blazer nữ phong cách Hàn Quốc, phù hợp môi trường công sở.', 1, 0),
(8, 'Áo dài truyền thống nữ', 499000, 'https://down-vn.img.susercontent.com/file/vn-11134207-7ras8-m3552l5t2gm3fc.webp', 'Áo dài truyền thống thiết kế tinh tế, chất liệu lụa mềm mại.', 1, 1);

-- Thêm dữ liệu mẫu cho bảng users
INSERT INTO `users` (`id`, `username`, `password`, `email`, `fullname`, `role`) VALUES
(1, 'admin', '$2y$10$dVMpvO1JBEXdVq5hWVRT1eRCvfEH.w2PVS.o/VMUxFLAkIz2mVET2', 'admin@example.com', 'Administrator', 'admin');
-- Mật khẩu: admin123