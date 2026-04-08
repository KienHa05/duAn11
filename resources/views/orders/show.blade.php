@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-8">
    <div class="container mx-auto px-4">
        <!-- Status Banner -->
        @if ($order->payment_status === 'paid')
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-800 font-semibold">✓ Thanh toán thành công!</p>
            </div>
        @elseif ($order->payment_status === 'pending')
            <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <p class="text-yellow-800 font-semibold">⏳ Chờ thanh toán</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- LEFT: Order Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Header -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Đơn Hàng {{ $order->order_number }}</h1>
                    <p class="text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</p>

                    @if ($order->is_guest)
                        <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-xs text-blue-800">👤 Đơn hàng khách (không kết nối tài khoản)</p>
                        </div>
                    @endif
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-8 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900">Sản Phẩm</h2>
                    </div>

                    <div class="divide-y divide-gray-200">
                        @foreach ($order->items as $item)
                            <div class="p-6 flex items-center gap-6 hover:bg-gray-50 transition">
                                <!-- Product Image -->
                                <div class="w-20 h-20 rounded-lg bg-gray-200 flex-shrink-0 overflow-hidden">
                                    @if ($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        Mã: {{ $item->product->id }} | Số lượng: {{ $item->quantity }}
                                    </p>
                                </div>

                                <!-- Price -->
                                <div class="text-right">
                                    <p class="text-sm text-gray-600">{{ $item->unit_price->toLocaleString('vi-VN') }} ₫</p>
                                    <p class="font-bold text-gray-900 text-lg">{{ $item->subtotal->toLocaleString('vi-VN') }} ₫</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">📍 Địa Chỉ Giao Hàng</h2>
                    <div class="space-y-2">
                        <p><span class="font-semibold text-gray-700">Tên:</span> {{ $order->guest_name ?? $order->user->name }}</p>
                        <p><span class="font-semibold text-gray-700">Điện thoại:</span> {{ $order->phone_number }}</p>
                        <p><span class="font-semibold text-gray-700">Email:</span> {{ $order->guest_email ?? $order->user->email }}</p>
                        <p><span class="font-semibold text-gray-700">Địa Chỉ:</span> {{ $order->shipping_address }}</p>
                        @if ($order->shipping_details)
                            <p><span class="font-semibold text-gray-700">Ghi Chú:</span> {{ $order->shipping_details }}</p>
                        @endif
                    </div>
                </div>

                <!-- Shipment Info (if exists) -->
                @if ($order->shipment)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">📦 Thông Tin Vận Chuyển</h2>
                        <div class="space-y-2">
                            <p><span class="font-semibold text-gray-700">Mã Vận Chuyển:</span> {{ $order->shipment->tracking_number ?? 'N/A' }}</p>
                            <p><span class="font-semibold text-gray-700">Đơn Vị:</span> {{ $order->shipment->carrier ?? 'N/A' }}</p>
                            <p><span class="font-semibold text-gray-700">Trạng Thái:</span> {{ $order->shipment->status ?? 'pending' }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- RIGHT: Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-6">
                    <!-- Status -->
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-3">Trạng Thái</h3>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-700">Đơn Hàng:</span>
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

                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-700">Thanh Toán:</span>
                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                    @if ($order->payment_status === 'paid') bg-green-100 text-green-800
                                    @elseif ($order->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 my-6"></div>

                    <!-- Price Summary -->
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tổng Hàng:</span>
                            <span class="text-gray-900 font-semibold">{{ $order->subtotal->toLocaleString('vi-VN') }} ₫</span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Phí Vận Chuyển:</span>
                            <span class="text-gray-900 font-semibold">{{ $order->shipping_cost->toLocaleString('vi-VN') }} ₫</span>
                        </div>

                        @if ($order->discount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Giảm Giá:</span>
                                <span class="text-gray-900 font-semibold">-{{ $order->discount->toLocaleString('vi-VN') }} ₫</span>
                            </div>
                        @endif

                        <div class="border-t border-gray-200 pt-3 flex justify-between">
                            <span class="text-lg font-bold text-gray-900">Tổng Cộng:</span>
                            <span class="text-lg font-bold text-blue-600">{{ $order->total_amount->toLocaleString('vi-VN') }} ₫</span>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 my-6"></div>

                    <!-- Payment Method -->
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-2">Phương Thức Thanh Toán</h3>
                        <p class="text-sm text-gray-900">
                            @switch($order->payment_method)
                                @case('cash')
                                    💰 Thanh Toán Khi Nhận Hàng
                                    @break
                                @case('bank_transfer')
                                    🏦 Chuyển Khoản Ngân Hàng
                                    @break
                                @case('credit_card')
                                    💳 Thẻ Tín Dụng
                                    @break
                                @case('e_wallet')
                                    📱 Ví Điện Tử
                                    @break
                                @default
                                    {{ $order->payment_method }}
                            @endswitch
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-2">
                        <a href="{{ route('client.cart.index') }}" class="block w-full px-4 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition text-center">
                            ← Tiếp Tục Mua Hàng
                        </a>

                        @if (!auth()->check() && !$order->is_guest)
                            <a href="{{ route('login') }}" class="block w-full px-4 py-3 border border-blue-600 text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition text-center">
                                🔐 Đăng Nhập Để Theo Dõi
                            </a>
                        @endif
                    </div>

                    <!-- Order Number for Reference -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-600 mb-1">📋 Mã Tham Chiếu</p>
                        <p class="font-mono font-bold text-gray-900 break-all">{{ $order->order_number }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if (session('success'))
<script>
// Show success notification
document.addEventListener('DOMContentLoaded', function() {
    window.cartStore?.showToast?.('{{ session('success') }}', 'success');
});
</script>
@endif

@endsection
