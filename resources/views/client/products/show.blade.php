@extends('layouts.app')

@section('title', $product->name . ' - Notorious Minimalist Performance')
@section('meta_description', Str::limit(strip_tags($product->description), 160))
@section('og_image', $product->image_url)
@section('og_type', 'product')

@section('content')
<div class="bg-base-50 min-h-screen py-8 lg:py-12" x-data="{ 
        quantity: 1, 
        stock: {{ $product->stock }},
        price: {{ $product->price }},
        discount: {{ $product->discount ?? 0 }},
        get currentPrice() { return this.price * (1 - this.discount / 100); },
        get totalPrice() { return this.currentPrice * this.quantity; }
    }"
>
    <div class="container mx-auto px-4 sm:px-6 max-w-7xl">
        <!-- Breadcrumbs -->
        <div class="text-sm breadcrumbs mb-8 text-base-content/60" data-aos="fade-down">
            <ul>
                <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">Trang chủ</a></li>
                <li><a href="{{ route('home') }}?category={{ $product->category_id }}" class="hover:text-primary transition-colors">{{ $product->category->name ?? 'Sản phẩm' }}</a></li>
                <li class="font-medium text-base-content">{{ $product->name }}</li>
            </ul>
        </div>

        <!-- Main Product Section -->
        <div class="flex flex-col lg:flex-row gap-12 xl:gap-16 relative">
            <!-- Left: Product Image Gallery -->
            <div class="w-full lg:w-1/2" data-aos="fade-right">
                <div class="sticky top-24">
                    <div class="card bg-white shadow-sm border border-base-200 overflow-hidden rounded-3xl relative group">
                        <!-- Badges -->
                        <div class="absolute top-6 left-6 right-6 flex justify-between z-10 pointer-events-none">
                            @if(($product->discount ?? 0) > 0)
                                <div class="badge badge-warning gap-1 font-bold shadow-lg p-3 text-sm">
                                    -{{ $product->discount }}% OFF
                                </div>
                            @endif
                            @if($product->stock > 0)
                                <div class="badge badge-success gap-1 shadow-lg p-3 text-sm text-white">
                                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                                    Còn Hàng
                                </div>
                            @else
                                <div class="badge badge-error gap-1 shadow-lg p-3 text-sm text-white">
                                    Hết Hàng
                                </div>
                            @endif
                        </div>

                        <!-- Main Image -->
                        <figure class="aspect-square bg-base-100 flex items-center justify-center relative overflow-hidden">
                            @if($product->image)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110" id="mainImage">
                            @else
                                <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=1000&auto=format&fit=crop" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-700 hover:scale-110">
                            @endif
                        </figure>
                    </div>

                    <!-- Trust Badges -->
                    <div class="grid grid-cols-3 gap-4 mt-8">
                        <div class="flex flex-col items-center justify-center p-4 bg-white rounded-2xl border border-base-200 shadow-sm text-center">
                            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-xs font-medium text-base-content/70">Chính hãng 100%</span>
                        </div>
                        <div class="flex flex-col items-center justify-center p-4 bg-white rounded-2xl border border-base-200 shadow-sm text-center">
                            <div class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center mb-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <span class="text-xs font-medium text-base-content/70">Thanh toán an toàn</span>
                        </div>
                        <div class="flex flex-col items-center justify-center p-4 bg-white rounded-2xl border border-base-200 shadow-sm text-center">
                            <div class="w-10 h-10 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center mb-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path></svg>
                            </div>
                            <span class="text-xs font-medium text-base-content/70">Đổi trả 30 ngày</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Product Info -->
            <div class="w-full lg:w-1/2 flex flex-col" data-aos="fade-left" data-aos-delay="100">
                <div class="mb-2">
                    <span class="text-sm font-bold text-primary tracking-widest uppercase">{{ $product->category->name ?? 'Uncategorized' }}</span>
                </div>
                
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-slate-900 mb-4 leading-tight">
                    {{ $product->name }}
                </h1>

                <div class="flex items-center gap-4 mb-6">
                    <div class="flex text-yellow-400">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 fill-current border-yellow-500" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        @endfor
                    </div>
                    <span class="text-base-content/60 text-sm font-medium">4.9 (128 đánh giá)</span>
                </div>

                <!-- Pricing Block -->
                <div class="bg-white p-6 rounded-2xl border border-base-200 shadow-sm mb-8">
                    @if(($product->discount ?? 0) > 0)
                        <div class="flex flex-col gap-1">
                            <span class="text-lg text-base-content/40 line-through font-medium">
                                {{ number_format($product->price, 0, ',', '.') }} ₫
                            </span>
                            <div class="flex items-end gap-3 transition-transform">
                                <span class="text-4xl font-black text-rose-600 tracking-tight" x-text="(currentPrice).toLocaleString('vi-VN') + ' ₫'"></span>
                                <span class="bg-rose-100 text-rose-600 px-3 py-1 rounded-full text-sm font-bold border border-rose-200 mb-1">Tiết kiệm {{ $product->discount }}%</span>
                            </div>
                        </div>
                    @else
                        <div class="flex items-baseline">
                            <span class="text-4xl font-black text-slate-900 tracking-tight" x-text="(price).toLocaleString('vi-VN') + ' ₫'"></span>
                        </div>
                    @endif
                </div>

                <!-- Specs Grid -->
                <div class="grid grid-cols-2 gap-4 mb-10">
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 flex items-center gap-4">
                        <div class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center text-slate-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div>
                            <div class="text-xs text-base-content/50 uppercase tracking-widest font-semibold mb-1">Tình Trạng</div>
                            <div class="font-bold text-slate-900">Mới 100%</div>
                        </div>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 flex items-center gap-4">
                        <div class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center text-slate-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        </div>
                        <div>
                            <div class="text-xs text-base-content/50 uppercase tracking-widest font-semibold mb-1">Kho hàng</div>
                            <div class="font-bold text-slate-900">{{ $product->stock }} sản phẩm</div>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Info (Size & Color) -->
                @if($product->size || $product->color)
                <div class="grid grid-cols-2 gap-4 mb-10">
                    @if($product->size)
                    <div class="bg-indigo-50/30 p-4 rounded-xl border border-indigo-100 flex items-center gap-4">
                        <div class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center text-indigo-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4H10M4 12V20m0 0h4M4 20H10M20 8V4m0 0h-4M20 4H14M20 12V20m0 0h-4m4 0H14"></path></svg>
                        </div>
                        <div>
                            <div class="text-xs text-indigo-400 uppercase tracking-widest font-semibold mb-1">Kích thước</div>
                            <div class="font-bold text-slate-900">{{ $product->size }}</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($product->color)
                    <div class="bg-rose-50/30 p-4 rounded-xl border border-rose-100 flex items-center gap-4">
                        <div class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center text-rose-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17l.354-.354"></path></svg>
                        </div>
                        <div>
                            <div class="text-xs text-rose-400 uppercase tracking-widest font-semibold mb-1">Màu sắc</div>
                            <div class="font-bold text-slate-900">{{ $product->color }}</div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Desktop CTAs & Quantity -->
                <div class="hidden lg:block space-y-6 mb-10 border-t border-b border-base-200 py-8">
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-slate-700">Số lượng:</span>
                        <!-- Quantity Selector -->
                        <div class="flex items-center gap-2 bg-slate-50 p-1.5 rounded-xl border border-slate-200 w-fit">
                            <button @click="quantity > 1 ? quantity-- : null" class="btn btn-sm btn-circle btn-ghost text-slate-500 hover:bg-white hover:shadow-sm" :disabled="quantity <= 1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                            </button>
                            <input type="number" x-model.number="quantity" class="w-12 text-center bg-transparent border-0 focus:ring-0 font-bold text-lg p-0" min="1" :max="stock">
                            <button @click="quantity < stock ? quantity++ : null" class="btn btn-sm btn-circle btn-ghost text-slate-500 hover:bg-white hover:shadow-sm" :disabled="quantity >= stock">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-4 mb-2 opacity-80 pt-2">
                        <span class="text-sm font-medium">Tạm tính:</span>
                        <span class="text-xl font-bold text-primary" x-text="(totalPrice).toLocaleString('vi-VN') + ' ₫'"></span>
                    </div>

                    <div class="flex gap-4">
                        <button 
                            @click="addToCart({{ $product->id }}, '{{ $product->name }}', currentPrice, '{{ $product->image_url }}', quantity)"
                            :disabled="stock <= 0"
                            class="flex-1 btn h-14 bg-white border-2 border-slate-900 text-slate-900 hover:bg-slate-900 hover:text-white hover:shadow-xl rounded-xl font-bold text-lg transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed group">
                            <svg class="w-5 h-5 group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Thêm vào giỏ hàng
                        </button>
                        <button 
                            @click="addToCart({{ $product->id }}, '{{ $product->name }}', currentPrice, '{{ $product->image_url }}', quantity); window.location.href='{{ route('client.cart.index') }}'"
                            :disabled="stock <= 0"
                            class="flex-1 btn h-14 bg-gradient-to-r from-blue-600 to-indigo-600 border-0 text-white hover:shadow-lg hover:shadow-blue-500/30 rounded-xl font-bold text-lg transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed transform hover:-translate-y-1">
                            Mua Ngay
                        </button>
                        
                        <!-- Wishlist Button -->
                        <button 
                            @click="toggleWishlist({{ $product->id }})"
                            class="w-14 h-14 rounded-xl border border-gray-200 flex items-center justify-center transition-all duration-300 hover:bg-rose-50 group shadow-sm bg-white"
                            :class="isInWishlist({{ $product->id }}) ? 'border-rose-100 bg-rose-50' : ''"
                        >
                            <svg class="w-6 h-6 transition-all duration-300" :class="isInWishlist({{ $product->id }}) ? 'text-rose-500 scale-110' : 'text-gray-400 group-hover:text-rose-400'" :fill="isInWishlist({{ $product->id }}) ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Product Details Accordion -->
                <div class="space-y-4 flex-grow">
                    <div class="collapse collapse-arrow bg-white border border-base-200 rounded-2xl shadow-sm">
                        <input type="radio" name="my-accordion-2" checked="checked" /> 
                        <div class="collapse-title text-lg font-bold text-slate-800">
                            Mô tả sản phẩm
                        </div>
                        <div class="collapse-content text-base-content/70 leading-relaxed"> 
                            <p>Thiết kế đột phá dành cho dân thể thao chuyên nghiệp. Khả năng thấm hút mồ hôi ưu việt và form dáng hiện đại đem lại sự linh hoạt tối đa trong mỗi cử động.</p>
                            <p class="mt-2">{{ $product->description ?? 'Không có mô tả chi tiết cho sản phẩm này.' }}</p>
                        </div>
                    </div>
                    <div class="collapse collapse-arrow bg-white border border-base-200 rounded-2xl shadow-sm">
                        <input type="radio" name="my-accordion-2" /> 
                        <div class="collapse-title text-lg font-bold text-slate-800">
                            Thông số & Kích thước
                        </div>
                        <div class="collapse-content text-base-content/70"> 
                            <table class="w-full text-sm">
                                <tbody>
                                    <tr class="border-b border-base-100">
                                        <td class="py-3 font-semibold w-1/3">Danh mục</td>
                                        <td class="py-3">{{ $product->category->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr class="border-b border-base-100">
                                        <td class="py-3 font-semibold w-1/3">Dòng sản phẩm</td>
                                        <td class="py-3">The Notorious 2026</td>
                                    </tr>
                                    <tr class="border-b border-base-100">
                                        <td class="py-3 font-semibold w-1/3">Ngày ra mắt</td>
                                        <td class="py-3">{{ $product->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="collapse collapse-arrow bg-white border border-base-200 rounded-2xl shadow-sm">
                        <input type="radio" name="my-accordion-2" /> 
                        <div class="collapse-title text-lg font-bold text-slate-800">
                            Bảo hành & Vận chuyển
                        </div>
                        <div class="collapse-content text-base-content/70 text-sm space-y-2"> 
                            <p><strong class="text-slate-700">Vận chuyển:</strong> Miễn phí giao hàng nội thành cho đơn hàng từ 500,000đ. Giao hàng ngoại thành 3-5 ngày làm việc.</p>
                            <p><strong class="text-slate-700">Bảo hành:</strong> 1 đổi 1 trong vòng 30 ngày nếu có lỗi từ nhà sản xuất. Cam kết chính hãng.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mobile Sticky Bottom CTA -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-base-200 shadow-[0_-10px_20px_rgba(0,0,0,0.05)] z-40 px-4 py-3 pb-safe transform transition-transform" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 100)">
        <div class="flex items-center gap-3">
            <button 
                @click="addToCart({{ $product->id }}, '{{ $product->name }}', currentPrice, '{{ $product->image_url }}', quantity)"
                :disabled="stock <= 0"
                class="btn flex-1 bg-white border-2 border-slate-900 text-slate-900 hover:bg-slate-900 hover:text-white rounded-xl font-bold rounded-xl min-h-12 h-12 shadow-sm disabled:opacity-50">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                Thêm
            </button>
            <button 
                @click="addToCart({{ $product->id }}, '{{ $product->name }}', currentPrice, '{{ $product->image_url }}', quantity); window.location.href='{{ route('client.cart.index') }}'"
                :disabled="stock <= 0"
                class="btn flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 border-0 text-white hover:bg-blue-700 shadow-md shadow-blue-500/20 font-bold rounded-xl min-h-12 h-12 disabled:opacity-50">
                Mua Ngay
            </button>
        </div>
    </div>
</div>

    <!-- Reviews Section -->
    <section class="mt-24 border-t border-gray-100 pt-20 pb-32" id="reviews">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex flex-col md:flex-row gap-16">
                <!-- Left: Review Summary -->
                <div class="w-full md:w-1/3 lg:w-1/4">
                    <h2 class="text-3xl font-black text-black tracking-tighter uppercase mb-6">Đánh giá sản phẩm</h2>
                    <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100">
                        <div class="flex items-center gap-4 mb-4">
                            <span class="text-6xl font-black text-black tracking-tighter">{{ $product->average_rating }}</span>
                            <div>
                                <div class="flex text-yellow-400 mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= floor($product->average_rating) ? 'fill-current' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-500 font-medium whitespace-nowrap">{{ $product->review_count }} đánh giá khách quan</span>
                            </div>
                        </div>

                        <!-- Rating Bars (Visual only for now) -->
                        <div class="space-y-2 mt-8">
                            @foreach([5, 4, 3, 2, 1] as $star)
                                @php
                                    $count = $product->reviews->where('rating', $star)->count();
                                    $percent = $product->review_count > 0 ? ($count / $product->review_count) * 100 : 0;
                                @endphp
                                <div class="flex items-center gap-3">
                                    <span class="text-[10px] font-black text-gray-400 w-4">{{ $star }} ★</span>
                                    <div class="flex-grow h-1 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-black transition-all duration-1000" style="width: {{ $percent }}%"></div>
                                    </div>
                                    <span class="text-[10px] font-bold text-gray-300 w-8 text-right">{{ round($percent) }}%</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right: Reviews List & Form -->
                <div class="flex-grow">
                    <!-- Form: Apple-style Minimalism -->
                    @auth
                        @php
                            $hasReviewed = $product->reviews->where('user_id', auth()->id())->first();
                        @endphp
                        
                        @if(!$hasReviewed)
                        <div class="mb-16 bg-white border border-gray-100 rounded-3xl p-8 shadow-sm" x-data="{ rating: 5 }">
                            <h3 class="text-xl font-black text-black mb-6 uppercase tracking-tighter">Viết đánh giá của bạn</h3>
                            <form action="{{ route('reviews.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="rating" x-model="rating">
                                
                                <div class="mb-8">
                                    <label class="block text-[11px] font-black uppercase tracking-widest text-gray-400 mb-4">Điểm đánh giá của bạn*</label>
                                    <div class="flex gap-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button type="button" @click="rating = {{ $i }}" class="w-12 h-12 flex items-center justify-center rounded-xl border-2 transition-all duration-300" :class="rating >= {{ $i }} ? 'bg-black border-black text-white' : 'border-gray-100 text-gray-200 hover:border-gray-300'">
                                                {{ $i }}
                                            </button>
                                        @endfor
                                    </div>
                                </div>

                                <div class="mb-8">
                                    <label class="block text-[11px] font-black uppercase tracking-widest text-gray-400 mb-4">Chia sẻ trải nghiệm của bạn (Không bắt buộc)</label>
                                    <textarea name="comment" rows="4" class="w-full bg-gray-50 border border-gray-100 rounded-2xl p-6 focus:bg-white focus:ring-1 focus:ring-black outline-none transition-all font-medium placeholder:text-gray-300" placeholder="Chất liệu thế nào? Form dáng có đúng size không?..."></textarea>
                                </div>

                                <button type="submit" class="apple-btn bg-black text-white hover:bg-gray-800 w-full md:w-auto px-12">
                                    Gửi đánh giá
                                </button>
                            </form>
                        </div>
                        @endif
                    @endauth

                    <!-- Reviews List -->
                    <div class="space-y-12">
                        @forelse($product->reviews as $review)
                            <div class="flex gap-6 items-start animate-in fade-in slide-in-from-bottom-4 duration-500">
                                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center flex-shrink-0 text-gray-400 font-black">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div class="flex-grow border-b border-gray-50 pb-12">
                                    <div class="flex justify-between items-center mb-2">
                                        <h4 class="font-bold text-black uppercase tracking-tight">{{ $review->user->name }}</h4>
                                        <span class="text-[10px] text-gray-300 font-bold uppercase tracking-widest">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex text-yellow-400 mb-4">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endfor
                                    </div>
                                    <p class="text-gray-500 font-medium leading-relaxed italic max-w-2xl">
                                        {{ $review->comment ?: 'Khách hàng không để lại bình luận.' }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-20 bg-gray-50 rounded-3xl border border-dashed border-gray-200">
                                <p class="text-gray-400 font-medium italic">Chưa có đánh giá nào cho sản phẩm này. Hãy là người đầu tiên chia sẻ!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- JSON-LD Structured Data for SEO -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Product",
      "name": "{{ $product->name }}",
      "image": "{{ $product->image_url }}",
      "description": "{{ Str::limit(strip_tags($product->description), 200) }}",
      "sku": "NT-{{ $product->id }}",
      "brand": {
        "@type": "Brand",
        "name": "Notorious"
      },
      "offers": {
        "@type": "Offer",
        "url": "{{ url()->current() }}",
        "priceCurrency": "VND",
        "price": "{{ $product->price * (1 - ($product->discount ?? 0) / 100) }}",
        "availability": "https://schema.org/{{ $product->stock > 0 ? 'InStock' : 'OutOfStock' }}",
        "seller": {
          "@type": "Organization",
          "name": "Notorious"
        }
      },
      @if($product->review_count > 0)
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "{{ $product->average_rating }}",
        "reviewCount": "{{ $product->review_count }}"
      }
      @endif
    }
    </script>
@endsection
