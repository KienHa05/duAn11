@extends('admin.layout')

@section('title', 'Phân tích & Thống kê')

@section('content')
<style>
    :root {
        --enterprise-accent: #2563eb;
        --enterprise-surface: #ffffff;
        --enterprise-border: #f1f5f9;
        --enterprise-bg: #f8fafc;
        --enterprise-text-main: #0f172a;
        --enterprise-text-muted: #64748b;
    }

    @keyframes enterpriseReveal {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .reveal-stagger > * {
        opacity: 0;
        animation: enterpriseReveal 0.4s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
    }

    .reveal-stagger > *:nth-child(1) { animation-delay: 0.05s; }
    .reveal-stagger > *:nth-child(2) { animation-delay: 0.1s; }
    .reveal-stagger > *:nth-child(3) { animation-delay: 0.15s; }
    .reveal-stagger > *:nth-child(4) { animation-delay: 0.2s; }
    .reveal-stagger > *:nth-child(5) { animation-delay: 0.25s; }

    .ent-card {
        background: var(--enterprise-surface);
        border: 1px solid var(--enterprise-border);
        border-radius: 12px;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .ent-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.04), 0 8px 10px -6px rgba(0,0,0,0.04);
        border-color: rgba(37, 99, 235, 0.1);
    }

    .ent-stat-label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--enterprise-text-muted);
    }

    .ent-stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--enterprise-text-main);
    }

    .ent-icon-wrapper {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: var(--enterprise-bg);
        transition: transform 0.2s ease;
    }

    .ent-card:hover .ent-icon-wrapper {
        transform: scale(1.1);
    }

    /* Skeleton Loading Enterprise Style */
    .skeleton-box {
        background: linear-gradient(90deg, #f1f5f9 25%, #f8fafc 50%, #f1f5f9 75%);
        background-size: 200% 100%;
        animation: skeletonMove 1.5s infinite;
        border-radius: 4px;
    }

    @keyframes skeletonMove {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
</style>

<div id="analytics-config" data-url="{{ route('admin.api.analytics.data') }}"></div>

<div class="reveal-stagger space-y-8">
    {{-- Header --}}
    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
        <div class="space-y-1">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Báo cáo Phân tích</h1>
            <p class="text-sm font-medium text-slate-500">Giám sát hiệu suất vận hành tại thời điểm {{ $today->format('d/m/Y H:i') }}</p>
        </div>
        
        <div class="flex items-center gap-3">
            <div class="inline-flex rounded-lg bg-slate-100 p-1 border border-slate-200">
                <button class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all filter-btn bg-white shadow-sm text-blue-600" data-range="7d">7 ngày</button>
                <button class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all filter-btn text-slate-600 hover:text-slate-900" data-range="30d">30 ngày</button>
                <button class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all filter-btn text-slate-600 hover:text-slate-900" data-range="month">Tháng này</button>
                <button class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all filter-btn text-slate-600 hover:text-slate-900" data-range="year">Năm nay</button>
                <button class="px-4 py-1.5 text-xs font-semibold rounded-md transition-all filter-btn text-slate-600 hover:text-slate-900" data-range="custom">Tùy chọn</button>
            </div>
        </div>
    </div>

    {{-- Custom Range Picker --}}
    <div id="custom-date-picker" class="hidden animate-in fade-in slide-in-from-top-1 duration-200">
        <div class="ent-card p-4 flex flex-wrap items-end gap-4 bg-slate-50/50">
            <div class="space-y-1.5">
                <label class="text-[11px] font-bold uppercase text-slate-500 ml-1">Bắt đầu</label>
                <input type="date" id="start-date" class="block w-full rounded-lg border-slate-200 text-sm focus:ring-blue-500/20 focus:border-blue-500" />
            </div>
            <div class="space-y-1.5">
                <label class="text-[11px] font-bold uppercase text-slate-500 ml-1">Kết thúc</label>
                <input type="date" id="end-date" class="block w-full rounded-lg border-slate-200 text-sm focus:ring-blue-500/20 focus:border-blue-500" />
            </div>
            <button id="apply-custom-range" class="px-5 py-2 text-sm font-bold bg-slate-900 text-white rounded-lg hover:bg-slate-800 transition-colors shadow-sm">Áp dụng</button>
        </div>
    </div>

    {{-- System Overview Section --}}
    <div class="space-y-4">
        <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400">Chỉ số nền tảng</h3>
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3">
            <div class="ent-card p-5 group">
                <div class="flex items-start justify-between">
                    <div class="space-y-1">
                        <p class="ent-stat-label">Sản phẩm</p>
                        <p class="ent-stat-value">{{ number_format($overview['products']) }}</p>
                    </div>
                    <div class="ent-icon-wrapper text-blue-600 group-hover:bg-blue-50">
                        <x-heroicon-o-square-3-stack-3d class="w-5 h-5" />
                    </div>
                </div>
            </div>
            <div class="ent-card p-5 group">
                <div class="flex items-start justify-between">
                    <div class="space-y-1">
                        <p class="ent-stat-label">Danh mục</p>
                        <p class="ent-stat-value">{{ number_format($overview['categories']) }}</p>
                    </div>
                    <div class="ent-icon-wrapper text-emerald-600 group-hover:bg-emerald-50">
                        <x-heroicon-o-tag class="w-5 h-5" />
                    </div>
                </div>
            </div>
            <div class="ent-card p-5 group">
                <div class="flex items-start justify-between">
                    <div class="space-y-1">
                        <p class="ent-stat-label">Người dùng</p>
                        <p class="ent-stat-value">{{ number_format($overview['users']) }}</p>
                    </div>
                    <div class="ent-icon-wrapper text-indigo-600 group-hover:bg-indigo-50">
                        <x-heroicon-o-users class="w-5 h-5" />
                    </div>
                </div>
            </div>
            <div class="ent-card p-5 group">
                <div class="flex items-start justify-between">
                    <div class="space-y-1">
                        <p class="ent-stat-label">Khách hàng</p>
                        <p class="ent-stat-value">{{ number_format($overview['customers']) }}</p>
                    </div>
                    <div class="ent-icon-wrapper text-cyan-600 group-hover:bg-cyan-50">
                        <x-heroicon-o-user-group class="w-5 h-5" />
                    </div>
                </div>
            </div>
            <div class="ent-card p-5 group">
                <div class="flex items-start justify-between">
                    <div class="space-y-1">
                        <p class="ent-stat-label">Tổng đơn hàng</p>
                        <p class="ent-stat-value">{{ number_format($overview['orders']) }}</p>
                    </div>
                    <div class="ent-icon-wrapper text-orange-600 group-hover:bg-orange-50">
                        <x-heroicon-o-shopping-bag class="w-5 h-5" />
                    </div>
                </div>
            </div>
            <div class="ent-card p-5 group">
                <div class="flex items-start justify-between">
                    <div class="space-y-1">
                        <p class="ent-stat-label">Tổng doanh thu</p>
                        <p class="ent-stat-value">{{ number_format($overview['total_revenue']) }}₫</p>
                    </div>
                    <div class="ent-icon-wrapper text-rose-600 group-hover:bg-rose-50">
                        <x-heroicon-o-banknotes class="w-5 h-5" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Operational KPIs Section --}}
    <div class="space-y-4">
        <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400">Vận hành hôm nay</h3>
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4">
            <div class="ent-card p-5 bg-amber-50/20 border-amber-100/50">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-xl bg-white shadow-sm text-amber-600">
                        <x-heroicon-o-clock class="w-5 h-5" />
                    </div>
                    <div>
                        <p class="ent-stat-label text-amber-700/70">Chờ xác nhận</p>
                        <p class="text-lg font-bold text-slate-900">{{ number_format($kpis['pending_orders']) }}</p>
                    </div>
                </div>
            </div>
            <div class="ent-card p-5 bg-blue-50/20 border-blue-100/50">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-xl bg-white shadow-sm text-blue-600">
                        <x-heroicon-o-truck class="w-5 h-5" />
                    </div>
                    <div>
                        <p class="ent-stat-label text-blue-700/70">Đang giao</p>
                        <p class="text-lg font-bold text-slate-900">{{ number_format($kpis['shipping_orders']) }}</p>
                    </div>
                </div>
            </div>
            <div class="ent-card p-5 bg-emerald-50/20 border-emerald-100/50">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-xl bg-white shadow-sm text-emerald-600">
                        <x-heroicon-o-check-badge class="w-5 h-5" />
                    </div>
                    <div>
                        <p class="ent-stat-label text-emerald-700/70">Xử lý xong</p>
                        <p class="text-lg font-bold text-slate-900">{{ number_format($kpis['completed_today']) }}</p>
                    </div>
                </div>
            </div>
            <div class="ent-card p-5 bg-slate-900 border-slate-900">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-xl bg-slate-800 text-white">
                        <x-heroicon-o-banknotes class="w-5 h-5" />
                    </div>
                    <div>
                        <p class="ent-stat-label text-slate-400">Doanh thu ngày</p>
                        <p class="text-lg font-bold text-white">{{ number_format($kpis['revenue_today']) }}₫</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Orders by Status Section --}}
    <div class="space-y-4">
        <div class="flex items-end justify-between gap-3">
            <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400">Đơn hàng theo trạng thái</h3>
            <p class="text-sm text-base-content/60">Phân bổ tất cả đơn hàng trong hệ thống.</p>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            @php
                $statusConfig = [
                    'pending' => ['label' => 'Chờ xác nhận', 'color' => 'bg-yellow-50/70', 'border' => 'border-yellow-200/50', 'text' => 'text-yellow-700/80', 'icon' => 'heroicon-o-clock'],
                    'confirmed' => ['label' => 'Đã xác nhận', 'color' => 'bg-blue-50/70', 'border' => 'border-blue-200/50', 'text' => 'text-blue-700/80', 'icon' => 'heroicon-o-check-circle'],
                    'shipping' => ['label' => 'Đang giao', 'color' => 'bg-sky-50/70', 'border' => 'border-sky-200/50', 'text' => 'text-sky-700/80', 'icon' => 'heroicon-o-truck'],
                    'completed' => ['label' => 'Hoàn tất', 'color' => 'bg-emerald-50/70', 'border' => 'border-emerald-200/50', 'text' => 'text-emerald-700/80', 'icon' => 'heroicon-o-check-badge'],
                    'cancelled' => ['label' => 'Đã hủy', 'color' => 'bg-red-50/70', 'border' => 'border-red-200/50', 'text' => 'text-red-700/80', 'icon' => 'heroicon-o-x-circle'],
                    'returned' => ['label' => 'Trả hàng', 'color' => 'bg-purple-50/70', 'border' => 'border-purple-200/50', 'text' => 'text-purple-700/80', 'icon' => 'heroicon-o-arrow-uturn-left'],
                ];
            @endphp
            @foreach($statusConfig as $key => $cfg)
                <div class="ent-card p-4 {{ $cfg['color'] }} {{ $cfg['border'] }}">
                    <div class="flex items-center gap-3">
                        <div class="rounded-xl bg-white/70 p-2.5 shadow-sm {{ $cfg['text'] }}">
                            <x-dynamic-component :component="$cfg['icon']" class="w-5 h-5" />
                        </div>
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wide {{ $cfg['text'] }}">{{ $cfg['label'] }}</p>
                            <p class="text-xl font-extrabold text-slate-900 mt-0.5">{{ number_format($orderStatusStats[$key]) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Main Trend Chart --}}
    <div class="ent-card overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Xu hướng Tăng trưởng</h2>
                <p class="text-xs font-semibold text-slate-400">Phân tích tương quan giữa doanh thu và đơn hàng theo thời gian</p>
            </div>
            <div class="chart-loading hidden text-blue-600"><span class="loading loading-spinner loading-xs mr-2"></span><span class="text-[10px] font-bold uppercase tracking-widest">Đang tải...</span></div>
        </div>
        <div class="p-6">
            <div class="chart-content min-h-[380px] w-full" id="chart-revenue-trend"></div>
        </div>
    </div>

    {{-- Middle Grid Charts --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Best Sellers --}}
        <div class="ent-card">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h2 class="text-lg font-bold text-slate-900">Sản phẩm Bán chạy</h2>
                <x-heroicon-o-presentation-chart-line class="w-5 h-5 text-blue-500" />
            </div>
            <div class="p-6">
                <div class="chart-content min-h-[300px]" id="chart-top-sellers"></div>
            </div>
        </div>

        {{-- Order Distribution --}}
        <div class="ent-card">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h2 class="text-lg font-bold text-slate-900">Cơ cấu Đơn hàng</h2>
                <x-heroicon-o-variable class="w-5 h-5 text-indigo-500" />
            </div>
            <div class="p-6">
                <div class="chart-content min-h-[300px]" id="chart-order-status"></div>
            </div>
        </div>
    </div>

    {{-- Bottom Section: Slow Sellers --}}
    <div class="ent-card shadow-sm border-slate-200">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Cảnh báo Bán chậm</h2>
                <p class="text-xs font-semibold text-slate-400">Các mặt hàng còn tồn kho nhiều nhưng lượng bán ra thấp</p>
            </div>
            <div class="p-2 rounded-lg bg-red-50 text-red-600"><x-heroicon-o-exclamation-triangle class="w-5 h-5" /></div>
        </div>
        <div class="p-1">
            <div id="slow-sellers-container" class="grid grid-cols-1 md:grid-cols-3 gap-px bg-slate-100">
                {{-- Content by JS --}}
            </div>
        </div>
    </div>

    {{-- Monthly Statistics --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="ent-card">
            <div class="p-6 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-900">Doanh thu theo tháng</h2>
                <p class="text-xs font-semibold text-slate-400 mt-0.5">Năm {{ $monthlyChartData['year'] }}</p>
            </div>
            <div class="p-6">
                <div class="min-h-[300px]" id="chart-monthly-revenue"></div>
            </div>
        </div>
        <div class="ent-card">
            <div class="p-6 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-900">Đơn hàng theo tháng</h2>
                <p class="text-xs font-semibold text-slate-400 mt-0.5">Năm {{ $monthlyChartData['year'] }}</p>
            </div>
            <div class="p-6">
                <div class="min-h-[300px]" id="chart-monthly-orders"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/admin/dashboard-charts.js') }}"></script>
<script>
    var monthlyChartData = @json($monthlyChartData);

    function renderMonthlyCharts() {
        if (typeof ApexCharts === 'undefined') return;

        var baseChart = {
            animations: { enabled: false },
            dataLabels: { enabled: false },
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
        };

        new ApexCharts(document.querySelector('#chart-monthly-revenue'), {
            ...baseChart,
            chart: { type: 'bar', height: 300, width: '100%', toolbar: { show: false }, fontFamily: 'Inter, system-ui, sans-serif', redrawOnParentResize: true, redrawOnWindowResize: true },
            series: [{ name: 'Doanh thu', data: monthlyChartData.revenue }],
            colors: ['#2563eb'],
            plotOptions: { bar: { borderRadius: 2, columnWidth: '60%', dataLabels: { position: 'top' } } },
            xaxis: { categories: monthlyChartData.labels, axisBorder: { show: false }, axisTicks: { show: false }, labels: { style: { fontWeight: 600 } } },
            yaxis: { labels: { formatter: function (val) { return new Intl.NumberFormat('vi-VN', { notation: 'compact' }).format(val); }, style: { fontWeight: 600 } } },
            tooltip: { y: { formatter: function (val) { return new Intl.NumberFormat('vi-VN').format(val) + '₫'; } } },
            legend: { show: false },
        }).render();

        new ApexCharts(document.querySelector('#chart-monthly-orders'), {
            ...baseChart,
            chart: { type: 'bar', height: 300, width: '100%', toolbar: { show: false }, fontFamily: 'Inter, system-ui, sans-serif', redrawOnParentResize: true, redrawOnWindowResize: true },
            series: [{ name: 'Đơn hàng', data: monthlyChartData.orders }],
            colors: ['#10b981'],
            plotOptions: { bar: { borderRadius: 2, columnWidth: '60%', dataLabels: { position: 'top' } } },
            xaxis: { categories: monthlyChartData.labels, axisBorder: { show: false }, axisTicks: { show: false }, labels: { style: { fontWeight: 600 } } },
            yaxis: { labels: { formatter: function (val) { return Math.round(val); }, style: { fontWeight: 600 } } },
            tooltip: { y: { formatter: function (val) { return Math.round(val) + ' đơn'; } } },
            legend: { show: false },
        }).render();
    }

    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(renderMonthlyCharts, 700);
    });
</script>
@endpush
@endsection
