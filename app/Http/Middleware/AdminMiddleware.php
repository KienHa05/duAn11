<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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

        return $next($request);
    }
}
