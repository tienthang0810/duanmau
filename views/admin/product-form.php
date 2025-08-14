<?php
require_once './views/admin/layout/header.php';

// Xác định chế độ
$is_edit_mode = !empty($product) && isset($product['id']);

// Tiêu đề & action form
$form_title = $is_edit_mode ? 'Sửa sản phẩm' : 'Thêm sản phẩm mới';
$form_action = BASE_URL . '?act=admin-product&action=' . ($is_edit_mode ? 'edit&id=' . (int)$product['id'] : 'add');
?>

<div class="container-fluid">
    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3"><i class="fas fa-edit me-2"></i><?php echo $form_title; ?></h2>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>?act=admin-product">Admin</a></li>
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>?act=admin-product">Sản phẩm</a></li>
            <li class="breadcrumb-item active"><?php echo $form_title; ?></li>
        </ol>
    </div>

    <!-- Form -->
    <div class="card">
        <div class="card-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form action="<?php echo $form_action; ?>" method="POST" enctype="multipart/form-data">
                <?php if ($is_edit_mode): ?>
                    <input type="hidden" name="id" value="<?php echo (int)$product['id']; ?>">
                <?php endif; ?>

                <!-- Tên sản phẩm -->
                <div class="mb-3">
                    <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control"
                           value="<?php echo $is_edit_mode ? htmlspecialchars($product['name']) : ''; ?>" required>
                </div>

                <!-- Danh mục -->
                <div class="mb-3">
                    <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        <option value="">-- Chọn danh mục --</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>"
                                <?php echo ($is_edit_mode && $product['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Giá -->
                <div class="mb-3">
                    <label for="price" class="form-label">Giá <span class="text-danger">*</span></label>
                    <input type="number" name="price" id="price" class="form-control"
                           value="<?php echo $is_edit_mode ? $product['price'] : ''; ?>" min="0" required>
                </div>

                <!-- Mô tả -->
                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả sản phẩm</label>
                    <textarea name="description" id="description" class="form-control" rows="5"><?php
                        echo $is_edit_mode ? htmlspecialchars($product['description']) : '';
                    ?></textarea>
                </div>

                <!-- Hình ảnh -->
                <div class="mb-3">
                    <label for="image" class="form-label">
                        Hình ảnh sản phẩm <?php echo $is_edit_mode ? '' : '<span class="text-danger">*</span>'; ?>
                    </label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*" <?php echo $is_edit_mode ? '' : 'required'; ?>>
                    <?php if ($is_edit_mode && !empty($product['image'])): ?>
                        <div class="mt-2">
                            <img src="<?php echo $product['image']; ?>" alt="Hình sản phẩm" class="img-thumbnail" style="max-width: 150px;">
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Nổi bật -->
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="featured" id="featured"
                        <?php echo ($is_edit_mode && $product['featured']) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="featured">Sản phẩm nổi bật</label>
                </div>

                <!-- Nút -->
                <div class="d-flex justify-content-end">
                    <a href="<?php echo BASE_URL; ?>?act=admin-product" class="btn btn-secondary me-2">Hủy</a>
                    <button type="submit" class="btn btn-primary">
                        <?php echo $is_edit_mode ? 'Cập nhật' : 'Thêm mới'; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once './views/admin/layout/footer.php'; ?>
