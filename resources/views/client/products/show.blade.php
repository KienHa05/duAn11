@extends('layouts.app')

@section('title', $product->name . ' - The Notorious')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=600&h=400&fit=crop"
                     alt="{{ $product->name }}" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('client.products.index') }}">Sản phẩm</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ $product->category->name ?? 'N/A' }}</a></li>
                        <li class="breadcrumb-item active">{{ $product->name }}</li>
                    </ol>
                </nav>

                <h1 class="display-5 fw-bold mb-3">{{ $product->name }}</h1>

                <div class="mb-4">
                    <span class="badge bg-primary fs-6 mb-2">{{ $product->category->name ?? 'N/A' }}</span>
                    <h2 class="text-primary fw-bold">{{ number_format($product->price) }} VND</h2>
                </div>

                <div class="row mb-4">
                    <div class="col-sm-6">
                        <div class="border rounded p-3 text-center">
                            <i class="fas fa-warehouse text-muted mb-2"></i>
                            <div class="fw-bold">{{ $product->stock }}</div>
                            <small class="text-muted">Tồn kho</small>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="border rounded p-3 text-center">
                            <i class="fas fa-calendar text-muted mb-2"></i>
                            <div class="fw-bold">{{ $product->created_at->format('d/m/Y') }}</div>
                            <small class="text-muted">Ngày thêm</small>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-primary btn-lg" disabled>
                        <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ hàng
                    </button>
                    <a href="{{ route('client.products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Thông tin chi tiết</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="150">Tên sản phẩm:</th>
                                        <td>{{ $product->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Giá:</th>
                                        <td class="fw-bold text-primary">{{ number_format($product->price) }} VND</td>
                                    </tr>
                                    <tr>
                                        <th>Tồn kho:</th>
                                        <td>{{ $product->stock }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="150">Danh mục:</th>
                                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày tạo:</th>
                                        <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày cập nhật:</th>
                                        <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
