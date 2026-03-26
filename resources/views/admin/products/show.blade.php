@extends('admin.layout')

@section('title', $product->name . ' - Chi tiết sản phẩm')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-base-900">Chi tiết sản phẩm</h1>
            <p class="text-sm text-base-600 mt-1">{{ $product->name }}</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-ghost btn-circle">
            <x-heroicon-o-x-mark class="w-6 h-6" />
        </a>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Image & Key Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Image Card -->
            <div class="card bg-base-100 shadow-md border border-base-200">
                <div class="card-body p-0">
                    @if($product->image)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-64 object-cover rounded-t-2xl">
                    @else
                        <div class="w-full h-64 bg-base-200 rounded-t-2xl flex items-center justify-center">
                            <div class="text-center">
                                <x-heroicon-o-photo class="w-16 h-16 mx-auto text-base-400 mb-2" />
                                <p class="text-sm text-base-600">Chưa có hình ảnh</p>
                            </div>
                        </div>
                    @endif
                    <div class="px-6 pt-6 pb-0">
                        <!-- Stock Status Bar -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="label-text font-medium">Tồn kho</span>
                                <span class="font-bold text-lg">{{ $product->stock }}</span>
                            </div>
                            <div class="w-full bg-base-200 rounded-full h-3">
                                @php
                                    $percentage = min($product->stock, 100);
                                    $color = $percentage >= 50 ? 'bg-success' : ($percentage >= 20 ? 'bg-warning' : 'bg-error');
                                @endphp
                                <div class="h-full {{ $color }} rounded-full" style="width: {{ $percentage }}%;"></div>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="mb-6">
                            <span class="label-text font-medium">Giá bán</span>
                            <div class="text-3xl font-bold text-success mt-2">
                                <span>{{ number_format($product->price) }}</span>
                                <span class="text-lg ml-1">VND</span>
                            </div>
                        </div>

                        <!-- Category -->
                        @if($product->category)
                            <div>
                                <span class="label-text font-medium">Danh mục</span>
                                <div class="mt-2">
                                    <div class="badge badge-primary badge-lg">{{ $product->category->name }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Status Card -->
            <div class="card bg-base-100 shadow-md border border-base-200">
                <div class="card-body">
                    <h2 class="card-title text-lg font-bold flex items-center gap-2">
                        <x-heroicon-o-information-circle class="w-5 h-5 text-info" />
                        Tình trạng
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <span class="label-text font-medium">ID</span>
                            <div class="mt-1">
                                <div class="badge badge-neutral">{{ $product->id }}</div>
                            </div>
                        </div>
                        <div>
                            <span class="label-text font-medium">Kho hàng</span>
                            <div class="mt-1">
                                @if($product->stock > 0)
                                    <div class="badge badge-success">Còn hàng</div>
                                @else
                                    <div class="badge badge-error">Hết hàng</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information Card -->
            <div class="card bg-base-100 shadow-md border border-base-200">
                <div class="card-body">
                    <h2 class="card-title text-lg font-bold flex items-center gap-2">
                        <x-heroicon-o-square-3-stack-3d class="w-5 h-5 text-primary" />
                        Thông tin cơ bản
                    </h2>

                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <span class="label-text font-medium">Tên sản phẩm</span>
                            <h3 class="text-2xl font-bold mt-2">{{ $product->name }}</h3>
                        </div>

                        <!-- Description -->
                        @if($product->description)
                            <div>
                                <span class="label-text font-medium">Mô tả</span>
                                <div class="mt-2 p-4 bg-base-200 rounded-lg">
                                    <p class="text-base-700 whitespace-pre-line">{{ $product->description }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Specifications Card -->
            <div class="card bg-base-100 shadow-md border border-base-200">
                <div class="card-body">
                    <h2 class="card-title text-lg font-bold flex items-center gap-2">
                        <x-heroicon-o-adjustments-horizontal class="w-5 h-5 text-info" />
                        Thông số sản phẩm
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Size -->
                        <div>
                            <span class="label-text font-medium">Kích cỡ</span>
                            <div class="mt-2">
                                @if($product->size)
                                    <div class="badge badge-lg">{{ $product->size }}</div>
                                @else
                                    <span class="text-base-500">Không xác định</span>
                                @endif
                            </div>
                        </div>

                        <!-- Color -->
                        <div>
                            <span class="label-text font-medium">Màu sắc</span>
                            <div class="mt-2">
                                @if($product->color)
                                    @php
                                        $colors = [
                                            'Đen' => '#000000',
                                            'Trắng' => '#ffffff',
                                            'Xám' => '#888888',
                                            'Đỏ' => '#dc2626',
                                            'Xanh dương' => '#2563eb',
                                            'Xanh lá' => '#16a34a',
                                            'Vàng' => '#eab308',
                                            'Hồng' => '#ec4899',
                                            'Tím' => '#a855f7',
                                            'Cam' => '#ea580c',
                                        ];
                                        $colorHex = $colors[$product->color] ?? '#cccccc';
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full border-2 border-base-300" style="background-color: {{ $colorHex }};"></div>
                                        <span>{{ $product->color }}</span>
                                    </div>
                                @else
                                    <span class="text-base-500">Không xác định</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metadata Card -->
            <div class="card bg-base-100 shadow-md border border-base-200">
                <div class="card-body">
                    <h2 class="card-title text-lg font-bold flex items-center gap-2">
                        <x-heroicon-o-clock class="w-5 h-5 text-warning" />
                        Thông tin hệ thống
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Created At -->
                        <div>
                            <span class="label-text font-medium">Ngày tạo</span>
                            <div class="mt-2">
                                <p class="font-semibold">{{ $product->created_at->format('d/m/Y') }}</p>
                                <p class="text-sm text-base-600">{{ $product->created_at->format('H:i:s') }}</p>
                            </div>
                        </div>

                        <!-- Updated At -->
                        <div>
                            <span class="label-text font-medium">Ngày cập nhật</span>
                            <div class="mt-2">
                                <p class="font-semibold">{{ $product->updated_at->format('d/m/Y') }}</p>
                                <p class="text-sm text-base-600">{{ $product->updated_at->format('H:i:s') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Footer - Single Action Bar -->
    <div class="card bg-base-100 shadow-md border border-base-200">
        <div class="card-body">
            <div class="flex flex-col sm:flex-row gap-3 justify-end">
                <a href="{{ route('admin.products.index') }}" class="btn btn-ghost">
                    <x-heroicon-o-arrow-left class="w-5 h-5" />
                    Quay lại danh sách
                </a>
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">
                    <x-heroicon-o-pencil-square class="w-5 h-5" />
                    Sửa sản phẩm
                </a>
                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này? Hành động này không thể hoàn tác.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error w-full sm:w-auto">
                        <x-heroicon-o-trash class="w-5 h-5" />
                        Xóa sản phẩm
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
