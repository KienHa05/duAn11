<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use App\Mail\ResetPasswordOtpMail;

class OtpPasswordResetController extends Controller
{
    /**
     * Show the forgot password form (request OTP).
     */
    public function requestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Generate and send OTP.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.'
        ]);

        $email = $request->email;
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Không tìm thấy tài khoản với email này.']);
        }

        // Check for cooldown (resend in 60s)
        $latestOtp = PasswordResetOtp::where('email', $email)->orderBy('created_at', 'desc')->first();
        if ($latestOtp && $latestOtp->created_at->addSeconds(60) > now()) {
            return back()->withErrors(['email' => 'Vui lòng đợi 60 giây trước khi yêu cầu gửi lại mã.']);
        }

        // Generate 6-digit OTP
        $otp = sprintf('%06d', mt_rand(100000, 999999));

        // Disable previous OTPs
        PasswordResetOtp::where('email', $email)->whereNull('used_at')->update(['used_at' => now()]);

        // Save new OTP
        PasswordResetOtp::create([
            'email' => $email,
            'otp_hash' => Hash::make($otp),
            'expires_at' => now()->addMinutes(5),
        ]);

        // Send Email
        Mail::to($email)->send(new ResetPasswordOtpMail($otp, $user->name));

        // Store email in session to carry over to verify page
        session(['reset_password_email' => $email]);

        return redirect()->route('password.verify.form')->with('success', 'Mã xác thực đã được gửi đến email của bạn.');
    }

    /**
     * Show the OTP verification form.
     */
    public function verifyForm()
    {
        if (!session()->has('reset_password_email')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Vui lòng bắt đầu lại quá trình khôi phục.']);
        }

        return view('auth.verify-otp');
    }

    /**
     * Verify the provided OTP.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6'
        ], [
            'otp.required' => 'Vui lòng nhập mã OTP.',
            'otp.size' => 'Mã OTP phải gồm 6 chữ số.'
        ]);

        $email = session('reset_password_email');
        if (!$email) {
            return redirect()->route('password.request');
        }

        // Rate Limiting: 5 attempts per 15 minutes
        $rateLimitKey = 'verify-otp:' . request()->ip() . ':' . $email;
        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return back()->withErrors(['otp' => "Bạn đã nhập sai quá nhiều lần. Vui lòng thử lại sau " . ceil($seconds / 60) . " phút."]);
        }

        $otpRecord = PasswordResetOtp::where('email', $email)
            ->whereNull('used_at')
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'Không tìm thấy yêu cầu xác thực hợp lệ.']);
        }

        if (now() > $otpRecord->expires_at) {
            return back()->withErrors(['otp' => 'Mã OTP đã hết hạn. Vui lòng yêu cầu mã mới.']);
        }

        if (!Hash::check($request->otp, $otpRecord->otp_hash)) {
            RateLimiter::hit($rateLimitKey, 900); // 15 mins = 900s
            return back()->withErrors(['otp' => 'Mã OTP không hợp lệ.']);
        }

        // Clear rate limiter upon success
        RateLimiter::clear($rateLimitKey);

        // Mark as verified
        $otpRecord->update(['verified_at' => now()]);

        session(['reset_password_verified' => true]);

        return redirect()->route('password.reset.form')->with('success', 'Xác thực thành công. Vui lòng đặt mật khẩu mới.');
    }

    /**
     * Resend OTP.
     */
    public function resendOtp(Request $request)
    {
        $email = session('reset_password_email');
        if (!$email) {
            return redirect()->route('password.request');
        }

        // Pass an artificial request object to sendOtp for reuse
        $req = new Request(['email' => $email]);
        return $this->sendOtp($req);
    }

    /**
     * Show reset password form.
     */
    public function resetForm()
    {
        if (!session('reset_password_verified')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Bạn chưa xác thực email.']);
        }

        return view('auth.reset-password');
    }

    /**
     * Handle actual password reset.
     */
    public function resetPassword(Request $request)
    {
        if (!session('reset_password_verified')) {
            return redirect()->route('password.request');
        }

        $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
        ]);

        $email = session('reset_password_email');
        $user = User::where('email', $email)->firstOrFail();

        // Update password
        $user->forceFill([
            'password' => Hash::make($request->password)
        ])->save();

        // Mark OTP as used
        PasswordResetOtp::where('email', $email)
            ->whereNotNull('verified_at')
            ->whereNull('used_at')
            ->update(['used_at' => now()]);

        // Clean up session
        session()->forget(['reset_password_email', 'reset_password_verified']);

        return redirect()->route('login')->with('success', 'Mật khẩu đã được đổi thành công. Vui lòng đăng nhập.');
    }
}
