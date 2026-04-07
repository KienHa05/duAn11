@extends('layouts.app')

@section('title', 'Giỏ hàng - The Notorious')

@section('content')
<!-- Cart Page Hero -->
<div class="bg-white border-b border-gray-100">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl py-12">
    <div class="flex items-center gap-3 mb-2">
      <svg class="w-7 h-7 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
      </svg>
      <h1 class="text-4xl md:text-5xl font-black text-black tracking-tighter uppercase">Giỏ hàng</h1>
    </div>
    <p class="text-gray-500 font-medium">Quản lý các sản phẩm trong giỏ hàng của bạn</p>
  </div>
</div>

<!-- Main Content -->
<main class="flex-grow">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl py-16 md:py-24">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
      <!-- Left: Cart Items List -->
      <div class="lg:col-span-2">
        <!-- Empty Cart State -->
        <div x-show="items.length === 0" class="text-center py-20 bg-gray-50 rounded-3xl">
          <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center mx-auto mb-8 shadow-sm border border-gray-100">
            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
          </div>
          <h2 class="text-2xl font-black text-black mb-4 uppercase tracking-tight">Giỏ hàng của bạn đang trống</h2>
          <p class="text-gray-500 font-medium mb-10 max-w-md mx-auto">Hãy khám phá các sản phẩm mới nhất của chúng tôi và thêm chúng vào giỏ hàng.</p>
          <a href="{{ route('home') }}" class="inline-block bg-black text-white font-black text-sm uppercase tracking-widest px-10 py-4 rounded-xl hover:bg-gray-800 transition-all active:scale-95">
            TIẾP TỤC XEM HÀNG
          </a>
        </div>

        <!-- Cart Items -->
        <div x-show="items.length > 0" class="space-y-8">
          <template x-for="(item, index) in items" :key="item.id">
            <div class="flex gap-6 pb-8 border-b border-gray-100 group" x-data="{ item: item }">
              <!-- Product Image -->
              <div class="w-32 h-32 bg-gray-100 rounded-2xl overflow-hidden flex-shrink-0 flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                <template x-if="item.imageUrl && item.imageUrl.trim()">
                  <img :src="item.imageUrl" :alt="item.name" class="w-full h-full object-cover">
                </template>
                <template x-if="!item.imageUrl || !item.imageUrl.trim()">
                  <div class="flex flex-col items-center justify-center w-full h-full bg-gray-100">
                    <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-xs text-gray-400 font-medium">Không có ảnh</span>
                  </div>
                </template>
              </div>

              <!-- Product Details -->
              <div class="flex-1 flex flex-col justify-between">
                <div>
                  <!-- Product Name -->
                  <div class="flex items-start justify-between gap-4 mb-4">
                    <h3 class="text-lg md:text-xl font-bold text-black leading-tight group-hover:underline" x-text="item.name"></h3>
                    <button @click="removeFromCart(item.id)" class="text-gray-300 hover:text-red-500 transition-colors p-1 flex-shrink-0">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                      </svg>
                    </button>
                  </div>

                  <!-- Price per unit -->
                  <p class="text-xl font-black text-black mb-4" x-text="`${item.price.toLocaleString('vi-VN')} đ / sp`"></p>
                </div>

                <!-- Quantity & Subtotal -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                  <!-- Quantity Selector -->
                  <div class="flex items-center border border-gray-300 rounded-xl h-12 px-2 gap-3 bg-gray-50">
                    <button @click="decreaseQuantity(item.id)" class="text-gray-500 hover:text-black p-2 transition-colors">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path>
                      </svg>
                    </button>
                    <span class="text-sm font-black text-black w-8 text-center" x-text="item.quantity"></span>
                    <button @click="increaseQuantity(item.id)" class="text-gray-500 hover:text-black p-2 transition-colors">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                      </svg>
                    </button>
                  </div>

                  <!-- Item Subtotal -->
                  <p class="text-xl font-black text-black" x-text="`${(item.price * item.quantity).toLocaleString('vi-VN')} đ`"></p>
                </div>
              </div>
            </div>
          </template>
        </div>
      </div>

      <!-- Right: Order Summary (Sticky on Desktop) -->
      <div x-show="items.length > 0" class="lg:col-span-1">
        <div class="bg-gray-50 rounded-3xl p-8 sticky top-24 border border-gray-100">
          <!-- Summary Title -->
          <h2 class="text-xl font-black text-black mb-8 uppercase tracking-tight">Tóm tắt đơn hàng</h2>

          <!-- Summary Details -->
          <div class="space-y-4 mb-8 pb-8 border-b border-gray-200">
            <div class="flex justify-between items-center">
              <span class="text-sm font-bold text-gray-500 uppercase tracking-wider">Tạm tính</span>
              <span class="text-lg font-black text-black" x-text="`${subtotal.toLocaleString('vi-VN')} đ`"></span>
            </div>

            <div class="flex justify-between items-center">
              <span class="text-sm font-bold text-gray-500 uppercase tracking-wider">Vận chuyển</span>
              <span class="text-lg font-black text-black" x-text="shipping === 0 ? 'Miễn phí' : `${shipping.toLocaleString('vi-VN')} đ`"></span>
            </div>

            <template x-if="discount > 0">
              <div class="flex justify-between items-center">
                <span class="text-sm font-bold text-gray-500 uppercase tracking-wider">Giảm giá</span>
                <span class="text-lg font-black text-red-500" x-text="`-${discount.toLocaleString('vi-VN')} đ`"></span>
              </div>
            </template>
          </div>

          <!-- Total -->
          <div class="mb-8">
            <div class="flex justify-between items-baseline">
              <span class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Tổng cộng</span>
              <span class="text-3xl font-black text-black" x-text="`${total.toLocaleString('vi-VN')} đ`"></span>
            </div>
          </div>

          <!-- Checkout Button -->
          <button class="w-full bg-black text-white font-black text-sm uppercase tracking-widest py-4 rounded-xl hover:bg-gray-800 transition-all active:scale-95 mb-4">
            TIẾN HÀNH THANH TOÁN
          </button>

          <!-- Continue Shopping Link -->
          <a href="{{ route('home') }}" class="block w-full text-center border border-black text-black font-bold text-sm uppercase tracking-widest py-3 rounded-xl hover:bg-black hover:text-white transition-all active:scale-95">
            TIẾP TỤC XEM HÀNG
          </a>

          <!-- Info Text -->
          <p class="text-xs text-gray-500 font-medium text-center mt-6 leading-relaxed">
            Miễn phí vận chuyển cho đơn hàng từ 500.000 đ trở lên
          </p>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
