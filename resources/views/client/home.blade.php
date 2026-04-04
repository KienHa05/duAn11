@extends('layouts.app')

@section('title', 'The Notorious - Thời trang thể thao')

@section('content')
    <!-- Banner Slider -->
    <div class="container mx-auto px-4 sm:px-6 max-w-7xl pt-6">
        <x-banner-slider />
    </div>
    
    <!-- Main Content -->
    <div class="container mx-auto px-4 sm:px-6 max-w-7xl pb-16">
        <!-- Category Filter (Mobile-first) -->
        <div class="mb-8">
            <div class="flex overflow-x-auto gap-2 pb-2 -mx-4 px-4 sm:mx-0 sm:px-0">
                <button class="btn btn-sm btn-active btn-primary gap-1 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"></path>
                    </svg>
                    Tất cả
                </button>
                @forelse($categories as $category)
                <a 
                    href="?category={{ $category->id }}"
                    class="btn btn-sm btn-outline gap-1 whitespace-nowrap hover:btn-primary"
                >
                    {{ $category->name }}
                </a>
                @empty
                @endforelse
            </div>
        </div>
        
        <!-- Section Header -->
        <div class="mb-8">
            <h2 class="text-3xl md:text-4xl font-bold mb-2">Sản Phẩm Nổi Bật</h2>
            <p class="text-base-content/60">Khám phá bộ sưu tập quần áo thể thao mới nhất của chúng tôi</p>
        </div>
        
        <!-- Products Grid -->
        <div id="products" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @forelse($products as $product)
                <x-product-card :product="$product" />
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
