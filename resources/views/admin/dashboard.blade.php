@extends('admin.layout')

@section('title', 'Bảng điều khiển')

@section('content')
<div class="container mx-auto">
    <div class="hero bg-base-100 rounded-box mb-6">
        <div class="hero-content text-center">
            <div class="max-w-md">
                <h1 class="text-5xl font-bold">Chào mừng đến Bảng điều khiển</h1>
                <p class="py-6">Quản lý cửa hàng thương mại điện tử hiệu quả.</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 justify-items-center">
        <div class="card bg-primary text-primary-content">
            <div class="card-body text-center">
                <h2 class="card-title justify-center">
                    <x-heroicon-o-square-3-stack-3d class="w-6 h-6" />
                    Sản phẩm
                </h2>
                <p>{{ \App\Models\Product::count() }} sản phẩm tổng cộng</p>
                <div class="card-actions justify-center">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-ghost">Xem tất cả</a>
                </div>
            </div>
        </div>

        <div class="card bg-secondary text-secondary-content">
            <div class="card-body text-center">
                <h2 class="card-title justify-center">
                    <x-heroicon-o-tag class="w-6 h-6" />
                    Danh mục
                </h2>
                <p>{{ \App\Models\Category::count() }} danh mục tổng cộng</p>
                <div class="card-actions justify-center">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost">Xem tất cả</a>
                </div>
            </div>
        </div>

        <div class="card bg-accent text-accent-content">
            <div class="card-body text-center">
                <h2 class="card-title justify-center">
                    <x-heroicon-o-users class="w-6 h-6" />
                    Người dùng
                </h2>
                <p>{{ \App\Models\User::count() }} người dùng tổng cộng</p>
                <div class="card-actions justify-center">
                    <a href="#" class="btn btn-ghost">Xem tất cả</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
