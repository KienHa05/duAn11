@extends('layouts.app')

@section('title', 'Quên mật khẩu - The Notorious')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-20 bg-gray-50/50">
    <div class="w-full max-w-md" data-aos="fade-up">
        <!-- Brand Symbol -->
        <div class="flex justify-center mb-10">
            <div class="w-14 h-14 rounded-2xl bg-black flex items-center justify-center text-white font-black text-2xl shadow-2xl">
                N
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-8 md:p-10">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-black tracking-tighter text-black uppercase">Quên mật khẩu</h1>
                <p class="text-gray-400 mt-2 text-[11px] font-medium tracking-wide uppercase leading-relaxed">Nhập email của bạn và chúng tôi sẽ gửi cho bạn mã OTP xác thực gồm 6 chữ số.</p>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-100">
                    <p class="text-xs font-bold text-green-600 uppercase tracking-widest text-center">{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label for="email" class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="w-full h-14 bg-gray-50 border border-gray-100 rounded-2xl px-6 text-sm font-bold focus:bg-white focus:border-black focus:ring-4 focus:ring-black/5 transition-all outline-none placeholder:text-gray-300"
                        placeholder="your@email.com">
                    @error('email')
                        <p class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                    class="w-full h-14 bg-black text-white rounded-2xl font-black text-sm uppercase tracking-[0.2em] hover:bg-gray-800 transition-all active:scale-[0.98] shadow-lg shadow-black/10 mt-4 group">
                    <span class="flex items-center justify-center gap-2">
                        Gửi mã OTP
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </span>
                </button>
            </form>

            <div class="mt-8 text-center">
                <a href="{{ route('login') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-black transition-colors">
                    &larr; Quay lại trang đăng nhập
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
