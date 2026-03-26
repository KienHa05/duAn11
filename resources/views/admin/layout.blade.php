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
                @yield('content')
            </main>
        </div>

        <!-- Sidebar -->
        <div class="drawer-side">
            <label for="drawer-toggle" class="drawer-overlay"></label>
            <aside class="min-h-full w-80 bg-base-100 text-base-content">
                <div class="p-4">
                    <h2 class="text-2xl font-bold text-primary">The Notorious</h2>
                    <p class="text-sm opacity-70">Admin Panel</p>
                </div>
                <ul class="menu p-4 w-full">
                    <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <x-heroicon-o-squares-2x2 class="w-5 h-5" /> Bảng điều khiển
                    </a></li>
                    <li><a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <x-heroicon-o-square-3-stack-3d class="w-5 h-5" /> Sản phẩm
                    </a></li>
                    <li><a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <x-heroicon-o-tag class="w-5 h-5" /> Danh mục
                    </a></li>
                </ul>
            </aside>
        </div>
    </div>

    <script>
        // Optional: Add any JavaScript for sidebar toggle if needed
    </script>
</body>
</html>
