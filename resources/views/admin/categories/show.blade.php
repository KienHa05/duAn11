@extends('admin.layout')

@section('title', 'Chi tiết danh mục')

@section('content')
<div class="container mx-auto max-w-2xl">
    <div class="card bg-base-100">
        <div class="card-body">
            <h2 class="card-title">
                <x-heroicon-o-tag class="w-5 h-5" /> Chi tiết danh mục
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <strong>ID:</strong> {{ $category->id }}
                </div>
                <div>
                    <strong>Tên:</strong> {{ $category->name }}
                </div>
                <div>
                    <strong>Ngày tạo:</strong> {{ $category->created_at->format('d/m/Y H:i') }}
                </div>
                <div>
                    <strong>Ngày cập nhật:</strong> {{ $category->updated_at->format('d/m/Y H:i') }}
                </div>
            </div>

            <div class="card-actions justify-center mt-6">
                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">
                    <x-heroicon-o-pencil-square class="w-5 h-5" /> Sửa
                </a>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost">
                    <x-heroicon-o-arrow-left class="w-5 h-5" /> Quay lại danh sách
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
