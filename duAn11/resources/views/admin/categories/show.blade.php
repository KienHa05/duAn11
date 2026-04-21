@extends('admin.layout')

@section('title', $category->name)

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost btn-circle" title="Quay lại">
            <x-heroicon-o-arrow-left class="w-6 h-6" />
        </a>
        <div>
            <h1 class="text-4xl font-bold">{{ $category->name }}</h1>
            <p class="text-base-content/60 mt-1">Chi tiết danh mục và sản phẩm</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Category Info (1/3) -->
        <div class="space-y-6">
            <!-- Category Card -->
            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <div class="badge badge-lg badge-primary mb-3">Danh mục</div>
                    <h2 class="card-title text-2xl mb-2">{{ $category->name }}</h2>
                    <p class="text-sm text-base-content/60">Mã danh mục: <span class="font-semibold">#{{ $category->id }}</span></p>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="card bg-gradient-to-br from-primary/10 to-secondary/10 shadow-md">
                <div class="card-body">
                    <h3 class="card-title text-lg flex items-center gap-2">
                        <x-heroicon-o-chart-bar class="w-6 h-6 text-primary" />
                        Thống kê
                    </h3>
                    <div class="divider my-2"></div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="p-2 bg-primary/20 rounded-lg">
                                    <x-heroicon-o-shopping-bag class="w-5 h-5 text-primary" />
                                </div>
                                <span class="font-semibold">Tổng sản phẩm</span>
                            </div>
                            <span class="text-3xl font-bold text-primary">{{ $totalProducts }}</span>
                        </div>

                        <div class="divider my-2"></div>

                        <div>
                            <p class="text-xs font-semibold text-base-content/60 uppercase mb-2">Ngày tạo</p>
                            <p class="text-base font-semibold">{{ $category->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-base-content/60 uppercase mb-2">Lần cập nhật cuối</p>
                            <p class="text-base font-semibold">{{ $category->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-2">
                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning w-full gap-2">
                    <x-heroicon-o-pencil-square class="w-5 h-5" />
                    Chỉnh sửa danh mục
                </a>
                
                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="w-full" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?\nTất cả các sản phẩm sẽ được giữ lại, chỉ xóa danh mục.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error w-full gap-2">
                        <x-heroicon-o-trash class="w-5 h-5" />
                        Xóa danh mục
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Column - Products List (2/3) -->
        <div class="lg:col-span-2">
            <div class="card bg-base-100 shadow-md">
                <div class="card-body p-0">
                    <!-- Header -->
                    <div class="p-6 border-b border-base-200 flex items-center gap-3">
                        <div class="p-2 bg-info/10 rounded-lg">
                            <x-heroicon-o-list-bullet class="w-6 h-6 text-info" />
                        </div>
                        <div>
                            <h3 class="card-title text-lg">Danh sách sản phẩm</h3>
                            <p class="text-sm text-base-content/60">{{ $totalProducts }} sản phẩm trong danh mục</p>
                        </div>
                    </div>

                    <!-- Products Table -->
                    <div class="overflow-x-auto">
                        @if($products->count() > 0)
                            <table class="table table-zebra table-xs sm:table-sm w-full">
                                <thead>
                                    <tr class="bg-base-200 hover:bg-base-200">
                                        <th class="font-bold">ID</th>
                                        <th class="font-bold w-20">Ảnh</th>
                                        <th class="font-bold">Tên sản phẩm</th>
                                        <th class="font-bold text-right">Giá</th>
                                        <th class="font-bold text-right">Tồn kho</th>
                                        <th class="font-bold text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr class="hover:bg-base-200 transition">
                                            <td class="font-medium">{{ $product->id }}</td>
                                            <td>
                                                @if($product->image)
                                                    <div class="avatar">
                                                        <div class="w-12 h-12 rounded-lg ring ring-base-300 ring-offset-base-100 ring-offset-2 overflow-hidden">
                                                            <img 
                                                                src="{{ $product->image_url }}" 
                                                                alt="{{ $product->name }}"
                                                                class="object-cover w-full h-full"
                                                            >
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="avatar placeholder">
                                                        <div class="w-12 h-12 bg-base-300 text-base-content rounded-lg flex items-center justify-center">
                                                            <x-heroicon-o-photo class="w-5 h-5" />
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="font-semibold text-base-content">{{ Str::limit($product->name, 25) }}</div>
                                                <div class="text-xs text-base-content/60">SKU: #{{ $product->id }}</div>
                                            </td>
                                            <td class="font-semibold text-right">
                                                <div class="text-primary font-bold">{{ number_format($product->price) }}</div>
                                                <div class="text-xs text-base-content/60">VND</div>
                                            </td>
                                            <td class="text-right">
                                                @if($product->stock > 10)
                                                    <span class="badge badge-success gap-2 text-xs">{{ $product->stock }}</span>
                                                @elseif($product->stock > 0)
                                                    <span class="badge badge-warning gap-2 text-xs">{{ $product->stock }}</span>
                                                @else
                                                    <span class="badge badge-error gap-2 text-xs">{{ $product->stock }}</span>
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
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <!-- Empty State -->
                            <div class="p-8">
                                <div class="flex flex-col items-center justify-center gap-4">
                                    <div class="p-4 bg-base-200 rounded-lg">
                                        <x-heroicon-o-inbox class="w-12 h-12 text-base-300" />
                                    </div>
                                    <div class="text-center">
                                        <p class="text-base-content/60 font-medium">Chưa có sản phẩm nào</p>
                                        <p class="text-sm text-base-content/50 mt-1">Bắt đầu bằng cách tạo sản phẩm mới cho danh mục này</p>
                                    </div>
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm gap-2 mt-2">
                                        <x-heroicon-o-plus class="w-4 h-4" />
                                        Tạo sản phẩm
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="border-t border-base-200 p-4">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
