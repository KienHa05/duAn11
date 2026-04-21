<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $timezone = config('app.timezone', 'UTC');
        $today = now()->setTimezone($timezone);
        $startOfDay = $today->copy()->startOfDay();
        $endOfDay = $today->copy()->endOfDay();

        $kpis = [
            'pending_orders' => Order::where('status', 'pending')->count(),
            'shipping_orders' => Order::where('status', 'shipping')->count(),
            'completed_today' => Order::where('status', 'completed')
                ->whereBetween('delivered_at', [$startOfDay, $endOfDay])
                ->count(),
            'revenue_today' => (int) Order::where('payment_status', 'paid')
                ->whereBetween('paid_at', [$startOfDay, $endOfDay])
                ->sum('total_amount'),
        ];

        $overviewStats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'users' => User::count(),
        ];

        $recentOrders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get();

        $lowStockProducts = Product::query()
            ->where('stock', '<=', 10)
            ->orderBy('stock')
            ->orderBy('name')
            ->limit(5)
            ->get();

        return view('admin.dashboard-v2', [
            'overviewStats' => $overviewStats,
            'kpis' => $kpis,
            'recentOrders' => $recentOrders,
            'lowStockProducts' => $lowStockProducts,
            'today' => $today,
            'hasRevenueToday' => $kpis['revenue_today'] > 0,
        ]);
    }
}
