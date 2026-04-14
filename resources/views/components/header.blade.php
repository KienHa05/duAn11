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

        <!-- Order Tracking Button -->
        <a href="{{ route('client.track-order.index') }}"
          class="hidden sm:flex items-center gap-2 h-11 px-6 text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all font-bold text-sm tracking-tight cursor-pointer whitespace-nowrap">
          <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
          </svg>
          <span class="uppercase tracking-wider">Tra cứu</span>
        </a>

        <!-- Authentication / User Menu -->
        @guest
          <a href="{{ route('login') }}"
            class="hidden sm:flex items-center gap-2 h-11 px-6 text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all font-bold text-sm tracking-tight cursor-pointer whitespace-nowrap">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="uppercase tracking-wider">Đăng nhập</span>
          </a>
        @endguest

        @auth
          <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" @click.away="open = false"
              class="flex items-center gap-3 h-11 px-4 text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all font-bold text-sm tracking-tight cursor-pointer whitespace-nowrap">
              <div class="w-7 h-7 rounded-full bg-black flex items-center justify-center text-[10px] text-white font-black overflow-hidden ring-2 ring-gray-100">
                {{ substr(Auth::user()->name, 0, 1) }}
              </div>
              <span class="hidden md:inline uppercase tracking-widest text-[11px]">{{ Auth::user()->name }}</span>
              <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" 
              x-transition:enter="transition ease-out duration-200"
              x-transition:enter-start="opacity-0 scale-95 translate-y-2"
              x-transition:enter-end="opacity-100 scale-100 translate-y-0"
              x-transition:leave="transition ease-in duration-75"
              x-transition:leave-start="opacity-100 scale-100 translate-y-0"
              x-transition:leave-end="opacity-0 scale-95 translate-y-2"
              class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-2xl border border-gray-100 py-2 z-[60] overflow-hidden" 
              style="display: none;">
              
              <div class="px-4 py-3 border-b border-gray-50 mb-1">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tài khoản</p>
                <p class="text-xs font-bold text-black truncate mt-0.5">{{ Auth::user()->email }}</p>
              </div>

              @if(Auth::user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  </svg>
                  Quản trị viên
                </a>
              @endif

              <a href="{{ route('orders.history') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Đơn hàng của tôi
              </a>

              <a href="#" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Hồ sơ cá nhân
              </a>

              <div class="mt-1 pt-1 border-t border-gray-50">
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-xs font-bold text-red-500 hover:bg-red-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Đăng xuất
                  </button>
                </form>
              </div>
            </div>
          </div>
        @endauth

        <!-- Cart Button: Ghost Style H-11 (Perfectly Matched) -->
        <a href="{{ route('client.cart.index') }}"
          class="relative flex items-center gap-2 h-11 px-6 text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all font-bold text-sm tracking-tight cursor-pointer active:scale-95 whitespace-nowrap">
          <div class="relative flex items-center">
            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
              </path>
            </svg>
            <span
              class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-red-500 text-white text-[9px] font-black rounded-full flex items-center justify-center border-2 border-white shadow-lg"
              x-show="cartCount > 0" x-text="cartCount">
            </span>
          </div>
          <span class="hidden lg:inline uppercase tracking-wider">Giỏ hàng</span>
        </a>
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