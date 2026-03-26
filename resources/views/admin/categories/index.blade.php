@extends('admin.layout')

@section('title', 'Danh mục')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Danh mục</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <x-heroicon-o-plus class="w-5 h-5" /> Thêm danh mục
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
                            <th>Tên danh mục</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="flex justify-center gap-1">
                                        <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm btn-info btn-outline" title="Xem chi tiết">
                                            <x-heroicon-o-eye class="w-5 h-5" />
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning btn-outline" title="Sửa">
                                            <x-heroicon-o-pencil-square class="w-5 h-5" />
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-error btn-outline" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')" title="Xóa">
                                                <x-heroicon-o-trash class="w-5 h-5" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection
