<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    /**
     * Show Admin login form
     */
    public function showAdminLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    /**
     * Process login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ]);

        if (Auth::guard('web')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            // Rule: /login via 'web' guard always leads to Home
            return redirect()->intended('/')->with('success', 'Chào mừng quay trở lại, ' . Auth::guard('web')->user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('email');
    }

    /**
     * Process Admin login
     */
    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ]);

        // Attempt login using 'admin' guard
        if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
            // Strict check: Must be admin attribute
            if (!Auth::guard('admin')->user()->is_admin) {
                Auth::guard('admin')->logout();
                return back()->withErrors([
                    'email' => 'Tài khoản này không có quyền truy cập vùng quản trị.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập quản trị không chính xác.',
        ])->onlyInput('email');
    }

    /**
     * Show register form
     */
    public function showRegister()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    /**
     * Process registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập email',
            'email.unique' => 'Email này đã được đăng ký',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải từ 8 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        Auth::guard('web')->login($user);

        return redirect()->route('home')->with('success', 'Đăng ký tài khoản thành công!');
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        return view('client.profile', ['user' => Auth::guard('web')->user()]);
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::guard('web')->user();
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update($request->only('name', 'email', 'phone'));

        return back()->with('success', 'Hồ sơ đã được cập nhật thành công!');
    }

    /**
     * Process logout for Client (web guard)
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        // Web session invalidation
        $request->session()->forget('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'); // Example key, better use session()->invalidate() if only one guard
        // Wait, session()->invalidate() clears EVERYTHING. 
        // We want to keep the other guard logged in.
        // Laravel handles this by guard name prefix in session keys.
        
        return redirect('/')->with('success', 'Bạn đã đăng xuất khỏi khu vực khách hàng.');
    }

    /**
     * Process logout for Admin (admin guard)
     */
    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login')->with('success', 'Bạn đã đăng xuất khỏi hệ thống quản trị.');
    }
}
