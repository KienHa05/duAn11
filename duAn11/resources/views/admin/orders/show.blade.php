@extends('admin.layout')

@section('title', 'Chi tiết đơn hàng: ' . $order->order_number)

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost btn-circle" title="Quay lại">
            <x-heroicon-o-arrow-left class="w-6 h-6" />
        </a>
        <div>
            <h1 class="text-4xl font-bold">{{ $order->order_number }}</h1>
            <p class="text-base-content/60 mt-1">Chi tiết đơn hàng</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Order Info (1/3) -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <h3 class="card-title text-lg flex items-center gap-2">
                        <x-heroicon-o-chart-bar class="w-6 h-6 text-primary" />
                        Trạng thái
                    </h3>
                    <div class="divider my-2"></div>

                    <div class="space-y-3">
                        <!-- Order Status -->
                        <div>
                            <p class="text-xs font-semibold text-base-content/60 uppercase mb-1">Đơn hàng</p>
                            <div class="badge badge-lg badge-{{ $order->status_color }} w-full justify-center">
                                {{ $order->status_label }}
                            </div>
                        </div>

                        <!-- Payment Status -->
                        <div>
                            <p class="text-xs font-semibold text-base-content/60 uppercase mb-1">Thanh toán</p>
                            <div class="badge badge-lg badge-{{ $order->isPaid() ? 'success' : 'warning' }} w-full justify-center">
                                {{ $order->payment_status_label }}
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <p class="text-xs font-semibold text-base-content/60 uppercase mb-1">Phương thức</p>
                            <p class="text-base font-semibold capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Card -->
            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <h3 class="card-title text-lg flex items-center gap-2">
                        <x-heroicon-o-user class="w-6 h-6 text-info" />
                        Khách hàng
                    </h3>
                    <div class="divider my-2"></div>

                    <!-- Guest/Member Badge -->
                    <div class="mb-3">
                        @if($order->isGuest())
                            <span class="badge badge-lg badge-warning gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                                </svg>
                                Khách hàng
                            </span>
                        @else
                            <span class="badge badge-lg badge-success gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Thành viên
                            </span>
                        @endif
                    </div>

                    <div class="space-y-2 text-sm">
                        <div>
                            <p class="font-semibold text-base-content/60">Tên</p>
                            <p class="text-base">{{ $order->customer_name }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-base-content/60">Email</p>
                            <p class="text-base truncate">{{ $order->customer_email }}</p>
                        </div>
                        <div>
                            <p class="font-semibold text-base-content/60">Điện thoại</p>
                            <p class="text-base">{{ $order->customer_phone }}</p>
                        </div>

                        @if($order->isGuest())
                            <div class="bg-warning/10 border border-warning/30 rounded-lg p-2 mt-3">
                                <p class="text-xs font-semibold text-warning mb-1">🔑 Tracking Token</p>
                                <p class="text-xs font-mono break-all">{{ $order->tracking_token }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Timeline Card -->
            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <h3 class="card-title text-lg flex items-center gap-2">
                        <x-heroicon-o-clock class="w-6 h-6 text-warning" />
                        Lịch sử
                    </h3>
                    <div class="divider my-2"></div>

                    <ul class="timeline timeline-compact">
                        <li class="timeline-start">
                            <div class="timeline-middle">
                                <x-heroicon-o-check-circle class="w-5 h-5 text-success" />
                            </div>
                            <div class="timeline-end text-sm mb-3">
                                <div class="font-bold">Đơn hàng tạo</div>
                                <time class="text-xs opacity-50">{{ $order->created_at->format('d/m/Y H:i') }}</time>
                            </div>
                        </li>

                        @if($order->paid_at)
                            <li class="timeline-start">
                                <div class="timeline-middle">
                                    <x-heroicon-o-check-circle class="w-5 h-5 text-success" />
                                </div>
                                <div class="timeline-end text-sm mb-3">
                                    <div class="font-bold">Đã thanh toán</div>
                                    <time class="text-xs opacity-50">{{ $order->paid_at->format('d/m/Y H:i') }}</time>
                                </div>
                            </li>
                        @endif

                        @if($order->shipped_at)
                            <li class="timeline-start">
                                <div class="timeline-middle">
                                    <x-heroicon-o-check-circle class="w-5 h-5 text-success" />
                                </div>
                                <div class="timeline-end text-sm mb-3">
                                    <div class="font-bold">Đang giao hàng</div>
                                    <time class="text-xs opacity-50">{{ $order->shipped_at->format('d/m/Y H:i') }}</time>
                                </div>
                            </li>
                        @endif

                        @if($order->delivered_at)
                            <li class="timeline-start">
                                <div class="timeline-middle">
                                    <x-heroicon-o-check-circle class="w-5 h-5 text-success" />
                                </div>
                                <div class="timeline-end text-sm">
                                    <div class="font-bold">Hoàn tất</div>
                                    <time class="text-xs opacity-50">{{ $order->delivered_at->format('d/m/Y H:i') }}</time>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2 flex-col">
                <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-primary gap-2">
                    <x-heroicon-o-pencil-square class="w-5 h-5" />
                    Cập nhật trạng thái
                </a>

                @if(!$order->isCancelled())
                    <form action="{{ route('admin.orders.cancel', $order) }}" method="POST">
                        @csrf
                        <div class="flex gap-2">
                            <input type="text" name="reason" placeholder="Lý do hủy..." class="input input-bordered input-sm flex-1" required>
                            <button type="submit" class="btn btn-error btn-sm gap-2">
                                <x-heroicon-o-x-mark class="w-4 h-4" />
                                Hủy
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>

        <!-- Right Column - Details (2/3) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <h3 class="card-title text-lg flex items-center gap-2">
                        <x-heroicon-o-shopping-bag class="w-6 h-6 text-primary" />
                        Sản phẩm
                    </h3>
                    <div class="divider my-2"></div>

                    <div class="overflow-x-auto">
                        <table class="table table-compact w-full text-sm">
                            <thead>
                                <tr class="bg-base-200/50">
                                    <th>Sản phẩm</th>
                                    <th class="text-right">Giá</th>
                                    <th class="text-right">SL</th>
                                    <th class="text-right">Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="font-semibold">{{ $item->product->name }}</div>
                                            <div class="text-xs text-base-content/60">
                                                @if($item->size)
                                                    Kích cỡ: {{ $item->size }}
                                                @endif
                                                @if($item->color)
                                                    | Màu: {{ $item->color }}
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-right">{{ number_format($item->unit_price) }}</td>
                                        <td class="text-right">{{ $item->quantity }}</td>
                                        <td class="text-right font-semibold">{{ number_format($item->subtotal) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pricing Summary -->
            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <h3 class="card-title text-lg flex items-center gap-2">
                        <x-heroicon-o-currency-dollar class="w-6 h-6 text-success" />
                        Tóm tắt giá
                    </h3>
                    <div class="divider my-2"></div>

                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span>Tổng tiền hàng:</span>
                            <span class="font-semibold">{{ number_format($order->subtotal) }}₫</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Phí vận chuyển:</span>
                            <span class="font-semibold">{{ number_format($order->shipping_cost) }}₫</span>
                        </div>
                        @if($order->discount > 0)
                            <div class="flex justify-between text-error">
                                <span>Chiết khấu:</span>
                                <span class="font-semibold">-{{ number_format($order->discount) }}₫</span>
                            </div>
                        @endif
                        <div class="divider my-1"></div>
                        <div class="flex justify-between text-lg">
                            <span class="font-bold">Tổng cộng:</span>
                            <span class="font-bold text-primary">{{ number_format($order->total_amount) }}₫</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <h3 class="card-title text-lg flex items-center gap-2">
                        <x-heroicon-o-truck class="w-6 h-6 text-info" />
                        Vận chuyển
                    </h3>
                    <div class="divider my-2"></div>

                    @if($order->shipment)
                        <div class="space-y-2 text-sm">
                            <div>
                                <p class="font-semibold text-base-content/60">Trạng thái</p>
                                <div class="badge badge-{{ $order->shipment->status_color }} gap-2 mt-1">
                                    {{ $order->shipment->status_label }}
                                </div>
                            </div>
                            @if($order->shipment->tracking_number)
                                <div>
                                    <p class="font-semibold text-base-content/60">Mã theo dõi</p>
                                    <p class="font-mono">{{ $order->shipment->tracking_number }}</p>
                                </div>
                            @endif
                            @if($order->shipment->carrier)
                                <div>
                                    <p class="font-semibold text-base-content/60">Đơn vị vận chuyển</p>
                                    <p>{{ $order->shipment->carrier }}</p>
                                </div>
                            @endif
                            @if($order->shipment->estimated_delivery)
                                <div>
                                    <p class="font-semibold text-base-content/60">Dự kiến giao</p>
                                    <p>{{ $order->shipment->estimated_delivery->format('d/m/Y') }}</p>
                                </div>
                            @endif
                        </div>

                        <form action="{{ route('admin.orders.shipment', $order) }}" method="POST" class="mt-4 pt-4 border-t border-base-200">
                            @csrf
                            <div class="space-y-2">
                                <input type="text" name="tracking_number" placeholder="Mã theo dõi" class="input input-bordered input-sm w-full" value="{{ $order->shipment->tracking_number }}">
                                <input type="text" name="carrier" placeholder="Đơn vị vận chuyển" class="input input-bordered input-sm w-full" value="{{ $order->shipment->carrier }}">
                                <input type="date" name="estimated_delivery" class="input input-bordered input-sm w-full" value="{{ $order->shipment->estimated_delivery?->format('Y-m-d') }}">
                                <button type="submit" class="btn btn-primary btn-sm w-full">Cập nhật vận chuyển</button>
                            </div>
                        </form>
                    @else
                        <p class="text-base-content/60">Chưa có thông tin vận chuyển</p>
                        <form action="{{ route('admin.orders.shipment', $order) }}" method="POST" class="mt-4 pt-4 border-t border-base-200">
                            @csrf
                            <div class="space-y-2">
                                <input type="text" name="tracking_number" placeholder="Mã theo dõi" class="input input-bordered input-sm w-full">
                                <input type="text" name="carrier" placeholder="Đơn vị vận chuyển" class="input input-bordered input-sm w-full">
                                <input type="date" name="estimated_delivery" class="input input-bordered input-sm w-full">
                                <button type="submit" class="btn btn-primary btn-sm w-full">Thêm thông tin vận chuyển</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <h3 class="card-title text-lg flex items-center gap-2">
                        <x-heroicon-o-map-pin class="w-6 h-6 text-warning" />
                        Địa chỉ giao hàng
                    </h3>
                    <div class="divider my-2"></div>

                    <div class="space-y-1 text-sm">
                        <p class="font-semibold">{{ $order->shipping_address }}</p>
                        @if($order->shipping_details)
                            <p class="text-base-content/70">{{ $order->shipping_details }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if($order->notes)
                <div class="card bg-warning/10 shadow-md border border-warning/20">
                    <div class="card-body">
                        <h3 class="card-title text-lg flex items-center gap-2">
                            <x-heroicon-o-document-text class="w-6 h-6 text-warning" />
                            Ghi chú
                        </h3>
                        <div class="divider my-2"></div>
                        <p class="text-sm">{{ $order->notes }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
