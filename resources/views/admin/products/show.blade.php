@extends('admin.layout')

@section('title', $product->name)

@section('content')
<div class="container mx-auto">
<!-- Header -->
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-ghost btn-sm gap-2 w-fit">
            <x-heroicon-o-arrow-left class="w-5 h-5" /> Quay lại
        </a>
        <h1 class="text-3xl font-bold text-base-900">{{ $product->name }}</h1>
        <p class="text-sm text-base-content/70 mt-1">
            Danh mục: <span class="font-semibold">{{ $product->category->name ?? 'N/A' }}</span>
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column - Image & Quick Info -->
    <div class="lg:col-span-1 space-y-4">
        <!-- Image Card -->
        <div class="card bg-base-100 shadow overflow-hidden">
            <figure class="aspect-square bg-base-200">
                @if($product->image)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <x-heroicon-o-photo class="w-20 h-20 text-base-300" />
                    </div>
                @endif
            </figure>
        </div>

        <!-- Price Card -->
        <div class="card bg-success text-success-content shadow">
            <div class="card-body">
                <p class="text-sm opacity-90">Giá bán</p>
                <h2 class="text-4xl font-bold">{{ number_format($product->price, 0, ',', '.') }} <span class="text-2xl">₫</span></h2>
            </div>
        </div>

        <!-- Stock Status -->
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h3 class="font-bold text-lg mb-3">Tồn kho</h3>
                <div class="flex items-end gap-3">
                    <div class="flex-1">
                        <div class="progress progress-{{ $product->stock > 10 ? 'success' : ($product->stock > 0 ? 'warning' : 'error') }}" role="progressbar" aria-valuenow="{{ min($product->stock, 100) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ min($product->stock / 100 * 100, 100) }}%"></div>
                    </div>
                    <span class="text-2xl font-bold">{{ $product->stock }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Details -->
    <div class="lg:col-span-2 space-y-4">
        <!-- Basic Info -->
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title text-lg mb-4">
                    <x-heroicon-o-information-circle class="w-5 h-5 text-primary" /> Thông tin cơ bản
                </h2>

                @if($product->description)
                    <div class="mb-4">
                        <p class="text-sm text-base-600 font-semibold mb-2">Mô tả</p>
                        <p class="text-base whitespace-pre-wrap">{{ $product->description }}</p>
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-base-600 font-semibold">Danh mục</p>
                        <p class="text-base font-semibold">{{ $product->category->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-base-600 font-semibold">Trạng thái</p>
                        <p class="text-base">
                            @if($product->stock > 0)
                                <span class="badge badge-success">Còn hàng</span>
                            @else
                                <span class="badge badge-error">Hết hàng</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Specifications -->
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title text-lg mb-4">
                    <x-heroicon-o-adjustments-horizontal class="w-5 h-5 text-info" /> Thông số sản phẩm
                </h2>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-base-600 font-semibold">Kích cỡ</p>
                        <p class="text-base font-semibold">{{ $product->size ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-base-600 font-semibold">Màu sắc</p>
                        <p class="text-base font-semibold">{{ $product->color ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Meta Info -->
        <div class="grid grid-cols-2 gap-4">
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <p class="text-sm text-base-600 font-semibold">ID Sản phẩm</p>
                    <p class="text-2xl font-bold">#{{ $product->id }}</p>
                </div>
            </div>
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <p class="text-sm text-base-600 font-semibold">Ngày tạo</p>
                    <p class="text-lg font-bold">{{ $product->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-2">
            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-lg btn-warning flex-1 gap-2">
                <x-heroicon-o-pencil-square class="w-5 h-5" /> Chỉnh sửa
            </a>
            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="flex-1" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-lg btn-error w-full gap-2">
                    <x-heroicon-o-trash class="w-5 h-5" /> Xóa
                </button>
            </form>
            <a href="{{ route('admin.products.index') }}" class="btn btn-lg btn-ghost flex-1">
                Danh sách
            </a>
        </div>
    </div>
</div>
 </div>
@endsection
