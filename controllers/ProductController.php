<?php
// có class chứa các function thực thi xử lý logic 
class ProductController
{
    public $modelProduct;
    public $modelCategory;

    public function __construct()
    {
        $this->modelProduct = new ProductModel();
        $this->modelCategory = new CategoryModel();
    }

    public function Home()
    {
        // Lấy danh sách danh mục
        $categories = $this->modelCategory->getAllCategories();
        
        // Lấy sản phẩm nổi bật
        $featuredProducts = $this->modelProduct->getFeaturedProducts(4);
        
        $title = "Shop Thời Trang";
        require_once './views/trangchu.php';
    }
    
    public function Products()
    {
        // Lấy danh sách danh mục cho sidebar
        $categories = $this->modelCategory->getAllCategories();
        
        // Xử lý phân trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 8; // Số sản phẩm trên mỗi trang
        $offset = ($page - 1) * $limit;
        
        // Xử lý lọc theo danh mục
        if (isset($_GET['category']) && $_GET['category'] > 0) {
            $category_id = (int)$_GET['category'];
            $products = $this->modelProduct->getProductsByCategory($category_id, $limit, $offset);
            $totalProducts = $this->modelProduct->countProductsByCategory($category_id);
            $selectedCategory = $this->modelCategory->getCategoryById($category_id);
        } 
        // Xử lý tìm kiếm
        else if (isset($_GET['search']) && !empty($_GET['search'])) {
            $keyword = $_GET['search'];
            $products = $this->modelProduct->searchProducts($keyword, $limit, $offset);
            $totalProducts = $this->modelProduct->countSearchResults($keyword);
        } 
        // Lấy tất cả sản phẩm
        else {
            $products = $this->modelProduct->getAllProduct($limit, $offset);
            $totalProducts = $this->modelProduct->countAllProducts();
        }
        
        // Tính toán phân trang
        $totalPages = ceil($totalProducts / $limit);
        
        $title = "Sản phẩm";
        require_once './views/products.php';
    }
    
    public function ProductDetail()
    {
        // Lấy thông tin sản phẩm theo ID
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $product = $this->modelProduct->getProductById($id);
        
        if (!$product) {
            // Nếu không tìm thấy sản phẩm, chuyển hướng về trang sản phẩm
            header("Location: " . BASE_URL . "?act=products");
            exit;
        }
        
        // Lấy sản phẩm liên quan
        $relatedProducts = $this->modelProduct->getRelatedProducts($id, $product['category_id'], 4);
        
        $title = $product['name'] . " - Shop Thời Trang";
        require_once './views/product-detail.php';
    }
    
    public function Login()
    {
        $title = "Đăng nhập ";
        require_once './views/login.php';
    }
    
    public function Register()
    {
        $title = "Đăng ký tài khoản";
        require_once './views/register.php';
    }
}
