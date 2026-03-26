@extends('layouts.admin')

@section('title', 'Chỉnh sửa sản phẩm')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-base-content"><x-heroicon-o-pencil-square class="inline w-8 h-8 mr-3" />Chỉnh sửa sản phẩm</h1>
        <p class="text-base-content/70">{{ $product->name }}</p>
    </div>
    <div class="flex justify-center gap-4">
        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-info">
            <x-heroicon-o-eye class="w-5 h-5" /> Xem chi tiết
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-ghost">
            <x-heroicon-o-arrow-left class="w-5 h-5" /> Quay lại danh sách
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title"><x-heroicon-o-square-3-stack-3d class="w-5 h-5 mr-2" />Thông tin sản phẩm</h2>

                <form method="POST" action="{{ route('admin.products.update', $product) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Tên sản phẩm <span class="text-error">*</span></span>
                        </label>
                        <input type="text" class="input input-bordered @error('name') input-error @enderror"
                               name="name" value="{{ old('name', $product->name) }}"
                               placeholder="Nhập tên sản phẩm" required>
                        @error('name')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Giá (VND) <span class="text-error">*</span></span>
                            </label>
                            <input type="number" class="input input-bordered @error('price') input-error @enderror"
                                   name="price" value="{{ old('price', $product->price) }}"
                                   min="0" placeholder="Nhập giá" required>
                            @error('price')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text">Tồn kho <span class="text-error">*</span></span>
                            </label>
                            <input type="number" class="input input-bordered @error('stock') input-error @enderror"
                                   name="stock" value="{{ old('stock', $product->stock) }}"
                                   min="0" placeholder="Nhập số lượng" required>
                            @error('stock')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <div class="form-control w-full mb-6">
                        <label class="label">
                            <span class="label-text">Danh mục <span class="text-error">*</span></span>
                        </label>
                        <select class="select select-bordered @error('category_id') select-error @enderror"
                                name="category_id" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="flex justify-center gap-4">
                        <button type="submit" class="btn btn-primary">
                            <x-heroicon-o-check-circle class="w-5 h-5" /> Cập nhật sản phẩm
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-ghost">
                            <x-heroicon-o-x-mark class="w-5 h-5" /> Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="card bg-error text-error-content shadow-xl">
            <div class="card-body">
                <h2 class="card-title"><x-heroicon-o-exclamation-triangle class="w-5 h-5 mr-2" />Vùng nguy hiểm</h2>
                <p class="mb-4">Hành động này không thể hoàn tác.</p>
                <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-error w-full">
                        <x-heroicon-o-trash class="w-5 h-5 mr-2" />Xóa sản phẩm vĩnh viễn
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
