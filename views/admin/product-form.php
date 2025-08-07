<?php
// Sử dụng layout admin
require_once './views/admin/layout/header.php';

// Xác định chế độ (thêm mới hoặc sửa)
$is_edit_mode = isset($product) && !empty($product);
$form_title = $is_edit_mode ? 'Sửa sản phẩm' : 'Thêm sản phẩm mới';
$form_action = $is_edit_mode ? BASE_URL . '?act=admin-product&action=edit&id=' . $product['id'] : BASE_URL . '?act=admin-product&action=add';
?>

<script>
    // Debug thông tin sản phẩm
    console.log('Form mode: <?php echo $is_edit_mode ? "Edit" : "Add"; ?>');
    <?php if ($is_edit_mode): ?>
    console.log('Product ID: <?php echo $product["id"]; ?>');
    console.log('Product data:', <?php echo json_encode($product); ?>);
    <?php endif; ?>
</script>

<div class="container-fluid">
    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3"><i class="fas fa-edit me-2"></i><?php echo $form_title; ?></h2>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>?act=admin">Admin</a></li>
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>?act=admin-product">Sản phẩm</a></li>
            <li class="breadcrumb-item active"><?php echo $form_title; ?></li>
        </ol>
    </div>
    
    <!-- Form Card -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0"><?php echo $form_title; ?></h5>
        </div>
        <div class="card-body">
            <?php if (isset($error) && !empty($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if (isset($success) && !empty($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form action="<?php echo $form_action; ?>" method="POST" enctype="multipart/form-data" id="productForm">
                <?php if ($is_edit_mode): ?>
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                <?php endif; ?>
                
                <div class="row">
                    <!-- Thông tin cơ bản -->
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $is_edit_mode ? htmlspecialchars($product['name']) : ''; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">Chọn danh mục</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['id']; ?>" <?php echo ($is_edit_mode && $product['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="price" class="form-label">Giá <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="price" name="price" value="<?php echo $is_edit_mode ? $product['price'] : ''; ?>" min="0" required>
                                <span class="input-group-text">₫</span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả sản phẩm</label>
                            <textarea class="form-control" id="description" name="description" rows="5"><?php echo $is_edit_mode ? htmlspecialchars($product['description']) : ''; ?></textarea>
                        </div>
                    </div>
                    
                    <!-- Hình ảnh và trạng thái -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">Hình ảnh sản phẩm <?php echo $is_edit_mode ? '' : '<span class="text-danger">*</span>'; ?></label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" <?php echo $is_edit_mode ? '' : 'required'; ?>>
                            <div class="form-text">Chấp nhận các định dạng: JPG, JPEG, PNG, GIF</div>
                            
                            <?php if ($is_edit_mode && !empty($product['image'])): ?>
                                <div class="mt-2">
                                    <p>Hình ảnh hiện tại:</p>
                                    <img src="<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="featured" name="featured" <?php echo ($is_edit_mode && $product['featured'] == 1) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="featured">Sản phẩm nổi bật</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-3">
                    <a href="<?php echo BASE_URL; ?>?act=admin-product" class="btn btn-secondary me-2">Hủy</a>
                    <button type="submit" class="btn btn-primary" onclick="console.log('Submit form for <?php echo $is_edit_mode ? 'edit' : 'add'; ?> product')">
                        <?php echo $is_edit_mode ? 'Cập nhật sản phẩm' : 'Thêm sản phẩm'; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Xác thực form trước khi submit
    document.getElementById('productForm').addEventListener('submit', function(event) {
        console.log('Validating form...');
        let isValid = true;
        
        // Kiểm tra tên sản phẩm
        const name = document.getElementById('name').value.trim();
        if (name === '') {
            isValid = false;
            alert('Vui lòng nhập tên sản phẩm');
        }
        
        // Kiểm tra danh mục
        const category = document.getElementById('category_id').value;
        if (category === '') {
            isValid = false;
            alert('Vui lòng chọn danh mục');
        }
        
        // Kiểm tra giá
        const price = document.getElementById('price').value;
        if (price === '' || parseFloat(price) <= 0) {
            isValid = false;
            alert('Vui lòng nhập giá hợp lệ');
        }
        
        // Kiểm tra hình ảnh (chỉ bắt buộc khi thêm mới)
        const isEditMode = <?php echo $is_edit_mode ? 'true' : 'false'; ?>;
        const image = document.getElementById('image').files;
        if (!isEditMode && (image.length === 0)) {
            isValid = false;
            alert('Vui lòng chọn hình ảnh cho sản phẩm');
        }
        
        if (!isValid) {
            event.preventDefault();
        } else {
            console.log('Form is valid, submitting...');
        }
    });
</script>

<?php require_once './views/admin/layout/footer.php'; ?>