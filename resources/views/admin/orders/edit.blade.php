@extends('admin.layout')

@section('title', 'Cập nhật trạng thái: ' . $order->order_number)

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-ghost btn-circle" title="Quay lại">
            <x-heroicon-o-arrow-left class="w-6 h-6" />
        </a>
        <div>
            <h1 class="text-4xl font-bold">Cập nhật đơn hàng</h1>
            <p class="text-base-content/60 mt-1">{{ $order->order_number }}</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Form (2/3) -->
        <div class="lg:col-span-2">
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" id="statusForm" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Order Status Card -->
                <div class="card bg-base-100 shadow-md">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-primary/10 rounded-lg">
                                <x-heroicon-o-chart-bar class="w-6 h-6 text-primary" />
                            </div>
                            <h2 class="card-title text-xl">Trạng thái đơn hàng</h2>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Trạng thái <span class="text-error">*</span></span>
                            </label>
                            <select name="status" class="select select-bordered focus:select-primary text-base @error('status') select-error @enderror">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                                <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Đã gửi hàng</option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Đã giao hàng</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                <option value="returned" {{ $order->status === 'returned' ? 'selected' : '' }}>Trả hàng</option>
                            </select>
                            @error('status')
                                <label class="label">
                                    <span class="label-text-alt text-error flex items-center gap-1">
                                        <x-heroicon-o-exclamation-circle class="w-4 h-4" />
                                        {{ $message }}
                                    </span>
                                </label>
                            @enderror
                        </div>

                        <!-- Status Info Alert -->
                        <div class="mt-4 alert alert-info">
                            <x-heroicon-o-information-circle class="w-5 h-5 stroke-current" />
                            <div>
                                <p class="text-sm font-semibold">Thứ tự trạng thái:</p>
                                <p class="text-xs mt-1">Chờ xác nhận → Đã xác nhận → Đang xử lý → Đã gửi hàng → Đã giao hàng</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Status Card -->
                <div class="card bg-base-100 shadow-md">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-success/10 rounded-lg">
                                <x-heroicon-o-currency-dollar class="w-6 h-6 text-success" />
                            </div>
                            <h2 class="card-title text-xl">Trạng thái thanh toán</h2>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Thanh toán <span class="text-error">*</span></span>
                            </label>
                            <select name="payment_status" class="select select-bordered focus:select-primary text-base @error('payment_status') select-error @enderror">
                                <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Chờ thanh toán</option>
                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                                <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Thanh toán thất bại</option>
                                <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Hoàn tiền</option>
                            </select>
                            @error('payment_status')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Notes Card -->
                <div class="card bg-base-100 shadow-md">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-warning/10 rounded-lg">
                                <x-heroicon-o-document-text class="w-6 h-6 text-warning" />
                            </div>
                            <h2 class="card-title text-xl">Ghi chú</h2>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Ghi chú thêm</span>
                            </label>
                            <textarea name="notes" rows="4" placeholder="Ghi chú về đơn hàng..." class="textarea textarea-bordered focus:textarea-primary text-base @error('notes') textarea-error @enderror">{{ old('notes', $order->notes) }}</textarea>
                            @error('notes')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-4 border-t border-base-200">
                    <button 
                        type="submit" 
                        class="btn btn-primary gap-2 flex-1"
                        form="statusForm">
                        <x-heroicon-o-check-circle class="w-5 h-5" />
                        Cập nhật
                    </button>
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-ghost gap-2">
                        <x-heroicon-o-x-mark class="w-5 h-5" />
                        Hủy
                    </a>
                </div>
            </form>
        </div>

        <!-- Right Sidebar - Info (1/3) -->
        <div class="space-y-6">
            <!-- Order Summary -->
            <div class="card bg-base-100 shadow-md sticky top-6">
                <div class="card-body">
                    <h3 class="card-title text-lg">Tóm tắt</h3>
                    <div class="divider my-2"></div>

                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="font-semibold text-base-content/60">Mã đơn hàng</p>
                            <p class="text-base font-mono font-bold text-primary">{{ $order->order_number }}</p>
                        </div>

                        <div>
                            <p class="font-semibold text-base-content/60">Khách hàng</p>
                            <p class="text-base">{{ $order->user->name }}</p>
                        </div>

                        <div>
                            <p class="font-semibold text-base-content/60">Tổng tiền</p>
                            <p class="text-2xl font-bold text-primary">{{ number_format($order->total_amount) }}₫</p>
                        </div>

                        <div>
                            <p class="font-semibold text-base-content/60">Trạng thái hiện tại</p>
                            <div class="badge badge-lg badge-{{ $order->status_color }} w-full justify-center mt-1">
                                {{ $order->status_label }}
                            </div>
                        </div>

                        <div>
                            <p class="font-semibold text-base-content/60">Thanh toán</p>
                            <div class="badge badge-lg badge-{{ $order->isPaid() ? 'success' : 'warning' }} w-full justify-center mt-1">
                                {{ $order->payment_status_label }}
                            </div>
                        </div>

                        <div>
                            <p class="font-semibold text-base-content/60">Ngày tạo</p>
                            <p class="text-base">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Summary -->
            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <h3 class="card-title text-lg">Sản phẩm</h3>
                    <div class="divider my-2"></div>

                    <div class="space-y-2">
                        @foreach($order->items as $item)
                            <div class="flex justify-between items-start text-sm">
                                <div>
                                    <p class="font-semibold">{{ $item->product->name }}</p>
                                    <p class="text-xs text-base-content/60">x{{ $item->quantity }}</p>
                                </div>
                                <p class="font-semibold">{{ number_format($item->subtotal) }}₫</p>
                            </div>
                        @endforeach

                        <div class="divider my-1"></div>
                        <div class="flex justify-between text-lg font-bold">
                            <span>Tổng:</span>
                            <span class="text-primary">{{ number_format($order->total_amount) }}₫</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
