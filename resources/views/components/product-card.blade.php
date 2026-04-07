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
        <div class="absolute top-4 right-4 w-2 h-2 rounded-full bg-green-500 shadow-[0_0_10px_rgba(34,197,94,0.5)]"></div>
        @else
        <div class="absolute top-4 right-4 bg-gray-800/80 text-white text-[9px] uppercase font-black px-2.5 py-1 rounded-full backdrop-blur-sm">
            Hết hàng
        </div>
        @endif
    </div>

    <!-- Content: Standardized Alignment -->
    <div class="p-5 flex flex-col flex-1 bg-white">
        <span class="text-[10px] uppercase tracking-[0.3em] text-gray-400 font-black mb-1.5">
            {{ $product->category->name ?? 'CAO CẤP' }}
        </span>

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
                    class="flex-1 h-9 flex items-center justify-center bg-black text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-gray-800 transition-all active:scale-95 cursor-pointer"
                    @click.stop
                >
                    MUA NGAY
                </a>

                <!-- Quick Add to Cart: Smaller Trolley Icon -->
                <button
                    @click.stop="addToCart($el.dataset.productId, $el.dataset.productName, parseFloat($el.dataset.price), $el.dataset.imageUrl)"
                    @click="$el.classList.add('scale-90'); setTimeout(() => $el.classList.remove('scale-90'), 200)"
                    :disabled="{{ ($product->stock > 0) ? 'false' : 'true' }}"
                    class="w-9 h-9 flex items-center justify-center rounded-xl border-2 border-black text-black hover:bg-black hover:text-white transition-all transform active:scale-90 disabled:opacity-30 disabled:cursor-not-allowed disabled:border-gray-300 disabled:text-gray-300 group/cart cursor-pointer shadow-sm"
                    :title="disabled ? 'Sản phẩm hết hàng' : 'Thêm vào giỏ hàng'"
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
