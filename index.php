<?php
// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Khởi tạo session
session_start();

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/ProductController.php';
require_once './controllers/UserController.php';
require_once './controllers/AdminController.php';
require_once './controllers/CategoryController.php';

// Require toàn bộ file Models
require_once './models/ProductModel.php';
require_once './models/CategoryModel.php';
require_once './models/UserModel.php';

// Route
$act = $_GET['act'] ?? '/';


// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    // Trang chủ
    '/' => (new ProductController())->Home(),

    // Trang sản phẩm
    'products' => (new ProductController())->Products(),

    // Trang chi tiết sản phẩm
    'product-detail' => (new ProductController())->ProductDetail(),

    // Trang đăng nhập
    'login' => (new UserController())->Login(),

    // Trang đăng ký
    'register' => (new UserController())->Register(),
    'categories' => (new CategoryController())->ViewCategories(),
    // Đăng xuất
    'logout' => (new UserController())->Logout(),

    // Trang quản lý admin
    'admin-product' => (new AdminController())->Products(),
    'admin-categories' => (new CategoryController())->Categories(),
    'admin-users' => (new AdminController())->Users(),
};
