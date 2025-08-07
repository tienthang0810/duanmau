<?php
// Sử dụng layout admin
require_once './views/admin/layout/header.php';
?>

<script>
    console.log('Categories page loaded');
    <?php if (isset($categories)): ?>
    console.log('Categories data:', <?php echo json_encode($categories); ?>);
    <?php else: ?>
    console.log('No categories data found');
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
    console.log('Error:', <?php echo json_encode($error); ?>);
    <?php endif; ?>
    
    <?php if (isset($success)): ?>
    console.log('Success:', <?php echo json_encode($success); ?>);
    <?php endif; ?>
</script>

<div class="container-fluid">
    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3"><i class="fas fa-tags me-2"></i>Quản lý danh mục</h2>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>?act=admin">Admin</a></li>
            <li class="breadcrumb-item active">Danh mục</li>
        </ol>
    </div>
    
    <div class="row">
        <!-- Add/Edit Category Form -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <?php echo isset($_GET['action']) && $_GET['action'] === 'edit' ? 'Sửa danh mục' : 'Thêm danh mục mới'; ?>
                    </h5>
                </div>
                <div class="card-body">
                    <form action="" method="post" onsubmit="console.log('Form submitted:', {action: '<?php echo isset($_GET["action"]) && $_GET["action"] === "edit" ? "edit" : "add"; ?>', id: '<?php echo isset($category) ? $category["id"] : ""; ?>', name: document.getElementById('category_name').value, description: document.getElementById('description').value});">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php endif; ?>
                        
                        <input type="hidden" name="id" value="<?php echo isset($category) ? $category['id'] : ''; ?>">
                        
                        <div class="mb-3">
                            <label for="category_name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo isset($category) ? $category['name'] : ''; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?php echo isset($category) ? $category['description'] : ''; ?></textarea>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                <?php echo isset($_GET['action']) && $_GET['action'] === 'edit' ? 'Cập nhật' : 'Thêm mới'; ?>
                            </button>
                            
                            <?php if (isset($_GET['action']) && $_GET['action'] === 'edit'): ?>
                                <a href="<?php echo BASE_URL; ?>?act=admin-categories" class="btn btn-outline-secondary">Hủy</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Categories List -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Danh sách danh mục</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Tên danh mục</th>
                                    <th scope="col">Mô tả</th>
                                    <th scope="col">Số sản phẩm</th>
                                    <th scope="col">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($categories) && count($categories) > 0): ?>
                                    <?php foreach ($categories as $cat): ?>
                                        <tr>
                                            <td><?php echo $cat['id']; ?></td>
                                            <td><?php echo $cat['name']; ?></td>
                                            <td><?php echo !empty($cat['description']) ? $cat['description'] : 'Không có mô tả'; ?></td>
                                            <td>
                                                <span class="badge bg-primary"><?php echo $cat['product_count']; ?></span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?php echo BASE_URL; ?>?act=admin-categories&action=edit&id=<?php echo $cat['id']; ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Sửa" onclick="console.log('Edit category ID: <?php echo $cat["id"]; ?>')">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?php echo BASE_URL; ?>?act=admin-categories&action=delete&id=<?php echo $cat['id']; ?>" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Xóa" onclick="console.log('Delete category ID: <?php echo $cat["id"]; ?>'); return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Không có danh mục nào</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Thêm event listener cho các nút
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM fully loaded');
        
        // Kiểm tra URL hiện tại
        const currentUrl = window.location.href;
        console.log('Current URL:', currentUrl);
        
        // Thêm event listener cho form submit
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                console.log('Form is being submitted');
            });
        }
    });
</script>

<?php require_once './views/admin/layout/footer.php'; ?>