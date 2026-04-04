<!-- Sticky Header -->
<header class="sticky top-0 z-50 bg-white shadow-sm">
    <div class="container mx-auto px-4 sm:px-6 max-w-7xl">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/" class="text-2xl font-bold text-primary flex items-center gap-2">
                    <span class="w-8 h-8 bg-gradient-to-br from-primary to-secondary rounded-lg flex items-center justify-center text-white">
                        N
                    </span>
                    The Notorious
                </a>
            </div>
            
            <!-- Search Bar - Hidden on mobile, visible on md+ -->
            <div class="hidden md:flex flex-1 mx-8">
                <div class="w-full relative">
                    <input 
                        type="text" 
                        placeholder="Tìm sản phẩm..." 
                        class="w-full px-4 py-2 bg-base-100 border border-base-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                    />
                    <button class="absolute right-3 top-2.5 text-base-content/50 hover:text-base-content transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Actions - Cart and Menu -->
            <div class="flex items-center gap-4">
                <!-- Mobile Search Toggle -->
                <button class="md:hidden p-2 hover:bg-base-100 rounded-lg transition" @click="showMobileSearch = !showMobileSearch">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                
                <!-- Cart Button -->
                <button 
                    @click="$dispatch('toggle-cart-drawer')"
                    class="relative p-2 hover:bg-base-100 rounded-lg transition group"
                >
                    <svg class="w-6 h-6 group-hover:text-primary transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m10 0h2m-2 0h-2.5m0 0a1 1 0 11-2 0 1 1 0 012 0zM14 13h2m0 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                    </svg>
                    <!-- Cart Count Badge -->
                    @if($cartCount > 0)
                    <span class="absolute top-0 right-0 bg-error text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                        {{ $cartCount }}
                    </span>
                    @endif
                </button>
                
                <!-- Admin Button -->
                <a 
                    href="{{ route('admin.dashboard') }}" 
                    class="hidden sm:flex items-center gap-2 px-3 py-2 bg-base-100 hover:bg-base-200 rounded-lg transition text-sm font-medium"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Admin
                </a>
            </div>
        </div>
        
        <!-- Mobile Search Bar -->
        <div x-show="showMobileSearch" x-transition:enter class="pb-4 md:hidden">
            <input 
                type="text" 
                placeholder="Tìm sản phẩm..." 
                class="w-full px-4 py-2 bg-base-100 border border-base-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
            />
        </div>
    </div>
</header>
