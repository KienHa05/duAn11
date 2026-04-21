@extends('layouts.app')

@section('title', $product->name . ' - The Notorious')

@section('content')
<div class="bg-base-50 min-h-screen py-8 lg:py-12" x-data="{ 
        quantity: 1, 
        stock: {{ $product->stock }},
        price: {{ $product->price }},
        discount: {{ $product->discount ?? 0 }},
        image: '{{ $product->image_url }}',
        isBuying: false,
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
                                    -{{ $product->discount }}% GIẢM
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
                    <!-- Trust Badges: Elevated Linear Luxury Style -->
                    <div class="flex flex-wrap items-center gap-6 mt-12 py-6 border-t border-b border-gray-100">
                        <div class="flex items-center gap-3 group/badge cursor-default">
                            <div class="w-8 h-8 rounded-lg bg-black text-white flex items-center justify-center shrink-0 shadow-lg shadow-black/10 group-hover/badge:-rotate-12 transition-transform duration-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-[0.25em] text-gray-400 group-hover/badge:text-black transition-colors duration-300">Chính Hãng 100%</span>
                        </div>
                        <div class="w-px h-4 bg-gray-100 hidden md:block"></div>
                        <div class="flex items-center gap-3 group/badge cursor-default">
                            <div class="w-8 h-8 rounded-lg bg-black text-white flex items-center justify-center shrink-0 shadow-lg shadow-black/10 group-hover/badge:-rotate-12 transition-transform duration-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-[0.25em] text-gray-400 group-hover/badge:text-black transition-colors duration-300">Thanh Toán An Toàn</span>
                        </div>
                        <div class="w-px h-4 bg-gray-100 hidden md:block"></div>
                        <div class="flex items-center gap-3 group/badge cursor-default">
                            <div class="w-8 h-8 rounded-lg bg-black text-white flex items-center justify-center shrink-0 shadow-lg shadow-black/10 group-hover/badge:-rotate-12 transition-transform duration-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path></svg>
                            </div>
                            <span class="text-[10px] font-black uppercase tracking-[0.25em] text-gray-400 group-hover/badge:text-black transition-colors duration-300">Đổi Trả 30 Ngày</span>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Right: Product Info -->
            <div class="w-full lg:w-1/2 flex flex-col" data-aos="fade-left" data-aos-delay="100">
                <div class="mb-2">
                    <span class="text-sm font-bold text-primary tracking-widest uppercase">{{ $product->category->name ?? 'Sản phẩm' }}</span>
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

                <!-- Specs Grid: Elevated Glassmorphism Style -->
                <div class="grid grid-cols-2 gap-4 mb-10">
                    <div class="bg-white/40 backdrop-blur-md p-5 rounded-3xl border border-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex items-center gap-5 group/spec hover:bg-white hover:border-black transition-all duration-500">
                        <div class="w-12 h-12 bg-black text-white rounded-2xl shadow-lg flex items-center justify-center group-hover/spec:bg-gray-900 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div>
                            <div class="text-[9px] text-gray-400 uppercase tracking-[0.3em] font-black mb-1">Tình Trạng</div>
                            <div class="font-black text-black text-xs uppercase tracking-tight">Mới 100%</div>
                        </div>
                    </div>
                    <div class="bg-white/40 backdrop-blur-md p-5 rounded-3xl border border-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex items-center gap-5 group/spec hover:bg-white hover:border-black transition-all duration-500">
                        <div class="w-12 h-12 bg-black text-white rounded-2xl shadow-lg flex items-center justify-center group-hover/spec:bg-gray-900 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        </div>
                        <div>
                            <div class="text-[9px] text-gray-400 uppercase tracking-[0.3em] font-black mb-1">Kho hàng</div>
                            <div class="font-black text-black text-xs uppercase tracking-tight">{{ $product->stock }} Sản Phẩm</div>
                        </div>
                    </div>
                </div>

                @if($product->size || $product->color)
                <div class="grid grid-cols-2 gap-4 mb-10">
                    @if($product->size)
                    <div class="bg-white/40 backdrop-blur-md p-5 rounded-3xl border border-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex items-center gap-5 group/spec hover:bg-white hover:border-black transition-all duration-500">
                        <div class="w-12 h-12 bg-black text-white rounded-2xl shadow-lg flex items-center justify-center group-hover/spec:bg-gray-900 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4H10M4 12V20m0 0h4M4 20H10M20 8V4m0 0h-4M20 4H14M20 12V20m0 0h-4m4 0H14"></path></svg>
                        </div>
                        <div>
                            <div class="text-[9px] text-gray-400 uppercase tracking-[0.3em] font-black mb-1">Kích Thước</div>
                            <div class="font-black text-black text-xs uppercase tracking-tight">{{ $product->size }}</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($product->color)
                    <div class="bg-white/40 backdrop-blur-md p-5 rounded-3xl border border-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex items-center gap-5 group/spec hover:bg-white hover:border-black transition-all duration-500">
                        <div class="w-12 h-12 bg-black text-white rounded-2xl shadow-lg flex items-center justify-center group-hover/spec:bg-gray-900 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17l.354-.354"></path></svg>
                        </div>
                        <div>
                            <div class="text-[9px] text-gray-400 uppercase tracking-[0.3em] font-black mb-1">Màu Sắc</div>
                            <div class="font-black text-black text-xs uppercase tracking-tight">{{ $product->color }}</div>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Product Info Sections: Simple & Stable -->
                <div class="mt-12 space-y-4">
                    <!-- Trust Badges: Clean Linear Style -->
                    <div class="flex flex-wrap items-center gap-4 py-4 border-t border-gray-100">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-[10px] font-black uppercase tracking-widest text-black">Chính hãng 100%</span>
                        </div>
                        <div class="w-1 h-1 bg-gray-200 rounded-full"></div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            <span class="text-[10px] font-black uppercase tracking-widest text-black">Thanh toán an toàn</span>
                        </div>
                        <div class="w-1 h-1 bg-gray-200 rounded-full"></div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path></svg>
                            <span class="text-[10px] font-black uppercase tracking-widest text-black">Đổi trả 30 ngày</span>
                        </div>
                    </div>

                    <!-- Quantity & Primary CTAs -->
                    <div class="space-y-6 pt-6 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black uppercase tracking-widest text-black">Số lượng</span>
                            <div class="flex items-center gap-1 bg-gray-50 p-1 rounded-xl border border-gray-100">
                                <button @click="quantity > 1 ? quantity-- : null" class="w-8 h-8 flex items-center justify-center hover:bg-white rounded-lg transition-colors" :disabled="quantity <= 1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path></svg>
                                </button>
                                <input type="number" x-model.number="quantity" class="w-10 text-center bg-transparent border-0 focus:ring-0 font-bold text-sm" min="1" :max="stock">
                                <button @click="quantity < stock ? quantity++ : null" class="w-8 h-8 flex items-center justify-center hover:bg-white rounded-lg transition-colors" :disabled="quantity >= stock">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button 
                                @click="addToCart({{ $product->id }}, '{{ $product->name }}', currentPrice, image, quantity)"
                                :disabled="stock <= 0"
                                class="flex-1 h-14 bg-white border-2 border-black text-black rounded-xl font-black text-[10px] sm:text-xs uppercase tracking-[0.2em] hover:bg-black hover:text-white transition-all duration-500 active:scale-[0.96] shadow-sm hover:shadow-xl cursor-pointer premium-btn">
                                Thêm vào giỏ
                            </button>
                            <button 
                                @click="buyNow({{ $product->id }}, '{{ $product->name }}', currentPrice, image, quantity)"
                                :disabled="stock <= 0"
                                class="flex-1 h-14 bg-black text-white rounded-xl font-black text-[10px] sm:text-xs uppercase tracking-[0.2em] hover:bg-gray-900 transition-all duration-500 active:scale-[0.96] shadow-lg hover:shadow-2xl cursor-pointer premium-btn-primary flex items-center justify-center gap-2">
                                <span>MUA NGAY</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Accordion Details -->
                    <div class="space-y-2 mt-8">
                        <!-- Description -->
                        <div class="collapse collapse-arrow bg-white border border-gray-100 rounded-2xl shadow-sm">
                            <input type="checkbox" checked /> 
                            <div class="collapse-title text-sm font-black uppercase tracking-widest py-4">Mô tả sản phẩm</div>
                            <div class="collapse-content prose prose-sm text-gray-500 pb-6">
                                {{ $product->description ?? 'Không có mô tả chi tiết cho sản phẩm này.' }}
                            </div>
                        </div>

                        <!-- Specs -->
                        <div class="collapse collapse-arrow bg-white border border-gray-100 rounded-2xl shadow-sm">
                            <input type="checkbox" /> 
                            <div class="collapse-title text-sm font-black uppercase tracking-widest py-4">Thông số kỹ thuật</div>
                            <div class="collapse-content pb-6">
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">Danh mục</span>
                                        <span class="text-xs font-black text-black uppercase">{{ $product->category->name ?? 'Sản phẩm' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">Dòng sản phẩm</span>
                                        <span class="text-xs font-black text-black uppercase">Notorious 2026</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">Ngày ra mắt</span>
                                        <span class="text-xs font-black text-black uppercase">{{ $product->created_at->format('m/Y') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">Trạng thái</span>
                                        <span class="text-xs font-black text-black uppercase text-green-600">Sẵn hàng</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Shipping/Warranty -->
                        <div class="collapse collapse-arrow bg-white border border-gray-100 rounded-2xl shadow-sm">
                            <input type="checkbox" /> 
                            <div class="collapse-title text-sm font-black uppercase tracking-widest py-4">Bảo hành & Vận chuyển</div>
                            <div class="collapse-content text-xs text-gray-500 pb-6 space-y-4">
                                <p><strong>Vận chuyển:</strong> Miễn phí giao hàng nội thành cho đơn hàng từ 500,000đ. Giao hàng ngoại thành 3-5 ngày làm việc.</p>
                                <p><strong>Bảo hành:</strong> 1 đổi 1 trong vòng 30 ngày nếu có lỗi từ nhà sản xuất. Cam kết chính hãng Notorious.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="lg:hidden fixed bottom-6 left-6 right-6 backdrop-blur-md z-40 px-4 py-3 p-1 bg-black/90 rounded-2xl shadow-2xl border border-white/10" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 100)">
        <div class="flex items-center gap-3">
            <button 
                @click="addToCart({{ $product->id }}, '{{ $product->name }}', currentPrice, image, 1)"
                :disabled="stock <= 0"
                class="btn flex-1 bg-white border-0 text-black hover:bg-white/90 rounded-xl font-bold rounded-xl min-h-12 h-12 shadow-sm disabled:opacity-50">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                Thêm
            </button>
            <button 
                @click="isBuying = true; buyNow({{ $product->id }}, '{{ $product->name }}', currentPrice, image, 1)"
                :disabled="stock <= 0 || isBuying"
                class="btn flex-1 bg-blue-600 border-0 text-white hover:bg-blue-700 shadow-md shadow-blue-500/20 font-bold rounded-xl min-h-12 h-12 disabled:opacity-50 flex items-center justify-center">
                <template x-if="!isBuying">
                    <span>Mua Ngay</span>
                </template>
                <template x-if="isBuying">
                    <div class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                </template>
            </button>
        </div>
    </div>

    <!-- Related Products Section -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <div class="container mx-auto px-4 sm:px-6 max-w-7xl mt-24 mb-20">
        <div class="flex flex-col md:flex-row justify-between items-end gap-4 mb-10" data-aos="fade-up">
            <div class="space-y-2">
                <span class="text-xs font-black uppercase tracking-[0.3em] text-blue-600">Đề xuất cho bạn</span>
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">Sản phẩm liên quan</h2>
            </div>
            <a href="{{ route('home') }}?category={{ $product->category_id }}" class="group flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-black transition-colors pb-1 border-b-2 border-transparent hover:border-black">
                Xem tất cả
                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
        
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
            @foreach($relatedProducts as $related)
                <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <x-product-card :product="$related" />
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<style>
    /* Safe area padding for mobile notches */
    .pb-safe { padding-bottom: env(safe-area-inset-bottom, 1rem); }

    .premium-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        cursor: pointer !important;
    }

    .premium-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.05);
    }

    .premium-btn:active {
        transform: translateY(1px) scale(0.98);
    }

    .premium-btn-primary {
        position: relative;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        cursor: pointer !important;
    }

    .premium-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .premium-btn-primary:active {
        transform: translateY(1px) scale(0.98);
    }

    /* Magnetic effect hint */
    .premium-btn:hover svg {
        transform: translateX(3px);
        transition: transform 0.3s ease;
    }
</style>
@endsection
