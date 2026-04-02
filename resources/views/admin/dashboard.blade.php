@extends('admin.layout')

@section('title', 'Bảng điều khiển')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-4xl font-bold">Bảng điều khiển</h1>
            <p class="text-sm text-base-content/60 mt-1">Quản lý cửa hàng thương mại điện tử hiệu quả</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-base-content/60">{{ date('d/m/Y') }}</p>
            <p class="text-lg font-semibold">{{ date('H:i') }}</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Products Card -->
        <div class="card bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg">
            <div class="card-body text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Tổng sản phẩm</p>
                        <h2 class="text-4xl font-bold mt-2">{{ \App\Models\Product::count() }}</h2>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <x-heroicon-o-square-3-stack-3d class="w-8 h-8" />
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-white/20">
                    <a href="{{ route('admin.products.index') }}" class="text-blue-100 hover:text-white text-sm font-medium flex items-center gap-1 transition">
                        Xem chi tiết
                        <x-heroicon-o-arrow-right class="w-4 h-4" />
                    </a>
                </div>
            </div>
        </div>

        <!-- Categories Card -->
        <div class="card bg-gradient-to-br from-purple-500 to-purple-600 shadow-lg">
            <div class="card-body text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Tổng danh mục</p>
                        <h2 class="text-4xl font-bold mt-2">{{ \App\Models\Category::count() }}</h2>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <x-heroicon-o-tag class="w-8 h-8" />
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-white/20">
                    <a href="{{ route('admin.categories.index') }}" class="text-purple-100 hover:text-white text-sm font-medium flex items-center gap-1 transition">
                        Xem chi tiết
                        <x-heroicon-o-arrow-right class="w-4 h-4" />
                    </a>
                </div>
            </div>
        </div>

        <!-- Users Card -->
        <div class="card bg-gradient-to-br from-emerald-500 to-emerald-600 shadow-lg">
            <div class="card-body text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium">Tổng người dùng</p>
                        <h2 class="text-4xl font-bold mt-2">{{ \App\Models\User::count() }}</h2>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <x-heroicon-o-users class="w-8 h-8" />
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-white/20">
                    <a href="#" class="text-emerald-100 hover:text-white text-sm font-medium flex items-center gap-1 transition">
                        Xem chi tiết
                        <x-heroicon-o-arrow-right class="w-4 h-4" />
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Recent Products -->
        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <h3 class="card-title mb-4">Sản phẩm gần đây</h3>
                <div class="space-y-3">
                    @php
                        $recentProducts = \App\Models\Product::latest()->take(5)->get();
                    @endphp
                    @forelse($recentProducts as $product)
                        <div class="flex items-center justify-between p-3 rounded-lg bg-base-200 hover:bg-base-300 transition">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                @if($product->image)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-10 h-10 rounded object-cover">
                                @else
                                    <div class="w-10 h-10 rounded bg-base-300 flex items-center justify-center">
                                        <x-heroicon-o-photo class="w-5 h-5" />
                                    </div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <p class="font-semibold truncate">{{ $product->name }}</p>
                                    <p class="text-xs text-base-content/60">{{ number_format($product->price) }} VND</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-ghost btn-xs">
                                <x-heroicon-o-pencil-square class="w-4 h-4" />
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-base-content/60">Chưa có sản phẩm nào</p>
                        </div>
                    @endforelse
                </div>
                <div class="divider my-4"></div>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-block gap-2">
                    <x-heroicon-o-plus class="w-5 h-5" />
                    Thêm sản phẩm mới
                </a>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <h3 class="card-title mb-4">Liên kết nhanh</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 p-3 rounded-lg bg-base-200 hover:bg-base-300 transition group">
                        <div class="p-2 rounded-lg bg-blue-100 text-blue-600 group-hover:bg-blue-200 transition">
                            <x-heroicon-o-square-3-stack-3d class="w-5 h-5" />
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold">Danh sách sản phẩm</p>
                            <p class="text-xs text-base-content/60">Quản lý tất cả sản phẩm</p>
                        </div>
                        <x-heroicon-o-arrow-right class="w-5 h-5 opacity-0 group-hover:opacity-100 transition" />
                    </a>

                    <a href="{{ route('admin.products.create') }}" class="flex items-center gap-3 p-3 rounded-lg bg-base-200 hover:bg-base-300 transition group">
                        <div class="p-2 rounded-lg bg-green-100 text-green-600 group-hover:bg-green-200 transition">
                            <x-heroicon-o-plus-circle class="w-5 h-5" />
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold">Thêm sản phẩm</p>
                            <p class="text-xs text-base-content/60">Tạo sản phẩm mới</p>
                        </div>
                        <x-heroicon-o-arrow-right class="w-5 h-5 opacity-0 group-hover:opacity-100 transition" />
                    </a>

                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 p-3 rounded-lg bg-base-200 hover:bg-base-300 transition group">
                        <div class="p-2 rounded-lg bg-purple-100 text-purple-600 group-hover:bg-purple-200 transition">
                            <x-heroicon-o-tag class="w-5 h-5" />
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold">Danh mục</p>
                            <p class="text-xs text-base-content/60">Quản lý danh mục sản phẩm</p>
                        </div>
                        <x-heroicon-o-arrow-right class="w-5 h-5 opacity-0 group-hover:opacity-100 transition" />
                    </a>

                    <a href="{{ route('home') }}" class="flex items-center gap-3 p-3 rounded-lg bg-base-200 hover:bg-base-300 transition group">
                        <div class="p-2 rounded-lg bg-orange-100 text-orange-600 group-hover:bg-orange-200 transition">
                            <x-heroicon-o-home class="w-5 h-5" />
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold">Trang chủ</p>
                            <p class="text-xs text-base-content/60">Xem giao diện người dùng</p>
                        </div>
                        <x-heroicon-o-arrow-right class="w-5 h-5 opacity-0 group-hover:opacity-100 transition" />
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body">
            <h3 class="card-title mb-4">Thông tin hệ thống</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 bg-base-200 rounded-lg">
                    <p class="text-sm text-base-content/60">Phiên bản Laravel</p>
                    <p class="text-xl font-semibold">{{ app()->version() }}</p>
                </div>
                <div class="p-4 bg-base-200 rounded-lg">
                    <p class="text-sm text-base-content/60">PHP Version</p>
                    <p class="text-xl font-semibold">{{ phpversion() }}</p>
                </div>
                <div class="p-4 bg-base-200 rounded-lg">
                    <p class="text-sm text-base-content/60">Environment</p>
                    <p class="text-xl font-semibold">{{ app()->environment() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
