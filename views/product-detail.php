<?php
$page_title = isset($product) ? $product['name'] . " - Shop Thời Trang" : "Chi tiết sản phẩm";
require_once './views/layout/header.php';
?>

<div class="container py-4">
    <?php if (isset($product) && $product): ?>
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>?act=products">Sản phẩm</a></li>
            <?php if (isset($category) && $category): ?>
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>?act=products&category=<?php echo $category['id']; ?>"><?php echo $category['name']; ?></a></li>
            <?php endif; ?>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $product['name']; ?></li>
        </ol>
    </nav>
    
    <div class="row">
        <!-- Product Images -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="<?php echo $product['image']; ?>" class="d-block w-100" alt="<?php echo $product['name']; ?>" style="height: 400px; object-fit: contain;">
                            </div>
                            <!-- Có thể thêm nhiều hình ảnh khác nếu có -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Product Details -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="mb-3"><?php echo $product['name']; ?></h1>
                    <div class="mb-3">
                        <span class="badge bg-success me-2">Còn hàng</span>
                        <span class="text-muted">Mã sản phẩm: <?php echo $product['id']; ?></span>
                    </div>
                    
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-2">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star-half-alt text-warning"></i>
                        </div>
                        <span>(5 đánh giá)</span>
                    </div>
                    
                    <h2 class="text-primary mb-3"><?php echo number_format($product['price'], 0, ',', '.'); ?> ₫</h2>
                    
                    <div class="mb-4">
                        <h5>Mô tả ngắn:</h5>
                        <p><?php echo substr($product['description'], 0, 200); ?>...</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5>Thông tin sản phẩm:</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Danh mục:</span>
                                <span><?php echo isset($category) ? $category['name'] : 'NULL'; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Thương hiệu:</span>
                                <span><?php echo !empty($product['brand']) ? $product['brand'] : 'Áo Việt'; ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Tình trạng:</span>
                                <span>Còn hàng</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="quantity" class="form-label">Số lượng:</label>
                                <input type="number" class="form-control" id="quantity" value="1" min="1">
                            </div>
                        </div>
                        <button class="btn btn-primary btn-lg me-2">
                            <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ hàng
                        </button>
                        <button class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-heart me-2"></i>Yêu thích
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!-- Related Products -->
     <?php if (isset($relatedProducts) && count($relatedProducts) > 0): ?>
     <div class="row mt-5">
         <div class="col-12">
             <h3 class="mb-4">Sản phẩm liên quan</h3>
             <div class="row">
                 <?php foreach ($relatedProducts as $relatedProduct): ?>
                 <div class="col-md-3 mb-4">
                     <div class="card h-100">

                         <img src="<?php echo $relatedProduct['image']; ?>" class="card-img-top" alt="<?php echo $relatedProduct['name']; ?>" style="height: 200px; object-fit: cover;">
                         <div class="card-body d-flex flex-column">
                             <h5 class="card-title"><?php echo $relatedProduct['name']; ?></h5>
                             <p class="card-text flex-grow-1"><?php echo substr($relatedProduct['description'], 0, 60); ?>...</p>
                             <p class="text-primary fw-bold"><?php echo number_format($relatedProduct['price'], 0, ',', '.'); ?> ₫</p>
                             <a href="<?php echo BASE_URL; ?>?act=product-detail&id=<?php echo $relatedProduct['id']; ?>" class="btn btn-primary w-100 mt-2">Xem chi tiết</a>
                         </div>
                     </div>
                 </div>
                 <?php endforeach; ?>
             </div>
         </div>
     </div>
     <?php endif; ?>
     <?php else: ?>
     <div class="alert alert-warning" role="alert">
         Không tìm thấy thông tin sản phẩm!
     </div>
     <?php endif; ?>
</div>

<?php
require_once './views/layout/footer.php';
?>