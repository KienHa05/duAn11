@extends('admin.layout')

@section('title', 'Thêm danh mục')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost btn-circle" title="Quay lại">
            <x-heroicon-o-arrow-left class="w-6 h-6" />
        </a>
        <div>
            <h1 class="text-4xl font-bold">Thêm danh mục mới</h1>
            <p class="text-base-content/60 mt-1">Tạo một danh mục sản phẩm mới</p>
        </div>
    </div>

    <!-- Main Form Panel -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Form (2/3) -->
        <div class="lg:col-span-2">
            <form action="{{ route('admin.categories.store') }}" method="POST" id="categoryForm" class="space-y-6">
                @csrf

                <!-- Category Information Card -->
                <div class="card bg-base-100 shadow-md">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-primary/10 rounded-lg">
                                <x-heroicon-o-tag class="w-6 h-6 text-primary" />
                            </div>
                            <h2 class="card-title text-xl">Thông tin danh mục</h2>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Tên danh mục <span class="text-error">*</span></span>
                                <span class="label-text-alt text-base-content/60">Tên phải là duy nhất</span>
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                placeholder="Ví dụ: Áo phông, Quần jean, Giày..." 
                                class="input input-bordered focus:input-primary text-base @error('name') input-error @enderror" 
                                value="{{ old('name') }}" 
                                maxlength="255"
                                required>
                            @error('name')
                                <label class="label">
                                    <span class="label-text-alt text-error flex items-center gap-1">
                                        <x-heroicon-o-exclamation-circle class="w-4 h-4" />
                                        {{ $message }}
                                    </span>
                                </label>
                            @enderror
                            <label class="label">
                                <span class="label-text-alt text-base-content/50">Tối đa 255 ký tự</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Help Info Card -->
                <div class="alert alert-info">
                    <x-heroicon-o-information-circle class="w-5 h-5 stroke-current" />
                    <div>
                        <h3 class="font-bold text-sm">💡 Mẹo đặt tên danh mục</h3>
                        <ul class="text-xs mt-1 space-y-1">
                            <li>✓ Sử dụng tên ngắn gọn, dễ hiểu</li>
                            <li>✓ Để tên danh mục duy nhất (không trùng lặp)</li>
                            <li>✓ Ví dụ: Áo nam, Váy nữ, Phụ kiện, etc.</li>
                        </ul>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex gap-4 pt-4 border-t border-base-200">
                    <button 
                        type="submit" 
                        class="btn btn-primary gap-2 flex-1"
                        form="categoryForm">
                        <x-heroicon-o-check-circle class="w-5 h-5" />
                        Tạo danh mục
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-ghost gap-2">
                        <x-heroicon-o-x-mark class="w-5 h-5" />
                        Hủy
                    </a>
                </div>
            </form>
        </div>

        <!-- Right Sidebar - Summary (1/3) -->
        <div class="space-y-6">
            <!-- Quick Info Card -->
            <div class="card bg-base-100 shadow-md sticky top-6">
                <div class="card-body">
                    <h3 class="card-title text-lg">Chú ý</h3>
                    <div class="divider my-2"></div>
                    
                    <div class="space-y-4 text-sm">
                        <div class="flex gap-3">
                            <x-heroicon-o-lock-closed class="w-5 h-5 text-warning flex-shrink-0 mt-0.5" />
                            <div>
                                <p class="font-semibold">Tên duy nhất</p>
                                <p class="text-base-content/60 text-xs mt-1">Mỗi danh mục phải có tên không trùng lặp</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <x-heroicon-o-document-text class="w-5 h-5 text-info flex-shrink-0 mt-0.5" />
                            <div>
                                <p class="font-semibold">Mô tả ngắn gọn</p>
                                <p class="text-base-content/60 text-xs mt-1">Tên danh mục sẽ hiển thị để khách hàng phân loại sản phẩm</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <x-heroicon-o-check-badge class="w-5 h-5 text-success flex-shrink-0 mt-0.5" />
                            <div>
                                <p class="font-semibold">Có thể chỉnh sửa</p>
                                <p class="text-base-content/60 text-xs mt-1">Bạn có thể thay đổi danh mục sau khi tạo</p>
                            </div>
                        </div>
                    </div>

                    <!-- Icon Preview -->
                    <div class="mt-6 pt-4 border-t border-base-200">
                        <p class="text-xs font-semibold text-base-content/60 mb-3">DANH MỤC GẦN ĐÂY:</p>
                        <div class="flex flex-wrap gap-2">
                            <div class="badge badge-outline badge-sm">Áo nam</div>
                            <div class="badge badge-outline badge-sm">Giày</div>
                            <div class="badge badge-outline badge-sm">Phụ kiện</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
