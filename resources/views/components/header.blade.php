<!-- Modern Sticky Header -->
<header class="sticky top-0 z-50 backdrop-blur-md bg-white/80 border-b border-base-200/50 shadow-sm">
    <div class="container mx-auto px-4 sm:px-6 max-w-7xl">
        <div class="flex items-center justify-between h-16">
            <!-- Logo - Minimalist Design -->
            <div class="flex-shrink-0">
                <a href="/" class="text-2xl font-bold tracking-tighter group">
                    <span class="inline-flex items-center gap-2">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-slate-900 to-slate-700 flex items-center justify-center text-white font-black text-lg group-hover:shadow-lg transition-all">
                            N
                        </div>
                        <span class="hidden sm:inline bg-gradient-to-r from-slate-900 to-slate-600 bg-clip-text text-transparent">
                            The Notorious
                        </span>
                    </span>
                </a>
            </div>
            
            <!-- Search Bar - Desktop Only -->
            <div class="hidden md:flex flex-1 mx-8 max-w-md">
                <div class="w-full relative group">
                    <input 
                        type="text" 
                        placeholder="Tìm sản phẩm..." 
                        class="w-full px-4 py-2.5 bg-base-100 border border-base-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary/50 focus:border-secondary placeholder-base-content/40 text-sm"
                    />
                    <button class="absolute right-3 top-3 text-base-content/40 hover:text-secondary transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex items-center gap-3 sm:gap-4">
                <!-- Mobile Search -->
                <button class="md:hidden p-2 hover:bg-base-100 rounded-lg transition-colors" @click="showMobileSearch = !showMobileSearch">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                
                <!-- Cart Icon -->
                <button 
                    @click="$dispatch('toggle-cart-drawer')"
                    class="relative p-2 hover:bg-base-100 rounded-lg transition-colors group"
                >
                    <svg class="w-6 h-6 group-hover:text-secondary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    @if($cartCount > 0)
                    <span class="absolute top-1 right-1 w-5 h-5 bg-secondary text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse">
                        {{ $cartCount }}
                    </span>
                    @endif
                </button>
                
                <!-- Admin Link -->
                <a 
                    href="{{ route('admin.dashboard') }}" 
                    class="hidden sm:inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg hover:bg-base-100 transition-colors group"
                >
                    <svg class="w-4 h-4 group-hover:text-secondary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                    </svg>
                    <span class="text-xs uppercase tracking-wide">Admin</span>
                </a>
            </div>
        </div>
        
        <!-- Mobile Search -->
        <div x-show="showMobileSearch" x-transition class="pb-4 md:hidden">
            <input 
                type="text" 
                placeholder="Tìm sản phẩm..." 
                class="w-full px-4 py-2.5 bg-base-100 border border-base-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary/50 text-sm"
            />
        </div>
    </div>
</header>
