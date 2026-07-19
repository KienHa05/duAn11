@extends('admin.layout')

@section('title', 'Quản lý khách hàng')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold">Khách hàng</h1>
            <p class="text-sm text-base-content/60 mt-1">Quản lý danh sách khách hàng và lịch sử mua sắm</p>
        </div>
        
        <form action="{{ route('admin.customers.index') }}" method="GET" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm tên, email, SĐT..." class="input input-bordered input-sm w-full max-w-xs" />
            <button type="submit" class="btn btn-primary btn-sm">Tìm kiếm</button>
            @if(request('search'))
                <a href="{{ route('admin.customers.index') }}" class="btn btn-ghost btn-sm">Xóa lọc</a>
            @endif
        </form>
    </div>

    <!-- Table Card -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra table-sm lg:table-md w-full">
                    <thead>
                        <tr class="bg-base-200">
                            <th class="font-bold">ID</th>
                            <th class="font-bold">Họ tên</th>
                            <th class="font-bold">Email</th>
                            <th class="font-bold">Số điện thoại</th>
                            <th class="font-bold">Ngày đăng ký</th>
                            <th class="font-bold text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr class="hover:bg-base-200 transition">
                                <td class="font-bold text-primary">#{{ $customer->id }}</td>
                                <td class="font-semibold">{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone ?? 'Chưa cập nhật' }}</td>
                                <td>{{ $customer->created_at->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-ghost btn-xs gap-1" title="Chi tiết">
                                            <x-heroicon-o-eye class="w-4 h-4" />
                                            <span>Xem</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8">
                                    <div class="flex flex-col items-center gap-3">
                                        <x-heroicon-o-users class="w-12 h-12 text-base-300" />
                                        <p class="text-base-content/60 font-medium">Không tìm thấy khách hàng nào</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($customers->hasPages())
                <div class="border-t border-base-200 p-4">
                    {{ $customers->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
