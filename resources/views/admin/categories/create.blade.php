@extends('admin.layout')

@section('title', 'Thêm danh mục')

@section('content')
<div class="container mx-auto max-w-2xl">
    <div class="card bg-base-100">
        <div class="card-body">
            <h2 class="card-title">
                <x-heroicon-o-plus class="w-5 h-5" /> Thêm danh mục mới
            </h2>

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="form-control w-full max-w-md mx-auto">
                    <label class="label">
                        <span class="label-text">Tên danh mục</span>
                    </label>
                    <input type="text" name="name" class="input input-bordered" required
                           value="{{ old('name') }}" placeholder="Nhập tên danh mục">
                    @error('name')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-control mt-6">
                    <div class="flex justify-center gap-4">
                        <button type="submit" class="btn btn-primary">
                            <x-heroicon-o-check-circle class="w-5 h-5" /> Tạo danh mục
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
