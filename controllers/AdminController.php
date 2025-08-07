<?php
require_once './controllers/UserController.php';

class AdminController {
    private $userModel;
    private $productModel;
    private $categoryModel;
    private $userController;
    
    public function __construct() {
        // Kiểm tra quyền admin
        $this->checkAdminPermission();
        
        // Khởi tạo các model
        $this->userModel = new UserModel();
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        
        // Khởi tạo các controller
        $this->userController = new UserController();
    }
    
    /**
     * Kiểm tra quyền admin
     */
    private function checkAdminPermission() {
        // Nếu chưa đăng nhập hoặc không phải admin, chuyển hướng về trang chủ
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: " . BASE_URL);
            exit;
        }
    }
    
    /**
     * Quản lý sản phẩm
     */
    public function Products() {
        $page_title = "Quản lý sản phẩm";
        $error = null;
        $success = null;
        
        // Xử lý các hành động
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'add':
                    // Xử lý thêm sản phẩm mới
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        // Lấy dữ liệu từ form
                        $name = trim($_POST['name']);
                        $category_id = $_POST['category_id'];
                        $price = $_POST['price'];
                        $description = trim($_POST['description']);
                        $featured = isset($_POST['featured']) ? 1 : 0;
                        
                        // Validate dữ liệu
                        if (empty($name)) {
                            $error = "Vui lòng nhập tên sản phẩm";
                        } elseif (empty($category_id)) {
                            $error = "Vui lòng chọn danh mục";
                        } elseif (empty($price) || !is_numeric($price) || $price <= 0) {
                            $error = "Vui lòng nhập giá hợp lệ";
                        } else {
                            // Xử lý upload hình ảnh
                            $image = '';
                            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                                $upload_dir = './uploads/imgproduct/';
                                $file_name = time() . '_' . basename($_FILES['image']['name']);
                                $target_file = $upload_dir . $file_name;
                                
                                // Kiểm tra loại file
                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                                    $error = "Chỉ chấp nhận file hình ảnh (JPG, JPEG, PNG, GIF)";
                                } else {
                                    // Upload file
                                    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                                        $image = $target_file;
                                    } else {
                                        $error = "Có lỗi xảy ra khi upload hình ảnh";
                                    }
                                }
                            } else {
                                $error = "Vui lòng chọn hình ảnh cho sản phẩm";
                            }
                            
                            // Thêm sản phẩm mới nếu không có lỗi
                            if (empty($error)) {
                                if ($this->productModel->addProduct($name, $category_id, $price, $description, $image, $featured)) {
                                    $success = "Thêm sản phẩm thành công";
                                    // Reset form
                                    $_POST = [];
                                    // Chuyển hướng về trang danh sách sản phẩm với thông báo thành công
                                    header("Location: " . BASE_URL . "?act=admin-product&added=1");
                                    exit;
                                } else {
                                    $error = "Có lỗi xảy ra khi thêm sản phẩm";
                                }
                            }
                        }
                    }
                    
                    // Lấy danh sách danh mục cho form thêm sản phẩm
                    $categories = $this->categoryModel->getAllCategories();
                    
                    // Hiển thị form thêm sản phẩm
                    require_once './views/admin/product-form.php';
                    return;
                    
                case 'edit':
                    // Lấy thông tin sản phẩm cần sửa
                    if (isset($_GET['id'])) {
                        $product = $this->productModel->getProductById($_GET['id']);
                        
                        // Nếu không tìm thấy sản phẩm
                        if (!$product) {
                            $error = "Không tìm thấy sản phẩm với ID: {$_GET['id']}";
                        }
                    }
                    
                    // Xử lý form submit cập nhật sản phẩm
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
                        $id = $_POST['id'];
                        $name = trim($_POST['name']);
                        $category_id = $_POST['category_id'];
                        $price = $_POST['price'];
                        $description = trim($_POST['description']);
                        $featured = isset($_POST['featured']) ? 1 : 0;
                        
                        // Validate dữ liệu
                        if (empty($name)) {
                            $error = "Vui lòng nhập tên sản phẩm";
                        } elseif (empty($category_id)) {
                            $error = "Vui lòng chọn danh mục";
                        } elseif (empty($price) || !is_numeric($price) || $price <= 0) {
                            $error = "Vui lòng nhập giá hợp lệ";
                        } else {
                            // Lấy thông tin sản phẩm hiện tại
                            $current_product = $this->productModel->getProductById($id);
                            $image = $current_product['image'];
                            
                            // Xử lý upload hình ảnh mới (nếu có)
                            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                                $upload_dir = './uploads/imgproduct/';
                                $file_name = time() . '_' . basename($_FILES['image']['name']);
                                $target_file = $upload_dir . $file_name;
                                
                                // Kiểm tra loại file
                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                                    $error = "Chỉ chấp nhận file hình ảnh (JPG, JPEG, PNG, GIF)";
                                } else {
                                    // Upload file
                                    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                                        // Xóa hình ảnh cũ nếu có
                                        if (!empty($current_product['image']) && file_exists($current_product['image'])) {
                                            unlink($current_product['image']);
                                        }
                                        $image = $target_file;
                                    } else {
                                        $error = "Có lỗi xảy ra khi upload hình ảnh";
                                    }
                                }
                            }
                            
                            // Cập nhật sản phẩm nếu không có lỗi
                            if (empty($error)) {
                                if ($this->productModel->updateProduct($id, $name, $category_id, $price, $description, $image, $featured)) {
                                    $success = "Cập nhật sản phẩm thành công";
                                    // Lấy lại thông tin sản phẩm sau khi cập nhật
                                    $product = $this->productModel->getProductById($id);
                                    // Chuyển hướng về trang danh sách sản phẩm với thông báo thành công
                                    header("Location: " . BASE_URL . "?act=admin-product&updated=1");
                                    exit;
                                } else {
                                    $error = "Có lỗi xảy ra khi cập nhật sản phẩm";
                                }
                            }
                        }
                    }
                    
                    // Lấy danh sách danh mục cho form sửa sản phẩm
                    $categories = $this->categoryModel->getAllCategories();
                    
                    // Hiển thị form sửa sản phẩm
                    require_once './views/admin/product-form.php';
                    return;
                    
                case 'delete':
                    // Xử lý xóa sản phẩm
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        
                        // Kiểm tra xem sản phẩm có tồn tại không
                        $product = $this->productModel->getProductById($id);
                        
                        if (!$product) {
                            $error = "Không tìm thấy sản phẩm với ID: {$id}";
                        } else {
                            // Xóa sản phẩm
                            if ($this->productModel->deleteProduct($id)) {
                                // Chuyển hướng về trang danh sách sản phẩm với thông báo thành công
                                header("Location: " . BASE_URL . "?act=admin-product&deleted=1");
                                exit;
                            } else {
                                $error = "Có lỗi xảy ra khi xóa sản phẩm";
                            }
                        }
                    }
                    break;
            }
        }
        
        // Hiển thị thông báo thành công
        if (isset($_GET['added']) && $_GET['added'] == 1) {
            $success = "Thêm sản phẩm thành công";
        } else if (isset($_GET['updated']) && $_GET['updated'] == 1) {
            $success = "Cập nhật sản phẩm thành công";
        } else if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
            $success = "Xóa sản phẩm thành công";
        }
        
        // Lấy danh sách sản phẩm
        $products = $this->productModel->getAllProducts();
        
        // Hiển thị trang quản lý sản phẩm
        require_once './views/admin/products.php';
    }
    
    /**
     * Chuyển hướng đến CategoryController để quản lý danh mục
     */
    public function Categories() {
        // Chuyển hướng đến CategoryController
        $categoryController = new CategoryController();
        $categoryController->Categories();
    }
    
    /**
     * Quản lý người dùng
     */
    public function Users() {
        $page_title = "Quản lý người dùngử";
        
        // Lấy danh sách người dùng
        $users = $this->userModel->getAllUsers();
        
        // Xử lý các hành động
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'add':
                    $this->userController->AdminUsers();
                    return;
                case 'edit':
                    $this->userController->AdminUsers();
                    return;
                case 'delete':
                    $this->userController->AdminUsers();
                    return;
            }
        }
        
        // Hiển thị trang quản lý người dùng
        require_once './views/admin/users.php';
    }
}