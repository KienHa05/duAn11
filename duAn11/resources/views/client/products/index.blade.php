@extends('layouts.app')

@section('title', 'Sản phẩm - The Notorious')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">The Notorious</h1>
                <p class="lead mb-4">Thương hiệu thời trang thể thao hàng đầu với những sản phẩm chất lượng cao</p>
                <a href="#products" class="btn btn-light btn-lg">Xem sản phẩm</a>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=600&h=400&fit=crop" alt="Sports clothing" class="img-fluid rounded">
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section id="products" class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="text-center mb-4">Sản phẩm của chúng tôi</h2>

                <!-- Search Form -->
                <form method="GET" action="{{ route('home') }}" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   class="form-control" placeholder="Tìm kiếm sản phẩm...">
                        </div>
                        <div class="col-md-2">
                            <select name="category" class="form-select">
                                <option value="">Tất cả danh mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-1"></i>Tìm kiếm
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            @forelse($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card product-card h-100">
                        <div class="card-img-container" style="height: 250px; overflow: hidden;">
                            <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=250&fit=crop"
                                 class="card-img-top" alt="{{ $product->name }}"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted">{{ $product->category->name ?? 'N/A' }}</p>
                            <p class="card-text fw-bold text-primary mb-3">
                                {{ number_format($product->price) }} VND
                            </p>
                            <div class="mt-auto">
                                <a href="{{ route('client.products.show', $product) }}"
                                   class="btn btn-outline-primary w-100">
                                    <i class="fas fa-eye me-1"></i>Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Không tìm thấy sản phẩm nào</h4>
                        <p class="text-muted">Hãy thử tìm kiếm với từ khóa khác</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
