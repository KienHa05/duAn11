<!-- Modern Product Card -->
<div class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-base-200 hover:border-secondary/30">
    <!-- Image Container with Overlay -->
    <div class="relative w-full aspect-square overflow-hidden bg-base-100">
        @if($product->image)
            <img 
                src="{{ $product->image }}" 
                alt="{{ $product->name }}"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                loading="lazy"
            />
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-base-100 to-base-200">
                <svg class="w-20 h-20 text-base-content/10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        @endif
        
        <!-- Overlay on Hover -->
        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        
        <!-- Badges Container -->
        <div class="absolute top-4 left-4 right-4 flex justify-between items-start">
            <!-- Discount Badge -->
            @if($product->discount > 0)
            <div class="badge badge-warning gap-1 font-bold shadow-lg animate-pulse">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M4.25 5.5a.75.75 0 00-.5.735v8.53a.75.75 0 00.288.588l7.294 6.142a.749.749 0 001.025-.13l7.297-8.835a.75.75 0 00.102-.942L13.822 3.5h-4.147A1.75 1.75 0 008.25 5.5v1.241m1.671 0H5.75a.75.75 0 00-.75.75V14a.75.75 0 00.75.75H9a.75.75 0 00.75-.75v-7.509Z"></path>
                </svg>
                -{{ $product->discount }}%
            </div>
            @endif
            
            <!-- Stock Badge -->
            <div>
                @if($product->stock > 0)
                    <span class="badge badge-success gap-1 shadow-lg">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Còn hàng
                    </span>
                @else
                    <span class="badge badge-error gap-1 shadow-lg">Hết hàng</span>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Content Section -->
    <div class="p-5 flex flex-col h-full">
        <!-- Category Badge -->
        <div class="mb-3">
            <span class="inline-block px-3 py-1 bg-secondary/10 text-secondary text-xs font-bold uppercase tracking-widest rounded-full">
                {{ $product->category->name ?? 'Uncategorized' }}
            </span>
        </div>
        
        <!-- Product Name -->
        <h3 class="font-bold text-base leading-snug mb-3 line-clamp-2 group-hover:text-secondary transition-colors min-h-[3.5rem]">
            {{ $product->name }}
        </h3>
        
        <!-- Rating -->
        <div class="flex items-center gap-2 mb-4">
            <div class="flex text-yellow-400">
                @for($i = 0; $i < 5; $i++)
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                @endfor
            </div>
            <span class="text-xs text-base-content/50 font-medium">({{ rand(5, 300) }})</span>
        </div>
        
        <!-- Price Section - Spacious -->
        <div class="mb-5 border-b border-base-200 pb-4">
            @if($product->discount > 0)
                <div class="flex items-baseline gap-3">
                    <span class="text-2xl font-black text-error">
                        {{ number_format($product->price * (1 - $product->discount / 100), 0, ',', '.') }}<span class="text-sm ml-1">đ</span>
                    </span>
                    <span class="text-sm text-base-content/40 line-through font-medium">
                        {{ number_format($product->price, 0, ',', '.') }} đ
                    </span>
                </div>
            @else
                <span class="text-2xl font-black text-slate-900">
                    {{ number_format($product->price, 0, ',', '.') }}<span class="text-sm ml-1">đ</span>
                </span>
            @endif
        </div>
        
        <!-- Action Buttons -->
        <div class="flex gap-2 mt-auto">
            <!-- Add to Cart -->
            <button 
                @click="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price * (1 - ($product->discount ?? 0) / 100) }})"
                :disabled="!$el.closest('.bg-white').querySelector('[data-stock]')?.dataset.stock > 0"
                class="flex-1 btn btn-sm h-10 gap-2 bg-white border-2 border-slate-900 text-slate-900 hover:bg-slate-900 hover:text-white font-semibold transition-all disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="text-xs">Thêm</span>
            </button>
            
            <!-- Buy Now -->
            <a 
                href="{{ route('client.products.show', $product) }}"
                data-stock="{{ $product->stock }}"
                class="flex-1 btn btn-sm h-10 bg-gradient-to-r from-secondary to-blue-600 border-0 text-white hover:shadow-lg hover:shadow-secondary/40 font-semibold transition-all"
            >
                Mua
            </a>
        </div>
    </div>
</div>
