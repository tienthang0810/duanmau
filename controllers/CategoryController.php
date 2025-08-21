<?php
// có class chứa các function thực thi xử lý logic cho danh mục
class CategoryController
{
    public $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    /**
     * Quản lý danh mục
     */
    public function Categories() {
        $page_title = "Quản lý danh mục";
        $error = null;
        $success = null;
        
        // Xử lý các hành động
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'edit':
                    // Lấy thông tin danh mục cần sửa
                    if (isset($_GET['id'])) {
                        $category = $this->categoryModel->getCategoryById($_GET['id']);
                        
                        // Nếu không tìm thấy danh mục
                        if (!$category) {
                            $error = "Không tìm thấy danh mục với ID: {$_GET['id']}";
                        }
                    }
                    
                    // Xử lý form submit cập nhật danh mục
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
                        $id = $_POST['id'];
                        $category_name = trim($_POST['category_name']);
                        $description = trim($_POST['description']);
                        
                        // Validate dữ liệu
                        if (empty($category_name)) {
                            $error = "Vui lòng nhập tên danh mục";
                        } else {
                            // Cập nhật danh mục
                            if ($this->categoryModel->updateCategory($id, $category_name, $description)) {
                                // Chuyển hướng về trang danh sách danh mục với thông báo thành công
                                header("Location: " . BASE_URL . "?act=admin-categories&updated=1");
                                exit;
                            } else {
                                $error = "Có lỗi xảy ra khi cập nhật danh mục";
                            }
                        }
                    }
                    break;
                    
                case 'delete':
                    // Xử lý xóa danh mục
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        
                        // Kiểm tra xem danh mục có tồn tại không
                        $category = $this->categoryModel->getCategoryById($id);
                        
                        if (!$category) {
                            $error = "Không tìm thấy danh mục với ID: {$id}";
                        } else {
                            // Xóa danh mục
                            if ($this->categoryModel->deleteCategory($id)) {
                                // Chuyển hướng về trang danh sách danh mục với thông báo thành công
                                header("Location: " . BASE_URL . "?act=admin-categories");
                                exit;
                            } else {
                                $error = "Có lỗi xảy ra khi xóa danh mục";
                            }
                        }
                    }
                    break;
            }
        }
        
        // Xử lý thêm danh mục mới
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST['id'])) {
            // Debug để xem dữ liệu POST
            error_log('POST data: ' . print_r($_POST, true));
            
            $category_name = trim($_POST['category_name']);
            $description = trim($_POST['description']);
            
            // Validate dữ liệu
            if (empty($category_name)) {
                $error = "Vui lòng nhập tên danh mục";
            } else {
                // Thêm danh mục mới
                $result = $this->categoryModel->addCategory($category_name, $description);
                error_log('Add category result: ' . var_export($result, true));
                
                if ($result) {
                    $success = "Thêm danh mục thành công";
                    // Reset form
                    $_POST = [];
                    // Chuyển hướng để tránh gửi lại form khi refresh
                    header("Location: " . BASE_URL . "?act=admin-categories&added=1");
                    exit;
                } else {
                    $error = "Có lỗi xảy ra khi thêm danh mục";
                }
            }
        }
        
        // Hiển thị thông báo thành công
        if (isset($_GET['deleted']) && $_GET['deleted'] == 1) {
            $success = "Xóa danh mục thành công";
        } else if (isset($_GET['updated']) && $_GET['updated'] == 1) {
            $success = "Cập nhật danh mục thành công";
        } else if (isset($_GET['added']) && $_GET['added'] == 1) {
            $success = "Thêm danh mục thành công";
        }
        
        // Lấy danh sách danh mục
        $categories = $this->categoryModel->getAllCategories();
        
        // Đếm số sản phẩm trong mỗi danh mục
        foreach ($categories as &$category) {
            $category['product_count'] = $this->categoryModel->countProductsInCategory($category['id']);
        }
        
        // Hiển thị trang quản lý danh mục
        require_once './views/admin/categories.php';
    }

    /**
     * Hiển thị danh mục cho người dùng
     */
    public function ViewCategories() {
        // Lấy danh sách danh mục
        $categories = $this->categoryModel->getAllCategories();
        
        $title = "Danh mục sản phẩm";
        require_once './views/categories.php';
    }
}