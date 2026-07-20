@extends('layouts.app')

@section('title', 'Xác thực OTP - The Notorious')

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
                <h1 class="text-3xl font-black tracking-tighter text-black uppercase">Xác thực OTP</h1>
                <p class="text-gray-400 mt-3 text-[11px] font-medium tracking-wide uppercase leading-relaxed">
                    Nhập mã OTP 6 chữ số đã gửi đến email
                </p>
                <p class="text-black font-bold text-sm mt-1">{{ session('reset_password_email') }}</p>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-100">
                    <p class="text-xs font-bold text-green-600 uppercase tracking-widest text-center">{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('password.verify.submit') }}" method="POST" class="space-y-6" id="otp-form">
                @csrf

                <div class="space-y-3">
                    <label class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-500 ml-1 block text-center">Mã OTP</label>
                    
                    <!-- 6 OTP Input Boxes -->
                    <div class="flex justify-center gap-2" id="otp-inputs">
                        <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-black bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-black focus:ring-4 focus:ring-black/5 transition-all outline-none" data-index="0" inputmode="numeric" pattern="[0-9]" autocomplete="off">
                        <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-black bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-black focus:ring-4 focus:ring-black/5 transition-all outline-none" data-index="1" inputmode="numeric" pattern="[0-9]" autocomplete="off">
                        <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-black bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-black focus:ring-4 focus:ring-black/5 transition-all outline-none" data-index="2" inputmode="numeric" pattern="[0-9]" autocomplete="off">
                        <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-black bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-black focus:ring-4 focus:ring-black/5 transition-all outline-none" data-index="3" inputmode="numeric" pattern="[0-9]" autocomplete="off">
                        <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-black bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-black focus:ring-4 focus:ring-black/5 transition-all outline-none" data-index="4" inputmode="numeric" pattern="[0-9]" autocomplete="off">
                        <input type="text" maxlength="1" class="otp-input w-12 h-14 text-center text-xl font-black bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-black focus:ring-4 focus:ring-black/5 transition-all outline-none" data-index="5" inputmode="numeric" pattern="[0-9]" autocomplete="off">
                    </div>

                    <!-- Hidden real input for form submission -->
                    <input type="hidden" name="otp" id="otp-hidden">

                    @error('otp')
                        <p class="text-red-500 text-[10px] font-bold mt-1 text-center uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" id="btn-verify"
                    class="w-full h-14 bg-black text-white rounded-2xl font-black text-sm uppercase tracking-[0.2em] hover:bg-gray-800 transition-all active:scale-[0.98] shadow-lg shadow-black/10 mt-4 group">
                    <span class="flex items-center justify-center gap-2">
                        Xác thực
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </span>
                </button>
            </form>

            <!-- Resend OTP -->
            <div class="mt-8 text-center space-y-3">
                <form action="{{ route('password.resend') }}" method="POST" id="resend-form">
                    @csrf
                    <button type="submit" id="btn-resend" disabled
                        class="text-[10px] font-black uppercase tracking-widest text-gray-300 transition-colors disabled:cursor-not-allowed">
                        Gửi lại mã OTP (<span id="countdown">60</span>s)
                    </button>
                </form>
                <a href="{{ route('password.request') }}" class="block text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-black transition-colors">
                    &larr; Quay lại nhập email
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.otp-input');
    const hiddenInput = document.getElementById('otp-hidden');
    const form = document.getElementById('otp-form');

    // Focus first input on load
    inputs[0].focus();

    function updateHidden() {
        let val = '';
        inputs.forEach(i => val += i.value);
        hiddenInput.value = val;
    }

    inputs.forEach((input, idx) => {
        input.addEventListener('input', function (e) {
            // Only allow digits
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length === 1 && idx < inputs.length - 1) {
                inputs[idx + 1].focus();
            }
            updateHidden();
        });

        input.addEventListener('keydown', function (e) {
            if (e.key === 'Backspace' && this.value === '' && idx > 0) {
                inputs[idx - 1].focus();
                inputs[idx - 1].value = '';
                updateHidden();
            }
        });

        // Handle paste
        input.addEventListener('paste', function (e) {
            e.preventDefault();
            const pastedData = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '').slice(0, 6);
            for (let i = 0; i < pastedData.length; i++) {
                if (inputs[i]) {
                    inputs[i].value = pastedData[i];
                }
            }
            if (pastedData.length > 0 && inputs[Math.min(pastedData.length, 5)]) {
                inputs[Math.min(pastedData.length, 5)].focus();
            }
            updateHidden();
        });
    });

    // Countdown timer for resend (60 seconds)
    const btnResend = document.getElementById('btn-resend');
    const countdownEl = document.getElementById('countdown');
    let seconds = 60;

    const timer = setInterval(function () {
        seconds--;
        countdownEl.textContent = seconds;
        if (seconds <= 0) {
            clearInterval(timer);
            btnResend.disabled = false;
            btnResend.classList.remove('text-gray-300');
            btnResend.classList.add('text-black', 'hover:underline', 'underline-offset-4');
            btnResend.innerHTML = 'Gửi lại mã OTP';
        }
    }, 1000);
});
</script>
@endsection
