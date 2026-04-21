@extends('layouts.app')

@section('title', 'Notorious - Thế giới thời trang thể thao tối giản')

@section('content')
  <!-- Banner Slider - Full Width Edge-to-Edge -->
  <div class="w-full" data-aos="fade-in" data-aos-duration="1500">
    <x-banner-slider />
  </div>

  <!-- Main Content Section -->
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl py-20 lg:py-32">

    {{-- ===== Search Result Banner ===== --}}
    @if(request('search') || request('category') || request('sort', 'newest') !== 'newest')
      <div class="mb-10 p-4 bg-gray-50 border border-gray-100 rounded-2xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4" data-aos="fade-down" data-aos-duration="600">
        <div class="flex items-center gap-3 flex-wrap">
          <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          <span class="text-sm font-bold text-black">
            {{ number_format($products->total()) }} kết quả
            @if(request('search'))
              cho <span class="text-black">&ldquo;{{ request('search') }}&rdquo;</span>
            @endif
            @if(request('category'))
              @php $activeCat = $categories->firstWhere('id', request('category')); @endphp
              @if($activeCat)
                trong danh mục <span class="text-black">{{ $activeCat->name }}</span>
              @endif
            @endif
          </span>
          {{-- Active Tags --}}
          <div class="flex gap-2 flex-wrap">
            @if(request('search'))
              <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-black text-white text-xs font-bold rounded-full">
                {{ request('search') }}
                <a href="{{ route('home', array_filter(array_merge(request()->query(), ['search' => null]))) }}" class="hover:opacity-70 transition-opacity" aria-label="Xoá tìm kiếm">&times;</a>
              </span>
            @endif
            @if(request('category'))
              @php $activeCat = $activeCat ?? $categories->firstWhere('id', request('category')); @endphp
              <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-800 text-white text-xs font-bold rounded-full">
                {{ optional($activeCat)->name }}
                <a href="{{ route('home', array_filter(array_merge(request()->query(), ['category' => null]))) }}" class="hover:opacity-70 transition-opacity" aria-label="Xoá danh mục">&times;</a>
              </span>
            @endif
            @if(request('min_price') || request('max_price'))
              <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-800 text-white text-xs font-bold rounded-full">
                Từ {{ request('min_price') ? number_format(request('min_price')) . 'đ' : '0đ' }} đến {{ request('max_price') ? number_format(request('max_price')) . 'đ' : 'vô tận' }}
                <a href="{{ route('home', array_filter(array_merge(request()->query(), ['min_price' => null, 'max_price' => null]))) }}" class="hover:opacity-70 transition-opacity" aria-label="Xoá khoảng giá">&times;</a>
              </span>
            @endif
          </div>
        </div>
        <a href="{{ route('home') }}" class="shrink-0 text-xs font-bold text-gray-500 hover:text-black transition-colors border border-gray-200 hover:border-black px-4 py-2 rounded-full">
          Xoá tất cả bộ lọc
        </a>
      </div>
    @endif

    {{-- ===== Section Header ===== --}}
    <div class="mb-16 md:mb-20 relative z-40" data-aos="fade-up">
      <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="max-w-2xl">
          @if(request('search'))
            <span class="inline-block py-1 text-xs font-black uppercase tracking-[0.25em] text-gray-400 mb-4">Kết quả tìm kiếm</span>
            <h2 class="text-4xl md:text-5xl font-black text-black tracking-tighter leading-none">
              &ldquo;{{ strtoupper(request('search')) }}&rdquo;
            </h2>
          @else
            <span class="inline-block py-1 text-xs font-black uppercase tracking-[0.25em] text-gray-400 mb-4">Danh mục tuyển chọn</span>
            <h2 class="text-4xl md:text-6xl font-black text-black tracking-tighter leading-none">
              CÁC DÒNG SẢN PHẨM <br />MỚI NHẤT.
            </h2>
          @endif
        </div>

        {{-- Right controls: Filters --}}
        <div class="flex flex-wrap items-center gap-3 ml-auto">
          
          {{-- Category Dropdown --}}
          <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            @php
                $activeCat = request('category') ? $categories->firstWhere('id', request('category')) : null;
            @endphp
            <button @click="open = !open" type="button"
              class="flex items-center gap-2.5 px-6 py-3 {{ request('category') ? 'bg-black text-white shadow-md' : 'bg-gray-100 hover:bg-gray-200 text-gray-800' }} rounded-full text-sm font-bold transition-all duration-200 whitespace-nowrap cursor-pointer">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
              Danh mục{{ $activeCat ? ': ' . $activeCat->name : '' }}
              <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
            </button>
            
            <div x-show="open" x-cloak
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                class="absolute right-0 sm:left-0 sm:right-auto top-full mt-3 w-64 bg-white border border-gray-100 rounded-2xl shadow-xl shadow-black/5 overflow-hidden z-[60] max-h-80 overflow-y-auto">
                <a href="{{ route('home', array_filter(array_merge(request()->query(), ['category' => null, 'page' => null]))) }}"
                   class="flex items-center justify-between px-6 py-3.5 text-sm font-bold hover:bg-gray-50 transition-colors {{ !request('category') ? 'text-black' : 'text-gray-500' }}">
                   Tất cả
                   @if(!request('category'))
                     <svg class="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                     </svg>
                   @endif
                </a>
                @forelse($categories as $category)
                  <a href="{{ route('home', array_filter(array_merge(request()->query(), ['category' => $category->id, 'page' => null]))) }}"
                     class="flex items-center justify-between px-6 py-3.5 text-sm font-bold hover:bg-gray-50 transition-colors border-t border-gray-50 {{ request('category') == $category->id ? 'text-black' : 'text-gray-500' }}">
                     {{ $category->name }}
                     @if(request('category') == $category->id)
                       <svg class="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                       </svg>
                     @endif
                  </a>
                @empty
                @endforelse
            </div>
          </div>

          {{-- Price Dropdown --}}
          <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            <button @click="open = !open" type="button"
              class="flex items-center gap-2.5 px-6 py-3 {{ request('min_price') || request('max_price') ? 'bg-black text-white shadow-md' : 'bg-gray-100 hover:bg-gray-200 text-gray-800 hover:text-black' }} rounded-full text-sm font-bold transition-all duration-200 whitespace-nowrap cursor-pointer">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
              Khoảng giá
              <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open" x-cloak
              x-transition:enter="transition ease-out duration-150"
              x-transition:enter-start="opacity-0 translate-y-1 scale-95"
              x-transition:enter-end="opacity-100 translate-y-0 scale-100"
              x-transition:leave="transition ease-in duration-100"
              x-transition:leave-start="opacity-100 translate-y-0 scale-100"
              x-transition:leave-end="opacity-0 translate-y-1 scale-95"
              class="absolute right-0 top-full mt-3 w-80 bg-white border border-gray-100 rounded-2xl shadow-xl shadow-black/10 overflow-hidden z-[60] p-6">
              <form action="{{ route('home') }}" method="GET" class="flex flex-col gap-4" @click.stop>
                @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                @if(request('sort') && request('sort') !== 'newest') <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                
                <div class="text-sm font-black text-black uppercase tracking-widest mb-1 leading-none">Nhập khoảng giá</div>
                <div class="flex items-center gap-3">
                    <div class="flex-1 relative">
                        <input type="text" inputmode="numeric" pattern="[0-9]*" name="min_price" value="{{ request('min_price') }}" placeholder="Từ" 
                               class="w-full px-4 py-3 text-sm font-bold text-black border border-gray-200 rounded-lg focus:ring-2 focus:ring-black focus:border-black outline-none transition-all placeholder:font-normal placeholder:text-gray-400">
                    </div>
                    <span class="text-gray-400 font-black">-</span>
                    <div class="flex-1 relative">
                        <input type="text" inputmode="numeric" pattern="[0-9]*" name="max_price" value="{{ request('max_price') }}" placeholder="Đến" 
                               class="w-full px-4 py-3 text-sm font-bold text-black border border-gray-200 rounded-lg focus:ring-2 focus:ring-black focus:border-black outline-none transition-all placeholder:font-normal placeholder:text-gray-400">
                    </div>
                </div>
                <button type="submit" class="w-full mt-2 py-3 bg-black text-white rounded-xl text-sm font-bold tracking-widest uppercase hover:bg-gray-800 transition-all shadow-md active:scale-95 cursor-pointer">
                  Áp dụng
                </button>
              </form>
            </div>
          </div>

          {{-- Sort Dropdown --}}
          <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            <button @click="open = !open" type="button"
              class="flex items-center gap-2.5 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-full text-sm font-bold transition-all duration-200 whitespace-nowrap cursor-pointer">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/>
              </svg>
              @php
                $sortLabels = ['newest' => 'Mới nhất', 'price_asc' => 'Giá tăng dần', 'price_desc' => 'Giá giảm dần', 'name_asc' => 'Tên A-Z', 'name_desc' => 'Tên Z-A'];
              @endphp
              {{ $sortLabels[request('sort', 'newest')] ?? 'Mới nhất' }}
              <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>
            <div x-show="open" x-cloak
              x-transition:enter="transition ease-out duration-150"
              x-transition:enter-start="opacity-0 translate-y-1 scale-95"
              x-transition:enter-end="opacity-100 translate-y-0 scale-100"
              x-transition:leave="transition ease-in duration-100"
              x-transition:leave-start="opacity-100 translate-y-0 scale-100"
              x-transition:leave-end="opacity-0 translate-y-1 scale-95"
              class="absolute right-0 top-full mt-3 w-56 bg-white border border-gray-100 rounded-2xl shadow-xl shadow-black/5 overflow-hidden z-[60]">
              @foreach(['newest' => 'Mới nhất', 'price_asc' => 'Giá tăng dần', 'price_desc' => 'Giá giảm dần', 'name_asc' => 'Tên A-Z', 'name_desc' => 'Tên Z-A'] as $value => $label)
                <a href="{{ route('home', array_filter(array_merge(request()->query(), ['sort' => $value, 'page' => null]))) }}"
                  class="flex items-center justify-between px-6 py-3.5 text-sm font-bold hover:bg-gray-50 transition-colors {{ request('sort', 'newest') === $value ? 'text-black' : 'text-gray-500' }}">
                  {{ $label }}
                  @if(request('sort', 'newest') === $value)
                    <svg class="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                  @endif
                </a>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Products Grid - Focused & Clean -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-12 md:gap-x-10 md:gap-y-16">
      @forelse($products as $index => $product)
        <div data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 75 }}" class="h-full">
          <x-product-card :product="$product" />
        </div>
      @empty
        <div class="col-span-full py-40 text-center bg-gray-50 rounded-3xl" data-aos="fade-up">
          <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border border-gray-100">
            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
          </div>
          @if(request('search'))
            <h3 class="text-2xl font-black text-black mb-2">Không tìm thấy kết quả</h3>
            <p class="text-gray-500 font-medium mb-8">Không có sản phẩm nào khớp với &ldquo;<strong>{{ request('search') }}</strong>&rdquo;. Hãy thử từ khoá khác.</p>
            <a href="{{ route('home') }}" class="inline-block px-8 py-3 bg-black text-white font-bold text-sm rounded-full hover:bg-gray-800 transition-colors">Xem tất cả sản phẩm</a>
          @else
            <h3 class="text-2xl font-black text-black mb-2">Đang cập nhật sản phẩm</h3>
            <p class="text-gray-500 font-medium">Chúng tôi đang chuẩn bị bộ sưu tập mới cho danh mục này.</p>
          @endif
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