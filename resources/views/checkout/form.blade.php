@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Thanh Toán Đơn Hàng</h1>
            <p class="text-gray-600 mt-2">Vui lòng điền thông tin để hoàn thành đơn hàng</p>
        </div>

        <form id="checkoutForm" action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf

            <!-- LEFT: Checkout Form -->
            <div class="lg:col-span-2">
                <!-- STAGE 1 & 2: Guest Checkout Form -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">

                    <!-- Shipping Information -->
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-6">
                            <svg class="w-5 h-5 inline mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.657 5.343L19.07 3.93a1 1 0 00-1.414-1.414l-1.413 1.413A7 7 0 1019.07 19.07l1.414-1.414a1 1 0 00-1.414-1.414l-1.413 1.413A5 5 0 1117.657 5.343z"></path>
                            </svg>
                            Thông Tin Giao Hàng
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Họ Tên <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    placeholder="Nguyễn Văn A"
                                    value="{{ auth()->user()?->name ?? old('name') }}">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Số Điện Thoại <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" id="phone" name="phone" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    placeholder="0123 456 789"
                                    value="{{ auth()->user()?->phone ?? old('phone') }}">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="md:col-span-2">
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="email" id="email" name="email" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                        placeholder="email@example.com"
                                        value="{{ auth()->user()?->email ?? old('email') }}"
                                        @if(!auth()->user()) data-check-email @endif>

                                    <!-- Loading Spinner (Hidden by default) -->
                                    <div id="emailCheckLoading" class="hidden absolute right-4 top-1/2 transform -translate-y-1/2">
                                        <div class="w-5 h-5 border-2 border-blue-300 border-t-blue-600 rounded-full animate-spin"></div>
                                    </div>
                                </div>

                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror

                                <!-- Email Exists Suggestion (Hidden by default) -->
                                <div id="emailExistsSuggestion" class="hidden mt-3 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                    <p class="text-sm text-blue-900 font-semibold mb-2">
                                        💡 Email này đã được đăng ký
                                    </p>
                                    <p class="text-sm text-blue-800 mb-3">
                                        Bạn có muốn đăng nhập để nhận ưu đãi thành viên không?
                                    </p>
                                    <button type="button" onclick="alert('Tính năng đăng nhập sẽ được thêm trong phiên bản tiếp theo. Hiện tại bạn vẫn có thể tiếp tục thanh toán với email này.')"
                                        class="inline-block px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition">
                                        Đăng Nhập Ngay
                                    </button>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Địa Chỉ <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="address" name="address" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    placeholder="123 Đường ABC, Quận 1, TPHCM"
                                    value="{{ old('address') }}">
                                @error('address')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Shipping Details (Optional) -->
                            <div class="md:col-span-2">
                                <label for="shipping_details" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Ghi Chú Giao Hàng (Tùy Chọn)
                                </label>
                                <textarea id="shipping_details" name="shipping_details" rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                    placeholder="VD: Giao vào buổi sáng, không còi chuông..."
                                    value="{{ old('shipping_details') }}"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 my-8"></div>

                    <!-- Payment Method -->
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-6">
                            <svg class="w-5 h-5 inline mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 10h18V5H3v5zm0 8h18v-5H3v5z"></path>
                            </svg>
                            Phương Thức Thanh Toán
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-blue-50 transition" style="border-color: #e5e7eb;">
                                <input type="radio" name="payment_method" value="cash" checked required
                                    class="w-4 h-4 text-blue-600">
                                <span class="ml-3 font-medium text-gray-700">Thanh Toán Khi Nhận Hàng (COD)</span>
                            </label>

                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-blue-50 transition">
                                <input type="radio" name="payment_method" value="bank_transfer" required
                                    class="w-4 h-4 text-blue-600">
                                <span class="ml-3 font-medium text-gray-700">Chuyển Khoản Ngân Hàng</span>
                            </label>

                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-blue-50 transition">
                                <input type="radio" name="payment_method" value="e_wallet" required
                                    class="w-4 h-4 text-blue-600">
                                <span class="ml-3 font-medium text-gray-700">Ví Điện Tử (Momo, Viettel Pay)</span>
                            </label>

                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-blue-50 transition">
                                <input type="radio" name="payment_method" value="credit_card" required
                                    class="w-4 h-4 text-blue-600">
                                <span class="ml-3 font-medium text-gray-700">Thẻ Tín Dụng</span>
                            </label>
                        </div>

                        @error('payment_method')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 my-8"></div>

                    <!-- Login Suggestion (STAGE 2) -->
                    @if (!auth()->check())
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-lg p-6 mb-8">
                        <div class="flex items-start gap-4">
                            <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"></path>
                            </svg>
                            <div class="flex-1">
                                <h3 class="font-bold text-blue-900 mb-1">💡 Đăng Nhập Để Hưởng Lợi Ích</h3>
                                <p class="text-sm text-blue-800 mb-3">
                                    Đăng nhập hoặc tạo tài khoản để:
                                </p>
                                <ul class="text-sm text-blue-800 space-y-1 mb-4">
                                    <li>✓ Lưu lịch sử mua hàng</li>
                                    <li>✓ Nhận ưu đãi độc quyền và điểm thưởng</li>
                                    <li>✓ Theo dõi đơn hàng dễ dàng</li>
                                </ul>
                                <p class="text-xs text-blue-700 italic">Bạn có thể đăng nhập sau khi hoàn tất thanh toán</p>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-8">
                        <p class="text-sm text-green-800">
                            <span class="font-semibold">✓ Bạn đã đăng nhập:</span> Giỏ hàng của bạn sẽ được lưu vào tài khoản
                        </p>
                    </div>
                    @endif

                    <!-- Action Button -->
                    <div class="flex gap-4">
                        <a href="{{ route('client.cart.index') }}" class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition text-center">
                            ← Quay Lại Giỏ
                        </a>
                        <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg hover:shadow-lg transition">
                            Đặt Hàng Ngay →
                        </button>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Tóm Tắt Đơn Hàng</h3>

                    <!-- Cart Items -->
                    <div id="cartItems" class="space-y-4 mb-6 max-h-96 overflow-y-auto"></div>

                    <!-- Hidden input for items -->
                    <input type="hidden" id="itemsInput" name="items" value="[]">

                    <!-- Divider -->
                    <div class="border-t border-gray-200 my-6"></div>

                    <!-- Price Summary -->
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tổng Hàng:</span>
                            <span class="text-gray-900 font-semibold" id="subtotal">0 ₫</span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Phí Vận Chuyển:</span>
                            <span class="text-gray-900 font-semibold" id="shipping">30,000 ₫</span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Giảm Giá:</span>
                            <span class="text-gray-900 font-semibold" id="discount">0 ₫</span>
                        </div>

                        <div class="border-t border-gray-200 pt-3 flex justify-between">
                            <span class="text-lg font-bold text-gray-900">Tổng Cộng:</span>
                            <span class="text-lg font-bold text-blue-600" id="total">30,000 ₫</span>
                        </div>
                    </div>

                    <!-- Free Shipping Notice -->
                    <div id="freeShippingNotice" class="hidden mt-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-sm text-green-800 font-semibold">🎉 Miễn phí vận chuyển cho đơn hàng này!</p>
                    </div>

                    <!-- Order Note -->
                    <p class="text-xs text-gray-500 text-center mt-6">
                        Bước tiếp theo sẽ xác nhận thanh toán
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize cart display
    updateCartDisplay();

    // Listen for cart changes
    window.addEventListener('cart-updated', updateCartDisplay);
});

function updateCartDisplay() {
    const cartData = window.cartStore || { items: [] };
    const items = cartData.items || JSON.parse(localStorage.getItem('cart') || '[]');

    const cartItemsEl = document.getElementById('cartItems');
    const itemsInput = document.getElementById('itemsInput');

    if (items.length === 0) {
        cartItemsEl.innerHTML = '<p class="text-gray-500 text-sm text-center py-4">Giỏ hàng trống</p>';
        itemsInput.value = '[]';
        return;
    }

    // Update visible items
    cartItemsEl.innerHTML = items.map(item => `
        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
            <div class="flex-1">
                <p class="font-medium text-sm text-gray-900 truncate">${item.name}</p>
                <p class="text-xs text-gray-500">x${item.quantity}</p>
            </div>
            <p class="font-semibold text-sm text-gray-900">${(item.price * item.quantity).toLocaleString('vi-VN')} ₫</p>
        </div>
    `).join('');

    // Update hidden input (for form submission)
    itemsInput.value = JSON.stringify(items);

    // Update totals
    updatePrices(items);
}

function updatePrices(items) {
    const subtotal = items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const shipping = subtotal >= 500000 ? 0 : 30000;
    const discount = 0;
    const total = subtotal + shipping - discount;

    document.getElementById('subtotal').textContent = subtotal.toLocaleString('vi-VN') + ' ₫';
    document.getElementById('shipping').textContent = shipping.toLocaleString('vi-VN') + ' ₫';
    document.getElementById('discount').textContent = discount.toLocaleString('vi-VN') + ' ₫';
    document.getElementById('total').textContent = total.toLocaleString('vi-VN') + ' ₫';

    // Show/hide free shipping notice
    document.getElementById('freeShippingNotice').classList.toggle('hidden', shipping !== 0);
}

// Form validation before submit
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    const items = JSON.parse(document.getElementById('itemsInput').value || '[]');
    if (items.length === 0) {
        e.preventDefault();
        alert('Vui lòng chọn sản phẩm để thanh toán');
    }
});

// STAGE 3: Email check on blur
const emailInput = document.querySelector('[data-check-email]');
if (emailInput) {
    let checkTimeout;

    emailInput.addEventListener('blur', function() {
        const email = this.value.trim();
        const suggestion = document.getElementById('emailExistsSuggestion');
        const loading = document.getElementById('emailCheckLoading');

        // Clear previous suggestion
        suggestion.classList.add('hidden');
        loading.classList.add('hidden');

        // Only check if email is valid
        if (!email || !email.includes('@')) {
            return;
        }

        // Debounce: wait 300ms after user stops typing
        clearTimeout(checkTimeout);
        checkTimeout = setTimeout(() => {
            checkEmailExists(email);
        }, 300);
    });
}

async function checkEmailExists(email) {
    const loading = document.getElementById('emailCheckLoading');
    const suggestion = document.getElementById('emailExistsSuggestion');

    loading.classList.remove('hidden');

    try {
        const response = await fetch('/api/checkout/check-email', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ email: email })
        });

        const data = await response.json();
        loading.classList.add('hidden');

        if (data.exists) {
            // Email exists - show suggestion
            suggestion.classList.remove('hidden');
        } else {
            // New email - hide suggestion
            suggestion.classList.add('hidden');
        }
    } catch (error) {
        console.error('Error checking email:', error);
        loading.classList.add('hidden');
    }
}
</script>
@endsection
