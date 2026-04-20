@extends('layouts.app')

@section('title', 'Notorious - Tra cứu đơn hàng')

@section('content')
<div class="py-20 md:py-32 bg-gray-50 min-h-[calc(100vh-200px)] flex items-center justify-center">
  <div class="container mx-auto px-4 max-w-lg">
    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-gray-100" data-aos="fade-up">
      
      <div class="text-center mb-10">
        <div class="w-16 h-16 bg-black text-white rounded-2xl flex items-center justify-center mx-auto mb-6 transform rotate-3 shadow-lg">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
          </svg>
        </div>
        <h1 class="text-3xl font-black uppercase tracking-tight text-black mb-3">Tra Cứu Đơn Hàng</h1>
        <p class="text-gray-500 font-medium text-sm">Nhập Mã Tracking và Email để tra cứu thông tin vận chuyển</p>
      </div>

      <form action="{{ route('client.track-order.process') }}" method="POST" class="space-y-6">
        @csrf
        
        <div>
          <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Tracking Token <span class="text-red-500">*</span></label>
          <input type="text" name="tracking_token" value="{{ old('tracking_token') }}" placeholder="Ví dụ: 8e94a8...d2c1" required
            class="w-full h-14 bg-gray-50 border border-gray-200 rounded-xl px-5 text-black font-medium placeholder:text-gray-300 focus:bg-white focus:border-black focus:ring-0 transition-all outline-none">
          @error('tracking_token')
            <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
          @enderror
        </div>

        <div>
           <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Email Đặt Hàng <span class="text-red-500">*</span></label>
           <input type="email" name="email" value="{{ old('email') }}" placeholder="Email bạn đã dùng khi đặt hàng" required
             class="w-full h-14 bg-gray-50 border border-gray-200 rounded-xl px-5 text-black font-medium placeholder:text-gray-300 focus:bg-white focus:border-black focus:ring-0 transition-all outline-none">
           @error('email')
             <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
           @enderror
        </div>

        <button type="submit"
          class="w-full h-14 bg-black text-white rounded-xl font-bold uppercase tracking-wider text-sm hover:bg-gray-900 active:scale-[0.98] transition-all flex items-center justify-center gap-3 group shadow-xl shadow-black/10">
          <span>Tra cứu ngay</span>
          <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
          </svg>
        </button>

      </form>
    </div>
  </div>
</div>
@endsection
