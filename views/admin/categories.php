<?php
// Layout header
require_once './views/admin/layout/header.php';

// Xác định chế độ form
$isEdit = ($_GET['action'] ?? '') === 'edit';
$formTitle = $isEdit ? 'Sửa danh mục' : 'Thêm danh mục mới';
$formButton = $isEdit ? 'Cập nhật' : 'Thêm mới';
$formId = $isEdit && isset($category['id']) ? (int)$category['id'] : '';
$formName = $isEdit && isset($category['name']) ? htmlspecialchars($category['name']) : '';
$formDesc = $isEdit && isset($category['description']) ? htmlspecialchars($category['description']) : '';
?>

<div class="container-fluid">
    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3"><i class="fas fa-tags me-2"></i>Quản lý danh mục</h2>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>?act=admin-product">Admin</a></li>
            <li class="breadcrumb-item active">Danh mục</li>
        </ol>
    </div>

    <div class="row">
        <!-- Form Add/Edit -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0"><?= $formTitle ?></h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php endif; ?>

                    <form action="<?= BASE_URL ?>?act=admin-categories<?= $isEdit ? '&action=edit&id='.$formId : '' ?>" method="post">
                        <?php if ($isEdit): ?>
                        <input type="hidden" name="id" value="<?= $formId ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="category_name" class="form-label">
                                Tên danh mục <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="category_name" 
                                   name="category_name" value="<?= $formName ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?= $formDesc ?></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i><?= $formButton ?>
                            </button>
                            <?php if ($isEdit): ?>
                                <a href="<?= BASE_URL ?>?act=admin-categories" class="btn btn-outline-secondary">Hủy</a>
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
              <form action="<?= BASE_URL ?>?act=admin-categories<?= $isEdit ? '&action=edit&id='.$formId : '' ?>" method="post"><form action="<?= BASE_URL ?>?act=admin-categories<?= $isEdit ? '&action=edit&id='.$formId : '' ?>" method="post">      <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên danh mục</th>
                                    <th>Mô tả</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $cat): ?>
                                        <tr>
                                            <td><?= (int)$cat['id'] ?></td>
                                            <td><?= htmlspecialchars($cat['name']) ?></td>
                                            <td><?= !empty($cat['description']) ? htmlspecialchars($cat['description']) : 'Không có mô tả' ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= BASE_URL ?>?act=admin-categories&action=edit&id=<?= (int)$cat['id'] ?>" 
                                                       class="btn btn-sm btn-primary" title="Sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?= BASE_URL ?>?act=admin-categories&action=delete&id=<?= (int)$cat['id'] ?>" 
                                                       class="btn btn-sm btn-danger" title="Xóa"
                                                       onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Không có danh mục nào</td>
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
document.addEventListener('DOMContentLoaded', () => {
    console.log('Categories page loaded');
    console.log('Categories data:', <?= json_encode($categories ?? []) ?>);
    <?php if (!empty($error)): ?>console.log('Error:', <?= json_encode($error) ?>);<?php endif; ?>
    <?php if (!empty($success)): ?>console.log('Success:', <?= json_encode($success) ?>);<?php endif; ?>
});
</script>

<?php require_once './views/admin/layout/footer.php'; ?>
