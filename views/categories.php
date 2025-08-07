<?php
// Sử dụng layout chung
require_once './views/layout/header.php';
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4"><?php echo $title; ?></h1>
        </div>
    </div>
    
    <div class="row">
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $category): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($category['name']); ?></h5>
                            <?php if (!empty($category['description'])): ?>
                                <p class="card-text"><?php echo htmlspecialchars($category['description']); ?></p>
                            <?php else: ?>
                                <p class="card-text text-muted">Không có mô tả</p>
                            <?php endif; ?>
                            <a href="<?php echo BASE_URL; ?>?act=products&category=<?php echo $category['id']; ?>" class="btn btn-primary">
                                Xem sản phẩm
                                <?php if (isset($category['product_count'])): ?>
                                    <span class="badge bg-light text-dark ms-1"><?php echo $category['product_count']; ?></span>
                                <?php endif; ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">
                    Không có danh mục nào.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
require_once './views/layout/footer.php';
?>