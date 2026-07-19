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
                <h1 class="text-3xl font-black tracking-tighter text-black uppercase">Mật khẩu mới</h1>
                <p class="text-gray-400 mt-2 text-[11px] font-medium tracking-wide uppercase leading-relaxed">Vui lòng nhập mật khẩu mới cho tài khoản của bạn.</p>
            </div>

            <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                @csrf
                
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="space-y-2">
                    <label for="email" class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $request->email) }}" required readonly
                        class="w-full h-14 bg-gray-100 border border-gray-100 rounded-2xl px-6 text-sm font-bold outline-none text-gray-500 cursor-not-allowed">
                    @error('email')
                        <p class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

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
