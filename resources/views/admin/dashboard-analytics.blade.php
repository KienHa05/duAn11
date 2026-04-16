@extends('admin.layout')

@section('title', 'Tổng Quan Analytics')

@push('styles')
<style>
    @keyframes dashboardFadeUp {
        from { opacity: 0; transform: translateY(18px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .dashboard-reveal { opacity: 0; animation: dashboardFadeUp 0.65s ease-out forwards; }
    .dashboard-surface { position: relative; overflow: hidden; transition: transform 220ms ease, box-shadow 220ms ease, border-color 220ms ease, background-color 220ms ease; }
    .dashboard-surface::before { content: ""; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(255,255,255,0.16), rgba(255,255,255,0)); opacity: 0; transition: opacity 220ms ease; pointer-events: none; }
    .dashboard-surface:hover { transform: translateY(-6px); box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12); border-color: rgba(59, 130, 246, 0.18); }
    .dashboard-surface:hover::before { opacity: 1; }
    .dashboard-chip { transition: transform 220ms ease, background-color 220ms ease; }
    .dashboard-surface:hover .dashboard-chip { transform: scale(1.06); }
    .dashboard-row { transition: transform 180ms ease, background-color 180ms ease; }
    .dashboard-row:hover { transform: translateX(4px); }
    .analytics-loading { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.8); transition: opacity 220ms ease, visibility 220ms ease; z-index: 1; }
    .analytics-loading.is-hidden { opacity: 0; visibility: hidden; pointer-events: none; }
    .filter-pill { transition: transform 180ms ease, background-color 180ms ease, color 180ms ease, border-color 180ms ease; }
    .filter-pill:hover { transform: translateY(-1px); }
</style>
@endpush

@section('content')
<div class="relative space-y-6">
    <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-64 overflow-hidden">
        <div class="absolute -left-10 top-0 h-40 w-40 rounded-full bg-primary/10 blur-3xl"></div>
        <div class="absolute right-0 top-8 h-48 w-48 rounded-full bg-info/10 blur-3xl"></div>
    </div>

    <div class="dashboard-reveal flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between" style="animation-delay: 0.05s;">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-primary/70">Bảng điều khiển quản trị</p>
            <h1 class="mt-2 text-3xl font-bold sm:text-4xl">Tổng quan vận hành và analytics</h1>
            <p class="mt-2 text-sm text-base-content/60">Theo dõi chỉ số hệ thống, xu hướng doanh thu, đơn hàng và hiệu suất sản phẩm trong cùng một màn hình.</p>
        </div>
        <div class="dashboard-surface rounded-2xl border border-base-300 bg-base-100/90 px-4 py-3 text-sm shadow-sm backdrop-blur">
            <p class="text-base-content/50">Khoảng phân tích</p>
            <p class="mt-1 font-semibold">{{ $analytics['range_label'] }}</p>
        </div>
    </div>

    <div class="dashboard-reveal dashboard-surface rounded-3xl border border-base-300 bg-base-100/90 p-5 shadow-sm backdrop-blur" style="animation-delay: 0.1s;">
        <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
            <div>
                <h2 class="text-xl font-bold">Bộ lọc thời gian</h2>
                <p class="text-sm text-base-content/60">Dùng chung cho toàn bộ khối analytics trên dashboard.</p>
            </div>

            <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-col gap-3 xl:items-end">
                <div class="flex flex-wrap gap-2">
                    @foreach ([
                        '7d' => '7 ngày',
                        '30d' => '30 ngày',
                        'month' => 'Tháng này',
                        'year' => 'Năm nay',
                    ] as $value => $label)
                        <a href="{{ route('admin.dashboard', ['range' => $value]) }}"
                           class="filter-pill rounded-full border px-4 py-2 text-sm font-medium {{ $selectedRange === $value ? 'border-primary bg-primary text-primary-content shadow-sm' : 'border-base-300 bg-base-100 text-base-content/70 hover:border-primary/30 hover:bg-primary/5 hover:text-primary' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>

                <div class="flex flex-col gap-3 rounded-2xl border border-base-300 bg-base-200/60 p-3 sm:flex-row sm:items-end">
                    <input type="hidden" name="range" value="custom">
                    <label class="form-control">
                        <span class="label pb-1"><span class="label-text text-xs uppercase tracking-wider text-base-content/60">Từ ngày</span></span>
                        <input type="date" name="start_date" value="{{ $rangeStart->toDateString() }}" class="input input-bordered input-sm w-full min-w-40">
                    </label>
                    <label class="form-control">
                        <span class="label pb-1"><span class="label-text text-xs uppercase tracking-wider text-base-content/60">Đến ngày</span></span>
                        <input type="date" name="end_date" value="{{ $rangeEnd->toDateString() }}" class="input input-bordered input-sm w-full min-w-40">
                    </label>
                    <button type="submit" class="btn btn-primary btn-sm">Áp dụng</button>
                </div>
            </form>
        </div>
    </div>
    <div class="dashboard-reveal space-y-4" style="animation-delay: 0.15s;">
        <div>
            <h2 class="text-xl font-bold">Chỉ số tổng quan</h2>
            <p class="text-sm text-base-content/60">Những số liệu nền tảng của hệ thống quản trị.</p>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="dashboard-surface card border border-base-300 bg-base-100/90 shadow-sm backdrop-blur">
                <div class="card-body gap-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm text-base-content/60">Tổng sản phẩm</p>
                            <p class="mt-2 text-3xl font-bold">{{ number_format($overviewStats['products']) }}</p>
                        </div>
                        <div class="dashboard-chip rounded-2xl bg-info/15 p-3 text-info">
                            <x-heroicon-o-square-3-stack-3d class="h-6 w-6" />
                        </div>
                    </div>
                    <p class="text-xs text-base-content/50">Số lượng sản phẩm đang có trong hệ thống.</p>
                </div>
            </div>

            <div class="dashboard-surface card border border-base-300 bg-base-100/90 shadow-sm backdrop-blur">
                <div class="card-body gap-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm text-base-content/60">Tổng danh mục</p>
                            <p class="mt-2 text-3xl font-bold">{{ number_format($overviewStats['categories']) }}</p>
                        </div>
                        <div class="dashboard-chip rounded-2xl bg-secondary/15 p-3 text-secondary">
                            <x-heroicon-o-tag class="h-6 w-6" />
                        </div>
                    </div>
                    <p class="text-xs text-base-content/50">Nhóm danh mục dùng để phân loại sản phẩm.</p>
                </div>
            </div>

            <div class="dashboard-surface card border border-base-300 bg-base-100/90 shadow-sm backdrop-blur">
                <div class="card-body gap-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm text-base-content/60">Tổng người dùng</p>
                            <p class="mt-2 text-3xl font-bold">{{ number_format($overviewStats['users']) }}</p>
                        </div>
                        <div class="dashboard-chip rounded-2xl bg-success/15 p-3 text-success">
                            <x-heroicon-o-users class="h-6 w-6" />
                        </div>
                    </div>
                    <p class="text-xs text-base-content/50">Bao gồm tài khoản khách hàng và quản trị viên.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-reveal space-y-4" style="animation-delay: 0.2s;">
        <div>
            <h2 class="text-xl font-bold">Chỉ số vận hành hôm nay</h2>
            <p class="text-sm text-base-content/60">Tập trung vào các tín hiệu cần xử lý trong ngày.</p>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="dashboard-surface card border border-base-300 bg-base-100/90 shadow-sm backdrop-blur">
                <div class="card-body gap-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm text-base-content/60">Đơn chờ xác nhận</p>
                            <p class="mt-2 text-3xl font-bold">{{ number_format($kpis['pending_orders']) }}</p>
                        </div>
                        <div class="dashboard-chip rounded-2xl bg-warning/15 p-3 text-warning">
                            <x-heroicon-o-clock class="h-6 w-6" />
                        </div>
                    </div>
                    <p class="text-xs text-base-content/50">Cần xác nhận sớm để tránh chậm tiến độ xử lý.</p>
                </div>
            </div>

            <div class="dashboard-surface card border border-base-300 bg-base-100/90 shadow-sm backdrop-blur">
                <div class="card-body gap-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm text-base-content/60">Đơn đang giao</p>
                            <p class="mt-2 text-3xl font-bold">{{ number_format($kpis['shipping_orders']) }}</p>
                        </div>
                        <div class="dashboard-chip rounded-2xl bg-info/15 p-3 text-info">
                            <x-heroicon-o-truck class="h-6 w-6" />
                        </div>
                    </div>
                    <p class="text-xs text-base-content/50">Theo dõi những đơn hàng đang trên đường tới khách.</p>
                </div>
            </div>

            <div class="dashboard-surface card border border-base-300 bg-base-100/90 shadow-sm backdrop-blur">
                <div class="card-body gap-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm text-base-content/60">Đơn hoàn tất hôm nay</p>
                            <p class="mt-2 text-3xl font-bold">{{ number_format($kpis['completed_today']) }}</p>
                        </div>
                        <div class="dashboard-chip rounded-2xl bg-success/15 p-3 text-success">
                            <x-heroicon-o-check-badge class="h-6 w-6" />
                        </div>
                    </div>
                    <p class="text-xs text-base-content/50">Đơn đã giao thành công và hoàn tất trong ngày.</p>
                </div>
            </div>

            <div class="dashboard-surface card border border-base-300 bg-base-100/90 shadow-sm backdrop-blur">
                <div class="card-body gap-4">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm text-base-content/60">Doanh thu hôm nay</p>
                            <p class="mt-2 text-3xl font-bold">{{ number_format($kpis['revenue_today']) }}₫</p>
                        </div>
                        <div class="dashboard-chip rounded-2xl bg-primary/15 p-3 text-primary">
                            <x-heroicon-o-banknotes class="h-6 w-6" />
                        </div>
                    </div>
                    <p class="text-xs text-base-content/50">
                        @if($hasRevenueToday)
                            Tính từ các đơn đã thanh toán có thời điểm `paid_at` trong hôm nay.
                        @else
                            Chưa phát sinh doanh thu hôm nay.
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-reveal grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,2fr)_minmax(320px,1fr)]" style="animation-delay: 0.25s;">
        <div class="dashboard-surface card border border-base-300 bg-base-100/90 shadow-sm backdrop-blur">
            <div class="card-body gap-4">
                <div>
                    <h2 class="text-xl font-bold">Xu hướng doanh thu</h2>
                    <p class="text-sm text-base-content/60">Theo dõi doanh thu theo thời gian, chỉ tính các đơn đã thanh toán.</p>
                </div>

                @if($analytics['revenue_trend']['has_data'])
                    <div class="relative rounded-3xl border border-base-300 bg-base-200/40 p-4">
                        <div class="analytics-loading" data-chart-loading>
                            <span class="loading loading-spinner loading-md text-primary"></span>
                            <span class="ml-3 text-sm text-base-content/60">Đang tải biểu đồ doanh thu...</span>
                        </div>
                        <div id="revenue-trend-chart" class="h-[320px]"></div>
                    </div>
                @else
                    <div class="flex min-h-[320px] flex-col items-center justify-center rounded-3xl border border-dashed border-base-300 bg-base-200/50 px-6 py-10 text-center">
                        <x-heroicon-o-banknotes class="h-10 w-10 text-base-content/30" />
                        <p class="mt-4 text-lg font-semibold">{{ $analytics['revenue_trend']['empty_message'] }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="dashboard-surface card border border-base-300 bg-base-100/90 shadow-sm backdrop-blur">
            <div class="card-body gap-4">
                <div>
                    <h2 class="text-xl font-bold">Phân bổ trạng thái đơn</h2>
                    <p class="text-sm text-base-content/60">Nhìn nhanh cơ cấu trạng thái trong kỳ phân tích.</p>
                </div>

                @if($analytics['status_distribution']['has_data'])
                    <div class="relative rounded-3xl border border-base-300 bg-base-200/40 p-4">
                        <div class="analytics-loading" data-chart-loading>
                            <span class="loading loading-spinner loading-md text-primary"></span>
                            <span class="ml-3 text-sm text-base-content/60">Đang tải phân bổ trạng thái...</span>
                        </div>
                        <div id="status-distribution-chart" class="h-[320px]"></div>
                    </div>
                @else
                    <div class="flex min-h-[320px] flex-col items-center justify-center rounded-3xl border border-dashed border-base-300 bg-base-200/50 px-6 py-10 text-center">
                        <x-heroicon-o-chart-pie class="h-10 w-10 text-base-content/30" />
                        <p class="mt-4 text-lg font-semibold">{{ $analytics['status_distribution']['empty_message'] }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="dashboard-reveal grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)_minmax(0,1fr)]" style="animation-delay: 0.32s;">
        <div class="dashboard-surface card border border-base-300 bg-base-100/90 shadow-sm backdrop-blur">
            <div class="card-body gap-4">
                <div>
                    <h2 class="text-xl font-bold">Xu hướng đơn hàng</h2>
                    <p class="text-sm text-base-content/60">Số lượng đơn phát sinh theo thời gian trong kỳ đã chọn.</p>
                </div>

                @if($analytics['orders_trend']['has_data'])
                    <div class="relative rounded-3xl border border-base-300 bg-base-200/40 p-4">
                        <div class="analytics-loading" data-chart-loading>
                            <span class="loading loading-spinner loading-md text-primary"></span>
                            <span class="ml-3 text-sm text-base-content/60">Đang tải biểu đồ đơn hàng...</span>
                        </div>
                        <div id="orders-trend-chart" class="h-[300px]"></div>
                    </div>
                @else
                    <div class="flex min-h-[300px] flex-col items-center justify-center rounded-3xl border border-dashed border-base-300 bg-base-200/50 px-6 py-10 text-center">
                        <x-heroicon-o-inbox class="h-10 w-10 text-base-content/30" />
                        <p class="mt-4 text-lg font-semibold">{{ $analytics['orders_trend']['empty_message'] }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="dashboard-surface card border border-base-300 bg-base-100/90 shadow-sm backdrop-blur">
            <div class="card-body gap-4">
                <div>
                    <h2 class="text-xl font-bold">Top 3 bán chạy</h2>
                    <p class="text-sm text-base-content/60">Dựa trên tổng số lượng đã bán từ order items trong kỳ.</p>
                </div>

                @if(count($analytics['best_sellers']) > 0)
                    <div class="relative rounded-3xl border border-base-300 bg-base-200/40 p-4">
                        <div class="analytics-loading" data-chart-loading>
                            <span class="loading loading-spinner loading-md text-primary"></span>
                            <span class="ml-3 text-sm text-base-content/60">Đang tải top bán chạy...</span>
                        </div>
                        <div id="best-sellers-chart" class="h-[250px]"></div>
                    </div>
                @else
                    <div class="flex min-h-[320px] flex-col items-center justify-center rounded-3xl border border-dashed border-base-300 bg-base-200/50 px-6 py-10 text-center">
                        <x-heroicon-o-fire class="h-10 w-10 text-base-content/30" />
                        <p class="mt-4 text-lg font-semibold">Chưa có dữ liệu bán chạy trong khoảng thời gian này.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="dashboard-surface card border border-base-300 bg-base-100/90 shadow-sm backdrop-blur">
            <div class="card-body gap-4">
                <div>
                    <h2 class="text-xl font-bold">Top 3 bán chậm</h2>
                    <p class="text-sm text-base-content/60">Sản phẩm còn tồn cao nhưng lượng bán thấp trong kỳ.</p>
                </div>

                @if(count($analytics['slow_sellers']) > 0)
                    <div class="relative rounded-3xl border border-base-300 bg-base-200/40 p-4">
                        <div class="analytics-loading" data-chart-loading>
                            <span class="loading loading-spinner loading-md text-primary"></span>
                            <span class="ml-3 text-sm text-base-content/60">Đang tải top bán chậm...</span>
                        </div>
                        <div id="slow-sellers-chart" class="h-[250px]"></div>
                    </div>
                @else
                    <div class="flex min-h-[320px] flex-col items-center justify-center rounded-3xl border border-dashed border-base-300 bg-base-200/50 px-6 py-10 text-center">
                        <x-heroicon-o-archive-box class="h-10 w-10 text-base-content/30" />
                        <p class="mt-4 text-lg font-semibold">Chưa có dữ liệu bán chậm trong khoảng thời gian này.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="dashboard-reveal grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,2fr)_minmax(320px,1fr)]" style="animation-delay: 0.38s;">
        <div class="dashboard-surface card border border-base-300 bg-base-100/90 shadow-sm backdrop-blur">
            <div class="card-body gap-4">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-bold">Đơn hàng gần đây</h2>
                        <p class="text-sm text-base-content/60">5 đơn mới nhất trong khoảng phân tích hiện tại.</p>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost btn-sm transition duration-200 hover:-translate-y-0.5 hover:bg-primary/10 hover:text-primary">Xem tất cả</a>
                </div>

                @if($recentOrders->isEmpty())
                    <div class="flex min-h-64 flex-col items-center justify-center rounded-3xl border border-dashed border-base-300 bg-base-200/60 px-6 py-10 text-center transition duration-300 hover:border-primary/30 hover:bg-base-200/80">
                        <x-heroicon-o-inbox class="h-10 w-10 text-base-content/30" />
                        <p class="mt-4 text-lg font-semibold">Chưa có đơn hàng nào</p>
                        <p class="mt-2 max-w-md text-sm text-base-content/60">Không có đơn phát sinh trong khoảng thời gian đang chọn.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="table table-sm">
                            <thead>
                                <tr class="text-base-content/70">
                                    <th>Mã đơn hàng</th>
                                    <th>Khách hàng</th>
                                    <th class="text-right">Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr class="dashboard-row hover">
                                        <td class="font-semibold text-primary">{{ $order->order_number }}</td>
                                        <td>
                                            <div class="font-medium">{{ $order->customer_name }}</div>
                                            @if($order->customer_email)
                                                <div class="text-xs text-base-content/50">{{ $order->customer_email }}</div>
                                            @endif
                                        </td>
                                        <td class="text-right font-semibold">{{ number_format($order->total_amount) }}₫</td>
                                        <td>
                                            <span class="badge badge-{{ $order->status_color }} badge-sm gap-1 whitespace-nowrap transition duration-200 hover:scale-105">
                                                {{ $order->status_label }}
                                            </span>
                                        </td>
                                        <td class="text-sm text-base-content/60">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div class="dashboard-surface card border border-base-300 bg-base-100/90 shadow-sm backdrop-blur">
            <div class="card-body gap-4">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-bold">Cảnh báo sắp hết hàng</h2>
                        <p class="text-sm text-base-content/60">Những sản phẩm có tồn kho từ 10 trở xuống.</p>
                    </div>
                    <span class="badge badge-outline">{{ $lowStockProducts->count() }}</span>
                </div>

                @if($lowStockProducts->isEmpty())
                    <div class="flex min-h-64 flex-col items-center justify-center rounded-3xl border border-dashed border-base-300 bg-base-200/60 px-6 py-10 text-center transition duration-300 hover:border-success/30 hover:bg-base-200/80">
                        <x-heroicon-o-check-circle class="h-10 w-10 text-success/70" />
                        <p class="mt-4 text-lg font-semibold">Chưa có sản phẩm sắp hết</p>
                        <p class="mt-2 text-sm text-base-content/60">Tồn kho hiện tại vẫn an toàn theo ngưỡng cảnh báo.</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($lowStockProducts as $product)
                            <div class="dashboard-row flex items-center justify-between gap-3 rounded-2xl border border-base-300 bg-base-200/40 px-4 py-3 transition duration-200 hover:border-warning/40 hover:bg-warning/5">
                                <div class="min-w-0">
                                    <p class="truncate font-semibold">{{ $product->name }}</p>
                                    <p class="text-xs text-base-content/50">Cần bổ sung sớm để tránh hết hàng.</p>
                                </div>
                                <span class="badge {{ $product->stock > 0 ? 'badge-warning' : 'badge-error' }} gap-1 transition duration-200 hover:scale-105">
                                    {{ $product->stock }} sản phẩm
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    const dashboardAnalytics = @json($analytics);
    const commonChartOptions = {
        chart: { toolbar: { show: false }, animations: { enabled: true, easing: 'easeinout', speed: 650 }, fontFamily: 'ui-sans-serif, system-ui, sans-serif', foreColor: '#64748b' },
        stroke: { curve: 'smooth', width: 3 },
        grid: { borderColor: 'rgba(148, 163, 184, 0.12)', strokeDashArray: 5 },
        tooltip: { theme: 'light' },
        dataLabels: { enabled: false },
        legend: { show: false },
    };

    const formatCurrency = (value) => new Intl.NumberFormat('vi-VN').format(value) + '₫';

    const renderChart = (selector, options) => {
        const element = document.querySelector(selector);
        if (!element || typeof ApexCharts === 'undefined') return;
        const chart = new ApexCharts(element, options);
        chart.render().then(() => {
            element.closest('.relative')?.querySelector('[data-chart-loading]')?.classList.add('is-hidden');
        });
    };

    document.addEventListener('DOMContentLoaded', () => {
        renderChart('#revenue-trend-chart', {
            ...commonChartOptions,
            chart: { ...commonChartOptions.chart, type: 'area', height: 320 },
            colors: ['#0f172a'],
            fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.28, opacityTo: 0.02, stops: [0, 90, 100] } },
            series: dashboardAnalytics.revenue_trend.series,
            xaxis: { categories: dashboardAnalytics.revenue_trend.labels, axisBorder: { show: false }, axisTicks: { show: false } },
            yaxis: { labels: { formatter: (value) => new Intl.NumberFormat('vi-VN', { notation: 'compact' }).format(value) } },
            tooltip: { y: { formatter: formatCurrency } },
        });

        renderChart('#orders-trend-chart', {
            ...commonChartOptions,
            chart: { ...commonChartOptions.chart, type: 'line', height: 300 },
            colors: ['#0284c7'],
            series: dashboardAnalytics.orders_trend.series,
            markers: { size: 4, strokeWidth: 0 },
            xaxis: { categories: dashboardAnalytics.orders_trend.labels, axisBorder: { show: false }, axisTicks: { show: false } },
            yaxis: { labels: { formatter: (value) => Math.round(value) } },
        });

        renderChart('#status-distribution-chart', {
            chart: { type: 'donut', height: 320, fontFamily: 'ui-sans-serif, system-ui, sans-serif' },
            labels: dashboardAnalytics.status_distribution.labels,
            series: dashboardAnalytics.status_distribution.data,
            colors: ['#f59e0b', '#0ea5e9', '#22c55e', '#ef4444'],
            legend: { position: 'bottom' },
            dataLabels: { enabled: true },
            plotOptions: { pie: { donut: { size: '68%' } } },
        });

        renderChart('#best-sellers-chart', {
            chart: { type: 'bar', height: 250, toolbar: { show: false }, animations: { enabled: true, easing: 'easeinout', speed: 650 }, fontFamily: 'ui-sans-serif, system-ui, sans-serif' },
            colors: ['#16a34a'],
            series: [{ name: 'Đã bán', data: dashboardAnalytics.best_sellers.map((item) => item.value) }],
            plotOptions: { bar: { horizontal: true, borderRadius: 8, barHeight: '48%' } },
            dataLabels: { enabled: false },
            xaxis: { categories: dashboardAnalytics.best_sellers.map((item) => item.name) },
            grid: { borderColor: 'rgba(148, 163, 184, 0.12)', strokeDashArray: 5 },
        });

        renderChart('#slow-sellers-chart', {
            chart: { type: 'bar', height: 250, toolbar: { show: false }, animations: { enabled: true, easing: 'easeinout', speed: 650 }, fontFamily: 'ui-sans-serif, system-ui, sans-serif' },
            colors: ['#f59e0b'],
            series: [{ name: 'Đã bán', data: dashboardAnalytics.slow_sellers.map((item) => item.value) }],
            plotOptions: { bar: { horizontal: true, borderRadius: 8, barHeight: '48%' } },
            dataLabels: { enabled: false },
            xaxis: { categories: dashboardAnalytics.slow_sellers.map((item) => item.name) },
            grid: { borderColor: 'rgba(148, 163, 184, 0.12)', strokeDashArray: 5 },
        });
    });
</script>
@endpush
