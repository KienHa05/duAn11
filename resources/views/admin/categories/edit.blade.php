@extends('admin.layout')

@section('title', 'Sửa danh mục')

@section('content')
<div class="container mx-auto max-w-2xl">
    <div class="card bg-base-100">
        <div class="card-body">
            <h2 class="card-title">
                <x-heroicon-o-pencil-square class="w-5 h-5" /> Sửa danh mục
            </h2>

            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-control w-full max-w-md mx-auto">
                    <label class="label">
                        <span class="label-text">Tên danh mục</span>
                    </label>
                    <input type="text" name="name" class="input input-bordered" required
                           value="{{ old('name', $category->name) }}" placeholder="Nhập tên danh mục">
                    @error('name')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-control mt-6">
                    <div class="flex justify-center gap-4">
                        <button type="submit" class="btn btn-primary">
                            <x-heroicon-o-check-circle class="w-5 h-5" /> Cập nhật danh mục
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost">
                            <x-heroicon-o-x-mark class="w-5 h-5" /> Hủy
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
