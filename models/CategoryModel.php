<?php
// Class chứa các function thực thi tương tác với cơ sở dữ liệu cho bảng categories
class CategoryModel
{
    public $conn;
    
    public function __construct()
    {
        $this->conn = connectDB();
    }
    
    // Lấy tất cả danh mục
    public function getAllCategories()
    {
        $sql = "SELECT * FROM categories ORDER BY id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Đếm số sản phẩm trong một danh mục
    public function countProductsInCategory($category_id)
    {
        $sql = "SELECT COUNT(*) FROM products WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    // Đếm tổng số danh mục
    public function countCategories()
    {
        $sql = "SELECT COUNT(*) FROM categories";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    // Lấy danh mục theo ID
    public function getCategoryById($id)
    {
        $sql = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    // Thêm danh mục mới
    public function addCategory($category_name, $description = null)
    {
        $sql = "INSERT INTO categories (name, description) VALUES (:category_name, :description)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':category_name', $category_name);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }
    
    // Cập nhật danh mục
    public function updateCategory($id, $category_name, $description = null)
    {
        $sql = "UPDATE categories SET name = :category_name, description = :description WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':category_name', $category_name);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }
    
    // Xóa danh mục
    public function deleteCategory($id)
    {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}