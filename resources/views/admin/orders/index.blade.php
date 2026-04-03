@extends('admin.layout')

@section('title', 'Đơn hàng')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold">Quản lý đơn hàng</h1>
            <p class="text-sm text-base-content/60 mt-1">Danh sách tất cả các đơn hàng từ khách hàng</p>
        </div>
    </div>

    <!-- Orders Table Card -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra table-xs sm:table-sm lg:table-md w-full">
                    <thead>
                        <tr class="bg-base-200 hover:bg-base-200">
                            <th class="font-bold">Mã đơn hàng</th>
                            <th class="font-bold">Khách hàng</th>
                            <th class="font-bold text-right">Tổng tiền</th>
                            <th class="font-bold text-center">Trạng thái đơn</th>
                            <th class="font-bold text-center">Thanh toán</th>
                            <th class="font-bold">Ngày tạo</th>
                            <th class="font-bold text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr class="hover:bg-base-200 transition">
                                <td class="font-bold text-primary">{{ $order->order_number }}</td>
                                <td>
                                    <div class="font-semibold text-base-content">{{ $order->user->name }}</div>
                                    <div class="text-xs text-base-content/60">{{ $order->user->email }}</div>
                                </td>
                                <td class="font-bold text-right">
                                    {{ number_format($order->total_amount) }}₫
                                </td>
                                <td class="text-center">
                                    <div class="badge badge-{{ $order->status_color }} gap-2">
                                        {{ $order->status_label }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($order->isPaid())
                                        <span class="badge badge-success gap-2">Đã trả</span>
                                    @elseif($order->payment_status === 'refunded')
                                        <span class="badge badge-error gap-2">Hoàn tiền</span>
                                    @else
                                        <span class="badge badge-warning gap-2">Chưa trả</span>
                                    @endif
                                </td>
                                <td class="text-sm text-base-content/70">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="text-center">
                                    <div class="flex justify-center gap-2 flex-wrap">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-ghost btn-xs gap-1" title="Xem chi tiết">
                                            <x-heroicon-o-eye class="w-4 h-4" />
                                            <span class="hidden sm:inline">Xem</span>
                                        </a>
                                        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-warning btn-xs gap-1" title="Sửa">
                                            <x-heroicon-o-pencil-square class="w-4 h-4" />
                                            <span class="hidden sm:inline">Sửa</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-8">
                                    <div class="flex flex-col items-center gap-3">
                                        <x-heroicon-o-inbox class="w-12 h-12 text-base-300" />
                                        <p class="text-base-content/60 font-medium">Chưa có đơn hàng nào</p>
                                        <p class="text-sm text-base-content/50">Đơn hàng sẽ xuất hiện tại đây khi khách hàng đặt</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="border-t border-base-200 p-4">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
