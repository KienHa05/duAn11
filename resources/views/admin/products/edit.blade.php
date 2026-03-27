@extends('admin.layout')

@section('title', 'Chỉnh sửa: ' . $product->name)

@section('content')
<div class="container mx-auto">
<!-- Header -->
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-ghost btn-sm gap-2 w-fit">
            <x-heroicon-o-arrow-left class="w-5 h-5" /> Quay lại
        </a>
        <h1 class="text-3xl font-bold text-base-900">Chỉnh sửa sản phẩm</h1>
        <p class="text-base-600 mt-1">{{ $product->name }}</p>
    </div>
</div>

<!-- Form -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Form -->
    <div class="lg:col-span-2 space-y-4">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" id="productForm" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Thông tin cơ bản -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title text-lg mb-4">
                        <x-heroicon-o-information-circle class="w-5 h-5 text-primary" /> Thông tin cơ bản
                    </h2>

                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text font-semibold">Tên sản phẩm <span class="text-error">*</span></span>
                        </label>
                        <input type="text" name="name" placeholder="VD: Áo thun nam cộc tay" 
                            class="input input-bordered focus:input-primary @error('name') input-error @enderror" 
                            value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Mô tả sản phẩm</span>
                        </label>
                        <textarea name="description" placeholder="Mô tả chi tiết..." rows="4" 
                            class="textarea textarea-bordered focus:textarea-primary @error('description') textarea-error @enderror">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Giá & Tồn kho -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title text-lg mb-4">
                        <x-heroicon-o-currency-dollar class="w-5 h-5 text-success" /> Giá & Tồn kho
                    </h2>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Giá (₫) <span class="text-error">*</span></span>
                            </label>
                            <input type="number" name="price" placeholder="0" min="0"
                                class="input input-bordered focus:input-primary @error('price') input-error @enderror" 
                                value="{{ old('price', $product->price) }}" required>
                            @error('price')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Tồn kho (cái) <span class="text-error">*</span></span>
                            </label>
                            <input type="number" name="stock" placeholder="0" min="0"
                                class="input input-bordered focus:input-primary @error('stock') input-error @enderror" 
                                value="{{ old('stock', $product->stock) }}" required>
                            @error('stock')
                                <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thông số sản phẩm -->
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title text-lg mb-4">
                        <x-heroicon-o-adjustments-horizontal class="w-5 h-5 text-info" /> Thông số sản phẩm
                    </h2>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Kích cỡ</span>
                            </label>
                            <select name="size" class="select select-bordered focus:select-primary @error('size') select-error @enderror">
                                <option value="">-- Chọn kích cỡ --</option>
                                <option value="XS" {{ old('size', $product->size) == 'XS' ? 'selected' : '' }}>XS (Extra Small)</option>
                                <option value="S" {{ old('size', $product->size) == 'S' ? 'selected' : '' }}>S (Small)</option>
                                <option value="M" {{ old('size', $product->size) == 'M' ? 'selected' : '' }}>M (Medium)</option>
                                <option value="L" {{ old('size', $product->size) == 'L' ? 'selected' : '' }}>L (Large)</option>
                                <option value="XL" {{ old('size', $product->size) == 'XL' ? 'selected' : '' }}>XL (Extra Large)</option>
                                <option value="2XL" {{ old('size', $product->size) == '2XL' ? 'selected' : '' }}>2XL</option>
                                <option value="3XL" {{ old('size', $product->size) == '3XL' ? 'selected' : '' }}>3XL</option>
                            </select>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Màu sắc</span>
                            </label>
                            <select name="color" class="select select-bordered focus:select-primary @error('color') select-error @enderror">
                                <option value="">-- Chọn màu --</option>
                                <option value="Đen" {{ old('color', $product->color) == 'Đen' ? 'selected' : '' }}>Đen</option>
                                <option value="Trắng" {{ old('color', $product->color) == 'Trắng' ? 'selected' : '' }}>Trắng</option>
                                <option value="Xám" {{ old('color', $product->color) == 'Xám' ? 'selected' : '' }}>Xám</option>
                                <option value="Đỏ" {{ old('color', $product->color) == 'Đỏ' ? 'selected' : '' }}>Đỏ</option>
                                <option value="Xanh dương" {{ old('color', $product->color) == 'Xanh dương' ? 'selected' : '' }}>Xanh dương</option>
                                <option value="Xanh lá" {{ old('color', $product->color) == 'Xanh lá' ? 'selected' : '' }}>Xanh lá</option>
                                <option value="Vàng" {{ old('color', $product->color) == 'Vàng' ? 'selected' : '' }}>Vàng</option>
                                <option value="Hồng" {{ old('color', $product->color) == 'Hồng' ? 'selected' : '' }}>Hồng</option>
                                <option value="Tím" {{ old('color', $product->color) == 'Tím' ? 'selected' : '' }}>Tím</option>
                                <option value="Cam" {{ old('color', $product->color) == 'Cam' ? 'selected' : '' }}>Cam</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Sidebar -->
    <div class="space-y-4">
        <!-- Danh mục -->
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title text-base mb-4">
                    <x-heroicon-o-tag class="w-5 h-5 text-warning" /> Danh mục
                </h2>
                <div class="form-control">
                    <select name="category_id" form="productForm" class="select select-bordered focus:select-primary @error('category_id') select-error @enderror" required>
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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

        <!-- Hình ảnh -->
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title text-base mb-4">
                    <x-heroicon-o-photo class="w-5 h-5 text-secondary" /> Hình ảnh
                </h2>

                <div id="imagePreview" class="w-full h-40 bg-base-200 rounded-lg border-2 border-dashed border-base-300 flex items-center justify-center mb-3 overflow-hidden">
                    @if($product->image)
                        <img src="{{ $product->image_url }}" class="w-full h-full object-cover" />
                    @else
                        <div class="text-center">
                            <x-heroicon-o-photo class="w-12 h-12 mx-auto text-base-400 mb-2" />
                            <p class="text-sm text-base-600">Chọn ảnh</p>
                        </div>
                    @endif
                </div>

                <input type="file" name="image" id="imageInput" form="productForm" accept="image/*" class="hidden">
                <button type="button" id="pickImageBtn" class="btn btn-outline w-full gap-2">
                    <x-heroicon-o-arrow-up-tray class="w-5 h-5" /> Đổi ảnh sản phẩm
                </button>
                @error('image')
                    <div class="mt-2 text-sm text-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-2">
            <a href="{{ route('admin.products.index') }}" class="btn btn-ghost flex-1">Hủy</a>
            <button type="submit" form="productForm" class="btn bg-amber-400 hover:bg-amber-500 text-base-900 flex-1">
                <x-heroicon-o-check-circle class="w-5 h-5" /> Lưu
            </button>
        </div>

        <!-- Danger Zone -->
        <div class="divider my-0"></div>

        <div class="alert alert-error">
            <x-heroicon-o-exclamation-triangle class="w-6 h-6" />
            <div>
                <h3 class="font-bold">Vùng nguy hiểm</h3>
                <p class="text-sm">Xóa sản phẩm này khỏi hệ thống (không thể khôi phục)</p>
                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display: inline;" onsubmit="return confirm('Xác nhận xóa sản phẩm này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-error mt-2 gap-1">
                        <x-heroicon-o-trash class="w-4 h-4" /> Xóa sản phẩm
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<script>
const imageInput = document.getElementById('imageInput');
const imagePreview = document.getElementById('imagePreview');
const pickImageBtn = document.getElementById('pickImageBtn');

pickImageBtn.addEventListener('click', () => imageInput.click());

imageInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover" />`;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
