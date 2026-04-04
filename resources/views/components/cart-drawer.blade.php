<!-- Cart Drawer Component -->
<div class="drawer drawer-end" @open-cart-drawer.window="$el.querySelector('input[type=checkbox]').checked = true" @close-cart-drawer.window="$el.querySelector('input[type=checkbox]').checked = false">
    <input id="cart-drawer" type="checkbox" class="drawer-toggle" />
    <div class="drawer-side z-40">
        <label for="cart-drawer" class="drawer-overlay"></label>
        
        <div class="w-full max-w-sm bg-white h-full flex flex-col">
            <!-- Header -->
            <div class="p-6 border-b border-base-200 flex items-center justify-between">
                <h2 class="text-2xl font-bold">Giỏ hàng</h2>
                <label for="cart-drawer" class="btn btn-ghost btn-sm btn-circle">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </label>
            </div>
            
            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto p-6">
                <!-- Empty State -->
                <div x-show="cart.items.length === 0" class="h-full flex flex-col items-center justify-center text-center">
                    <svg class="w-16 h-16 text-base-content/20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m10 0h2m-2 0h-2.5m0 0a1 1 0 11-2 0 1 1 0 012 0zM14 13h2m0 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold mb-2">Giỏ hàng trống</h3>
                    <p class="text-sm text-base-content/60">Hãy thêm một số sản phẩm để bắt đầu mua sắm</p>
                    <label for="cart-drawer" class="btn btn-primary btn-sm mt-4">
                        Tiếp tục mua sắm
                    </label>
                </div>
                
                <!-- Cart Items List -->
                <template x-for="item in cart.items" :key="item.id">
                    <div class="bg-base-100 rounded-lg p-4 mb-4">
                        <div class="flex gap-4 mb-3">
                            <!-- Item Image Placeholder -->
                            <div class="w-16 h-16 bg-base-200 rounded-lg flex-shrink-0"></div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-sm line-clamp-2" x-text="item.name"></h4>
                                <p class="text-primary font-bold text-sm mt-1">
                                    <span x-text="`${item.price.toLocaleString('vi-VN')} đ`"></span>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="join">
                                <button 
                                    @click="decreaseQuantity(item.id)"
                                    class="btn btn-xs join-item"
                                >
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <button class="btn btn-xs join-item bg-base-200 cursor-default" x-text="item.quantity"></button>
                                <button 
                                    @click="increaseQuantity(item.id)"
                                    class="btn btn-xs join-item"
                                >
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                            <button 
                                @click="removeFromCart(item.id)"
                                class="btn btn-ghost btn-xs text-error hover:bg-error/10"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
            
            <!-- Footer -->
            <div class="border-t border-base-200 p-6 space-y-4">
                <!-- Subtotal -->
                <div class="flex justify-between text-sm">
                    <span class="text-base-content/60">Tạm tính:</span>
                    <span class="font-semibold" x-text="`${cart.subtotal.toLocaleString('vi-VN')} đ`"></span>
                </div>
                
                <!-- Discount (if any) -->
                <div x-show="cart.discount > 0" class="flex justify-between text-sm text-success">
                    <span>Giảm giá:</span>
                    <span x-text="`-${cart.discount.toLocaleString('vi-VN')} đ`"></span>
                </div>
                
                <!-- Shipping -->
                <div class="flex justify-between text-sm">
                    <span class="text-base-content/60">Vận chuyển:</span>
                    <span class="font-semibold" x-text="`${cart.shipping.toLocaleString('vi-VN')} đ`"></span>
                </div>
                
                <!-- Total -->
                <div class="divider my-2"></div>
                <div class="flex justify-between text-lg">
                    <span class="font-bold">Tổng cộng:</span>
                    <span class="font-bold text-primary" x-text="`${cart.total.toLocaleString('vi-VN')} đ`"></span>
                </div>
                
                <!-- Checkout Button -->
                <button 
                    :disabled="cart.items.length === 0"
                    class="btn btn-primary w-full gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span class="font-semibold">Thanh Toán</span>
                </button>
                
                <!-- Continue Shopping -->
                <label for="cart-drawer" class="btn btn-outline w-full">
                    Tiếp tục mua sắm
                </label>
            </div>
        </div>
    </div>
</div>
