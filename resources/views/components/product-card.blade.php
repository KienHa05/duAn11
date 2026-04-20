<!-- Notorious Premium Product Card -->
<div
    class="group relative flex flex-col bg-white overflow-hidden transition-all duration-500 ease-out cursor-pointer hover:shadow-2xl rounded-3xl border border-gray-50 hover:border-black/5"
    @click="window.location.href='{{ route('client.products.show', $product) }}'"
>
    <!-- Image Container: High-end UI (Fixed 1:1 Aspect) -->
    <div class="relative aspect-square overflow-hidden bg-gray-50 transition-colors duration-500 group-hover:bg-gray-100/50">
        @if($product->image)
            <img
                src="{{ $product->image_url }}"
                alt="{{ $product->name }}"
                class="w-full h-full object-cover transform transition-transform duration-1000 group-hover:scale-110"
                loading="lazy"
            />
        @else
            <div class="w-full h-full flex items-center justify-center bg-gray-50">
                <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        @endif

        <!-- Premium Badge -->
        @if($product->discount > 0)
        <div class="absolute top-4 left-4 bg-black text-white text-[10px] font-black uppercase tracking-widest px-2.5 py-1.5 rounded-full shadow-lg">
            -{{ $product->discount }}%
        </div>
        @endif

        <!-- Status: In Stock -->
        @if($product->stock > 0)
        <div class="absolute top-4 right-4 w-2 h-2 rounded-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.5)] z-10"></div>
        @else
        <div class="absolute top-4 right-4 bg-gray-800/80 text-white text-[9px] uppercase font-black px-2.5 py-1 rounded-full backdrop-blur-sm z-10">
            Hết hàng
        </div>
        @endif

        <!-- Wishlist Toggle -->
        @auth
        <button 
            @click.stop="toggleWishlist({{ $product->id }})"
            class="absolute bottom-4 right-4 w-10 h-10 rounded-full bg-white/90 backdrop-blur-md flex items-center justify-center shadow-lg transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 hover:bg-black hover:text-white z-20"
            :class="isInWishlist({{ $product->id }}) ? 'text-rose-500 bg-white' : 'text-gray-400'"
        >
            <svg class="w-5 h-5" :fill="isInWishlist({{ $product->id }}) ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
        </button>
        @endauth
    </div>

    <!-- Content: Standardized Alignment -->
    <div class="p-5 flex flex-col flex-1 bg-white">
        <div class="flex justify-between items-start mb-1.5">
            <span class="text-[10px] uppercase tracking-[0.3em] text-gray-400 font-black">
                {{ $product->category->name ?? 'CAO CẤP' }}
            </span>
            
            <!-- Dynamic Star Rating -->
            <div class="flex items-center gap-1">
                <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
                <span class="text-[10px] font-bold text-gray-600">{{ $product->average_rating ?? '5.0' }}</span>
            </div>
        </div>

        <!-- Fixed Title Height to ensure alignment -->
        <h3 class="text-sm md:text-base font-bold text-black leading-tight mb-3 min-h-[2.5rem] line-clamp-2 tracking-tight group-hover:text-black">
            {{ $product->name }}
        </h3>

        <div class="mt-auto">
            @if($product->discount > 0)
                <div class="flex items-baseline gap-2 mb-4">
                    <span class="text-xl font-black text-black tracking-tighter">
                        {{ number_format($product->price * (1 - $product->discount / 100), 0, ',', '.') }}<span class="text-[12px] ml-0.5 font-bold">đ</span>
                    </span>
                    <span class="text-[11px] text-gray-300 line-through font-bold">
                        {{ number_format($product->price, 0, ',', '.') }} đ
                    </span>
                </div>
            @else
                <div class="mb-4">
                    <span class="text-xl font-black text-black tracking-tighter">
                        {{ number_format($product->price, 0, ',', '.') }}<span class="text-[12px] ml-0.5 font-bold">đ</span>
                    </span>
                </div>
            @endif

            <!-- Optimized Small Actions -->
            <div class="flex gap-2 items-center">
                <!-- Buy Now Button: Compact -->
                <a
                    href="{{ route('client.products.show', $product) }}"
                    class="flex-1 h-10 flex items-center justify-center bg-black text-white text-[10px] font-black uppercase tracking-widest rounded-xl border-2 border-black hover:bg-white hover:text-black hover:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] -translate-y-0 hover:-translate-y-1 transition-all duration-300 active:scale-95 cursor-pointer"
                    @click.stop
                >
                    MUA NGAY
                </a>

                <!-- Quick Add to Cart: Smaller Trolley Icon -->
                <button
                    @click.stop="addToCartWithLoading($el.dataset.productId, $el.dataset.productName, parseFloat($el.dataset.price), $el.dataset.imageUrl)"
                    :disabled="{{ ($product->stock > 0) ? 'false' : 'true' }} || isAdding"
                    class="w-9 h-9 flex items-center justify-center rounded-xl border-2 border-black text-black hover:bg-black hover:text-white transition-all transform active:scale-90 disabled:opacity-30 disabled:cursor-not-allowed disabled:border-gray-300 disabled:text-gray-300 group/cart cursor-pointer shadow-sm"
                    :title="disabled ? (isAdding ? 'Đang thêm...' : 'Sản phẩm hết hàng') : 'Thêm vào giỏ hàng'"
                    data-product-id="{{ $product->id }}"
                    data-product-name="{{ $product->name }}"
                    data-price="{{ $product->price * (1 - ($product->discount ?? 0) / 100) }}"
                    data-image-url="{{ $product->image_url }}"
                >
                    <svg class="w-4 h-4 group-hover/cart:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Alpine.js Data Bridge -->
    <div data-stock="{{ $product->stock }}" class="hidden"></div>
</div>
