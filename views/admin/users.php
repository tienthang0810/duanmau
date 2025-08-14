<?php
// Sử dụng layout admin
require_once './views/admin/layout/header.php';
?>

<div class="container-fluid">
    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3"><i class="fas fa-users me-2"></i>Quản lý người dùng</h2>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>?act=admin-product">Admin</a></li>
            <li class="breadcrumb-item active">Người dùng</li>
        </ol>
    </div>
    
    <!-- Action Buttons -->
    <div class="mb-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fas fa-user-plus me-2"></i>Thêm người dùng mới
        </button>
    </div>
    
    <!-- Users Table -->
    <div class="card">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="card-title mb-0">Danh sách người dùng</h5>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Tìm kiếm người dùng..." id="searchUser">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Tên đăng nhập</th>
                            <th scope="col">Họ tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Vai trò</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($users) && count($users) > 0): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo $user['username']; ?></td>
                                    <td><?php echo $user['fullname']; ?></td>
                                    <td><?php echo $user['email']; ?></td>
                                    <td>
                                        <?php if ($user['role'] === 'admin'): ?>
                                            <span class="badge bg-danger">Admin</span>
                                        <?php else: ?>
                                            <span class="badge bg-info">User</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal<?php echo $user['id']; ?>" data-bs-toggle="tooltip" title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <?php if ($user['id'] != $_SESSION['user_id']): ?> <!-- Không cho phép xóa chính mình -->
                                                <a href="<?php echo BASE_URL; ?>?act=admin-users&action=delete&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <!-- Edit User Modal -->
                                        <div class="modal fade" id="editUserModal<?php echo $user['id']; ?>" tabindex="-1" aria-labelledby="editUserModalLabel<?php echo $user['id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editUserModalLabel<?php echo $user['id']; ?>">Sửa thông tin người dùng</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="<?php echo BASE_URL; ?>?act=admin-users&action=edit" method="post">
                                                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                                            
                                                            <div class="mb-3">
                                                                <label for="username<?php echo $user['id']; ?>" class="form-label">Tên đăng nhập</label>
                                                                <input type="text" class="form-control" id="username<?php echo $user['id']; ?>" name="username" value="<?php echo $user['username']; ?>" readonly>
                                                                <small class="text-muted">Tên đăng nhập không thể thay đổi</small>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label for="fullname<?php echo $user['id']; ?>" class="form-label">Họ tên</label>
                                                                <input type="text" class="form-control" id="fullname<?php echo $user['id']; ?>" name="fullname" value="<?php echo $user['fullname']; ?>">
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label for="email<?php echo $user['id']; ?>" class="form-label">Email</label>
                                                                <input type="email" class="form-control" id="email<?php echo $user['id']; ?>" name="email" value="<?php echo $user['email']; ?>">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="role<?php echo $user['id']; ?>" class="form-label">Vai trò</label>
                                                                <select class="form-select" id="role<?php echo $user['id']; ?>" name="role">
                                                                    <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                                                                    <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label for="password<?php echo $user['id']; ?>" class="form-label">Mật khẩu mới (để trống nếu không đổi)</label>
                                                                <input type="password" class="form-control" id="password<?php echo $user['id']; ?>" name="password">
                                                            </div>
                                                            
                                                            <div class="d-grid gap-2">
                                                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Không có người dùng nào</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Thêm người dùng mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo BASE_URL; ?>?act=admin-users-add" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên đăng nhập <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="fullname" name="fullname" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                                 
                    <div class="mb-3">
                        <label for="role" class="form-label">Vai trò</label>
                        <select class="form-select" id="role" name="role">
                            <option value="user" selected>User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Tìm kiếm người dùng
    document.getElementById('searchUser').addEventListener('keyup', function() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById('searchUser');
        filter = input.value.toUpperCase();
        table = document.querySelector('table');
        tr = table.getElementsByTagName('tr');
        
        for (i = 1; i < tr.length; i++) { // Bắt đầu từ 1 để bỏ qua header
            // Tìm kiếm theo tên đăng nhập, họ tên và email
            var found = false;
            for (var j = 1; j <= 3; j++) { // Cột 1: username, 2: fullname, 3: email
                td = tr[i].getElementsByTagName('td')[j];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
            }
            
            if (found) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        }
    });
</script>

<?php require_once './views/admin/layout/footer.php'; ?>