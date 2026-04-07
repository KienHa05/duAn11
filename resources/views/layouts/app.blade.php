<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'The Notorious - Thời trang thể thao tối giản')</title>

  <!-- Premium Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <!-- Load cart.js BEFORE Alpine.js so cartStore() is defined -->
  @vite(['resources/js/cart.js'])
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-white text-black font-sans antialiased selection:bg-black selection:text-white">
  <div x-data="cartStore()" x-init="init()" @cart-updated.window="updateCart($event)" class="min-h-screen flex flex-col">
    <!-- Apple-Style Header -->
    <x-header />

    <!-- Main Content Area -->
    <main class="flex-grow">
      @yield('content')
    </main>

    <!-- Minimalist Footer -->
    <footer class="bg-gray-50 border-t border-gray-100 pt-20 pb-12">
      <div class="container mx-auto px-4 max-w-7xl">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
          <div class="md:col-span-1 space-y-6 text-center md:text-left">
            <a href="/" class="flex flex-col items-center md:items-start group">
              <div
                class="w-10 h-10 rounded-lg bg-black flex items-center justify-center text-white font-black text-lg group-hover:scale-105 transition-transform duration-300">
                N
              </div>
              <span class="mt-4 text-xl font-black tracking-tighter uppercase">NOTORIOUS</span>
            </a>
            <p class="text-xs text-gray-500 leading-relaxed font-bold tracking-widest">
              MINIMALIST PERFORMANCE WEAR. <br />ESTABLISHED 2026.
            </p>
          </div>

          <div class="md:col-span-3 grid grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="space-y-4">
              <h4 class="text-[11px] font-black uppercase tracking-[0.2em] text-black">Hỗ trợ khách hàng</h4>
              <ul class="space-y-2 text-sm font-medium text-gray-500">
                <li><a href="#" class="hover:text-black transition-colors">Tình trạng đơn hàng</a></li>
                <li><a href="#" class="hover:text-black transition-colors">Chính sách vận chuyển</a></li>
                <li><a href="#" class="hover:text-black transition-colors">Chính sách đổi trả</a></li>
              </ul>
            </div>

            <div class="space-y-4">
              <h4 class="text-[11px] font-black uppercase tracking-[0.2em] text-black">Về chúng tôi</h4>
              <ul class="space-y-2 text-sm font-medium text-gray-500">
                <li><a href="#" class="hover:text-black transition-colors">Câu chuyện thương hiệu</a></li>
                <li><a href="#" class="hover:text-black transition-colors">Quy trình bền vững</a></li>
                <li><a href="#" class="hover:text-black transition-colors">Cửa hàng vật lý</a></li>
              </ul>
            </div>

            <div class="space-y-4 col-span-2 lg:col-span-1">
              <h4 class="text-[11px] font-black uppercase tracking-[0.2em] text-black">Kết nối với chúng tôi</h4>
              <div class="flex gap-4">
                <a href="#"
                  class="w-8 h-8 rounded-full bg-white border border-gray-100 flex items-center justify-center hover:bg-black hover:text-white transition-all text-gray-600">
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path
                      d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                  </svg>
                </a>
                <a href="#"
                  class="w-8 h-8 rounded-full bg-white border border-gray-100 flex items-center justify-center hover:bg-black hover:text-white transition-all text-gray-600">
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path
                      d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm3.98-10.105a1.44 1.44 0 11-2.88 0 1.44 1.44 0 012.88 0z" />
                  </svg>
                </a>
              </div>
            </div>
          </div>
        </div>

        <div
          class="border-t border-gray-100 pt-8 flex flex-col md:flex-row items-center justify-between gap-6 text-[10px] sm:text-xs font-bold text-gray-400 tracking-widest uppercase">
          <p>&copy; {{ date('Y') }} NOTORIOUS PLATFORM. TẤT CẢ QUYỀN ĐƯỢC BẢO LƯU.</p>
          <div class="flex gap-8">
            <a href="#" class="hover:text-black">Quyền riêng tư</a>
            <a href="#" class="hover:text-black">Điều khoản</a>
            <a href="#" class="hover:text-black">Cookies</a>
          </div>
        </div>
      </div>
    </footer>

    <!-- Cart Drawer Component -->
    <x-cart-drawer />
  </div>

  <!-- Core Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      AOS.init({
        duration: 1000,
        once: true,
        offset: 50,
        easing: 'ease-out-expo'
      });
    });
  </script>
  @vite(['resources/js/init.js'])
  @stack('scripts')
</body>

</html>
