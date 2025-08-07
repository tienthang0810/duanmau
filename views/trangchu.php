<?php
$page_title = "Trang chủ";
require_once './views/layout/header.php';
?>

<!-- Hero Section -->
<div class="bg-secondary-subtle py-5 mb-5 rounded">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-4 fw-bold">Cảm ơn bạn đã ghé qua!</h1>
                <p class="lead">Chúng tôi cung cấp các sản chất lượng cao với giá cả hợp lý.</p>
                <a href="<?php echo BASE_URL; ?>?act=products" class="btn btn-primary btn-lg">Xem sản phẩm</a>
            </div>
            <div class="col-md-6">
                <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=1170&q=80" alt="Electronics" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<!-- Featured Categories -->
<section class="mb-5">
    <div class="container">
        <h2 class="text-center mb-4">Danh mục nổi bật</h2>
        <div class="row g-4">
            <?php if (isset($categories) && count($categories) > 0): ?>
                <?php 
                // Hiển thị tối đa 3 danh mục đầu tiên
                $displayedCategories = array_slice($categories, 0, 3);
                $remainingCategories = array_slice($categories, 3);
                $hasMoreCategories = count($remainingCategories) > 0;
                ?>
                
                <div class="row initial-categories">
                    <?php foreach ($displayedCategories as $category): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 text-center">
                                <div class="card-body">
                                    <?php 
                                    // Chọn icon phù hợp dựa trên tên danh mục
                                    $icon = 'fa-solid fa-shirt';
                                    $categoryName = strtolower($category['name']);
                                    
                                    if (strpos($categoryName, 'laptop') !== false) {
                                        $icon = 'fas fa-laptop';
                                    } elseif (strpos($categoryName, 'điện thoại') !== false || strpos($categoryName, 'phone') !== false) {
                                        $icon = 'fas fa-mobile-alt';
                                    } elseif (strpos($categoryName, 'tai nghe') !== false || strpos($categoryName, 'headphone') !== false) {
                                        $icon = 'fas fa-headphones';
                                    } elseif (strpos($categoryName, 'máy tính bảng') !== false || strpos($categoryName, 'tablet') !== false) {
                                        $icon = 'fas fa-tablet-alt';
                                    } elseif (strpos($categoryName, 'phụ kiện') !== false || strpos($categoryName, 'accessory') !== false) {
                                        $icon = 'fas fa-plug';
                                    }
                                    ?>
                                    <i class="<?php echo $icon; ?> fa-4x mb-3" style="color: var(--primary-color);"></i>
                                    <h5 class="card-title"><?php echo $category['name']; ?></h5>
                                    <p class="card-text"><?php echo !empty($category['description']) ? $category['description'] : 'Khám phá các sản phẩm ' . $category['name'] . ' mới nhất của chúng tôi.'; ?></p>
                                    <a href="<?php echo BASE_URL; ?>?act=products&category=<?php echo $category['id']; ?>" class="btn btn-outline-primary">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <?php if ($hasMoreCategories): ?>
                <div class="row remaining-categories" style="display: none;">
                    <?php foreach ($remainingCategories as $category): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 text-center">
                                <div class="card-body">
                                    <?php 
                                    // Chọn icon phù hợp dựa trên tên danh mục
                                    $icon = 'fas fa-box';
                                    $categoryName = strtolower($category['name']);
                                    
                                    if (strpos($categoryName, 'laptop') !== false) {
                                        $icon = 'fas fa-laptop';
                                    } elseif (strpos($categoryName, 'điện thoại') !== false || strpos($categoryName, 'phone') !== false) {
                                        $icon = 'fas fa-mobile-alt';
                                    } elseif (strpos($categoryName, 'tai nghe') !== false || strpos($categoryName, 'headphone') !== false) {
                                        $icon = 'fas fa-headphones';
                                    } elseif (strpos($categoryName, 'máy tính bảng') !== false || strpos($categoryName, 'tablet') !== false) {
                                        $icon = 'fas fa-tablet-alt';
                                    } elseif (strpos($categoryName, 'phụ kiện') !== false || strpos($categoryName, 'accessory') !== false) {
                                        $icon = 'fas fa-plug';
                                    }
                                    ?>
                                    <i class="<?php echo $icon; ?> fa-4x mb-3" style="color: var(--primary-color);"></i>
                                    <h5 class="card-title"><?php echo $category['name']; ?></h5>
                                    <p class="card-text"><?php echo !empty($category['description']) ? $category['description'] : 'Khám phá các sản phẩm ' . $category['name'] . ' mới nhất của chúng tôi.'; ?></p>
                                    <a href="<?php echo BASE_URL; ?>?act=products&category=<?php echo $category['id']; ?>" class="btn btn-outline-primary">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="text-center mt-3">
                    <button id="toggleCategories" class="btn btn-primary">Xem tất cả danh mục</button>
                </div>
                <?php endif; ?>
                
            <?php else: ?>
                <div class="col-md-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-laptop fa-4x mb-3" style="color: var(--primary-color);"></i>
                            <h5 class="card-title">Laptop</h5>
                            <p class="card-text">Các dòng laptop mới nhất với hiệu năng mạnh mẽ.</p>
                            <a href="<?php echo BASE_URL; ?>?act=products" class="btn btn-outline-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-mobile-alt fa-4x mb-3" style="color: var(--primary-color);"></i>
                            <h5 class="card-title">Điện thoại</h5>
                            <p class="card-text">Smartphone với công nghệ tiên tiến và thiết kế hiện đại.</p>
                            <a href="<?php echo BASE_URL; ?>?act=products" class="btn btn-outline-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-headphones fa-4x mb-3" style="color: var(--primary-color);"></i>
                        <h5 class="card-title">Phụ kiện</h5>
                        <p class="card-text">Các phụ kiện chất lượng cao cho thiết bị điện tử của bạn.</p>
                        <a href="#" class="btn btn-outline-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="mb-5">
    <div class="container">
        <h2 class="text-center mb-4">Sản phẩm nổi bật</h2>
        <div class="row">
            <?php if (isset($featuredProducts) && count($featuredProducts) > 0): ?>
                <?php foreach ($featuredProducts as $product): ?>
                    <div class="col-md-3 product-item mb-4">
                        <div class="card h-100">

                            <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo $product['name']; ?></h5>
                                <p class="card-text flex-grow-1"><?php echo substr($product['description'], 0, 60); ?>...</p>
                                <p class="text-primary fw-bold"><?php echo number_format($product['price'], 0, ',', '.'); ?> ₫</p>
                                <a href="<?php echo BASE_URL; ?>?act=product-detail&id=<?php echo $product['id']; ?>" class="btn btn-primary w-100 mt-2">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-md-3 product-item">
                    <div class="card h-100">
                        <img src="https://images.unsplash.com/photo-1576871337622-98d48d1cf531?q=80&w=387&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="card-img-top" alt="aothun">
                        <div class="card-body">
                            <h5 class="card-title">Áo thun</h5>
                            <p class="card-text">Áo croptop ôm body, thích hợp tập gym hoặc mặc hàng ngày.</p>
                            <p class="text-primary fw-bold">500.000 ₫</p>
                            <a href="<?php echo BASE_URL; ?>?act=product-detail&id=1" class="btn btn-primary w-100">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?php echo BASE_URL; ?>?act=products" class="btn btn-outline-primary">Xem tất cả sản phẩm</a>
        </div>
    </div>
</section>

<?php require_once './views/layout/footer.php'; ?>

