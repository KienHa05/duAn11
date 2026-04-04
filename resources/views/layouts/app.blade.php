<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'The Notorious - Thời trang thể thao')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-base-50">
    <div x-data="cartStore()" @cart-updated.window="updateCart($event)">
        <!-- Header Component -->
        <x-header :cartCount="$cartCount ?? 0" />
        
        <!-- Main Content -->
        <main class="min-h-screen">
            @yield('content')
        </main>
        
        <!-- Footer -->
        <footer class="bg-base-200 border-t border-base-300 mt-16 py-8">
            <div class="container mx-auto px-4 sm:px-6 max-w-7xl">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <h3 class="font-bold text-lg mb-4">The Notorious</h3>
                        <p class="text-sm text-base-content/70">Thời trang thể thao chất lượng cao, giá cải phải.</p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Hỗ trợ khách hàng</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="link link-hover">Liên hệ chúng tôi</a></li>
                            <li><a href="#" class="link link-hover">Câu hỏi thường gặp</a></li>
                            <li><a href="#" class="link link-hover">Chính sách trả hàng</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Về chúng tôi</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="link link-hover">Về The Notorious</a></li>
                            <li><a href="#" class="link link-hover">Tin tức</a></li>
                            <li><a href="#" class="link link-hover">Blogs</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Kết nối</h4>
                        <div class="flex gap-4">
                            <a href="#" class="link link-hover">Facebook</a>
                            <a href="#" class="link link-hover">Instagram</a>
                            <a href="#" class="link link-hover">Twitter</a>
                        </div>
                    </div>
                </div>
                <div class="border-t border-base-300 pt-8 text-center text-sm text-base-content/60">
                    <p>&copy; 2026 The Notorious. Tất cả quyền được bảo lưu.</p>
                </div>
            </div>
        </footer>
        
        <!-- Cart Drawer -->
        <x-cart-drawer />
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @vite(['resources/js/cart.js', 'resources/js/init.js'])
</body>
</html>
