@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-8">
    <div class="container mx-auto px-4">
        <!-- Success Banner -->
        <div class="mb-8 p-6 bg-green-100 border-l-4 border-green-600 rounded-lg">
            <div class="flex items-center gap-4">
                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                </svg>
                <div>
                    <h2 class="text-xl font-bold text-green-900">Cảm Ơn! Đơn Hàng Của Bạn Đã Được Tạo</h2>
                    <p class="text-sm text-green-800 mt-1">Mã đơn hàng: <span class="font-mono font-bold">{{ $order->order_number }}</span></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- LEFT: Order Summary -->
            <div class="lg:col-span-2">
                <!-- Order Details Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">📋 Tóm Tắt Đơn Hàng</h3>

                    <!-- Order Timeline -->
                    <div class="mb-8">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">Đơn hàng đã tạo</p>
                                <p class="text-sm text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">Đang xử lý</p>
                                <p class="text-sm text-gray-600">Chúng tôi đang xác nhận đơn hàng của bạn</p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="mb-8 pb-8 border-b border-gray-200">
                        <h4 class="font-bold text-gray-900 mb-4">Sản Phẩm</h4>
                        <div class="space-y-4">
                            @foreach ($order->items as $item)
                                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">{{ $item->product->name }}</p>
                                        <p class="text-sm text-gray-600">Số lượng: {{ $item->quantity }}</p>
                                    </div>
                                    <p class="font-bold text-gray-900">{{ number_format($item->subtotal, 0, ',', '.') }} ₫</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Shipping Info -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h4 class="font-bold text-gray-900 mb-4">📍 Thông Tin Giao Hàng</h4>
                        <div class="space-y-2 text-sm text-gray-700">
                            <p><span class="font-semibold">Người nhận:</span> {{ $order->guest_name ?? $order->user->name }}</p>
                            <p><span class="font-semibold">Điện thoại:</span> {{ $order->phone_number }}</p>
                            <p><span class="font-semibold">Địa chỉ:</span> {{ $order->shipping_address }}</p>
                            @if ($order->shipping_details)
                                <p><span class="font-semibold">Ghi chú:</span> {{ $order->shipping_details }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">📬 Bước Tiếp Theo</h3>
                    <ol class="space-y-4">
                        <li class="flex gap-4">
                            <span class="font-bold text-blue-600 flex-shrink-0">1</span>
                            <div>
                                <p class="font-semibold text-gray-900">Xác thực thanh toán</p>
                                <p class="text-sm text-gray-600">Chúng tôi sẽ xác nhận thanh toán của bạn trong 24 giờ</p>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <span class="font-bold text-blue-600 flex-shrink-0">2</span>
                            <div>
                                <p class="font-semibold text-gray-900">Chuẩn bị hàng</p>
                                <p class="text-sm text-gray-600">Sản phẩm sẽ được đóng gói và sẵn sàng giao hàng</p>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <span class="font-bold text-blue-600 flex-shrink-0">3</span>
                            <div>
                                <p class="font-semibold text-gray-900">Giao hàng</p>
                                <p class="text-sm text-gray-600">Bạn sẽ nhận được mã vận chuyển để theo dõi</p>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>

            <!-- RIGHT: Sidebar -->
            <div class="lg:col-span-1">
                <!-- Order Summary Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-6 mb-6">
                    <h4 class="text-lg font-bold text-gray-900 mb-6">💰 Tóm Tắt Thanh Toán</h4>

                    <div class="space-y-3 mb-6 pb-6 border-b border-gray-200">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tổng hàng:</span>
                            <span class="font-semibold text-gray-900">{{ number_format($order->subtotal, 0, ',', '.') }} ₫</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Vận chuyển:</span>
                            <span class="font-semibold text-gray-900">
                                @if ($order->shipping_cost == 0)
                                    Miễn phí
                                @else
                                    {{ number_format($order->shipping_cost, 0, ',', '.') }} ₫
                                @endif
                            </span>
                        </div>
                        @if ($order->discount > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Giảm giá:</span>
                                <span class="font-semibold text-red-600">-{{ number_format($order->discount, 0, ',', '.') }} ₫</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex justify-between items-center mb-6">
                        <span class="text-gray-900 font-bold">Tổng cộng:</span>
                        <span class="text-2xl font-bold text-blue-600">{{ number_format($order->total_amount, 0, ',', '.') }} ₫</span>
                    </div>

                    <!-- Status -->
                    <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg mb-6">
                        <p class="text-sm text-yellow-900">
                            <span class="font-semibold">⏳ Trạng thái:</span> Chờ xác nhận
                        </p>
                    </div>

                    <!-- Reference Code -->
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-600 mb-1">🔐 Mã Tham Chiếu (Bảo Mật)</p>
                        <p class="font-mono font-bold text-gray-900 break-all text-xs">{{ $trackingToken }}</p>
                    </div>
                </div>

                <!-- Member Section -->
                @if ($order->user_id)
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl border-2 border-green-300 p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"></path>
                            </svg>
                            <div>
                                <p class="font-bold text-green-900">✓ Thành Viên</p>
                                <p class="text-xs text-green-700">Tài khoản bạn đã được tạo</p>
                            </div>
                        </div>

                        <p class="text-sm text-green-900 mb-4">
                            Bạn có thể theo dõi tất cả đơn hàng trong lịch sử tài khoản.
                        </p>

                        <a href="{{ route('orders.history') }}" class="block w-full px-4 py-3 bg-green-600 text-white font-bold rounded-lg text-center hover:bg-green-700 transition">
                            📋 Xem Lịch Sử Đơn Hàng
                        </a>
                    </div>
                @else
                    <!-- Guest Upgrade Section (THE MAGIC!) -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl border-2 border-blue-300 p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"></path>
                            </svg>
                            <div>
                                <p class="font-bold text-blue-900">💡 Nâng Cấp Tài Khoản</p>
                                <p class="text-xs text-blue-700">Tạo tài khoản để lưu lịch sử</p>
                            </div>
                        </div>

                        <p class="text-sm text-blue-900 mb-4">
                            Chỉ cần tạo mật khẩu, chúng tôi sẽ liên kết đơn hàng này với tài khoản của bạn.
                        </p>

                        <form id="guestUpgradeForm" class="space-y-3">
                            @csrf

                            <!-- Password Input -->
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-1">Mật Khẩu (Min 8 ký tự)</label>
                                <input type="password" name="password" required minlength="8"
                                    class="w-full px-3 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="••••••••">
                                <span class="text-xs text-blue-700 mt-1 block">🔒 Mật khẩu mạnh mẽ</span>
                            </div>

                            <!-- Password Confirm -->
                            <div>
                                <label class="block text-sm font-semibold text-blue-900 mb-1">Xác Nhận Mật Khẩu</label>
                                <input type="password" name="password_confirmation" required minlength="8"
                                    class="w-full px-3 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="••••••••">
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full px-4 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition active:scale-95">
                                Tạo Tài Khoản & Đăng Nhập
                            </button>

                            <!-- Loading State -->
                            <div id="loadingState" class="hidden">
                                <div class="flex items-center justify-center gap-2 py-3">
                                    <div class="w-4 h-4 bg-blue-600 rounded-full animate-bounce"></div>
                                    <span class="text-sm text-blue-900 font-semibold">Đang tạo tài khoản...</span>
                                </div>
                            </div>

                            <!-- Error State -->
                            <div id="errorState" class="hidden bg-red-50 border border-red-200 rounded-lg p-3">
                                <p id="errorMessage" class="text-sm text-red-800 font-semibold"></p>
                            </div>
                        </form>

                        <p class="text-xs text-blue-700 text-center mt-4 leading-relaxed">
                            Email: <span class="font-mono font-bold">{{ $order->guest_email }}</span>
                        </p>
                    </div>
                @endif

                <!-- Continue Shopping Link -->
                <div class="mt-6">
                    <a href="{{ route('home') }}"
                        class="block w-full px-4 py-3 border-2 border-gray-300 text-gray-900 font-bold rounded-lg text-center hover:bg-gray-50 transition">
                        ← Tiếp Tục Mua Hàng
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Xóa giỏ hàng local storage vì đã đặt hàng thành công
    if (localStorage.getItem('cart')) {
        localStorage.removeItem('cart');
        window.dispatchEvent(new CustomEvent('cart-updated'));
    }

    @if ($order->is_guest)
        // Guest upgrade form handler
        document.getElementById('guestUpgradeForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            const errorState = document.getElementById('errorState');
            const errorMessage = document.getElementById('errorMessage');
            const loadingState = document.getElementById('loadingState');
            const button = form.querySelector('button[type="submit"]');

            // Show loading
            loadingState.classList.remove('hidden');
            errorState.classList.add('hidden');
            button.disabled = true;

            try {
                const response = await fetch('{{ route("checkout.guest-upgrade", ["tracking_token" => $trackingToken]) }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    // Success - redirect to orders history
                    window.location.href = data.redirect;
                } else {
                    // Error
                    errorMessage.textContent = data.message;
                    errorState.classList.remove('hidden');
                    loadingState.classList.add('hidden');
                    button.disabled = false;
                }
            } catch (error) {
                errorMessage.textContent = 'Có lỗi xảy ra. Vui lòng thử lại.';
                errorState.classList.remove('hidden');
                loadingState.classList.add('hidden');
                button.disabled = false;
            }
        });
    @endif
</script>

@endsection
