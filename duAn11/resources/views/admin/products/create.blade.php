@extends('admin.layout')

@section('title', 'Thêm sản phẩm mới')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.products.index') }}" class="btn btn-ghost btn-circle">
            <x-heroicon-o-arrow-left class="w-6 h-6" />
        </a>
        <div>
            <h1 class="text-4xl font-bold">Thêm sản phẩm mới</h1>
            <p class="text-base-content/60 mt-1">Điền đầy đủ thông tin sản phẩm và tải lên ảnh</p>
        </div>
    </div>

    <!-- Main Form Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Main Form (2/3) -->
        <div class="lg:col-span-2 space-y-6">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm" class="space-y-6">
                @csrf

                <!-- Basic Information Card -->
                <div class="card bg-base-100 shadow-md">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-primary/10 rounded-lg">
                                <x-heroicon-o-information-circle class="w-6 h-6 text-primary" />
                            </div>
                            <h2 class="card-title text-xl">Thông tin cơ bản</h2>
                        </div>

                        <div class="form-control mb-4">
                            <label class="label">
                                <span class="label-text font-semibold">Tên sản phẩm <span class="text-error">*</span></span>
                            </label>
                            <input type="text" name="name" placeholder="Nhập tên sản phẩm..." 
                                class="input input-bordered focus:input-primary text-base @error('name') input-error @enderror" 
                                value="{{ old('name') }}" required>
                            @error('name')
                                <label class="label"><span class="label-text-alt text-error flex items-center gap-1"><x-heroicon-o-exclamation-circle class="w-4 h-4" />{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Mô tả sản phẩm</span>
                            </label>
                            <textarea name="description" placeholder="Mô tả chi tiết sản phẩm..." rows="4" 
                                class="textarea textarea-bordered focus:textarea-primary text-base @error('description') textarea-error @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Price & Stock Card -->
                <div class="card bg-base-100 shadow-md">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-success/10 rounded-lg">
                                <x-heroicon-o-currency-dollar class="w-6 h-6 text-success" />
                            </div>
                            <h2 class="card-title text-xl">Giá & Tồn kho</h2>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold">Giá (₫) <span class="text-error">*</span></span>
                                </label>
                                <input type="number" name="price" placeholder="0" min="0" step="1000"
                                    class="input input-bordered focus:input-primary text-base @error('price') input-error @enderror" 
                                    value="{{ old('price') }}" required>
                                @error('price')
                                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                                @enderror
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold">Tồn kho (cái) <span class="text-error">*</span></span>
                                </label>
                                <input type="number" name="stock" placeholder="0" min="0"
                                    class="input input-bordered focus:input-primary text-base @error('stock') input-error @enderror" 
                                    value="{{ old('stock') }}" required>
                                @error('stock')
                                    <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Specification Card -->
                <div class="card bg-base-100 shadow-md">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-info/10 rounded-lg">
                                <x-heroicon-o-adjustments-horizontal class="w-6 h-6 text-info" />
                            </div>
                            <h2 class="card-title text-xl">Thông số sản phẩm</h2>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold">Kích cỡ</span>
                                </label>
                                <select name="size" class="select select-bordered focus:select-primary text-base @error('size') select-error @enderror">
                                    <option value="">-- Chọn kích cỡ --</option>
                                    <option value="XS" {{ old('size') == 'XS' ? 'selected' : '' }}>XS</option>
                                    <option value="S" {{ old('size') == 'S' ? 'selected' : '' }}>S</option>
                                    <option value="M" {{ old('size') == 'M' ? 'selected' : '' }}>M</option>
                                    <option value="L" {{ old('size') == 'L' ? 'selected' : '' }}>L</option>
                                    <option value="XL" {{ old('size') == 'XL' ? 'selected' : '' }}>XL</option>
                                    <option value="2XL" {{ old('size') == '2XL' ? 'selected' : '' }}>2XL</option>
                                    <option value="3XL" {{ old('size') == '3XL' ? 'selected' : '' }}>3XL</option>
                                </select>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold">Màu sắc</span>
                                </label>
                                <select name="color" class="select select-bordered focus:select-primary text-base @error('color') select-error @enderror">
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
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right Sidebar (1/3) -->
        <div class="space-y-6">
            <!-- Category Card -->
            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 bg-warning/10 rounded-lg">
                            <x-heroicon-o-tag class="w-6 h-6 text-warning" />
                        </div>
                        <h2 class="card-title text-lg">Danh mục</h2>
                    </div>
                    <div class="form-control">
                        <select name="category_id" form="productForm" class="select select-bordered focus:select-primary text-base @error('category_id') select-error @enderror" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Image Upload Card -->
            <div class="card bg-base-100 shadow-md">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 bg-secondary/10 rounded-lg">
                            <x-heroicon-o-photo class="w-6 h-6 text-secondary" />
                        </div>
                        <h2 class="card-title text-lg">Ảnh sản phẩm</h2>
                    </div>

                    <!-- Preview Area -->
                    <div id="imagePreview" class="w-full aspect-square bg-gradient-to-br from-base-200 to-base-300 rounded-xl border-2 border-dashed border-base-400 flex items-center justify-center mb-4 overflow-hidden cursor-pointer transition hover:border-primary hover:from-primary/5 hover:to-primary/10 group">
                        <div class="text-center pointer-events-none group-hover:scale-105 transition">
                            <div class="p-3 bg-base-300 rounded-full inline-block mb-3 group-hover:bg-primary/20 transition">
                                <x-heroicon-o-photo class="w-8 h-8 text-base-500 group-hover:text-primary transition" />
                            </div>
                            <p class="text-sm font-medium text-base-700">Kéo ảnh vào đây</p>
                            <p class="text-xs text-base-500 mt-1">hoặc nhấp để chọn</p>
                        </div>
                    </div>

                    <input type="file" name="image" id="imageInput" form="productForm" accept="image/*" class="hidden" />
                    
                    <!-- Action Buttons -->
                    <div class="flex gap-2 mb-3">
                        <button type="button" onclick="document.getElementById('imageInput').click()" class="btn btn-primary w-full gap-2">
                            <x-heroicon-o-arrow-up-tray class="w-5 h-5" /> Chọn ảnh
                        </button>
                        <button type="button" id="clearImageBtn" class="btn btn-ghost btn-square hidden">
                            <x-heroicon-o-x-mark class="w-5 h-5" />
                        </button>
                    </div>

                    @error('image')
                        <div class="alert alert-error">
                            <x-heroicon-o-exclamation-circle class="w-5 h-5" />
                            <span>{{ $message }}</span>
                        </div>
                    @enderror

                    <div class="text-xs text-base-500 bg-base-200 rounded-lg p-2">
                        <p class="font-semibold mb-1">📋 Yêu cầu:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Định dạng: JPG, PNG, GIF</li>
                            <li>Dung lượng: Tối đa 5MB</li>
                            <li>Kích thước: Tối ưu 800x600px</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col gap-3">
                <button type="submit" form="productForm" class="btn btn-primary btn-lg gap-2">
                    <x-heroicon-o-check-circle class="w-6 h-6" /> Tạo sản phẩm
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-lg">
                    <x-heroicon-o-arrow-left class="w-6 h-6" /> Hủy
                </a>
            </div>
        </div>
    </div>
</div>

<script>
const imageInput = document.getElementById('imageInput');
const imagePreview = document.getElementById('imagePreview');
const clearBtn = document.getElementById('clearImageBtn');
const selectBtn = document.querySelector('button[onclick*="imageInput"]');

imageInput.addEventListener('change', handleImageSelect);
imagePreview.addEventListener('dragover', handleDragOver);
imagePreview.addEventListener('dragleave', handleDragLeave);
imagePreview.addEventListener('drop', handleDrop);
imagePreview.addEventListener('click', () => imageInput.click());
clearBtn.addEventListener('click', clearImage);

function handleImageSelect(e) {
    const file = e.target.files[0];
    if (!file) return;

    if (file.size > 5 * 1024 * 1024) {
        alert('❌ Ảnh vượt quá 5MB! Vui lòng chọn ảnh nhỏ hơn.');
        imageInput.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = (e) => {
        imagePreview.style.backgroundImage = `url('${e.target.result}')`;
        imagePreview.style.backgroundSize = 'cover';
        imagePreview.style.backgroundPosition = 'center';
        imagePreview.innerHTML = '';
        selectBtn.classList.add('hidden');
        clearBtn.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}

function handleDragOver(e) {
    e.preventDefault();
    e.stopPropagation();
    imagePreview.classList.add('border-primary', 'bg-primary/10');
}

function handleDragLeave(e) {
    e.preventDefault();
    e.stopPropagation();
    imagePreview.classList.remove('border-primary', 'bg-primary/10');
}

function handleDrop(e) {
    e.preventDefault();
    e.stopPropagation();
    imagePreview.classList.remove('border-primary', 'bg-primary/10');
    const files = e.dataTransfer.files;
    imageInput.files = files;
    imageInput.dispatchEvent(new Event('change'));
}

function clearImage() {
    imageInput.value = '';
    imagePreview.innerHTML = `
        <div class="text-center pointer-events-none group-hover:scale-105 transition">
            <div class="p-3 bg-base-300 rounded-full inline-block mb-3">
                <x-heroicon-o-photo class="w-8 h-8 text-base-500" />
            </div>
            <p class="text-sm font-medium text-base-700">Kéo ảnh vào đây</p>
            <p class="text-xs text-base-500 mt-1">hoặc nhấp để chọn</p>
        </div>
    `;
    imagePreview.style.backgroundImage = '';
    selectBtn.classList.remove('hidden');
    clearBtn.classList.add('hidden');
}
</script>
@endsection
