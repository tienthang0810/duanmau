<?php 
// Có class chứa các function thực thi tương tác với cơ sở dữ liệu 
class ProductModel 
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy danh sách tất cả sản phẩm với phân trang
    public function getAllProduct($limit = 8, $offset = 0)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.id DESC 
                LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Đếm tổng số sản phẩm
    public function countAllProducts()
    {
        $sql = "SELECT COUNT(*) as total FROM products";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    // Đếm tổng số sản phẩm (alias cho AdminController)
    public function countProducts()
    {
        return $this->countAllProducts();
    }
    
    // Lấy tất cả sản phẩm (không phân trang, dùng cho trang admin)
    public function getAllProducts()
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Lấy sản phẩm mới nhất
    public function getLatestProducts($limit = 5)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.id DESC 
                LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Lấy sản phẩm theo ID
    public function getProductById($id)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    // Lấy sản phẩm theo danh mục
    public function getProductsByCategory($category_id, $limit = 8, $offset = 0)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = :category_id 
                ORDER BY p.id DESC 
                LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Đếm số sản phẩm theo danh mục
    public function countProductsByCategory($category_id)
    {
        $sql = "SELECT COUNT(*) as total FROM products WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    // Tìm kiếm sản phẩm
    public function searchProducts($keyword, $limit = 8, $offset = 0)
    {
        $search = "%$keyword%";
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.name LIKE :keyword OR p.description LIKE :keyword 
                ORDER BY p.id DESC 
                LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':keyword', $search);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Đếm kết quả tìm kiếm
    public function countSearchResults($keyword)
    {
        $search = "%$keyword%";
        $sql = "SELECT COUNT(*) as total FROM products WHERE name LIKE :keyword OR description LIKE :keyword";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':keyword', $search);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    // Thêm sản phẩm mới
    public function addProduct($name, $category_id, $price, $description, $image, $featured = 0)
    {
        $sql = "INSERT INTO products (name, price, image, description, category_id, featured) 
                VALUES (:name, :price, :image, :description, :category_id, :featured)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':featured', $featured);
        return $stmt->execute();
    }
    
    // Cập nhật sản phẩm
    public function updateProduct($id, $name, $category_id, $price, $description, $image, $featured = 0)
    {
        $sql = "UPDATE products 
                SET name = :name, 
                    price = :price, 
                    image = :image, 
                    description = :description, 
                    category_id = :category_id, 
                    featured = :featured 
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':featured', $featured);
        return $stmt->execute();
    }
    
    // Xóa sản phẩm
    public function deleteProduct($id)
    {
        // Lấy thông tin hình ảnh trước khi xóa
        $sql = "SELECT image FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $product = $stmt->fetch();
        
        // Xóa file hình ảnh nếu có
        if ($product && !empty($product['image'])) {
            deleteFile($product['image']);
        }
        
        // Xóa sản phẩm từ database
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    // Lấy sản phẩm nổi bật
    public function getFeaturedProducts($limit = 4)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.featured = 1 
                ORDER BY p.id DESC 
                LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Lấy sản phẩm liên quan (cùng danh mục)
    public function getRelatedProducts($product_id, $category_id, $limit = 4)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = :category_id AND p.id != :product_id 
                ORDER BY RAND() 
                LIMIT :limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
