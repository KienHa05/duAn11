@extends('admin.layout')

@section('title', 'Tong Quan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-primary/70">Admin Dashboard</p>
            <h1 class="mt-2 text-3xl font-bold sm:text-4xl">Tong quan van hanh</h1>
            <p class="mt-2 text-sm text-base-content/60">Theo doi don hang, doanh thu va ton kho trong ngay.</p>
        </div>
        <div class="rounded-2xl border border-base-300 bg-base-100 px-4 py-3 text-sm shadow-sm">
            <p class="text-base-content/50">Hom nay</p>
            <p class="mt-1 font-semibold">{{ $today->format('d/m/Y') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="card border border-base-300 bg-base-100 shadow-sm">
            <div class="card-body gap-4">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm text-base-content/60">Don cho xac nhan</p>
                        <p class="mt-2 text-3xl font-bold">{{ number_format($kpis['pending_orders']) }}</p>
                    </div>
                    <div class="rounded-2xl bg-warning/15 p-3 text-warning">
                        <x-heroicon-o-clock class="h-6 w-6" />
                    </div>
                </div>
                <p class="text-xs text-base-content/50">Can xu ly som de khong cham don.</p>
            </div>
        </div>

        <div class="card border border-base-300 bg-base-100 shadow-sm">
            <div class="card-body gap-4">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm text-base-content/60">Don dang giao</p>
                        <p class="mt-2 text-3xl font-bold">{{ number_format($kpis['shipping_orders']) }}</p>
                    </div>
                    <div class="rounded-2xl bg-info/15 p-3 text-info">
                        <x-heroicon-o-truck class="h-6 w-6" />
                    </div>
                </div>
                <p class="text-xs text-base-content/50">Theo doi don dang tren duong giao toi khach.</p>
            </div>
        </div>

        <div class="card border border-base-300 bg-base-100 shadow-sm">
            <div class="card-body gap-4">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm text-base-content/60">Hoan tat hom nay</p>
                        <p class="mt-2 text-3xl font-bold">{{ number_format($kpis['completed_today']) }}</p>
                    </div>
                    <div class="rounded-2xl bg-success/15 p-3 text-success">
                        <x-heroicon-o-check-badge class="h-6 w-6" />
                    </div>
                </div>
                <p class="text-xs text-base-content/50">Don da giao thanh cong trong ngay.</p>
            </div>
        </div>

        <div class="card border border-base-300 bg-base-100 shadow-sm">
            <div class="card-body gap-4">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm text-base-content/60">Doanh thu hom nay</p>
                        <p class="mt-2 text-3xl font-bold">{{ number_format($kpis['revenue_today']) }}₫</p>
                    </div>
                    <div class="rounded-2xl bg-primary/15 p-3 text-primary">
                        <x-heroicon-o-banknotes class="h-6 w-6" />
                    </div>
                </div>
                <p class="text-xs text-base-content/50">
                    @if($hasRevenueToday)
                        Tinh theo don da thanh toan co paid_at trong hom nay.
                    @else
                        Chua phat sinh doanh thu hom nay.
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-[minmax(0,2fr)_minmax(320px,1fr)]">
        <div class="card border border-base-300 bg-base-100 shadow-sm">
            <div class="card-body gap-4">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-bold">Recent Orders</h2>
                        <p class="text-sm text-base-content/60">5 don moi nhat can theo doi.</p>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost btn-sm">Xem tat ca</a>
                </div>

                @if($recentOrders->isEmpty())
                    <div class="flex min-h-64 flex-col items-center justify-center rounded-3xl border border-dashed border-base-300 bg-base-200/60 px-6 py-10 text-center">
                        <x-heroicon-o-inbox class="h-10 w-10 text-base-content/30" />
                        <p class="mt-4 text-lg font-semibold">Chua co don hang nao</p>
                        <p class="mt-2 max-w-md text-sm text-base-content/60">Don hang moi se xuat hien tai day ngay khi khach hang hoan tat dat mua.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="table table-sm">
                            <thead>
                                <tr class="text-base-content/70">
                                    <th>Order code</th>
                                    <th>Customer</th>
                                    <th class="text-right">Total</th>
                                    <th>Status</th>
                                    <th>Created at</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr class="hover">
                                        <td class="font-semibold text-primary">{{ $order->order_number }}</td>
                                        <td>
                                            <div class="font-medium">{{ $order->customer_name }}</div>
                                            @if($order->customer_email)
                                                <div class="text-xs text-base-content/50">{{ $order->customer_email }}</div>
                                            @endif
                                        </td>
                                        <td class="text-right font-semibold">{{ number_format($order->total_amount) }}₫</td>
                                        <td>
                                            <span class="badge badge-{{ $order->status_color }} badge-sm gap-1 whitespace-nowrap">
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

        <div class="card border border-base-300 bg-base-100 shadow-sm">
            <div class="card-body gap-4">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-bold">Low Stock Alert</h2>
                        <p class="text-sm text-base-content/60">San pham co ton kho tu 10 tro xuong.</p>
                    </div>
                    <span class="badge badge-outline">{{ $lowStockProducts->count() }}</span>
                </div>

                @if($lowStockProducts->isEmpty())
                    <div class="flex min-h-64 flex-col items-center justify-center rounded-3xl border border-dashed border-base-300 bg-base-200/60 px-6 py-10 text-center">
                        <x-heroicon-o-check-circle class="h-10 w-10 text-success/70" />
                        <p class="mt-4 text-lg font-semibold">Chua co san pham sap het</p>
                        <p class="mt-2 text-sm text-base-content/60">Ton kho hien tai van an toan theo nguong canh bao.</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($lowStockProducts as $product)
                            <div class="flex items-center justify-between gap-3 rounded-2xl border border-base-300 bg-base-200/40 px-4 py-3">
                                <div class="min-w-0">
                                    <p class="truncate font-semibold">{{ $product->name }}</p>
                                    <p class="text-xs text-base-content/50">Can bo sung som de tranh out of stock.</p>
                                </div>
                                <span class="badge {{ $product->stock > 0 ? 'badge-warning' : 'badge-error' }} gap-1">
                                    {{ $product->stock }} sp
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
