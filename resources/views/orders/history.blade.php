@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Lịch Sử Mua Hàng</h1>
            <p class="text-gray-600 mt-2">Quản lý các đơn hàng của bạn</p>
        </div>

        @if ($orders->count() > 0)
            <div class="space-y-4">
                @foreach ($orders as $order)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                            <!-- Order Number -->
                            <div>
                                <p class="text-xs text-gray-600 uppercase font-semibold mb-1">Mã Đơn Hàng</p>
                                <p class="font-bold text-gray-900">{{ $order->order_number }}</p>
                            </div>

                            <!-- Total Amount -->
                            <div>
                                <p class="text-xs text-gray-600 uppercase font-semibold mb-1">Tổng Tiền</p>
                                <p class="font-bold text-lg text-gray-900">{{ $order->total_amount->toLocaleString('vi-VN') }} ₫</p>
                            </div>

                            <!-- Status -->
                            <div>
                                <p class="text-xs text-gray-600 uppercase font-semibold mb-1">Trạng Thái</p>
                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                    @if ($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif ($order->status === 'confirmed') bg-blue-100 text-blue-800
                                    @elseif ($order->status === 'processing') bg-blue-100 text-blue-800
                                    @elseif ($order->status === 'shipped') bg-indigo-100 text-indigo-800
                                    @elseif ($order->status === 'delivered') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>

                            <!-- Date & Action -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-600 uppercase font-semibold mb-1">Ngày Đặt</p>
                                    <p class="text-gray-900">{{ $order->created_at->format('d/m/Y') }}</p>
                                </div>
                                <a href="{{ route('orders.show', $order) }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition">
                                    Chi Tiết →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($orders->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $orders->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Chưa Có Đơn Hàng</h3>
                <p class="text-gray-600 mb-6">Hãy bắt đầu mua sắm ngay bây giờ</p>
                <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    Quay Lại Cửa Hàng
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
