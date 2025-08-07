<?php
$page_title = "Sản phẩm";
require_once './views/layout/header.php';

// Xác định tiêu đề trang
$pageHeading = "Sản phẩm của chúng tôi";
$pageSubheading = "Khám phá các mẫu áo chất lượng cao";

// Nếu đang lọc theo danh mục
if (isset($selectedCategory)) {
    $pageHeading = $selectedCategory['name'];
    $pageSubheading = "Các sản phẩm thuộc danh mục {$selectedCategory['name']}";
}

// Nếu đang tìm kiếm
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $pageHeading = "Kết quả tìm kiếm";
    $pageSubheading = "Tìm kiếm cho: {$_GET['search']}";
}
?>

<!-- Products Banner -->
<div class="bg-primary text-white py-4 mb-4 rounded">
    <div class="container">
        <h1 class="text-center"><?php echo $pageHeading; ?></h1>
        <p class="text-center lead"><?php echo $pageSubheading; ?></p>
    </div>
</div>

<!-- Filter and Search -->
<div class="container mb-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Danh mục</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="<?php echo BASE_URL; ?>?act=products" class="list-group-item list-group-item-action <?php echo !isset($_GET['category']) ? 'active' : ''; ?>">Tất cả sản phẩm</a>
                        <?php foreach ($categories as $category): ?>
                            <a href="<?php echo BASE_URL; ?>?act=products&category=<?php echo $category['id']; ?>" 
                               class="list-group-item list-group-item-action <?php echo (isset($_GET['category']) && $_GET['category'] == $category['id']) ? 'active' : ''; ?>">
                                <?php echo $category['name']; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <?php if (isset($totalProducts) && isset($currentPage) && isset($productsPerPage)): ?>
                        <span>
                            Hiển thị 
                            <?php 
                                $start = ($currentPage - 1) * $productsPerPage + 1;
                                $end = min($start + count($products) - 1, $totalProducts);
                                echo "$start-$end của $totalProducts sản phẩm";
                            ?>
                        </span>
                    <?php else: ?>
                        <span>Hiển thị sản phẩm</span>
                    <?php endif; ?>
                </div>
                <div class="d-flex">
                    <form action="<?php echo BASE_URL; ?>" method="GET" class="d-flex">
                        <input type="hidden" name="act" value="products">
                        <?php if (isset($_GET['category'])): ?>
                            <input type="hidden" name="category" value="<?php echo $_GET['category']; ?>">
                        <?php endif; ?>
                        <div class="input-group me-2">
                            <input type="text" class="form-control" name="search" placeholder="Tìm kiếm..." 
                                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                    <select class="form-select" style="width: auto;" onchange="window.location.href=this.value">
                        <option value="<?php echo BASE_URL; ?>?act=products<?php echo isset($_GET['category']) ? '&category='.$_GET['category'] : ''; ?><?php echo isset($_GET['search']) ? '&search='.$_GET['search'] : ''; ?>" 
                            <?php echo !isset($_GET['sort']) ? 'selected' : ''; ?>>Sắp xếp theo</option>
                        <option value="<?php echo BASE_URL; ?>?act=products<?php echo isset($_GET['category']) ? '&category='.$_GET['category'] : ''; ?><?php echo isset($_GET['search']) ? '&search='.$_GET['search'] : ''; ?>&sort=price_asc" 
                            <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'selected' : ''; ?>>Giá: Thấp đến cao</option>
                        <option value="<?php echo BASE_URL; ?>?act=products<?php echo isset($_GET['category']) ? '&category='.$_GET['category'] : ''; ?><?php echo isset($_GET['search']) ? '&search='.$_GET['search'] : ''; ?>&sort=price_desc" 
                            <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? 'selected' : ''; ?>>Giá: Cao đến thấp</option>
                        <option value="<?php echo BASE_URL; ?>?act=products<?php echo isset($_GET['category']) ? '&category='.$_GET['category'] : ''; ?><?php echo isset($_GET['search']) ? '&search='.$_GET['search'] : ''; ?>&sort=newest" 
                            <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'newest') ? 'selected' : ''; ?>>Mới nhất</option>
                    </select>
                </div>
            </div>
            
            <div class="row">
                <?php if (isset($products) && count($products) > 0): ?>
                    <?php foreach ($products as $product): ?>
                        <!-- Product -->
                        <div class="col-md-4 product-item mb-4">
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
                    <div class="col-12">
                        <div class="alert alert-info">
                            Không tìm thấy sản phẩm nào.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Pagination -->
            <?php if (isset($totalProducts) && isset($currentPage) && isset($productsPerPage) && $totalProducts > $productsPerPage): ?>
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php 
                            $totalPages = ceil($totalProducts / $productsPerPage);
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($totalPages, $startPage + 4);
                            
                            if ($startPage > 1) {
                                echo '<li class="page-item"><a class="page-link" href="' . BASE_URL . '?act=products' . 
                                    (isset($_GET['category']) ? '&category=' . $_GET['category'] : '') . 
                                    (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '') . 
                                    (isset($_GET['sort']) ? '&sort=' . $_GET['sort'] : '') . 
                                    '&page=1">1</a></li>';
                                
                                if ($startPage > 2) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                            }
                            
                            for ($i = $startPage; $i <= $endPage; $i++) {
                                echo '<li class="page-item ' . ($i == $currentPage ? 'active' : '') . '">';
                                echo '<a class="page-link" href="' . BASE_URL . '?act=products' . 
                                    (isset($_GET['category']) ? '&category=' . $_GET['category'] : '') . 
                                    (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '') . 
                                    (isset($_GET['sort']) ? '&sort=' . $_GET['sort'] : '') . 
                                    '&page=' . $i . '">' . $i . '</a>';
                                echo '</li>';
                            }
                            
                            if ($endPage < $totalPages) {
                                if ($endPage < $totalPages - 1) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                                
                                echo '<li class="page-item"><a class="page-link" href="' . BASE_URL . '?act=products' . 
                                    (isset($_GET['category']) ? '&category=' . $_GET['category'] : '') . 
                                    (isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '') . 
                                    (isset($_GET['sort']) ? '&sort=' . $_GET['sort'] : '') . 
                                    '&page=' . $totalPages . '">' . $totalPages . '</a></li>';
                            }
                        ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
        </div>
    </div>
</div>

<?php require_once './views/layout/footer.php'; ?>