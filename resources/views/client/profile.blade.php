@extends('layouts.app')

@section('title', 'Hồ sơ cá nhân - The Notorious')

@section('content')
<div class="min-h-screen bg-white py-20 px-4">
    <div class="container mx-auto max-w-3xl">
        <!-- Header -->
        <div class="mb-16" data-aos="fade-right">
            <h1 class="text-4xl font-black tracking-tighter text-black uppercase">Hồ sơ cá nhân</h1>
            <p class="text-gray-400 mt-2 text-sm font-bold tracking-widest uppercase">Quản lý thông tin tài khoản của bạn</p>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-gray-100 p-8 md:p-12 shadow-2xl shadow-black/5" data-aos="fade-up">
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Họ và tên</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                            class="w-full h-14 bg-gray-50 border border-gray-100 rounded-2xl px-6 text-sm font-bold focus:bg-white focus:border-black focus:ring-4 focus:ring-black/5 transition-all outline-none">
                        @error('name')
                            <p class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase tracking-wider">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="space-y-2">
                        <label for="phone" class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Số điện thoại</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" required
                            class="w-full h-14 bg-gray-50 border border-gray-100 rounded-2xl px-6 text-sm font-bold focus:bg-white focus:border-black focus:ring-4 focus:ring-black/5 transition-all outline-none">
                        @error('phone')
                            <p class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase tracking-wider">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label for="email" class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                        class="w-full h-14 bg-gray-50 border border-gray-100 rounded-2xl px-6 text-sm font-bold focus:bg-white focus:border-black focus:ring-4 focus:ring-black/5 transition-all outline-none">
                    @error('email')
                        <p class="text-red-500 text-[10px] font-bold mt-1 ml-1 uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-6">
                    <button type="submit" 
                        class="w-full h-16 bg-black text-white rounded-2xl font-black text-sm uppercase tracking-[0.2em] hover:bg-gray-800 transition-all active:scale-[0.98] shadow-xl shadow-black/10 group">
                        <span class="flex items-center justify-center gap-2">
                            Lưu thay đổi
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                    </button>
                </div>
            </form>

            <div class="mt-12 pt-10 border-t border-gray-50">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div>
                        <h4 class="text-sm font-black uppercase tracking-widest text-black">Bảo mật tài khoản</h4>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mt-1">Bạn muốn thay đổi mật khẩu?</p>
                    </div>
                    <button class="h-12 px-8 rounded-xl border-2 border-gray-100 text-[10px] font-black uppercase tracking-widest hover:border-black transition-all">
                        Đổi mật khẩu
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
