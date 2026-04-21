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

      <!-- Search Bar: Desktop Live Search -->
      <div class="hidden md:flex flex-1 items-center justify-center px-8 lg:px-12 h-full"
           x-data="{
              query: '{{ request('search') }}',
              results: { products: [], categories: [] },
              loading: false,
              showResults: false,
              async search() {
                  if (this.query.length < 2) {
                      this.results = { products: [], categories: [] };
                      this.showResults = false;
                      return;
                  }
                  this.loading = true;
                  this.showResults = true;
                  try {
                      const response = await fetch('{{ route('api.search') }}?q=' + encodeURIComponent(this.query));
                      this.results = await response.json();
                  } catch (e) {
                      console.error('Search error:', e);
                  } finally {
                      this.loading = false;
                  }
              }
           }"
           @click.away="showResults = false"
      >
        <div class="relative w-full max-w-xl group">
          <input type="text"
            id="desktop-search"
            x-model="query"
            @input.debounce.300ms="search"
            @focus="if(query.length >= 2) showResults = true"
            @keyup.enter="window.location.href='{{ route('home') }}?search=' + encodeURIComponent(query)"
            placeholder="Tìm kiếm sản phẩm..."
            autocomplete="off"
            class="w-full h-11 bg-gray-50 border border-gray-200 rounded-xl px-4 pr-14 text-sm font-medium focus:bg-white focus:border-black focus:ring-0 focus:outline-none transition-all duration-300 placeholder:text-gray-400" />

          <button @click="window.location.href='{{ route('home') }}?search=' + encodeURIComponent(query)"
            aria-label="Tìm kiếm"
            class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-400 hover:text-black transition-colors border-l border-transparent hover:border-gray-100 group-focus-within:text-black cursor-pointer">
            <template x-if="!loading">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </template>
            <template x-if="loading">
              <div class="w-5 h-5 border-2 border-gray-300 border-t-black rounded-full animate-spin"></div>
            </template>
          </button>

          <!-- Search Results Dropdown (Apple Aesthetic) -->
          <div x-show="showResults"
               x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="opacity-0 translate-y-4"
               x-transition:enter-end="opacity-100 translate-y-0"
               class="absolute top-full left-0 right-0 mt-4 bg-white/95 backdrop-blur-xl border border-gray-100 rounded-3xl shadow-2xl overflow-hidden z-[100]"
               style="display: none;">

            <div class="p-2">
                <!-- Categories -->
                <template x-if="results.categories && results.categories.length > 0">
                    <div class="mb-4">
                        <h4 class="px-4 py-2 text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-50">Danh mục gợi ý</h4>
                        <div class="grid grid-cols-1 mt-1">
                            <template x-for="category in results.categories" :key="category.id">
                                <a :href="category.url" class="px-4 py-3 flex items-center gap-3 hover:bg-gray-50 transition-colors group">
                                    <div class="w-6 h-6 rounded bg-gray-100 flex items-center justify-center text-[10px] font-bold text-gray-400 group-hover:bg-black group-hover:text-white transition-all">#</div>
                                    <span class="text-xs font-bold text-gray-700" x-text="category.name"></span>
                                </a>
                            </template>
                        </div>
                    </div>
                </template>

                <!-- Products -->
                <div>
                    <h4 class="px-4 py-2 text-[10px] font-black uppercase tracking-widest text-gray-400 border-b border-gray-50">Sản phẩm phù hợp</h4>
                    <div class="space-y-1 mt-1">
                        <template x-for="product in results.products" :key="product.id">
                            <a :href="product.url" class="px-3 py-3 flex items-center gap-4 hover:bg-gray-50 transition-all rounded-2xl group">
                                <div class="w-12 h-12 rounded-xl border border-gray-100 overflow-hidden flex-shrink-0 bg-gray-50">
                                    <img :src="product.image" :alt="product.name" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                </div>
                                <div class="flex-grow">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-0.5" x-text="product.category"></p>
                                    <h5 class="text-xs font-bold text-black group-hover:text-black transition-colors" x-text="product.name"></h5>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-black text-black" x-text="product.price"></span>
                                </div>
                            </a>
                        </template>
                    </div>
                </div>

                <!-- Empty State -->
                <template x-if="results.products.length === 0 && results.categories.length === 0 && !loading">
                    <div class="p-12 text-center">
                        <p class="text-sm font-medium text-gray-400 italic">Không tìm thấy sản phẩm nào khớp với "<span x-text="query"></span>"</p>
                    </div>
                </template>

                <!-- Loading State placeholder -->
                <template x-if="loading && results.products.length === 0">
                    <div class="p-12 text-center">
                        <div class="w-8 h-8 border-2 border-gray-100 border-t-black rounded-full animate-spin mx-auto mb-4"></div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 animate-pulse">Đang tìm kiếm...</p>
                    </div>
                </template>

                <!-- Footer -->
                <div class="p-3 border-t border-gray-50 bg-gray-50/50 mt-2">
                    <a :href="'{{ route('home') }}?search=' + encodeURIComponent(query)" class="block w-full h-10 border border-gray-200 rounded-xl flex items-center justify-center text-[10px] font-black uppercase tracking-widest text-gray-500 hover:bg-black hover:text-white hover:border-black transition-all">
                        Xem tất cả kết quả
                    </a>
                </div>
            </div>
          </div>
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
        @if(Auth::guard('web')->check())
          <!-- Client State: User Name + Dropdown -->
          <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" @click.away="open = false"
              class="flex items-center gap-3 h-11 px-4 text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all font-bold text-sm tracking-tight cursor-pointer whitespace-nowrap">
              <div class="w-8 h-8 rounded-full bg-black flex items-center justify-center text-[11px] text-white font-black overflow-hidden ring-2 ring-gray-100 shadow-sm">
                {{ substr(Auth::guard('web')->user()->name, 0, 1) }}
              </div>
              <span class="hidden md:inline uppercase tracking-widest text-[11px] font-black">{{ Auth::guard('web')->user()->name }}</span>
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
              class="absolute right-0 mt-2 w-60 bg-white rounded-2xl shadow-2xl border border-gray-100 py-2 z-[60] overflow-hidden"
              style="display: none;">

              <div class="px-5 py-4 border-b border-gray-50 mb-1 bg-gray-50/50">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Khách hàng</p>
                <p class="text-[11px] font-bold text-black truncate mt-1">{{ Auth::guard('web')->user()->email }}</p>
              </div>

              <a href="{{ route('orders.history') }}" class="flex items-center gap-3 px-5 py-3 text-xs font-bold text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Đơn hàng của tôi
              </a>

              <a href="{{ route('profile') }}" class="flex items-center gap-3 px-5 py-3 text-xs font-bold text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Hồ sơ cá nhân
              </a>

              <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 px-5 py-3 text-xs font-bold text-gray-600 hover:bg-gray-50 hover:text-black transition-colors">
                <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                Danh sách yêu thích
              </a>

              <div class="mt-1 pt-1 border-t border-gray-50">
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button type="submit" class="w-full flex items-center gap-3 px-5 py-3 text-xs font-bold text-red-500 hover:bg-red-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Đăng xuất
                  </button>
                </form>
              </div>
            </div>
          </div>
        @else
          <!-- Guest State: Login | Register -->
          <div class="hidden sm:flex items-center gap-2">
            <a href="{{ route('login') }}"
              class="flex items-center gap-2 h-11 px-5 text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all font-bold text-sm tracking-tight cursor-pointer whitespace-nowrap">
              <span class="uppercase tracking-wider">Đăng nhập</span>
            </a>
            <div class="w-px h-4 bg-gray-200"></div>
            <a href="{{ route('register') }}"
              class="flex items-center gap-2 h-11 px-5 text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all font-bold text-sm tracking-tight cursor-pointer whitespace-nowrap">
              <span class="uppercase tracking-wider">Đăng ký</span>
            </a>
          </div>
        @endif

        <!-- Wishlist Link: Desktop -->
        @auth
        <a href="{{ route('wishlist.index') }}"
          class="hidden sm:flex items-center gap-2 h-11 px-4 text-gray-700 hover:text-black hover:bg-gray-50 rounded-xl transition-all font-bold text-sm tracking-tight cursor-pointer relative">
          <div class="relative">
            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
            <span
              class="absolute -top-1.5 -right-1.5 w-4 h-4 bg-black text-white text-[8px] font-black rounded-full flex items-center justify-center border-2 border-white shadow-sm"
              x-show="wishlistItems.length > 0" x-text="wishlistItems.length">
            </span>
          </div>
        </a>
        @endauth

        <!-- Cart Button -->
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
    <div x-show="showSearch" x-cloak
      x-transition:enter="transition duration-300 ease-out"
      x-transition:enter-start="opacity-0 -translate-y-2"
      x-transition:enter-end="opacity-100 translate-y-0"
      x-transition:leave="transition duration-200 ease-in"
      x-transition:leave-start="opacity-100 translate-y-0"
      x-transition:leave-end="opacity-0 -translate-y-2"
      class="md:hidden pb-4 pt-1">
      <form action="{{ route('home') }}" method="GET" class="relative" role="search">
        @if(request('category'))
          <input type="hidden" name="category" value="{{ request('category') }}">
        @endif
        @if(request('sort') && request('sort') !== 'newest')
          <input type="hidden" name="sort" value="{{ request('sort') }}">
        @endif
        @if(request('min_price'))
          <input type="hidden" name="min_price" value="{{ request('min_price') }}">
        @endif
        @if(request('max_price'))
          <input type="hidden" name="max_price" value="{{ request('max_price') }}">
        @endif
        <input
          id="mobile-search"
          type="text"
          name="search"
          value="{{ request('search') }}"
          placeholder="Tìm sản phẩm..."
          autocomplete="off"
          x-ref="mobileSearchInput"
          class="w-full h-11 bg-gray-50 border border-gray-200 rounded-xl px-4 pr-12 text-sm font-medium focus:bg-white focus:border-black focus:outline-none transition-all" />
        <button type="submit" class="absolute inset-y-0 right-0 px-4 text-gray-400 hover:text-black transition-colors cursor-pointer" aria-label="Tìm kiếm">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </button>
      </form>
    </div>
  </div>
</header>