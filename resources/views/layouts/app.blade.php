<!DOCTYPE html>
<html lang="vi" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'The Notorious - Thời trang thể thao cao cấp')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-base-50 text-base-content antialiased flex flex-col min-h-screen">
    <div x-data="cartStore()" @cart-updated.window="updateCart($event)" class="flex flex-col min-h-screen">
        <!-- Header Component -->
        <x-header :cartCount="$cartCount ?? 0" />
        
        <!-- Main Content -->
        <main class="flex-grow">
            @yield('content')
        </main>
        
        <!-- Premium Footer -->
        <footer class="bg-slate-900 border-t border-slate-800 mt-20 pt-16 pb-8 text-slate-300">
            <div class="container mx-auto px-4 sm:px-6 max-w-7xl">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
                    <!-- Brand Section -->
                    <div class="space-y-6">
                        <a href="/" class="inline-flex items-center gap-2 group">
                            <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center text-slate-900 font-black text-lg shadow-lg group-hover:scale-105 transition-transform duration-300">
                                N
                            </div>
                            <span class="text-xl font-bold tracking-tighter text-white">The Notorious</span>
                        </a>
                        <p class="text-sm text-slate-400 leading-relaxed max-w-xs">
                            Định hình phong cách thể thao hiện đại với những thiết kế đột phá, dẫn đầu xu hướng và đề cao tính ứng dụng.
                        </p>
                        <div class="flex gap-4">
                            <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all duration-300 transform hover:-translate-y-1">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-pink-600 hover:text-white transition-all duration-300 transform hover:-translate-y-1">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm3.98-10.105a1.44 1.44 0 11-2.88 0 1.44 1.44 0 012.88 0z"/></svg>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Customer Service -->
                    <div>
                        <h4 class="text-white font-bold text-lg mb-6">Hỗ trợ khách hàng</h4>
                        <ul class="space-y-3 text-sm">
                            <li><a href="#" class="text-slate-400 hover:text-white hover:translate-x-1 inline-block transition-transform duration-200">Trạng thái đơn hàng</a></li>
                            <li><a href="#" class="text-slate-400 hover:text-white hover:translate-x-1 inline-block transition-transform duration-200">Chính sách vận chuyển</a></li>
                            <li><a href="#" class="text-slate-400 hover:text-white hover:translate-x-1 inline-block transition-transform duration-200">Chính sách đổi trả</a></li>
                            <li><a href="#" class="text-slate-400 hover:text-white hover:translate-x-1 inline-block transition-transform duration-200">Hỗ trợ thanh toán</a></li>
                        </ul>
                    </div>
                    
                    <!-- Information -->
                    <div>
                        <h4 class="text-white font-bold text-lg mb-6">Về chúng tôi</h4>
                        <ul class="space-y-3 text-sm">
                            <li><a href="#" class="text-slate-400 hover:text-white hover:translate-x-1 inline-block transition-transform duration-200">Câu chuyện thương hiệu</a></li>
                            <li><a href="#" class="text-slate-400 hover:text-white hover:translate-x-1 inline-block transition-transform duration-200">Tin tức & Sự kiện</a></li>
                            <li><a href="#" class="text-slate-400 hover:text-white hover:translate-x-1 inline-block transition-transform duration-200">Cửa hàng</a></li>
                        </ul>
                    </div>
                    
                    <!-- App Download & Contact -->
                    <div class="space-y-6">
                        <h4 class="text-white font-bold text-lg mb-6">Liên hệ</h4>
                        <ul class="space-y-3 text-sm">
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span>123 Đường Nam Kỳ Khởi Nghĩa, Quận 1, TP.HCM</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span>+84 123 456 789</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span>support@thenotorious.com</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-slate-500">
                    <p>&copy; {{ date('Y') }} The Notorious. Tất cả quyền được bảo lưu.</p>
                    <div class="flex gap-4">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa" class="h-6 opacity-60 grayscale hover:grayscale-0 transition-all">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard" class="h-6 opacity-60 grayscale hover:grayscale-0 transition-all">
                    </div>
                </div>
            </div>
        </footer>
        
        <!-- Cart Drawer -->
        <x-cart-drawer />
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                once: true,
                offset: 50,
                easing: 'ease-out-cubic'
            });
        });
    </script>
    @vite(['resources/js/cart.js', 'resources/js/init.js'])
    @stack('scripts')
</body>
</html>
