<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bảng điều khiển Admin') - The Notorious</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-base-200">
    <div class="drawer lg:drawer-open">
        <input id="drawer-toggle" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col">
            <!-- Navbar -->
            <div class="navbar bg-base-100 lg:hidden">
                <div class="flex-none">
                    <label for="drawer-toggle" class="btn btn-square btn-ghost">
                        <x-heroicon-o-bars-3 class="w-6 h-6" />
                    </label>
                </div>
                <div class="flex-1">
                    <h1 class="text-xl font-bold">Bảng điều khiển Admin</h1>
                </div>
            </div>

            <!-- Main Content -->
            <main class="flex-1 p-6">
                <x-notification />
                @yield('content')
            </main>
        </div>

        <!-- Sidebar -->
        <div class="drawer-side">
            <label for="drawer-toggle" class="drawer-overlay"></label>
            <aside class="min-h-full w-80 bg-base-100 text-base-content border-r border-base-200">
                <div class="p-5 sticky top-0 bg-base-100 z-10 border-b border-base-200">
                    <div class="flex items-center gap-3">
                        <div class="avatar placeholder">
                            <div class="w-10 rounded-lg bg-primary text-primary-content">
                                <span class="font-bold">TN</span>
                            </div>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-lg font-bold leading-tight">The Notorious</h2>
                            <p class="text-xs opacity-70 truncate">Admin Dashboard</p>
                        </div>
                    </div>
                </div>

                <div class="p-4">
                    <ul class="menu menu-md gap-1">
                        <!-- Dashboard -->
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <x-heroicon-o-squares-2x2 class="w-5 h-5" />
                                <span>Bảng điều khiển</span>
                            </a>
                        </li>

                        <!-- Products Management -->
                        <li>
                            <details class="{{ request()->routeIs('admin.products.*') ? 'open' : '' }}">
                                <summary class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                                    <x-heroicon-o-square-3-stack-3d class="w-5 h-5" />
                                    <span>Quản lý sản phẩm</span>
                                </summary>
                                <ul class="bg-base-200 rounded-lg mt-1">
                                    <li>
                                        <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                                            <x-heroicon-o-list-bullet class="w-4 h-4" />
                                            <span>Danh sách sản phẩm</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.products.create') }}" class="{{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                                            <x-heroicon-o-plus-circle class="w-4 h-4" />
                                            <span>Thêm sản phẩm mới</span>
                                        </a>
                                    </li>
                                </ul>
                            </details>
                        </li>

                        <!-- Categories -->
                        <li>
                            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                                <x-heroicon-o-tag class="w-5 h-5" />
                                <span>Danh mục</span>
                            </a>
                        </li>
                    </ul>

                    <div class="divider my-4"></div>

                    <a href="{{ route('home') }}" class="btn btn-ghost w-full justify-start gap-2">
                        <x-heroicon-o-home class="w-5 h-5" />
                        Về trang chủ
                    </a>
                </div>
            </aside>
        </div>
    </div>

    <script>
        // Optional: Add any JavaScript for sidebar toggle if needed
    </script>
</body>
</html>
