<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated in the 'admin' guard
        if (!auth()->guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error', 'Vui lòng đăng nhập quyền quản trị.');
        }

        $user = auth()->guard('admin')->user();

        $gate = Gate::forUser($user);

        if ($request->is('admin') || $request->is('admin/') || $request->is('admin')) {
            return $next($request);
        }

        if (str_starts_with($request->path(), 'admin/products') && !$gate->allows('access-products')) {
            abort(403, 'Bạn không có quyền truy cập quản lý sản phẩm.');
        }

        if (str_starts_with($request->path(), 'admin/categories') && !$gate->allows('access-categories')) {
            abort(403, 'Bạn không có quyền truy cập quản lý danh mục.');
        }

        if (str_starts_with($request->path(), 'admin/orders') && !$gate->allows('access-orders')) {
            abort(403, 'Bạn không có quyền truy cập quản lý đơn hàng.');
        }

        if (str_starts_with($request->path(), 'admin/customers') && !$gate->allows('access-customers')) {
            abort(403, 'Bạn không có quyền truy cập quản lý khách hàng.');
        }

        if (str_starts_with($request->path(), 'admin/admin-users') && !$gate->allows('access-admin-users')) {
            abort(403, 'Bạn không có quyền quản lý tài khoản Admin.');
        }

        return $next($request);
    }
}
