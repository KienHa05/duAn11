@extends('admin.layout')

@section('title', 'Sản phẩm')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold">Quản lý sản phẩm</h1>
            <p class="text-sm text-base-content/60 mt-1">Danh sách tất cả các sản phẩm trong cửa hàng</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary gap-2">
            <x-heroicon-o-plus class="w-5 h-5" /> 
            Thêm sản phẩm mới
        </a>
    </div>

    <!-- Products Table Card -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra table-xs sm:table-sm lg:table-md w-full">
                    <thead>
                        <tr class="bg-base-200 hover:bg-base-200">
                            <th class="font-bold">ID</th>
                            <th class="font-bold w-20">Hình ảnh</th>
                            <th class="font-bold">Tên sản phẩm</th>
                            <th class="font-bold text-right">Giá</th>
                            <th class="font-bold text-right">Tồn kho</th>
                            <th class="font-bold">Danh mục</th>
                            <th class="font-bold text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr class="hover:bg-base-200 transition">
                                <td class="font-medium">{{ $product->id }}</td>
                                <td>
                                    @if($product->image)
                                        <div class="avatar">
                                            <div class="w-16 h-16 rounded-lg ring ring-base-300 ring-offset-base-100 ring-offset-2 overflow-hidden hover:ring-primary transition cursor-pointer">
                                                <img 
                                                    src="{{ $product->image_url }}" 
                                                    alt="{{ $product->name }}"
                                                    class="object-cover w-full h-full hover:scale-110 transition duration-300"
                                                >
                                            </div>
                                        </div>
                                    @else
                                        <div class="avatar placeholder">
                                            <div class="w-16 h-16 bg-base-300 text-base-content rounded-lg flex items-center justify-center">
                                                <x-heroicon-o-photo class="w-8 h-8" />
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="font-semibold text-base-content">{{ Str::limit($product->name, 30) }}</div>
                                    <div class="text-xs text-base-content/60">SKU: #{{ $product->id }}</div>
                                </td>
                                <td class="font-semibold text-right">
                                    <div class="text-primary font-bold">{{ number_format($product->price) }}</div>
                                    <div class="text-xs text-base-content/60">VND</div>
                                </td>
                                <td class="text-right">
                                    @if($product->stock > 10)
                                        <span class="badge badge-success gap-2">{{ $product->stock }}</span>
                                    @elseif($product->stock > 0)
                                        <span class="badge badge-warning gap-2">{{ $product->stock }}</span>
                                    @else
                                        <span class="badge badge-error gap-2">{{ $product->stock }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->category)
                                        <div class="badge badge-outline">{{ $product->category->name }}</div>
                                    @else
                                        <div class="badge badge-ghost">N/A</div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="flex justify-center gap-2 flex-wrap">
                                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-ghost btn-xs gap-1" title="Xem chi tiết">
                                            <x-heroicon-o-eye class="w-4 h-4" />
                                            <span class="hidden sm:inline">Xem</span>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-xs gap-1" title="Sửa">
                                            <x-heroicon-o-pencil-square class="w-4 h-4" />
                                            <span class="hidden sm:inline">Sửa</span>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-error btn-xs gap-1" title="Xóa" onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?')">
                                                <x-heroicon-o-trash class="w-4 h-4" />
                                                <span class="hidden sm:inline">Xóa</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12">
                                    <div class="flex flex-col items-center gap-3">
                                        <x-heroicon-o-inbox class="w-12 h-12 text-base-300" />
                                        <div>
                                            <p class="font-semibold">Không có sản phẩm nào</p>
                                            <p class="text-sm text-base-content/60">Bắt đầu tạo sản phẩm mới ngay hôm nay</p>
                                        </div>
                                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm mt-2">
                                            Thêm sản phẩm
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="border-t border-base-200 p-6">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .table-xs tr td {
        padding: 0.75rem;
    }
</style>
@endsection
