@extends('layouts.app')

@section('title', 'Đăng nhập - The Notorious')

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
            <div class="text-center mb-10">
                <h1 class="text-3xl font-black tracking-tighter text-black uppercase">Đăng nhập</h1>
                <p class="text-gray-400 mt-2 text-sm font-medium tracking-wide uppercase">Chào mừng bạn quay trở lại</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label for="email" class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full h-14 bg-gray-50 border border-gray-100 rounded-2xl px-6 text-sm font-bold focus:bg-white focus:border-black focus:ring-4 focus:ring-black/5 transition-all outline-none placeholder:text-gray-300"
                        placeholder="your@email.com">
                    @error('email')
                        <p class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between ml-1">
                        <label for="password" class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-500">Mật khẩu</label>
                        <a href="#" class="text-[10px] font-black uppercase tracking-wider text-gray-400 hover:text-black transition-colors">Quên mật khẩu?</a>
                    </div>
                    <input type="password" name="password" id="password" required
                        class="w-full h-14 bg-gray-50 border border-gray-100 rounded-2xl px-6 text-sm font-bold focus:bg-white focus:border-black focus:ring-4 focus:ring-black/5 transition-all outline-none placeholder:text-gray-300"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center gap-3 ml-1">
                    <input type="checkbox" name="remember" id="remember" class="w-5 h-5 rounded-lg border-gray-200 text-black focus:ring-black cursor-pointer">
                    <label for="remember" class="text-xs font-bold text-gray-500 cursor-pointer select-none">Ghi nhớ đăng nhập</label>
                </div>

                <button type="submit" 
                    class="w-full h-14 bg-black text-white rounded-2xl font-black text-sm uppercase tracking-[0.2em] hover:bg-gray-800 transition-all active:scale-[0.98] shadow-lg shadow-black/10 mt-4 group">
                    <span class="flex items-center justify-center gap-2">
                        Đăng nhập
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </span>
                </button>
            </form>

            <div class="mt-10 pt-10 border-t border-gray-50 text-center">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                    Chưa có tài khoản?
                    <a href="{{ route('register') }}" class="text-black hover:underline underline-offset-4 ml-2">Đăng ký ngay</a>
                </p>
            </div>
        </div>

        <!-- System Status -->
        <p class="text-center mt-10 text-[9px] font-black text-gray-300 uppercase tracking-[0.3em]">
            &copy; 2026 The Notorious Platform / Secure Authentication
        </p>
    </div>
</div>
@endsection
