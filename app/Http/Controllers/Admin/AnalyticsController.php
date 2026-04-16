<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
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

        $overview = [
            'products' => Product::count(),
            'categories' => \App\Models\Category::count(),
            'users' => \App\Models\User::count(),
            'orders' => Order::count(),
        ];

        return view('admin.analytics', [
            'kpis' => $kpis,
            'overview' => $overview,
            'today' => $today
        ]);
    }

    public function getChartData(Request $request)
    {
        $range = $request->get('range', '7d');
        $startDate = null;
        $endDate = Carbon::now();
        $groupBy = 'day';

        switch ($range) {
            case '7d':
                $startDate = Carbon::now()->subDays(6)->startOfDay();
                break;
            case '30d':
                $startDate = Carbon::now()->subDays(29)->startOfDay();
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                break;
            case 'year':
                $startDate = Carbon::now()->startOfYear();
                $groupBy = 'month';
                break;
            case 'custom':
                $startDate = $request->has('start') ? Carbon::parse($request->get('start')) : Carbon::now()->subDays(6);
                $endDate = $request->has('end') ? Carbon::parse($request->get('end'))->endOfDay() : Carbon::now();
                break;
            default:
                $startDate = Carbon::now()->subDays(6)->startOfDay();
        }

        return response()->json([
            'revenue_orders' => $this->getRevenueAndOrdersTrend($startDate, $endDate, $groupBy),
            'top_sellers' => $this->getTop3BestSellers($startDate, $endDate),
            'slow_sellers' => $this->getTop3SlowSellers($startDate, $endDate),
            'order_status' => $this->getOrderStatusDistribution($startDate, $endDate),
        ]);
    }

    private function getRevenueAndOrdersTrend($startDate, $endDate, $groupBy)
    {
        $format = ($groupBy === 'month') ? '%Y-%m' : '%Y-%m-%d';
        $driver = DB::getDriverName();
        $dateExpression = ($driver === 'sqlite') 
            ? "strftime('$format', created_at)" 
            : "DATE_FORMAT(created_at, '$format')";
            
        $data = Order::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw("$dateExpression as date"),
                DB::raw("COUNT(*) as order_count"),
                DB::raw("SUM(CASE WHEN payment_status = 'paid' THEN total_amount ELSE 0 END) as revenue")
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $revenue = [];
        $orders = [];

        $current = $startDate->copy();
        while ($current <= $endDate) {
            $key = $current->format(($groupBy === 'month') ? 'Y-m' : 'Y-m-d');
            $friendlyLabel = ($groupBy === 'month') ? $current->format('m/Y') : $current->format('d/m');
            
            $match = $data->firstWhere('date', $key);
            
            $labels[] = $friendlyLabel;
            $revenue[] = $match ? (int)$match->revenue : 0;
            $orders[] = $match ? (int)$match->order_count : 0;

            if ($groupBy === 'month') {
                $current->addMonth();
            } else {
                $current->addDay();
            }
        }

        return [
            'labels' => $labels,
            'revenue' => $revenue,
            'orders' => $orders
        ];
    }

    private function getTop3BestSellers($startDate, $endDate)
    {
        return OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.payment_status', 'paid')
            ->select(
                'products.name',
                DB::raw('SUM(order_items.quantity) as total_sold')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(3)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->name,
                    'value' => (int)$item->total_sold
                ];
            });
    }

    private function getTop3SlowSellers($startDate, $endDate)
    {
        // Subquery to get sales in period
        $salesSubquery = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select('product_id', DB::raw('SUM(quantity) as period_sold'))
            ->groupBy('product_id');

        return Product::leftJoinSub($salesSubquery, 'sales', function ($join) {
                $join->on('products.id', '=', 'sales.product_id');
            })
            ->whereNull('products.deleted_at')
            ->select(
                'products.name',
                'products.stock',
                DB::raw('COALESCE(sales.period_sold, 0) as period_sold')
            )
            ->orderBy('period_sold', 'asc')
            ->orderByDesc('products.stock')
            ->limit(3)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->name,
                    'stock' => $item->stock,
                    'sold' => (int)$item->period_sold
                ];
            });
    }

    private function getOrderStatusDistribution($startDate, $endDate)
    {
        $statusMap = [
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang xử lý',
            'shipping' => 'Đang giao hàng',
            'delivered' => 'Đã giao',
            'completed' => 'Hoàn tất',
            'cancelled' => 'Đã hủy',
            'returned' => 'Trả hàng'
        ];

        $rawCounts = Order::whereBetween('created_at', [$startDate, $endDate])
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $labels = [];
        $values = [];

        foreach ($statusMap as $key => $label) {
            if (isset($rawCounts[$key])) {
                $labels[] = $label;
                $values[] = (int)$rawCounts[$key];
            }
        }

        return [
            'labels' => $labels,
            'values' => $values
        ];
    }
}
