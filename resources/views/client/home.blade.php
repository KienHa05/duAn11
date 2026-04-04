@extends('layouts.app')

@section('title', 'The Notorious - Thế giới thời trang thể thao')

@section('content')
    <!-- Banner Slider -->
    <div class="container mx-auto px-4 sm:px-6 max-w-7xl pt-8" data-aos="fade-down" data-aos-duration="1000">
        <x-banner-slider />
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 sm:px-6 max-w-7xl py-16 lg:py-24">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6" data-aos="fade-up">
            <div>
                <h2 class="text-4xl md:text-5xl font-black mb-3 tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600">
                    Sản Phẩm Tinh Hoa
                </h2>
                <p class="text-slate-500 text-lg">Khám phá những bộ sưu tập dẫn đầu xu hướng mới nhất.</p>
            </div>
            
            <!-- Category Filter - Sticky or Inline -->
            <div class="flex overflow-x-auto gap-2 pb-2 -mx-4 px-4 sm:mx-0 sm:px-0 scrollbar-hide">
                <a href="{{ route('home') }}" class="btn {{ !request('category') ? 'bg-slate-900 text-white hover:bg-slate-800' : 'btn-outline border-slate-200 text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-900' }} border-0 rounded-full px-6 transition-all duration-300">
                    Tất cả
                </a>

                @forelse($categories as $category)
                    <a href="?category={{ $category->id }}" class="btn {{ request('category') == $category->id ? 'bg-slate-900 text-white hover:bg-slate-800' : 'btn-outline border-slate-200 text-slate-600 hover:bg-slate-50 hover:border-slate-300 hover:text-slate-900' }} border-0 rounded-full px-6 whitespace-nowrap transition-all duration-300">
                        {{ $category->name }}
                    </a>
                @empty
                @endforelse
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
            @forelse($products as $index => $product)
                <div data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 100 }}">
                    <x-product-card :product="$product" />
                </div>
            @empty
                <div class="col-span-full py-24 text-center bg-white rounded-3xl border border-dashed border-slate-300" data-aos="fade-up">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Chưa có sản phẩm</h3>
                    <p class="text-slate-500">Danh mục này hiện chưa có sản phẩm nào. Vui lòng quay lại sau.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->hasPages())
            <div class="mt-16 flex justify-center" data-aos="fade-up">
                <div class="bg-white px-4 py-2 rounded-full shadow-sm border border-slate-100">
                    {{ $products->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Premium Newsletter Section -->
    <section class="py-24 relative overflow-hidden my-12" data-aos="fade-up">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900"></div>
        
        <!-- Abstract Shapes -->
        <div class="absolute top-0 right-0 -translate-y-12 translate-x-1/3 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/3 -translate-x-1/4 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 right-1/4 translate-y-1/3 w-96 h-96 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-4000"></div>

        <div class="container mx-auto px-4 max-w-4xl relative z-10 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-white/10 border border-white/20 text-blue-200 text-sm font-semibold tracking-wider mb-6 backdrop-blur-md">THÔNG TIN MỚI NHẤT</span>
            <h2 class="text-4xl md:text-6xl font-black text-white mb-6 tracking-tight">Cập nhật xu hướng & <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-emerald-400">Nhận ưu đãi 15%</span></h2>
            <p class="text-lg md:text-xl text-blue-100/80 mb-10 max-w-2xl mx-auto font-light leading-relaxed">
                Đăng ký thành viên cộng đồng The Notorious để là người đầu tiên sở hữu những bộ sưu tập giới hạn và các chương trình khuyến mãi độc quyền.
            </p>
            
            <form class="flex flex-col sm:flex-row gap-4 max-w-2xl mx-auto relative">
                <div class="relative flex-grow">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input type="email" placeholder="Nhập địa chỉ email của bạn..." class="w-full pl-12 pr-4 py-4 rounded-2xl border-0 focus:ring-4 focus:ring-blue-500/30 bg-white/10 backdrop-blur-md text-white placeholder-blue-200/50 text-lg transition-all" required>
                </div>
                <button type="button" class="btn btn-lg bg-white text-slate-900 border-0 rounded-2xl hover:bg-blue-50 hover:scale-105 transition-all duration-300 font-bold px-8 shadow-[0_0_20px_rgba(255,255,255,0.3)]">
                    Đăng Ký Ngay
                </button>
            </form>
            <p class="text-sm text-blue-200/60 mt-6 select-none">Bằng việc đăng ký, bạn đồng ý với Điều khoản dịch vụ & Chính sách bảo mật của chúng tôi.</p>
        </div>
    </section>
@endsection
