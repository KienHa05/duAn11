@extends('admin.layout')

@section('title', 'Sản phẩm')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Sản phẩm</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <x-heroicon-o-plus class="w-5 h-5" /> Thêm sản phẩm
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">
            <x-heroicon-o-check-circle class="w-5 h-5" />
            {{ session('success') }}
        </div>
    @endif

    <div class="card bg-base-100">
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Tồn kho</th>
                            <th>Danh mục</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ number_format($product->price) }} VND</td>
                                <td>{{ $product->stock }}</td>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                <td>
                                    <div class="flex justify-center gap-1">
                                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-info btn-outline" title="Xem chi tiết">
                                            <x-heroicon-o-eye class="w-5 h-5" />
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning btn-outline" title="Sửa">
                                            <x-heroicon-o-pencil-square class="w-5 h-5" />
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-error btn-outline" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                                <x-heroicon-o-trash class="w-5 h-5" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
