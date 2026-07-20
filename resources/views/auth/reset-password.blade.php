@extends('layouts.app')

@section('title', 'Đặt lại mật khẩu - The Notorious')

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
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-green-50 flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-black tracking-tighter text-black uppercase">Mật khẩu mới</h1>
                <p class="text-gray-400 mt-2 text-[11px] font-medium tracking-wide uppercase leading-relaxed">Xác thực thành công. Vui lòng nhập mật khẩu mới cho tài khoản của bạn.</p>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-100">
                    <p class="text-xs font-bold text-green-600 uppercase tracking-widest text-center">{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label for="password" class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Mật khẩu mới</label>
                    <input type="password" name="password" id="password" required autofocus
                        class="w-full h-14 bg-gray-50 border border-gray-100 rounded-2xl px-6 text-sm font-bold focus:bg-white focus:border-black focus:ring-4 focus:ring-black/5 transition-all outline-none placeholder:text-gray-300"
                        placeholder="••••••••">
                    @error('password')
                        <p class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password_confirmation" class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full h-14 bg-gray-50 border border-gray-100 rounded-2xl px-6 text-sm font-bold focus:bg-white focus:border-black focus:ring-4 focus:ring-black/5 transition-all outline-none placeholder:text-gray-300"
                        placeholder="••••••••">
                </div>

                <!-- Password strength hint -->
                <div class="p-3 bg-gray-50 rounded-xl">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Yêu cầu mật khẩu</p>
                    <ul class="mt-2 space-y-1">
                        <li class="text-[10px] font-medium text-gray-400 flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-gray-300 inline-block"></span>
                            Tối thiểu 8 ký tự
                        </li>
                        <li class="text-[10px] font-medium text-gray-400 flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-gray-300 inline-block"></span>
                            Xác nhận mật khẩu phải trùng khớp
                        </li>
                    </ul>
                </div>

                <button type="submit" 
                    class="w-full h-14 bg-black text-white rounded-2xl font-black text-sm uppercase tracking-[0.2em] hover:bg-gray-800 transition-all active:scale-[0.98] shadow-lg shadow-black/10 mt-4 group">
                    <span class="flex items-center justify-center gap-2">
                        Đặt lại mật khẩu
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
