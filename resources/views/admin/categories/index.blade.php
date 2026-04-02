@extends('admin.layout')

@section('title', 'Danh mục')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold">Quản lý danh mục</h1>
            <p class="text-sm text-base-content/60 mt-1">Danh sách tất cả các danh mục sản phẩm</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary gap-2">
            <x-heroicon-o-plus class="w-5 h-5" /> 
            Thêm danh mục mới
        </a>
    </div>

    <!-- Categories Table Card -->
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table table-zebra table-xs sm:table-sm lg:table-md w-full">
                    <thead>
                        <tr class="bg-base-200 hover:bg-base-200">
                            <th class="font-bold">ID</th>
                            <th class="font-bold">Tên danh mục</th>
                            <th class="font-bold text-center">Số sản phẩm</th>
                            <th class="font-bold">Ngày tạo</th>
                            <th class="font-bold text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr class="hover:bg-base-200 transition">
                                <td class="font-medium">{{ $category->id }}</td>
                                <td>
                                    <div class="font-semibold text-base-content">{{ $category->name }}</div>
                                </td>
                                <td class="text-center">
                                    @if($category->products_count > 0)
                                        <span class="badge badge-primary gap-2">{{ $category->products_count }}</span>
                                    @else
                                        <span class="badge badge-ghost gap-2">{{ $category->products_count }}</span>
                                    @endif
                                </td>
                                <td class="text-sm text-base-content/70">
                                    {{ $category->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="text-center">
                                    <div class="flex justify-center gap-2 flex-wrap">
                                        <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-ghost btn-xs gap-1" title="Xem chi tiết">
                                            <x-heroicon-o-eye class="w-4 h-4" />
                                            <span class="hidden sm:inline">Xem</span>
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning btn-xs gap-1" title="Sửa">
                                            <x-heroicon-o-pencil-square class="w-4 h-4" />
                                            <span class="hidden sm:inline">Sửa</span>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-error btn-xs gap-1" title="Xóa" onclick="return confirm('Bạn chắc chắn muốn xóa danh mục này?')">
                                                <x-heroicon-o-trash class="w-4 h-4" />
                                                <span class="hidden sm:inline">Xóa</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-8">
                                    <div class="flex flex-col items-center gap-3">
                                        <x-heroicon-o-inbox class="w-12 h-12 text-base-300" />
                                        <p class="text-base-content/60 font-medium">Chưa có danh mục nào</p>
                                        <p class="text-sm text-base-content/50">Hãy tạo danh mục đầu tiên của bạn</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($categories->hasPages())
                <div class="border-t border-base-200 p-4">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
