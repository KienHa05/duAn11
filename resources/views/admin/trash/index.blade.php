@extends('admin.layout')

@section('title', 'Thùng rác')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold">Thùng rác</h1>
            <p class="text-sm text-base-content/60 mt-1">Quản lý dữ liệu đã xóa mềm</p>
        </div>
    </div>

    <div role="tablist" class="tabs tabs-lifted">
        <input type="radio" name="trash_tabs" role="tab" class="tab" aria-label="Sản phẩm" checked>
        <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-4">
                <div>
                    <h2 class="text-xl font-bold">Sản phẩm đã xóa</h2>
                    <p class="text-sm text-base-content/60">Chỉ hiển thị sản phẩm trong thùng rác</p>
                </div>
                <form method="GET" action="{{ route('admin.trash.index') }}" class="join">
                    @if($categorySearch)
                        <input type="hidden" name="category_search" value="{{ $categorySearch }}">
                    @endif
                    <input type="text" name="product_search" value="{{ $productSearch }}" placeholder="Tìm sản phẩm" class="input input-bordered input-sm join-item">
                    <button type="submit" class="btn btn-primary btn-sm join-item">Tìm</button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="table table-zebra table-xs sm:table-sm lg:table-md w-full">
                    <thead>
                        <tr class="bg-base-200 hover:bg-base-200">
                            <th class="font-bold">ID</th>
                            <th class="font-bold">Tên</th>
                            <th class="font-bold">Ngày xóa</th>
                            <th class="font-bold text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr class="hover:bg-base-200 transition">
                                <td class="font-medium">{{ $product->id }}</td>
                                <td><div class="font-semibold text-base-content">{{ $product->name }}</div></td>
                                <td class="text-sm text-base-content/70">{{ $product->deleted_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center">
                                    <div class="flex justify-center gap-2 flex-wrap">
                                        <form action="{{ route('admin.trash.products.restore', $product->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-xs gap-1" onclick="return confirm('Khôi phục sản phẩm này?')">
                                                <x-heroicon-o-arrow-path class="w-4 h-4" />
                                                <span class="hidden sm:inline">Khôi phục</span>
                                            </button>
                                        </form>
                                        @if($product->order_items_count > 0)
                                            <button type="button" class="btn btn-error btn-xs gap-1" disabled title="Đã có đơn hàng, không thể xóa vĩnh viễn">
                                                <x-heroicon-o-trash class="w-4 h-4" />
                                                <span class="hidden sm:inline">Xóa vĩnh viễn</span>
                                            </button>
                                        @else
                                            <form action="{{ route('admin.trash.products.force-delete', $product->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-error btn-xs gap-1" onclick="return confirm('Xóa vĩnh viễn sản phẩm này?')">
                                                    <x-heroicon-o-trash class="w-4 h-4" />
                                                    <span class="hidden sm:inline">Xóa vĩnh viễn</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-8">
                                    <div class="flex flex-col items-center gap-3">
                                        <x-heroicon-o-inbox class="w-12 h-12 text-base-300" />
                                        <p class="text-base-content/60 font-medium">Không có sản phẩm đã xóa</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="border-t border-base-200 pt-4 mt-4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>

        <input type="radio" name="trash_tabs" role="tab" class="tab" aria-label="Danh mục">
        <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-4">
                <div>
                    <h2 class="text-xl font-bold">Danh mục đã xóa</h2>
                    <p class="text-sm text-base-content/60">Chỉ hiển thị danh mục trong thùng rác</p>
                </div>
                <form method="GET" action="{{ route('admin.trash.index') }}" class="join">
                    @if($productSearch)
                        <input type="hidden" name="product_search" value="{{ $productSearch }}">
                    @endif
                    <input type="text" name="category_search" value="{{ $categorySearch }}" placeholder="Tìm danh mục" class="input input-bordered input-sm join-item">
                    <button type="submit" class="btn btn-primary btn-sm join-item">Tìm</button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="table table-zebra table-xs sm:table-sm lg:table-md w-full">
                    <thead>
                        <tr class="bg-base-200 hover:bg-base-200">
                            <th class="font-bold">ID</th>
                            <th class="font-bold">Tên</th>
                            <th class="font-bold">Ngày xóa</th>
                            <th class="font-bold text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr class="hover:bg-base-200 transition">
                                <td class="font-medium">{{ $category->id }}</td>
                                <td><div class="font-semibold text-base-content">{{ $category->name }}</div></td>
                                <td class="text-sm text-base-content/70">{{ $category->deleted_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center">
                                    <div class="flex justify-center gap-2 flex-wrap">
                                        <form action="{{ route('admin.trash.categories.restore', $category->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-xs gap-1" onclick="return confirm('Khôi phục danh mục này?')">
                                                <x-heroicon-o-arrow-path class="w-4 h-4" />
                                                <span class="hidden sm:inline">Khôi phục</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.trash.categories.force-delete', $category->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-error btn-xs gap-1" onclick="return confirm('Xóa vĩnh viễn danh mục này?')">
                                                <x-heroicon-o-trash class="w-4 h-4" />
                                                <span class="hidden sm:inline">Xóa vĩnh viễn</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-8">
                                    <div class="flex flex-col items-center gap-3">
                                        <x-heroicon-o-inbox class="w-12 h-12 text-base-300" />
                                        <p class="text-base-content/60 font-medium">Không có danh mục đã xóa</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($categories->hasPages())
                <div class="border-t border-base-200 pt-4 mt-4">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection