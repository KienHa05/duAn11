@extends('admin.layout')

@section('title', 'Thêm sản phẩm mới')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-base-900">Thêm sản phẩm mới</h1>
            <p class="text-sm text-base-600 mt-1">Tạo sản phẩm mới cho cửa hàng của bạn</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-ghost btn-circle">
            <x-heroicon-o-x-mark class="w-6 h-6" />
        </a>
    </div>

    <!-- Main Form Card -->
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Main Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info Card -->
                <div class="card bg-base-100 shadow-md border border-base-200">
                    <div class="card-body">
                        <h2 class="card-title text-lg font-bold flex items-center gap-2">
                            <x-heroicon-o-information-circle class="w-5 h-5 text-primary" />
                            Thông tin cơ bản
                        </h2>

                        <!-- Product Name -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Tên sản phẩm <span class="text-error">*</span></span>
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                placeholder="Nhập tên sản phẩm (VD: Áo thun nam cộc tay)"
                                class="input input-bordered focus:input-primary transition @error('name') input-error @enderror"
                                value="{{ old('name') }}" 
                                required>
                            @error('name')
                                <label class="label">
                                    <span class="label-text-alt text-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-medium">Mô tả sản phẩm</span>
                            </label>
                            <textarea 
                                name="description" 
                                placeholder="Nhập mô tả chi tiết về sản phẩm..."
                                rows="4"
                                class="textarea textarea-bordered focus:textarea-primary transition @error('description') textarea-error @enderror">{{ old('description') }}</textarea>
                            <label class="label">
                                <span class="label-text-alt text-base-600">Tối đa 500 ký tự</span>
                            </label>
                            @error('description')
                                <label class="label">
                                    <span class="label-text-alt text-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing & Inventory Card -->
                <div class="card bg-base-100 shadow-md border border-base-200">
                    <div class="card-body">
                        <h2 class="card-title text-lg font-bold flex items-center gap-2">
                            <x-heroicon-o-currency-dollar class="w-5 h-5 text-success" />
                            Giá & Tồn kho
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Price -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Giá bán (đ) <span class="text-error">*</span></span>
                                </label>
                                <input 
                                    type="number" 
                                    name="price" 
                                    placeholder="0"
                                    class="input input-bordered focus:input-primary transition @error('price') input-error @enderror"
                                    value="{{ old('price') }}" 
                                    min="0"
                                    required>
                                @error('price')
                                    <label class="label">
                                        <span class="label-text-alt text-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Stock -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Tồn kho (cái) <span class="text-error">*</span></span>
                                </label>
                                <input 
                                    type="number" 
                                    name="stock" 
                                    placeholder="0"
                                    class="input input-bordered focus:input-primary transition @error('stock') input-error @enderror"
                                    value="{{ old('stock') }}" 
                                    min="0"
                                    required>
                                @error('stock')
                                    <label class="label">
                                        <span class="label-text-alt text-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Specifications Card -->
                <div class="card bg-base-100 shadow-md border border-base-200">
                    <div class="card-body">
                        <h2 class="card-title text-lg font-bold flex items-center gap-2">
                            <x-heroicon-o-adjustments-horizontal class="w-5 h-5 text-info" />
                            Thông số sản phẩm
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Size -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Kích cỡ</span>
                                </label>
                                <select 
                                    name="size" 
                                    class="select select-bordered focus:select-primary transition @error('size') select-error @enderror">
                                    <option value="">-- Chọn kích cỡ --</option>
                                    <option value="XS" {{ old('size') == 'XS' ? 'selected' : '' }}>XS (Extra Small)</option>
                                    <option value="S" {{ old('size') == 'S' ? 'selected' : '' }}>S (Small)</option>
                                    <option value="M" {{ old('size') == 'M' ? 'selected' : '' }}>M (Medium)</option>
                                    <option value="L" {{ old('size') == 'L' ? 'selected' : '' }}>L (Large)</option>
                                    <option value="XL" {{ old('size') == 'XL' ? 'selected' : '' }}>XL (Extra Large)</option>
                                    <option value="2XL" {{ old('size') == '2XL' ? 'selected' : '' }}>2XL</option>
                                    <option value="3XL" {{ old('size') == '3XL' ? 'selected' : '' }}>3XL</option>
                                </select>
                                @error('size')
                                    <label class="label">
                                        <span class="label-text-alt text-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <!-- Color -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-medium">Màu sắc</span>
                                </label>
                                <select 
                                    name="color" 
                                    class="select select-bordered focus:select-primary transition @error('color') select-error @enderror">
                                    <option value="">-- Chọn màu --</option>
                                    <option value="Đen" {{ old('color') == 'Đen' ? 'selected' : '' }}>Đen</option>
                                    <option value="Trắng" {{ old('color') == 'Trắng' ? 'selected' : '' }}>Trắng</option>
                                    <option value="Xám" {{ old('color') == 'Xám' ? 'selected' : '' }}>Xám</option>
                                    <option value="Đỏ" {{ old('color') == 'Đỏ' ? 'selected' : '' }}>Đỏ</option>
                                    <option value="Xanh dương" {{ old('color') == 'Xanh dương' ? 'selected' : '' }}>Xanh dương</option>
                                    <option value="Xanh lá" {{ old('color') == 'Xanh lá' ? 'selected' : '' }}>Xanh lá</option>
                                    <option value="Vàng" {{ old('color') == 'Vàng' ? 'selected' : '' }}>Vàng</option>
                                    <option value="Hồng" {{ old('color') == 'Hồng' ? 'selected' : '' }}>Hồng</option>
                                    <option value="Tím" {{ old('color') == 'Tím' ? 'selected' : '' }}>Tím</option>
                                    <option value="Cam" {{ old('color') == 'Cam' ? 'selected' : '' }}>Cam</option>
                                </select>
                                @error('color')
                                    <label class="label">
                                        <span class="label-text-alt text-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                    </label>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Category & Image -->
            <div class="space-y-6">
                <!-- Category Card -->
                <div class="card bg-base-100 shadow-md border border-base-200">
                    <div class="card-body">
                        <h2 class="card-title text-lg font-bold flex items-center gap-2">
                            <x-heroicon-o-tag class="w-5 h-5 text-warning" />
                            Danh mục
                        </h2>

                        <div class="form-control">
                            <select 
                                name="category_id" 
                                class="select select-bordered focus:select-primary transition @error('category_id') select-error @enderror"
                                required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <label class="label">
                                    <span class="label-text-alt text-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Image Card -->
                <div class="card bg-base-100 shadow-md border border-base-200">
                    <div class="card-body">
                        <h2 class="card-title text-lg font-bold flex items-center gap-2">
                            <x-heroicon-o-photo class="w-5 h-5 text-secondary" />
                            Hình ảnh sản phẩm
                        </h2>

                        <!-- Image Preview -->
                        <div class="mb-4">
                            <div id="imagePreview" class="w-full h-64 bg-base-200 rounded-lg border-2 border-dashed border-base-300 flex items-center justify-center overflow-hidden">
                                <div class="text-center">
                                    <x-heroicon-o-photo class="w-12 h-12 mx-auto text-base-400 mb-2" />
                                    <p class="text-sm text-base-600">Chưa chọn ảnh</p>
                                </div>
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="form-control">
                            <label class="label cursor-pointer border-2 border-dashed border-base-300 rounded-lg p-4 hover:border-primary transition active:scale-95">
                                <span class="label-text font-medium flex items-center gap-2">
                                    <x-heroicon-o-arrow-up-tray class="w-5 h-5" />
                                    Tải lên ảnh
                                </span>
                                <input 
                                    type="file" 
                                    name="image" 
                                    id="imageInput"
                                    accept="image/*"
                                    class="hidden"
                                    @error('image') aria-invalid="true" @enderror>
                            </label>
                            <label class="label">
                                <span class="label-text-alt text-base-600">JPG, PNG, GIF tối đa 2MB</span>
                            </label>
                            @error('image')
                                <label class="label">
                                    <span class="label-text-alt text-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Remove Image Button -->
                        <button type="button" id="removeImageBtn" class="btn btn-sm btn-ghost w-full hidden">
                            <x-heroicon-o-trash class="w-4 h-4" />
                            Xóa ảnh
                        </button>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="alert alert-info">
                    <x-heroicon-o-information-circle class="w-6 h-6 stroke-current" />
                    <div class="text-sm">
                        <p class="font-bold">Mẹo:</p>
                        <p>Tất cả các trường có dấu <span class="text-error">*</span> là bắt buộc phải điền.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="card bg-base-100 shadow-md border border-base-200">
            <div class="card-body">
                <div class="flex flex-col sm:flex-row gap-3 justify-end">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-ghost order-2 sm:order-1">
                        <x-heroicon-o-x-mark class="w-5 h-5" />
                        Hủy
                    </a>
                    <button type="submit" class="btn btn-primary order-1 sm:order-2">
                        <x-heroicon-o-check-circle class="w-5 h-5" />
                        Tạo sản phẩm
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const removeImageBtn = document.getElementById('removeImageBtn');

    // Handle image selection
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                imagePreview.innerHTML = `<img src="${event.target.result}" class="w-full h-full object-cover" alt="Preview">`;
                removeImageBtn.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    // Handle remove image
    removeImageBtn.addEventListener('click', function() {
        imageInput.value = '';
        imagePreview.innerHTML = `
            <div class="text-center">
                <svg class="w-12 h-12 mx-auto text-base-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-sm text-base-600">Chưa chọn ảnh</p>
            </div>
        `;
        removeImageBtn.classList.add('hidden');
    });

    // Handle drag and drop
    imagePreview.addEventListener('dragover', function(e) {
        e.preventDefault();
        imagePreview.classList.add('border-primary', 'bg-primary/5');
    });

    imagePreview.addEventListener('dragleave', function() {
        imagePreview.classList.remove('border-primary', 'bg-primary/5');
    });

    imagePreview.addEventListener('drop', function(e) {
        e.preventDefault();
        imagePreview.classList.remove('border-primary', 'bg-primary/5');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            imageInput.files = files;
            imageInput.dispatchEvent(new Event('change', { bubbles: true }));
        }
    });
});
</script>
@endsection
