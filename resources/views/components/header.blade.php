<!-- Notorious Premium Header -->
<header x-data="{ showSearch: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 10)"
  :class="scrolled ? 'bg-white/80 backdrop-blur-md border-b border-gray-100 shadow-sm' : 'bg-white border-b border-gray-50'"
  class="sticky top-0 z-50 transition-all duration-500 ease-in-out">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
    <div class="flex items-center justify-between h-16 md:h-20">
      <!-- Brand Logo: Notorious -->
      <div class="flex-shrink-0 flex items-center h-full">
        <a href="{{ route('home') }}"
          class="flex items-center group transition-transform hover:scale-[1.02] active:scale-95 cursor-pointer">
          <div
            class="w-9 h-9 rounded-xl bg-black flex items-center justify-center text-white font-black text-lg shadow-sm">
            N
          </div>
          <span class="ml-3 text-xl font-black tracking-tight text-black uppercase">
            Notorious
          </span>
        </a>
      </div>

      <!-- Search Bar: Perfectly Centered & Aligned -->
      <div class="hidden md:flex flex-1 items-center justify-center px-8 lg:px-12 h-full">
        <div class="relative w-full max-w-xl group">
          <input type="text" placeholder="Tìm kiếm sản phẩm đẳng cấp..."
            class="w-full h-11 bg-gray-50 border border-gray-200 rounded-xl px-4 pr-14 text-sm font-medium focus:bg-white focus:border-black focus:ring-0 focus:outline-none transition-all duration-300 placeholder:text-gray-400" />
          <button
            class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-400 hover:text-black transition-colors border-l border-transparent hover:border-gray-100 group-focus-within:text-black cursor-pointer">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
          </button>
        </div>
      </div>

      <!-- Actions: Balanced & Aligned (H-11 to match Search) -->
      <div class="flex items-center gap-2 sm:gap-4 ml-auto h-full">
        <!-- Mobile Search Toggle -->
        <button @click="showSearch = !showSearch"
          class="md:hidden p-2 text-gray-600 hover:text-black transition-colors cursor-pointer">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </button>

        <!-- Login Button: Ghost Style H-11 -->
        <a href="#"
          class="hidden sm:flex items-center gap-2 h-11 px-6 text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all font-bold text-sm tracking-tight cursor-pointer whitespace-nowrap">
          <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
          <span class="uppercase tracking-wider">Đăng nhập</span>
        </a>

        <!-- Cart Button: Ghost Style H-11 (Perfectly Matched) -->
        <button @click="$dispatch('toggle-cart-drawer')"
          class="relative flex items-center gap-2 h-11 px-6 text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all font-bold text-sm tracking-tight cursor-pointer active:scale-95 whitespace-nowrap">
          <div class="relative flex items-center">
            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
              </path>
            </svg>
            @if($cartCount > 0)
              <span
                class="absolute -top-1.5 -right-1.5 w-4 h-4 bg-black text-white text-[9px] font-black rounded-full flex items-center justify-center border border-white">
                {{ $cartCount }}
              </span>
            @endif
          </div>
          <span class="hidden lg:inline uppercase tracking-wider">Giỏ hàng</span>
        </button>
      </div>
    </div>

    <!-- Mobile Integrated Search Bar -->
    <div x-show="showSearch" x-transition:enter="transition duration-300"
      x-transition:enter-start="opacity-0 -translate-y-4" class="md:hidden pb-6">
      <div class="relative">
        <input type="text" placeholder="Tìm sản phẩm..."
          class="w-full h-11 bg-gray-50 border border-gray-200 rounded-xl px-4 pr-12 text-sm focus:border-black focus:outline-none transition-all" />
        <button class="absolute inset-y-0 right-0 px-4 text-gray-400 cursor-pointer">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
</header>