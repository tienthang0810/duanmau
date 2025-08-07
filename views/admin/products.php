<?php
// Sử dụng layout admin
require_once './views/admin/layout/header.php';
?>

<div class="container-fluid">
    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3"><i class="fas fa-box me-2"></i>Quản lý sản phẩm</h2>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>?act=admin">Admin</a></li>
            <li class="breadcrumb-item active">Sản phẩm</li>
        </ol>
    </div>
    
    <!-- Action Buttons -->
    <div class="mb-4">
        <a href="<?php echo BASE_URL; ?>?act=admin-product&action=add" class="btn btn-primary" onclick="console.log('Add new product')">
            <i class="fas fa-plus me-2"></i>Thêm sản phẩm mới
        </a>
    </div>
    
    <!-- Products Table -->
    <div class="card">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="card-title mb-0">Danh sách sản phẩm</h5>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Tìm kiếm sản phẩm..." id="searchProduct">
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
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Nổi bật</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($products) && count($products) > 0): ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo $product['id']; ?></td>
                                    <td>
                                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="img-thumbnail" width="50">
                                    </td>
                                    <td><?php echo $product['name']; ?></td>
                                    <td><?php echo $product['category_name']; ?></td>
                                    <td><?php echo number_format($product['price'], 0, ',', '.'); ?> ₫</td>
                                    <td>
                                        <?php if ($product['featured'] == 1): ?>
                                            <span class="badge bg-success">Có</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Không</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo date('d/m/Y', strtotime($product['created_at'])); ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo BASE_URL; ?>?act=product-detail&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="Xem" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>?act=admin-product&action=edit&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Sửa" onclick="console.log('Edit product ID: <?php echo $product["id"]; ?>')">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>?act=admin-product&action=delete&id=<?php echo $product['id']; ?>" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Xóa" onclick="console.log('Delete product ID: <?php echo $product["id"]; ?>'); return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Không có sản phẩm nào</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Tìm kiếm sản phẩm
    document.getElementById('searchProduct').addEventListener('keyup', function() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById('searchProduct');
        filter = input.value.toUpperCase();
        table = document.querySelector('table');
        tr = table.getElementsByTagName('tr');
        
        for (i = 1; i < tr.length; i++) { // Bắt đầu từ 1 để bỏ qua header
            td = tr[i].getElementsByTagName('td')[2]; // Cột tên sản phẩm
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = '';
                } else {
                    tr[i].style.display = 'none';
                }
            }
        }
    });
</script>

<?php require_once './views/admin/layout/footer.php'; ?>