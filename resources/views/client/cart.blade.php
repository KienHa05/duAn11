@extends('layouts.app')

@section('title', 'Giỏ hàng - ShopeeLike')

@section('content')
<div class="bg-[#f5f5f5] dark:bg-black min-h-screen py-8 pb-32 transition-colors duration-300">
    <div class="container mx-auto px-4 sm:px-6 max-w-7xl" x-data="{
        selectAll: false,
        selectedItems: [],
        toggleSelectAll() {
            if (this.selectAll) {
                this.selectedItems = this.items.map(item => item.id);
            } else {
                this.selectedItems = [];
            }
        },
        updateSelectAll() {
            this.selectAll = this.items.length > 0 && this.selectedItems.length === this.items.length;
        },
        get selectedTotal() {
            let total = 0;
            this.items.forEach(item => {
                if (this.selectedItems.includes(item.id)) {
                    total += item.price * item.quantity;
                }
            });
            return total;
        }
    }">
        <h1 class="text-3xl font-semibold text-black dark:text-white mb-8">
            Giỏ hàng của bạn.
        </h1>

        <!-- Header Row -->
        <div class="bg-white dark:bg-[#1d1d1f] rounded-xl shadow-sm border border-gray-200 dark:border-[#333] mb-4 items-center hidden md:flex text-gray-500 text-sm font-medium h-14 transition-colors">
            <div class="w-12 flex justify-center">
                <input type="checkbox" class="checkbox checkbox-sm border-gray-300 rounded-full checked:bg-black checked:border-black" x-model="selectAll" @change="toggleSelectAll()">
            </div>
            <div class="flex-grow pl-4">Sản Phẩm</div>
            <div class="w-32 text-center">Đơn Giá</div>
            <div class="w-32 text-center">Số Lượng</div>
            <div class="w-32 text-center">Số Tiền</div>
            <div class="w-24 text-center">Thao Tác</div>
        </div>

        <!-- Empty Cart -->
        <div x-show="items.length === 0" class="bg-white dark:bg-[#1d1d1f] rounded-xl shadow-sm border border-gray-200 dark:border-[#333] p-16 text-center transition-colors" style="display: none;">
            <div class="w-32 h-32 mx-auto mb-6 bg-slate-100 rounded-full flex flex-col items-center justify-center text-slate-300">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-slate-700 mb-2">Giỏ hàng của bạn còn trống</h2>
            <p class="text-gray-500 mb-6">Mua sắm thêm để nhận nhiều ưu đãi</p>
            <a href="/" class="px-8 py-3 bg-black dark:bg-white text-white dark:text-black rounded-full font-semibold hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors">Mua Ngay</a>
        </div>

        <!-- Cart Items -->
        <div class="bg-white dark:bg-[#1d1d1f] rounded-xl shadow-sm border border-gray-200 dark:border-[#333] transition-colors" x-show="items.length > 0">
            <div class="divide-y divide-gray-200 dark:divide-[#333]">
                <template x-for="item in items" :key="item.id">
                    <div class="flex flex-col md:flex-row items-start md:items-center p-4 hover:bg-gray-50 dark:hover:bg-[#2c2c2e] transition-colors">
                        <div class="w-12 h-full flex justify-center pt-2 md:pt-0">
                            <input type="checkbox" class="checkbox checkbox-sm border-gray-300 rounded-full checked:bg-black checked:border-black" :value="item.id" x-model="selectedItems" @change="updateSelectAll()">
                        </div>
                        
                        <div class="flex-grow flex gap-4 pl-4 w-full md:w-auto">
                            <!-- Image -->
                            <a :href="`/product/${item.id}`" class="w-20 h-20 rounded-md border border-base-200 overflow-hidden bg-base-100 flex-shrink-0">
                                <template x-if="item.image">
                                    <img :src="item.image" :alt="item.name" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!item.image">
                                    <div class="w-full h-full bg-[#f5f5f7] dark:bg-[#2c2c2e]"></div>
                                </template>
                            </a>
                            <!-- Info -->
                            <div class="flex flex-col justify-center max-w-sm">
                                <a :href="`/product/${item.id}`" class="text-base font-medium text-black dark:text-white line-clamp-2 hover:underline decoration-1 underline-offset-4" x-text="item.name"></a>
                            </div>
                        </div>

                        <div class="w-full md:w-auto flex items-center justify-between mt-4 md:mt-0 px-4 md:px-0">
                            <!-- Price mobile header -->
                            <div class="text-slate-500 text-sm line-through md:hidden mr-2 text-[10px]" x-show="item.discount > 0" x-text="item.price.toLocaleString('vi-VN') + ' ₫'"></div>
                            
                            <div class="w-32 text-center flex flex-col items-center">
                                <span class="text-slate-500 line-through text-xs mb-1" x-show="item.discount > 0" x-text="item.price.toLocaleString('vi-VN') + ' ₫'"></span>
                                <span class="text-sm font-medium" x-text="item.price.toLocaleString('vi-VN') + ' ₫'"></span>
                            </div>
                            
                            <div class="w-32 flex justify-center">
                                <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                                    <button @click="decreaseQuantity(item.id)" class="px-3 py-1.5 bg-[#f5f5f7] dark:bg-[#2c2c2e] hover:bg-gray-200 dark:hover:bg-[#3a3a3c] text-black dark:text-white transition-colors border-r border-gray-300 dark:border-gray-600">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                    </button>
                                    <input type="number" x-model.number="item.quantity" @change="if(item.quantity < 1) item.quantity = 1; cart.save()" class="w-10 text-center bg-white dark:bg-[#1d1d1f] border-0 text-sm focus:ring-0 p-0 py-1.5 text-black dark:text-white" min="1">
                                    <button @click="increaseQuantity(item.id)" class="px-3 py-1.5 bg-[#f5f5f7] dark:bg-[#2c2c2e] hover:bg-gray-200 dark:hover:bg-[#3a3a3c] text-black dark:text-white transition-colors border-l border-gray-300 dark:border-gray-600">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="w-32 text-center">
                                <span class="text-black dark:text-white font-semibold text-base" x-text="(item.price * item.quantity).toLocaleString('vi-VN') + ' ₫'"></span>
                            </div>
                            
                            <div class="w-24 text-center">
                                <button @click="removeFromCart(item.id); updateSelectAll();" class="text-blue-600 hover:text-blue-800 text-sm hover:underline transition-colors">
                                    Xóa
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Sticky Checkout Footer -->
        <div class="fixed bottom-0 left-0 right-0 z-40 bg-white dark:bg-[#1d1d1f] border-t border-gray-200 dark:border-[#333] shadow-[0_-5px_15px_rgba(0,0,0,0.05)] transform transition-transform" x-show="items.length > 0">
            <div class="container mx-auto px-4 sm:px-6 max-w-7xl flex flex-col md:flex-row items-center justify-between py-4">
                
                <div class="flex items-center gap-6 mb-4 md:mb-0 w-full md:w-auto">
                    <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-700 dark:text-gray-300">
                        <input type="checkbox" class="checkbox checkbox-sm border-gray-300 rounded-full checked:bg-black dark:checked:bg-white checked:border-black dark:checked:border-white" x-model="selectAll" @change="toggleSelectAll()">
                        Chọn Tất Cả (<span x-text="items.length"></span>)
                    </label>
                    <button class="text-sm text-blue-600 hover:underline" @click="selectedItems.forEach(id => removeFromCart(id)); selectedItems = []; selectAll = false;">
                        Xóa chọn
                    </button>
                </div>

                <div class="flex flex-col md:flex-row items-end md:items-center gap-6 w-full md:w-auto">
                    <div class="flex items-center gap-4 text-sm">
                        <span class="text-gray-700 dark:text-gray-300">Tổng thanh toán (<span x-text="selectedItems.length"></span> Sản phẩm):</span>
                        <div class="text-2xl font-bold text-black dark:text-white">
                            <span x-text="selectedTotal.toLocaleString('vi-VN') + ' ₫'"></span>
                        </div>
                    </div>
                    <button class="px-10 py-3 md:py-4 bg-black dark:bg-white hover:bg-gray-800 dark:hover:bg-gray-200 text-white dark:text-black rounded-full font-semibold transition-colors w-full md:w-auto" :disabled="selectedItems.length === 0">
                        Thanh Toán
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
