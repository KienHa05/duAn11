@extends('admin.layout')

@section('title', 'Chỉnh sửa: ' . $category->name)

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-ghost btn-circle" title="Quay lại">
            <x-heroicon-o-arrow-left class="w-6 h-6" />
        </a>
        <div>
            <h1 class="text-4xl font-bold">Chỉnh sửa danh mục</h1>
            <p class="text-base-content/60 mt-1">{{ $category->name }}</p>
        </div>
    </div>

    <!-- Main Form Panel -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Form (2/3) -->
        <div class="lg:col-span-2">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" id="categoryForm" class="space-y-6">
                @csrf
                @method('PUT')

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
                                value="{{ old('name', $category->name) }}" 
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

                <!-- Update Info Alert -->
                <div class="alert alert-warning">
                    <x-heroicon-o-exclamation-triangle class="w-5 h-5 stroke-current" />
                    <div>
                        <h3 class="font-bold text-sm">⚠️ Lưu ý</h3>
                        <ul class="text-xs mt-1 space-y-1">
                            <li>✓ Thay đổi sẽ áp dụng cho tất cả sản phẩm trong danh mục</li>
                            <li>✓ Tên danh mục phải là duy nhất</li>
                            <li>✓ Bạn có thể hoàn tác bất cứ lúc nào</li>
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
                        Cập nhật danh mục
                    </button>
                    <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-ghost gap-2">
                        <x-heroicon-o-x-mark class="w-5 h-5" />
                        Hủy
                    </a>
                </div>
            </form>
        </div>

        <!-- Right Sidebar - Info & Audit Trail (1/3) -->
        <div class="space-y-6">
            <!-- Quick Info Card -->
            <div class="card bg-base-100 shadow-md sticky top-6">
                <div class="card-body">
                    <h3 class="card-title text-lg">Thông tin</h3>
                    <div class="divider my-2"></div>

                    <div class="space-y-4 text-sm">
                        <!-- Current Name -->
                        <div>
                            <p class="font-semibold text-base-content/60 text-xs uppercase mb-1">Tên hiện tại</p>
                            <p class="text-base font-semibold">{{ $category->name }}</p>
                        </div>

                        <!-- Product Count -->
                        <div class="flex gap-3 p-3 bg-primary/10 rounded-lg">
                            <x-heroicon-o-shopping-bag class="w-5 h-5 text-primary flex-shrink-0 mt-0.5" />
                            <div>
                                <p class="font-semibold text-primary">Sản phẩm liên kết</p>
                                <p class="text-primary/80 text-xs mt-0.5">{{ $category->products()->count() }} sản phẩm</p>
                            </div>
                        </div>

                        <!-- Created At -->
                        <div>
                            <p class="font-semibold text-base-content/60 text-xs uppercase mb-1">Ngày tạo</p>
                            <p class="text-base">{{ $category->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <!-- Updated At -->
                        <div>
                            <p class="font-semibold text-base-content/60 text-xs uppercase mb-1">Lần cập nhật cuối</p>
                            <p class="text-base">{{ $category->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Category ID Badge -->
                    <div class="mt-4 pt-4 border-t border-base-200">
                        <p class="text-xs font-semibold text-base-content/60 uppercase mb-2">ID Danh Mục</p>
                        <div class="badge badge-lg badge-outline w-full justify-center">
                            #{{ $category->id }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Info Card -->
            <div class="card bg-info/10 shadow-md border border-info/20">
                <div class="card-body">
                    <h3 class="card-title text-lg text-info flex items-center gap-2">
                        <x-heroicon-o-light-bulb class="w-5 h-5" />
                        Mẹo
                    </h3>
                    <div class="divider my-2"></div>

                    <ul class="text-sm space-y-2 text-base-content/70">
                        <li class="flex gap-2">
                            <span class="text-primary font-bold">✓</span>
                            <span>Đặt tên ngắn gọn và dễ hiểu</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="text-primary font-bold">✓</span>
                            <span>Tránh sử dụng ký tự đặc biệt</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="text-primary font-bold">✓</span>
                            <span>Kiểm tra lại tên trước khi lưu</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Danger Zone Card -->
            <div class="card bg-error/10 shadow-md border border-error/20">
                <div class="card-body">
                    <h3 class="card-title text-lg text-error flex items-center gap-2">
                        <x-heroicon-o-exclamation-circle class="w-5 h-5" />
                        Vùng nguy hiểm
                    </h3>
                    <div class="divider my-2"></div>

                    <p class="text-sm text-base-content/70 mb-4">Xóa danh mục này không thể hoàn tác.</p>
                    
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa danh mục này?\nSản phẩm sẽ được giữ lại.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-error btn-sm w-full gap-2">
                            <x-heroicon-o-trash class="w-4 h-4" />
                            Xóa danh mục
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
