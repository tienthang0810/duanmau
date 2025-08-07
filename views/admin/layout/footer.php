</div> <!-- End Admin Content -->
        </div> <!-- End Row -->
    </div> <!-- End Container -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Custom Admin Scripts -->
    <script>
        // Khởi tạo tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
        
        // Khởi tạo biểu đồ nếu có
        if (document.getElementById('salesChart')) {
            var ctx = document.getElementById('salesChart').getContext('2d');
            var salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
                    datasets: [{
                        label: 'Doanh số',
                        data: [12, 19, 3, 5, 2, 3, 8, 14, 10, 15, 9, 11],
                        backgroundColor: 'rgba(138, 166, 36, 0.2)',
                        borderColor: 'rgba(138, 166, 36, 1)',
                        borderWidth: 2,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
        
        if (document.getElementById('categoryChart')) {
            var ctx = document.getElementById('categoryChart').getContext('2d');
            var categoryChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Laptop', 'Điện thoại', 'Máy tính bảng', 'Phụ kiện', 'TV & Màn hình', 'Thiết bị thông minh'],
                    datasets: [{
                        data: [30, 25, 15, 10, 10, 10],
                        backgroundColor: [
                            'rgba(138, 166, 36, 0.8)',
                            'rgba(254, 164, 5, 0.8)',
                            'rgba(219, 228, 201, 0.8)',
                            'rgba(138, 166, 36, 0.5)',
                            'rgba(254, 164, 5, 0.5)',
                            'rgba(219, 228, 201, 0.5)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>