<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Quản lý Shop Điện Tử'; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color:  #a88de6ff;
            --secondary-color: #DBE4C9;
            --light-color: #FFFFF0;
            --accent-color: #FEA405;
            --dark-color: #333333;
        }
        
        body {
            background-color: var(--light-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .admin-header {
            background-color: var(--primary-color);
            color: var(--light-color);
            padding: 1rem 0;
        }
        
        .admin-sidebar {
            background-color: var(--dark-color);
            color: var(--light-color);
            min-height: calc(100vh - 56px);
        }
        
        .admin-sidebar .nav-link {
            color: var(--light-color);
            padding: 0.8rem 1rem;
            border-radius: 0;
            transition: all 0.3s;
        }
        
        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            background-color: var(--primary-color);
        }
        
        .admin-sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .admin-content {
            padding: 2rem;
            flex-grow: 1;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-stat {
            border-left: 5px solid var(--primary-color);
        }
        
        .card-stat i {
            font-size: 2.5rem;
            color: var(--primary-color);
        }
        
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        
        .table thead {
            background-color: var(--primary-color);
            color: var(--light-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #7A9020;
            border-color: #7A9020;
        }
        
        .btn-accent {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: var(--light-color);
        }
        
        .btn-accent:hover {
            background-color: #E09000;
            border-color: #E09000;
            color: var(--light-color);
        }
    </style>
</head>
<body>
    <!-- Admin Header -->
    <header class="admin-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="h4 mb-0">Quản trị</h1>
                </div>
                <div class="col-md-6 text-end">
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i>
                            <?php echo isset($_SESSION['fullname']) ? $_SESSION['fullname'] : 'Admin'; ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>"><i class="fas fa-store me-2"></i>Xem cửa hàng</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>?act=logout"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <!-- Admin Sidebar -->
            <div class="col-md-3 col-lg-2 admin-sidebar p-0">
                <nav class="nav flex-column">
                    <a class="nav-link <?php echo isset($_GET['section']) && $_GET['section'] === 'products' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>?act=admin-product">
                        <i class="fas fa-box"></i> Sản phẩm
                    </a>
                    <a class="nav-link <?php echo isset($_GET['section']) && $_GET['section'] === 'categories' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>?act=admin-categories">
                        <i class="fas fa-tags"></i> Danh mục
                    </a>
                    <a class="nav-link <?php echo isset($_GET['section']) && $_GET['section'] === 'users' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>?act=admin-users">
                        <i class="fas fa-users"></i> Người dùng
                    </a>
                </nav>
            </div>

            <!-- Admin Content -->
            <div class="col-md-9 col-lg-10 admin-content">