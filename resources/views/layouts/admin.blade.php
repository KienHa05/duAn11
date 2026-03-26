<!DOCTYPE html>
<html lang="vi" data-theme="corporate">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - The Notorious')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-base-200">
    <div class="drawer">
        <input id="drawer-toggle" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content">
            <!-- Navbar -->
            <div class="navbar bg-base-100 shadow-lg">
                <div class="navbar-start">
                    <label for="drawer-toggle" class="btn btn-ghost btn-circle drawer-button">
                        <i class="fas fa-bars"></i>
                    </label>
                    <a class="btn btn-ghost normal-case text-xl font-bold">Admin Dashboard</a>
                </div>
                <div class="navbar-end">
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 rounded-full bg-primary text-primary-content flex items-center justify-center font-bold">A</div>
                        </label>
                        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                            <li><a>Profile</a></li>
                            <li><a>Settings</a></li>
                            <li><a>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="p-6">
                @if(session('success'))
                    <div class="alert alert-success shadow-lg mb-4">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error shadow-lg mb-4">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            <strong>Có lỗi xảy ra!</strong>
                            <ul class="mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>

        <div class="drawer-side">
            <label for="drawer-toggle" class="drawer-overlay"></label>
            <aside class="min-h-full w-80 bg-base-100 text-base-content border-r">
                <div class="p-4">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-ghost normal-case text-xl font-bold mb-4">
                        <i class="fas fa-shield-alt mr-2"></i>
                        The Notorious
                    </a>
                </div>

                <ul class="menu p-4 w-full text-base-content">
                    <li>
                        <a href="{{ route('admin.products.index') }}" class="@if(Route::currentRouteName() == 'admin.products.index') active @endif">
                            <i class="fas fa-list"></i>
                            Danh sách sản phẩm
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.products.create') }}" class="@if(Route::currentRouteName() == 'admin.products.create') active @endif">
                            <i class="fas fa-plus-circle"></i>
                            Thêm sản phẩm
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="/">
                            <i class="fas fa-home"></i>
                            Về trang chủ
                        </a>
                    </li>
                </ul>
            </aside>
        </div>
    </div>
</body>
</html>
