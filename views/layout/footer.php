</div>
    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Shop Thời Trang</h5>
                    <p>Chuyên cung cấp các sản phẩm đẹp với giá tốt nhất thị trường.</p>
                </div>
                <div class="col-md-4">
                    <h5>Liên kết nhanh</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo BASE_URL; ?>" class="text-white">Trang chủ</a></li>
                        <li><a href="<?php echo BASE_URL; ?>?act=products" class="text-white">Sản phẩm</a></li>
                        <li><a href="#" class="text-white">Về chúng tôi</a></li>
                        <li><a href="#" class="text-white">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Liên hệ</h5>
                    <address>
                        <p><i class="fas fa-map-marker-alt me-2"></i> 123 Đường ABC, Quận XYZ, TP. HCM</p>
                        <p><i class="fas fa-phone me-2"></i> (123) 456-7890</p>
                        <p><i class="fas fa-envelope me-2"></i> info@shopthoitrang.com</p>
                    </address>
                </div>
            </div>
            <hr class="bg-light">
            <div class="text-center">
                <p>&copy; <?php echo date('Y'); ?> Shop Thời Trang. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() { 
            // Làm cho toàn bộ card sản phẩm có thể nhấp vào
            const productCards = document.querySelectorAll('.product-item .card');
            productCards.forEach(card => {
                const detailLink = card.querySelector('a.btn-primary');
                if (detailLink) {
                    const href = detailLink.getAttribute('href');
                    card.style.cursor = 'pointer';
                    card.addEventListener('click', function(e) {
                        // Nếu người dùng nhấp vào nút, không làm gì cả (để nút xử lý sự kiện của nó)
                        if (e.target.tagName === 'A' || e.target.closest('a')) {
                            return;
                        }
                        // Nếu không, chuyển hướng đến trang chi tiết
                        window.location.href = href;
                    });
                }
            });
        });
    </script>
</body>
</html>