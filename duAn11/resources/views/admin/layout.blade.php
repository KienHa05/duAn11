<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tổng Quan Admin') - The Notorious</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

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
                    <h1 class="text-xl font-bold">Tổng Quan Admin</h1>
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
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group px-1">
                        <div class="w-10 h-10 flex flex-shrink-0 items-center justify-center rounded-xl bg-black text-white font-black text-lg shadow-sm transition-transform group-hover:scale-105 cursor-pointer">
                            N
                        </div>
                        <div class="min-w-0 flex flex-col justify-center cursor-pointer">
                            <span class="text-xl font-black tracking-tighter uppercase leading-none text-black">Notorious</span>
                            <span class="text-[9px] font-bold uppercase tracking-[0.2em] text-gray-400 mt-1">Admin Dashboard</span>
                        </div>
                    </a>
                </div>

                <div class="p-4">
                    <ul class="menu menu-md gap-1">
                        <!-- Dashboard -->
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <x-heroicon-o-squares-2x2 class="w-5 h-5" />
                                <span>Tổng Quan</span>
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
                                <span>Quản Lý Danh mục</span>
                            </a>
                        </li>

                        <!-- Orders -->
                        <li>
                            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                                <x-heroicon-o-shopping-bag class="w-5 h-5" />
                                <span>Quản Lý Đơn Hàng</span>
                            </a>
                        </li>

                    </ul>

                    <div class="divider my-4"></div>

                    <!-- Admin Session Info & Logout -->
                    <div class="bg-base-200 rounded-2xl p-4 mb-4">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="avatar placeholder">
                                <div class="w-10 rounded-full bg-neutral text-neutral-content">
                                    <span>{{ substr(Auth::guard('admin')->user()->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-black uppercase tracking-widest opacity-50">Đang quản trị</p>
                                <p class="text-sm font-bold truncate">{{ Auth::guard('admin')->user()->name }}</p>
                            </div>
                        </div>
                        
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-error btn-sm btn-block gap-2 rounded-xl text-white font-bold">
                                <x-heroicon-o-arrow-left-on-rectangle class="w-4 h-4" />
                                Đăng xuất
                            </button>
                        </form>
                    </div>

                    <a href="{{ route('home') }}" class="btn btn-ghost w-full justify-start gap-2 rounded-xl">
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
    @stack('scripts')
</body>
</html>
