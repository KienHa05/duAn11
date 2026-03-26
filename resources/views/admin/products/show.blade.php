@extends('layouts.admin')

@section('title', $product->name . ' - Chi tiết sản phẩm')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-base-content"><x-heroicon-o-information-circle class="inline w-8 h-8 mr-3" />Chi tiết sản phẩm</h1>
        <p class="text-base-content/70">{{ $product->name }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">
            <x-heroicon-o-pencil-square class="w-5 h-5 mr-2" />Chỉnh sửa
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline">
            <x-heroicon-o-arrow-left class="w-5 h-5 mr-2" />Quay lại danh sách
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title"><x-heroicon-o-square-3-stack-3d class="w-5 h-5 mr-2" />Thông tin cơ bản</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="label">
                            <span class="label-text font-semibold">ID</span>
                        </label>
                        <div class="badge badge-neutral">{{ $product->id }}</div>
                    </div>
                    <div>
                        <label class="label">
                            <span class="label-text font-semibold">Trạng thái</span>
                        </label>
                        @if($product->stock > 0)
                            <div class="badge badge-success">Còn hàng</div>
                        @else
                            <div class="badge badge-error">Hết hàng</div>
                        @endif
                    </div>
                </div>

                <div class="divider"></div>

                <div class="mb-6">
                    <label class="label">
                        <span class="label-text font-semibold">Tên sản phẩm</span>
                    </label>
                    <h3 class="text-xl font-bold">{{ $product->name }}</h3>
                </div>

                <div class="divider"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="label">
                            <span class="label-text font-semibold">Giá</span>
                        </label>
                        <div class="text-success text-xl font-bold">{{ number_format($product->price) }} VND</div>
                    </div>
                    <div>
                        <label class="label">
                            <span class="label-text font-semibold">Danh mục</span>
                        </label>
                        @if($product->category)
                            <div class="badge badge-primary">{{ $product->category->name }}</div>
                        @else
                            <span class="text-base-content/50">-</span>
                        @endif
                    </div>
                </div>

                <div class="divider"></div>

                <div>
                    <label class="label">
                        <span class="label-text font-semibold">Tồn kho</span>
                    </label>
                    <div class="w-full bg-base-200 rounded-full h-6">
                        @php
                            $percentage = $product->stock > 100 ? 100 : $product->stock;
                            $color = $percentage >= 50 ? 'bg-success' : ($percentage >= 20 ? 'bg-warning' : 'bg-error');
                        @endphp
                        <div class="h-full {{ $color }} rounded-full flex items-center justify-center text-xs font-bold text-base-100" style="width: {{ $percentage }}%;">
                            {{ $product->stock }} sản phẩm
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="card bg-base-100 shadow-xl mb-6">
            <div class="card-body">
                <h2 class="card-title"><x-heroicon-o-clock class="w-5 h-5 mr-2" />Lịch sử</h2>

                <div class="mb-4">
                    <label class="label">
                        <span class="label-text font-semibold">Ngày tạo</span>
                    </label>
                    <div>
                        {{ $product->created_at->format('d/m/Y') }}<br>
                        <span class="text-sm text-base-content/70">{{ $product->created_at->format('H:i:s') }}</span>
                    </div>
                </div>

                <div>
                    <label class="label">
                        <span class="label-text font-semibold">Ngày cập nhật</span>
                    </label>
                    <div>
                        {{ $product->updated_at->format('d/m/Y') }}<br>
                        <span class="text-sm text-base-content/70">{{ $product->updated_at->format('H:i:s') }}</span>
                    </div>
                </div>
            </div>

            <div class="card-actions justify-center mt-6">
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">
                    <x-heroicon-o-pencil-square class="w-5 h-5" /> Sửa
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-ghost">
                    <x-heroicon-o-arrow-left class="w-5 h-5" /> Quay lại danh sách
                </a>
            </div>
        </div>

        <div class="card bg-error text-error-content shadow-xl">
            <div class="card-body">
                <h2 class="card-title"><x-heroicon-o-exclamation-triangle class="w-5 h-5 mr-2" />Xóa sản phẩm</h2>
                <p class="mb-4">Hành động này không thể hoàn tác.</p>
                <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error w-full">
                        <x-heroicon-o-trash class="w-5 h-5 mr-2" />Xóa vĩnh viễn
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
