@extends('layouts.app')

@section('title', 'Danh sách yêu thích - The Notorious')

@section('content')
<div class="bg-white min-h-screen">
    <!-- Hero Header -->
    <section class="bg-gray-50 pt-24 pb-16 border-b border-gray-100">
        <div class="container mx-auto px-4 max-w-7xl">
            <nav class="text-sm breadcrumbs mb-6 text-gray-400 font-bold uppercase tracking-widest">
                <ul class="flex gap-2">
                    <li><a href="{{ route('home') }}" class="hover:text-black">Trang chủ</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-black">Yêu thích</li>
                </ul>
            </nav>
            <h1 class="text-4xl md:text-6xl font-black text-black tracking-tighter uppercase leading-none">
                Sản phẩm của bạn.
            </h1>
            <p class="mt-6 text-gray-500 font-medium text-lg italic max-w-xl">
                Lưu giữ những món đồ thể thao phong cách nhất để sở hữu ngay khi bạn sẵn sàng.
            </p>
        </div>
    </section>

    <!-- Wishlist Grid -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl py-20">
        @if($products->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-12 md:gap-x-10 md:gap-y-16">
                @foreach($products as $index => $product)
                    <div data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 100 }}" class="h-full group/wishlist relative">
                        <x-product-card :product="$product" />
                        
                        <!-- Remove from Wishlist Shortcut -->
                        <button 
                            @click.stop="toggleWishlist({{ $product->id }}); $el.closest('.group\\/wishlist').remove()"
                            class="absolute top-2 right-2 w-8 h-8 rounded-full bg-white text-gray-400 hover:text-red-500 flex items-center justify-center shadow-sm opacity-0 group-hover/wishlist:opacity-100 transition-all duration-300 z-30"
                            title="Xóa khỏi danh sách"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="mt-24 border-t border-gray-50 pt-16 flex justify-center">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <!-- Empty State: Apple-style Minimalism -->
            <div class="py-40 text-center max-w-lg mx-auto" data-aos="fade-up">
                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-10 shadow-sm border border-gray-100">
                    <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-black text-black mb-4 tracking-tighter uppercase">Danh sách trống</h2>
                <p class="text-gray-500 font-medium mb-12">Hãy khám phá bộ sưu tập mới nhất và chọn cho mình những món đồ ưng ý nhất.</p>
                <a href="{{ route('home') }}" class="apple-btn bg-black text-white hover:bg-gray-800 px-12 inline-flex items-center">
                    Khám phá ngay
                </a>
            </div>
        @endif
    </div>

    <!-- Recommendations Section -->
    <section class="py-24 bg-gray-50 overflow-hidden">
        <div class="container mx-auto px-4 max-w-7xl">
            <h2 class="text-2xl font-black text-black tracking-tighter uppercase mb-12">Có thể bạn sẽ thích</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @php $recommendations = \App\Models\Product::inRandomOrder()->take(4)->get(); @endphp
                @foreach($recommendations as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>
</div>

<style>
    .apple-btn {
        @apply h-14 rounded-xl font-bold uppercase tracking-widest text-xs transition-all duration-300 active:scale-95 flex items-center justify-center;
    }
</style>
@endsection
