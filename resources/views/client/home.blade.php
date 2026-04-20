@extends('layouts.app')

@section('title', 'Notorious - Thế giới thời trang thể thao tối giản')

@section('content')
  <!-- Banner Slider - Full Width Edge-to-Edge -->
  <div class="w-full" data-aos="fade-in" data-aos-duration="1500">
    <x-banner-slider />
  </div>

  <!-- Main Content Section -->
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl py-20 lg:py-32">
    <!-- Section Header - Apple Aesthetic -->
    <div class="mb-16 md:mb-24 flex flex-col md:flex-row md:items-end justify-between gap-8" data-aos="fade-up">
      <div class="max-w-2xl">
        <span class="inline-block py-1 text-xs font-black uppercase tracking-[0.25em] text-gray-400 mb-4">Danh mục tuyển
          chọn</span>
        <h2 class="text-4xl md:text-6xl font-black text-black tracking-tighter leading-none">
          CÁC DÒNG SẢN PHẨM <br />MỚI NHẤT.
        </h2>
      </div>

      <!-- Category Filter: Minimalist Navigation -->
      <div class="flex flex-wrap gap-3 md:gap-4 scrollbar-hide">
        <a href="{{ route('home') }}"
          class="px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300 {{ !request('category') ? 'bg-black text-white' : 'bg-gray-100 text-gray-500 hover:bg-gray-200 hover:text-black' }}">
          Tất cả
        </a>

        @forelse($categories as $category)
          <a href="?category={{ $category->id }}"
            class="px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300 {{ request('category') == $category->id ? 'bg-black text-white' : 'bg-gray-100 text-gray-500 hover:bg-gray-200 hover:text-black' }}">
            {{ $category->name }}
          </a>
        @empty
        @endforelse
      </div>
    </div>

    <!-- Products Grid - Focused & Clean -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-12 md:gap-x-10 md:gap-y-16">
      @forelse($products as $index => $product)
        <div data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 100 }}" class="h-full">
          <x-product-card :product="$product" />
        </div>
      @empty
        <div class="col-span-full py-40 text-center bg-gray-50 rounded-3xl" data-aos="fade-up">
          <div
            class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border border-gray-100">
            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
              </path>
            </svg>
          </div>
          <h3 class="text-2xl font-black text-black mb-2">Đang cập nhật sản phẩm</h3>
          <p class="text-gray-500 font-medium">Chúng tôi đang chuẩn bị bộ sưu tập mới cho danh mục này.</p>
        </div>
      @endforelse
    </div>

    <!-- Minimalist Pagination -->
    @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->hasPages())
      <div class="mt-24 border-t border-gray-100 pt-16 flex justify-center" data-aos="fade-up">
        <div class="bg-gray-50 p-1.5 rounded-full flex items-center shadow-sm">
          {{ $products->links() }}
        </div>
      </div>
    @endif
  </div>

  <!-- Apple-Style Promotion / About Section -->
  <section class="bg-black py-24 md:py-40 text-white overflow-hidden" data-aos="fade-up">
    <div class="container mx-auto px-4 max-w-6xl text-center relative z-10">
      <span
        class="inline-block px-3 py-1 bg-white/10 text-white text-[11px] font-black uppercase tracking-[0.3em] rounded mb-8">Triết
        lý thiết kế</span>
      <h2 class="text-4xl md:text-7xl font-black mb-10 tracking-tighter leading-none">
        ĐƠN GIẢN LÀ SỰ <br />TỐI THƯỢNG.
      </h2>
      <p class="text-lg md:text-2xl text-gray-400 mb-16 max-w-3xl mx-auto font-medium leading-relaxed italic">
        "Chúng tôi tin rằng cái đẹp thực sự không nằm ở những chi tiết thừa thãi, mà nó nằm ở sự cân bằng tuyệt đối giữa
        hiệu năng và tính thẩm mỹ cao nhất."
      </p>

      <div class="flex flex-col sm:flex-row gap-6 justify-center">
        <a href="#about"
          class="apple-btn bg-white text-black border border-transparent hover:bg-black hover:text-white hover:border-white">
          Về chúng tôi
        </a>
        <a href="#contact"
          class="apple-btn border border-white text-white hover:bg-white hover:text-black hover:border-black">
          Liên hệ trực tiếp
        </a>
      </div>
    </div>
  </section>

  <!-- Newsletters: High end minimalist -->
  <section class="py-24 md:py-32 bg-white" data-aos="fade-up">
    <div class="container mx-auto px-4 max-w-3xl text-center">
      <h2 class="text-3xl md:text-5xl font-black text-black mb-6 tracking-tighter uppercase">Bản tin Notorious</h2>
      <p class="text-gray-500 mb-10 text-lg font-medium">Nhận thông báo sớm nhất về các bộ sưu tập giới hạn.</p>

      <form class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto items-stretch">
        <div class="flex-grow">
          <input type="email" placeholder="Địa chỉ email..."
            class="w-full h-14 px-6 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-1 focus:ring-black focus:outline-none transition-all font-medium"
            required>
        </div>
        <button type="submit"
          class="h-14 bg-black text-white border border-black rounded-xl font-black text-xs tracking-[0.2em] px-10 transition-all duration-300 hover:bg-white hover:text-black shadow-lg shadow-black/10 active:scale-95 cursor-pointer whitespace-nowrap">
          ĐĂNG KÝ NGAY
        </button>
      </form>
    </div>
  </section>
@endsection