@extends('admin.layout')

@section('title', 'Thêm sản phẩm')

@section('content')
<div class="container mx-auto max-w-2xl">
    <div class="card bg-base-100">
        <div class="card-body">
            <h2 class="card-title">
                <x-heroicon-o-plus class="w-5 h-5" /> Thêm sản phẩm mới
            </h2>

            <form action="{{ route('admin.products.store') }}" method="POST">
                @csrf

                <div class="form-control w-full max-w-md mx-auto">
                    <label class="label">
                        <span class="label-text">Tên sản phẩm</span>
                    </label>
                    <input type="text" name="name" class="input input-bordered" required
                           value="{{ old('name') }}" placeholder="Nhập tên sản phẩm">
                    @error('name')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Giá</span>
                    </label>
                    <input type="number" name="price" class="input input-bordered" required
                           value="{{ old('price') }}" step="0.01" placeholder="Nhập giá">
                    @error('price')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Tồn kho</span>
                    </label>
                    <input type="number" name="stock" class="input input-bordered" required
                           value="{{ old('stock') }}" placeholder="Nhập số lượng tồn kho">
                    @error('stock')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Danh mục</span>
                    </label>
                    <select name="category_id" class="select select-bordered" required>
                        <option value="">Chọn danh mục</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-control mt-6">
                    <div class="flex justify-center gap-4">
                        <button type="submit" class="btn btn-primary">
                            <x-heroicon-o-check-circle class="w-5 h-5" /> Tạo sản phẩm
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-ghost">
                            <x-heroicon-o-x-mark class="w-5 h-5" /> Hủy
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
</div>
@endsection
