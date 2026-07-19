@extends('admin.layout')

@section('title', 'Chi tiết Khách hàng')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold">Chi tiết khách hàng</h1>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-ghost btn-sm gap-2">
            <x-heroicon-o-arrow-left class="w-4 h-4" />
            Quay lại
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-lg">
            <div>
                <x-heroicon-o-check-circle class="w-6 h-6" />
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Customer Info -->
        <div class="lg:col-span-1 space-y-6">
            <div class="card bg-base-100 shadow-lg border border-base-200">
                <div class="card-body">
                    <h2 class="card-title text-lg border-b pb-2">Thông tin tài khoản</h2>
                    
                    <form action="{{ route('admin.customers.update', $customer) }}" method="POST" class="space-y-4 mt-4">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold">Họ tên</span></label>
                            <input type="text" name="name" value="{{ $customer->name }}" class="input input-bordered" required>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold">Email</span></label>
                            <input type="email" value="{{ $customer->email }}" class="input input-bordered bg-base-200" readonly>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold">Số điện thoại</span></label>
                            <input type="text" name="phone" value="{{ $customer->phone }}" class="input input-bordered" required>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold">Ngày đăng ký</span></label>
                            <input type="text" value="{{ $customer->created_at->format('d/m/Y H:i') }}" class="input input-bordered bg-base-200" readonly>
                        </div>

                        <button type="submit" class="btn btn-primary w-full mt-4">Cập nhật thông tin</button>
                    </form>
                </div>
            </div>
            
            <div class="card bg-base-100 shadow-lg border border-base-200">
                <div class="card-body">
                    <h2 class="card-title text-lg border-b pb-2">Thống kê nhanh</h2>
                    <div class="stats stats-vertical shadow mt-4">
                        <div class="stat px-0">
                            <div class="stat-title">Tổng đơn hàng</div>
                            <div class="stat-value text-primary">{{ $customer->orders->count() }}</div>
                        </div>
                        
                        <div class="stat px-0">
                            <div class="stat-title">Đơn hoàn thành</div>
                            <div class="stat-value text-success">{{ $customer->orders->where('status', 'completed')->count() }}</div>
                        </div>
                        
                        <div class="stat px-0">
                            <div class="stat-title">Tổng chi tiêu</div>
                            <div class="stat-value text-xl">{{ number_format($customer->orders->where('payment_status', 'paid')->sum('total_amount')) }}₫</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders History -->
        <div class="lg:col-span-2">
            <div class="card bg-base-100 shadow-lg border border-base-200">
                <div class="card-body p-0">
                    <h2 class="text-lg font-bold p-6 pb-2">Lịch sử đơn hàng</h2>
                    
                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr class="bg-base-200">
                                    <th>Mã đơn</th>
                                    <th>Ngày đặt</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customer->orders as $order)
                                    <tr>
                                        <td class="font-bold text-primary">{{ $order->order_number }}</td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="font-bold">{{ number_format($order->total_amount) }}₫</td>
                                        <td>
                                            <div class="badge badge-{{ $order->status_color }}">{{ $order->status_label }}</div>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-ghost btn-xs">Chi tiết</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-6 text-base-content/60">
                                            Khách hàng chưa có đơn hàng nào.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
