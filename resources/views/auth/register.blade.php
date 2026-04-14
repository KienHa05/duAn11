@extends('layouts.app')

@section('title', 'Đăng ký - The Notorious')

@section('content')
<div class="min-h-[90vh] flex items-center justify-center px-4 py-20 bg-gray-50/50">
    <div class="w-full max-w-md" data-aos="fade-up">
        <!-- Brand Symbol -->
        <div class="flex justify-center mb-10">
            <div class="w-14 h-14 rounded-2xl bg-black flex items-center justify-center text-white font-black text-2xl shadow-2xl">
                N
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-8 md:p-10">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-black tracking-tighter text-black uppercase">Đăng ký</h1>
                <p class="text-gray-400 mt-2 text-sm font-medium tracking-wide uppercase">Cùng bắt đầu hành trình phong cách</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                
                <div class="space-y-1">
                    <label for="name" class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Họ và tên</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full h-12 bg-gray-50 border border-gray-100 rounded-xl px-4 text-sm font-bold focus:bg-white focus:border-black focus:ring-4 focus:ring-black/5 transition-all outline-none placeholder:text-gray-300"
                        placeholder="Nguyễn Văn A">
                    @error('name')
                        <p class="text-red-500 text-[9px] font-bold mt-1 ml-1 uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label for="email" class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full h-12 bg-gray-50 border border-gray-100 rounded-xl px-4 text-sm font-bold focus:bg-white focus:border-black focus:ring-4 focus:ring-black/5 transition-all outline-none placeholder:text-gray-300"
                        placeholder="your@email.com">
                    @error('email')
                        <p class="text-red-500 text-[9px] font-bold mt-1 ml-1 uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label for="phone" class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Số điện thoại</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                        class="w-full h-12 bg-gray-50 border border-gray-100 rounded-xl px-4 text-sm font-bold focus:bg-white focus:border-black focus:ring-4 focus:ring-black/5 transition-all outline-none placeholder:text-gray-300"
                        placeholder="09xx xxx xxx">
                    @error('phone')
                        <p class="text-red-500 text-[9px] font-bold mt-1 ml-1 uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label for="password" class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Mật khẩu</label>
                        <input type="password" name="password" id="password" required
                            class="w-full h-12 bg-gray-50 border border-gray-100 rounded-xl px-4 text-sm font-bold focus:bg-white focus:border-black focus:ring-4 focus:ring-black/5 transition-all outline-none placeholder:text-gray-300"
                            placeholder="••••••••">
                    </div>
                    <div class="space-y-1">
                        <label for="password_confirmation" class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Xác nhận</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full h-12 bg-gray-50 border border-gray-100 rounded-xl px-4 text-sm font-bold focus:bg-white focus:border-black focus:ring-4 focus:ring-black/5 transition-all outline-none placeholder:text-gray-300"
                            placeholder="••••••••">
                    </div>
                </div>
                @error('password')
                    <p class="text-red-500 text-[9px] font-bold mt-1 ml-1 uppercase tracking-wider">{{ $message }}</p>
                @enderror

                <button type="submit" 
                    class="w-full h-14 bg-black text-white rounded-2xl font-black text-sm uppercase tracking-[0.2em] hover:bg-gray-800 transition-all active:scale-[0.98] shadow-lg shadow-black/10 mt-6 group">
                    <span class="flex items-center justify-center gap-2">
                        Đăng ký ngay
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </span>
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-gray-50 text-center">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                    Đã có tài khoản?
                    <a href="{{ route('login') }}" class="text-black hover:underline underline-offset-4 ml-2">Đăng nhập</a>
                </p>
            </div>
        </div>

        <!-- Terms -->
        <p class="text-center mt-10 text-[9px] font-black text-gray-300 uppercase leading-relaxed tracking-[0.1em] max-w-[280px] mx-auto">
            Bằng việc đăng ký, bạn đồng ý với 
            <a href="#" class="text-gray-400 hover:text-black transition-colors">Điều khoản dịch vụ</a> 
            và 
            <a href="#" class="text-gray-400 hover:text-black transition-colors">Chính sách bảo mật</a> 
            của chúng tôi.
        </p>
    </div>
</div>
@endsection
