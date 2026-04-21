<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Quản trị - Notorious Dashboard</title>
    <!-- Font: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-[#0f172a] flex items-center justify-center min-h-screen p-4 overflow-hidden relative">
    <!-- Abstract Background Decor -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-indigo-600/10 rounded-full blur-3xl"></div>
    </div>

    <div class="w-full max-w-md" data-aos="fade-up">
        <!-- Logo & Title -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl mb-6 shadow-2xl">
                <span class="text-white text-3xl font-black italic">N</span>
            </div>
            <h1 class="text-2xl font-black text-white uppercase tracking-wider">Admin Dashboard</h1>
            <p class="text-gray-400 text-sm font-medium mt-2">Hệ thống quản trị và vận hành Notorious</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-[2.5rem] p-10 shadow-3xl shadow-black/50 overflow-hidden relative group">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500"></div>
            
            <form action="{{ url('/admin/login') }}" method="POST" class="space-y-6">
                @csrf
                
                @if($errors->any())
                    <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4 text-xs font-bold text-red-500 uppercase tracking-widest text-center">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Email -->
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.25em] ml-1">Tài khoản quản trị</label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                        class="w-full h-14 bg-white/5 border border-white/10 rounded-2xl px-6 text-white text-sm font-medium focus:bg-white/10 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none placeholder:text-gray-600"
                        placeholder="admin@example.com">
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.25em] ml-1">Mật khẩu hệ thống</label>
                    <input type="password" name="password" required
                        class="w-full h-14 bg-white/5 border border-white/10 rounded-2xl px-6 text-white text-sm font-medium focus:bg-white/10 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none placeholder:text-gray-600"
                        placeholder="••••••••">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-white/10 bg-white/5 text-blue-500 focus:ring-blue-500/20 focus:ring-offset-0 transition-all">
                        <span class="ml-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest group-hover:text-gray-300 transition-colors">Ghi nhớ phiên</span>
                    </label>
                    <a href="#" class="text-[10px] font-bold text-blue-400 uppercase tracking-widest hover:text-blue-300 transition-colors">Quên mã?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full h-16 bg-blue-600 hover:bg-blue-500 text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.25em] transition-all active:scale-[0.98] shadow-xl shadow-blue-500/20 flex items-center justify-center gap-2 group">
                    Tiến vào hệ thống
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center space-y-4">
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">
                © 2026 Notorious Engineering Team
            </p>
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-[10px] font-black text-gray-400 hover:text-white uppercase tracking-widest transition-all">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Quay lại trang chủ
            </a>
        </div>
    </div>

    <!-- AOS (Optional for smooth fade in if integrated later, but using CSS for now) -->
    <script>
        // Simple entry animation
        document.addEventListener('DOMContentLoaded', () => {
            const card = document.querySelector('.max-w-md');
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.8s ease-out';
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>
