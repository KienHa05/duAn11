<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - The Notorious')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #000000;
            --sidebar-width: 280px;
            --sidebar-bg: #000000;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            color: white;
            padding: 20px 0;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar.collapsed {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .sidebar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-brand:hover {
            color: var(--primary-color);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu li {
            margin: 0;
        }

        .sidebar-menu a {
            display: block;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--primary-color);
        }

        .sidebar-menu i {
            width: 20px;
            margin-right: 10px;
        }

        /* Top Navbar */
        .top-navbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: 70px;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 999;
            transition: left 0.3s ease;
        }

        .top-navbar.full-width {
            left: 0;
        }

        .navbar-start {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .toggle-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--primary-color);
            cursor: pointer;
            padding: 0;
        }

        .toggle-btn:hover {
            color: #333333;
        }

        .navbar-brand-text {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--sidebar-bg);
        }

        .navbar-end {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: 70px;
            padding: 30px;
            transition: margin-left 0.3s ease;
            min-height: calc(100vh - 70px);
        }

        .main-content.full-width {
            margin-left: 0;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .page-header h1 {
            margin: 0;
            font-size: 2rem;
            color: var(--sidebar-bg);
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .card-header {
            background: var(--primary-color);
            color: white;
            border-radius: 8px 8px 0 0;
            padding: 15px 20px;
        }

        .card-header h3 {
            margin: 0;
            font-size: 1.3rem;
        }

        /* Table Styles */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: var(--sidebar-bg);
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #333333;
            border-color: #333333;
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.875rem;
        }

        /* Forms */
        .form-control,
        .form-select {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 10px 12px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: var(--sidebar-bg);
            margin-bottom: 8px;
        }

        /* Alerts */
        .alert {
            border-radius: 6px;
            border: 1px solid;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        /* Pagination */
        .pagination {
            gap: 5px;
        }

        .page-link {
            border-radius: 4px;
            border: 1px solid #ddd;
            color: var(--primary-color);
        }

        .page-link:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .page-link.active {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            :root {
                --sidebar-width: 220px;
            }

            .navbar-end {
                gap: 15px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }
        }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand" style="display: flex; align-items: center; gap: 12px; text-decoration: none; padding: 10px 0;">
                <div style="width: 36px; height: 36px; border-radius: 10px; background-color: #fff; color: #000; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.1rem; flex-shrink: 0;">
                    N
                </div>
                <span style="font-size: 1.25rem; font-weight: 900; letter-spacing: -0.5px; text-transform: uppercase; color: #fff;">
                    Notorious
                </span>
            </a>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.products.index') }}"
                   class="@if(Route::currentRouteName() == 'admin.products.index') active @endif">
                    <i class="fas fa-list"></i>
                    <span>Danh sách sản phẩm</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.products.create') }}"
                   class="@if(Route::currentRouteName() == 'admin.products.create') active @endif">
                    <i class="fas fa-plus-circle"></i>
                    <span>Thêm sản phẩm</span>
                </a>
            </li>
            <li style="margin-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
                <a href="/">
                    <i class="fas fa-home"></i>
                    <span>Về trang chủ</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Top Navbar -->
    <nav class="top-navbar" id="topNavbar">
        <div class="navbar-start">
            <button class="toggle-btn" id="toggleSidebar">
                <i class="fas fa-bars"></i>
            </button>
            <span class="navbar-brand-text">Admin Dashboard</span>
        </div>

        <div class="navbar-end">
            <div class="navbar-user">
                <div class="user-avatar">{{ substr(Auth::guard('admin')->user()->name, 0, 1) }}</div>
                <div class="me-3">
                    <div style="font-size: 0.9rem; font-weight: 600;">{{ Auth::guard('admin')->user()->name }}</div>
                    <div style="font-size: 0.8rem; color: #999;">Administrator</div>
                </div>
                
                <!-- Admin Logout -->
                <form action="{{ route('admin.logout') }}" method="POST" class="ms-3 border-start ps-3">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                        <i class="fas fa-sign-out-alt me-1"></i> Đăng xuất Admin
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Có lỗi xảy ra!</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const topNavbar = document.getElementById('topNavbar');
        const mainContent = document.getElementById('mainContent');

        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            topNavbar.classList.toggle('full-width');
            mainContent.classList.toggle('full-width');
        });

        // Set active menu item based on current URL
        document.querySelectorAll('.sidebar-menu a').forEach(link => {
            if (link.href === window.location.href) {
                link.classList.add('active');
            }
        });
    </script>
</body>
</html>
