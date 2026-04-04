@extends('layouts.app')

@section('title', 'The Notorious - Thời trang thể thao')

@section('content')
    <!-- Banner Slider -->
    <div class="container mx-auto px-4 sm:px-6 max-w-7xl pt-8">
        <x-banner-slider />
    </div>
    
    <!-- Main Content -->
    <div class="container mx-auto px-4 sm:px-6 max-w-7xl py-16">
        <!-- Category Filter (Mobile-first) -->
        <div class="mb-12 fade-in" data-aos="fade-up">
            <div class="flex overflow-x-auto gap-2 pb-3 -mx-4 px-4 sm:mx-0 sm:px-0">
                <a href="/" class="btn btn-sm btn-active bg-slate-900 text-white border-0 gap-1 whitespace-nowrap hover:bg-slate-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"></path>
                    </svg>
                    Tất cả
                </a>
                @forelse($categories as $category)
                <a 
                    href="?category={{ $category->id }}"
                    class="btn btn-sm btn-outline gap-1 whitespace-nowrap hover:bg-slate-900 hover:text-white hover:border-slate-900"
                >
                    {{ $category->name }}
                </a>
                @empty
                @endforelse
            </div>
        </div>
        
        <!-- Section Header -->
        <div class="mb-12" data-aos="fade-up" data-aos-delay="100">
            <h2 class="text-4xl md:text-5xl font-black mb-3 text-slate-900 leading-tight">
                Sản Phẩm Nổi Bật
            </h2>
            <p class="text-lg text-slate-600 font-light">Khám phá những thiết kế tương lai với công nghệ vải tiên tiến</p>
        </div>
        
        <!-- Products Grid -->
        <div id="products" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @forelse($products as $product)
                <div data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 50 }}">
                    <x-product-card :product="$product" />
                </div>
            @empty
                <div class="col-span-full py-16 text-center">
                    <svg class="w-24 h-24 text-slate-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="text-2xl font-bold text-slate-600 mb-2">Không có sản phẩm</p>
                    <p class="text-slate-500 mb-6">Vui lòng quay lại sau</p>
                    <a href="/" class="btn btn-sm bg-slate-900 text-white border-0 hover:bg-slate-800">
                        Quay lại trang chủ
                    </a>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination (if needed) -->
        @if($products instanceof \Illuminate\Pagination\Paginator || $products instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="flex justify-center mt-16">
            {{ $products->links('pagination::tailwind') }}
        </div>
        @endif
        
        <!-- Features Section - Premium Style -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-20 pt-20 border-t-2 border-slate-200">
            <!-- Feature 1 -->
            <div class="text-center p-8 rounded-xl hover:shadow-lg transition-all duration-300" data-aos="fade-up" data-aos-delay="0">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 rounded-full mb-6">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-xl mb-3 text-slate-900">Giao Hàng Nhanh</h3>
                <p class="text-slate-600 font-light">Giao hàng miễn phí với đơn từ 500K. Nhanh chóng, an toàn, uy tín</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="text-center p-8 rounded-xl hover:shadow-lg transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-6">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-xl mb-3 text-slate-900">Chất Lượng Đảm Bảo</h3>
                <p class="text-slate-600 font-light">100% sản phẩm chính hãng, có bảo hành từ nhà sản xuất</p>
            </div>
            
            <!-- Feature 3 -->
            <div class="text-center p-8 rounded-xl hover:shadow-lg transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-orange-100 rounded-full mb-6">
                    <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-xl mb-3 text-slate-900">Dễ Dàng Đổi Trả</h3>
                <p class="text-slate-600 font-light">Có 30 ngày để đổi hàng không cần lý do, hỗ trợ 24/7</p>
            </div>
        </div>
    </div>

    <!-- Newsletter Section - Modern -->
    <section class="bg-gradient-to-r from-slate-900 via-blue-900 to-slate-900 py-16 md:py-20 rounded-3xl m-6 sm:m-8 md:m-12" data-aos="fade-up">
        <div class="container mx-auto px-6 max-w-2xl text-center">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-3 leading-tight">
                Nhận Ưu Đãi Độc Quyền
            </h2>
            <p class="text-gray-200 mb-8 font-light text-lg">
                Đăng ký nhận bản tin để được thông báo về các ưu đãi mới nhất, bộ sưu tập mới, và event đặc biệt
            </p>
            
            <form class="flex gap-3 flex-col sm:flex-row">
                <input 
                    type="email" 
                    placeholder="Nhập email của bạn" 
                    class="input input-bordered flex-1 h-12 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-0"
                    required
                />
                <button class="btn btn-primary h-12 px-8 gap-2 whitespace-nowrap bg-white text-slate-900 border-0 hover:bg-gray-100 font-bold rounded-lg">
                    <span>Đăng Ký</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </button>
            </form>
            
            <p class="text-xs text-gray-300 mt-4">
                ✓ Chúng tôi không bao giờ chia sẻ email của bạn với bên thứ ba
            </p>
        </div>
    </section>
@endsection
            @empty
                <div class="col-span-full py-12 text-center">
                    <svg class="w-16 h-16 text-base-content/20 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="text-lg font-semibold text-base-content/60">Không có sản phẩm</p>
                    <p class="text-sm text-base-content/40">Vui lòng quay lại sau</p>
                    <a href="/" class="btn btn-primary btn-sm mt-4">
                        Quay lại trang chủ
                    </a>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination (if needed) -->
        @if($products instanceof \Illuminate\Pagination\Paginator || $products instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="flex justify-center mt-12">
            {{ $products->links('pagination::tailwind') }}
        </div>
        @endif
        
        <!-- Features Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-16 pt-16 border-t border-base-200">
            <!-- Feature 1 -->
            <div class="text-center p-6">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/10 rounded-full mb-4">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2">Giao hàng nhanh</h3>
                <p class="text-sm text-base-content/60">Giao hàng miễn phí với đơn từ 500K</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="text-center p-6">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-success/10 rounded-full mb-4">
                    <svg class="w-8 h-8 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2">Chất lượng đảm bảo</h3>
                <p class="text-sm text-base-content/60">100% sản phẩm chính hãng, có bảo hành</p>
            </div>
            
            <!-- Feature 3 -->
            <div class="text-center p-6">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-warning/10 rounded-full mb-4">
                    <svg class="w-8 h-8 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m10 0h2m-2 0h-2.5m0 0a1 1 0 11-2 0 1 1 0 012 0zM14 13h2m0 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2">Dễ dàng đổi trả</h3>
                <p class="text-sm text-base-content/60">Có 30 ngày để đổi hàng không cần lý do</p>
            </div>
        </div>
    </div>

    <!-- Newsletter Section -->
    <section class="bg-gradient-to-r from-primary/10 to-secondary/10 py-12 md:py-16 border-t border-base-200">
        <div class="container mx-auto px-4 sm:px-6 max-w-7xl">
            <div class="max-w-2xl mx-auto text-center">
                <h2 class="text-2xl md:text-3xl font-bold mb-3">Nhận ưu đãi độc quyền</h2>
                <p class="text-base-content/60 mb-6">Đăng ký nhận bản tin của chúng tôi để được thông báo về các ưu đãi mới nhất và bộ sưu tập mới</p>
                
                <form class="flex gap-2 flex-col sm:flex-row">
                    <input 
                        type="email" 
                        placeholder="Nhập email của bạn" 
                        class="input input-bordered flex-1 h-12"
                        required
                    />
                    <button class="btn btn-primary h-12 px-8 gap-2 whitespace-nowrap">
                        <span class="font-semibold">Đăng ký</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </button>
                </form>
                
                <p class="text-xs text-base-content/50 mt-4">
                    Chúng tôi sẽ không bao giờ chia sẻ email của bạn với bên thứ ba.
                </p>
            </div>
        </div>
    </section>
@endsection
