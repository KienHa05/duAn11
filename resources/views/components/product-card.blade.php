<!-- Product Card Component -->
<div class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-shadow duration-300 group">
    <!-- Product Image Container -->
    <div class="relative w-full aspect-square overflow-hidden bg-base-100">
        @if($product->image)
            <img 
                src="{{ $product->image }}" 
                alt="{{ $product->name }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
            />
        @else
            <div class="w-full h-full flex items-center justify-center bg-base-200">
                <svg class="w-16 h-16 text-base-content/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        @endif
        
        <!-- Stock Badge -->
        <div class="absolute top-3 right-3">
            @if($product->stock > 0)
                <span class="badge badge-success gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Còn hàng
                </span>
            @else
                <span class="badge badge-error gap-2">Hết hàng</span>
            @endif
        </div>
        
        <!-- Discount Badge (if any) -->
        @if($product->discount > 0)
        <div class="absolute top-3 left-3">
            <span class="badge badge-warning font-bold">
                -{{ $product->discount }}%
            </span>
        </div>
        @endif
    </div>
    
    <!-- Product Info -->
    <div class="p-4">
        <!-- Category -->
        <p class="text-xs font-semibold text-primary uppercase tracking-wide mb-1">
            {{ $product->category->name ?? 'Uncategorized' }}
        </p>
        
        <!-- Product Name -->
        <h3 class="font-semibold text-base mb-2 line-clamp-2 h-14 group-hover:text-primary transition">
            {{ $product->name }}
        </h3>
        
        <!-- Rating (Placeholder) -->
        <div class="flex items-center gap-2 mb-3">
            <div class="flex text-warning">
                @for($i = 0; $i < 5; $i++)
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                @endfor
            </div>
            <span class="text-xs text-base-content/60">({{ rand(10, 200) }} đánh giá)</span>
        </div>
        
        <!-- Price Section -->
        <div class="mb-4">
            @if($product->discount > 0)
                <div class="flex items-baseline gap-2 mb-1">
                    <span class="text-2xl font-bold text-error">
                        {{ number_format($product->price * (1 - $product->discount / 100), 0, ',', '.') }} đ
                    </span>
                    <span class="text-sm text-base-content/50 line-through">
                        {{ number_format($product->price, 0, ',', '.') }} đ
                    </span>
                </div>
            @else
                <span class="text-2xl font-bold text-primary">
                    {{ number_format($product->price, 0, ',', '.') }} đ
                </span>
            @endif
        </div>
        
        <!-- Action Buttons -->
        <div class="flex gap-2">
            <!-- Add to Cart Button -->
            <button 
                @click="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price * (1 - ($product->discount ?? 0) / 100) }})"
                :disabled="!$el.closest('.bg-white').querySelector('[data-stock]')?.dataset.stock > 0"
                class="flex-1 btn btn-outline btn-sm h-10 gap-2 group/btn hover:btn-primary hover:border-primary"
            >
                <svg class="w-4 h-4 group-hover/btn:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="text-xs font-semibold">Thêm giỏ</span>
            </button>
            
            <!-- Buy Now Button -->
            <a 
                href="{{ route('client.products.show', $product) }}"
                data-stock="{{ $product->stock }}"
                class="flex-1 btn btn-primary btn-sm h-10 font-semibold"
            >
                Mua ngay
            </a>
        </div>
    </div>
</div>
