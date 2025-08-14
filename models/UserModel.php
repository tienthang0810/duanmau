<?php
class UserModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }
    
    /**
     * Đếm tổng số người dùng
     * @return int Tổng số người dùng
     */
    public function countUsers() {
        try {
            $stmt = $this->conn->query("SELECT COUNT(*) FROM users");
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }
    
    /**
     * Lấy danh sách tất cả người dùng
     * @return array Danh sách người dùng
     */
    public function getAllUsers() {
        try {
            $stmt = $this->conn->query("SELECT id, username, email, fullname, role, created_at FROM users ORDER BY id DESC");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Đăng ký tài khoản mới
     * @param string $username Tên đăng nhập
     * @param string $password Mật khẩu
     * @param string $email Email
     * @param string $fullname Họ tên
     * @return bool|string True nếu đăng ký thành công, chuỗi lỗi nếu thất bại
     */
    public function register($username, $password, $email, $fullname) {
        try {
            // Kiểm tra username đã tồn tại chưa
            $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return "Tên đăng nhập đã tồn tại";
            }
            
            // Kiểm tra email đã tồn tại chưa
            $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return "Email đã tồn tại";
            }
            
            // Mã hóa mật khẩu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Thêm người dùng mới
            $stmt = $this->conn->prepare(
                "INSERT INTO users (username, password, email, fullname, role) 
                 VALUES (:username, :password, :email, :fullname, 'user')"
            );
            
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':fullname', $fullname);
            
            $stmt->execute();
            return true;
            
        } catch (PDOException $e) {
            return "Lỗi: " . $e->getMessage();
        }
    }
    
    /**
     * Đăng nhập
     * @param string $username Tên đăng nhập hoặc email
     * @param string $password Mật khẩu
     * @return array|bool Thông tin người dùng nếu đăng nhập thành công, false nếu thất bại
     */
    public function login($username, $password) {
        try {
            // Kiểm tra đăng nhập bằng username hoặc email
            $stmt = $this->conn->prepare(
                "SELECT * FROM users WHERE username = :username OR email = :email LIMIT 1"
            );
            
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $username);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch();
                
                // Kiểm tra mật khẩu
                if (password_verify($password, $user['password'])) {
                    // Loại bỏ mật khẩu trước khi trả về thông tin người dùng
                    unset($user['password']);
                    return $user;
                }
            }
            
            return false;
            
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Lấy thông tin người dùng theo ID
     * @param int $id ID người dùng
     * @return array|bool Thông tin người dùng hoặc false nếu không tìm thấy
     */
    public function getUserById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch();
                unset($user['password']); // Loại bỏ mật khẩu
                return $user;
            }
            
            return false;
            
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Cập nhật thông tin người dùng
     */
    public function updateUser($userData)
    {
        try {
            // Kiểm tra email đã tồn tại chưa (nếu khác với email hiện tại)
            $checkEmailSql = "SELECT id FROM users WHERE email = ? AND id != ?";
            $checkEmailStmt = $this->conn->prepare($checkEmailSql);
            $checkEmailStmt->execute([$userData['email'], $userData['id']]);
            
            if ($checkEmailStmt->rowCount() > 0) {
                return "Email đã được sử dụng bởi tài khoản khác";
            }
            
            // Chuẩn bị câu lệnh SQL
            $fields = [];
            $values = [];
            
            foreach ($userData as $key => $value) {
                if ($key !== 'id' && $key !== 'password') {
                    $fields[] = "$key = ?";
                    $values[] = $value;
                }
            }
            
            // Nếu có mật khẩu mới, thêm vào câu lệnh SQL
            if (isset($userData['password']) && !empty($userData['password'])) {
                $fields[] = "password = ?";
                $values[] = password_hash($userData['password'], PASSWORD_DEFAULT);
            }
            
            // Thêm ID vào cuối mảng values
            $values[] = $userData['id'];
            
            $sql = "UPDATE users SET " . implode(", ", $fields) . " WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($values);
            
            return true;
        } catch (PDOException $e) {
            return "Lỗi cập nhật: " . $e->getMessage();
        }
    }
    
    /**
     * Xóa người dùng
     */
    public function deleteUser($id)
    {
        try {
            $sql = "DELETE FROM users WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            
            return true;
        } catch (PDOException $e) {
            return "Lỗi xóa: " . $e->getMessage();
        }
    }
    
    // Các phương thức getAllUsers() và countUsers() đã được khai báo ở trên
}