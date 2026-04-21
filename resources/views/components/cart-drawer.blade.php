<!-- Apple-Style Minimalist Cart Drawer -->
<div 
    class="drawer drawer-end" 
    x-data="{ open: false }" 
    @toggle-cart-drawer.window="open = !open"
    :class="{ 'drawer-open': open }"
>
    <input id="cart-drawer" type="checkbox" class="drawer-toggle" x-model="open" />
    
    <div class="drawer-side z-[100]">
        <label for="cart-drawer" class="drawer-overlay bg-black/20 backdrop-blur-sm"></label>
        
        <div class="w-full max-w-md bg-white h-full flex flex-col shadow-2xl">
            <!-- Top Header: Minimal & Bold -->
            <div class="p-8 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-7 h-7 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h2 class="text-2xl font-black tracking-tighter text-black uppercase">Giỏ hàng</h2>
                </div>
                <button @click="open = false" class="p-2 hover:bg-gray-100 rounded-full transition-colors group">
                    <svg class="w-6 h-6 text-gray-400 group-hover:text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
                      <!-- Items Area: Generous Spacing -->
            <div class="flex-1 overflow-y-auto px-8 py-6">
                <!-- Empty State: Clean & Centered -->
                <div x-show="items.length === 0" class="h-full flex flex-col items-center justify-center text-center py-20">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-8">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-black text-black mb-2 uppercase tracking-tight">Giỏ hàng đang trống</h3>
                    <p class="text-gray-400 text-sm font-medium mb-10">Khám phá các sản phẩm mới nhất của chúng tôi ngay hôm nay.</p>
                    <button @click="open = false" class="apple-btn apple-btn-black">
                        TIẾP TỤC XEM HÀNG
                    </button>
                </div>
                
                <!-- Product List -->
                <div class="space-y-10">
                    <template x-for="item in items" :key="item.id">
                        <div class="flex gap-6 group">
                            <!-- Subtle Placeholder or Image -->
                            <div class="w-24 h-24 bg-gray-50 rounded-xl overflow-hidden flex-shrink-0 group-hover:bg-gray-100 transition-colors flex items-center justify-center">
                                <template x-if="item.imageUrl && item.imageUrl.trim()">
                                    <img :src="item.imageUrl" :alt="item.name" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!item.imageUrl || !item.imageUrl.trim()">
                                    <div class="w-full h-full flex items-center justify-center text-gray-200">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                </template>
                            </div>
                            
                            <div class="flex-1 flex flex-col justify-between py-1">
                                <div>
                                    <div class="flex justify-between items-start gap-4">
                                        <h4 class="font-bold text-black text-sm md:text-base leading-tight group-hover:underline" x-text="item.name"></h4>
                                        <button @click="removeFromCart(item.id)" class="text-gray-300 hover:text-black transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                    <p class="text-sm font-black text-black mt-2" x-text="`${item.price.toLocaleString('vi-VN')} đ`"></p>
                                </div>
                                
                                <div class="flex items-center justify-between mt-4">
                                    <!-- Minimalist Quantity Selector -->
                                    <div class="flex items-center border border-gray-200 rounded-full h-9 px-3 gap-4">
                                        <button @click="decreaseQuantity(item.id)" class="text-gray-400 hover:text-black p-1 transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path></svg>
                                        </button>
                                        <span class="text-xs font-black text-black w-4 text-center" x-text="item.quantity"></span>
                                        <button @click="increaseQuantity(item.id)" class="text-gray-400 hover:text-black p-1 transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            
            <!-- Summary Footer: Prominent & Clean -->
            <div x-show="items.length > 0" class="p-8 bg-white border-t border-gray-100 space-y-6">
                <div class="space-y-3">
                    <div class="flex justify-between text-sm font-bold text-gray-400 uppercase tracking-widest">
                        <span>Tạm tính</span>
                        <span class="text-black" x-text="`${subtotal.toLocaleString('vi-VN')} đ`"></span>
                    </div>
                    <div class="flex justify-between text-sm font-bold text-gray-400 uppercase tracking-widest">
                        <span>Vận chuyển</span>
                        <span class="text-black" x-text="shipping === 0 ? 'Miễn phí' : `${shipping.toLocaleString('vi-VN')} đ`"></span>
                    </div>
                </div>
                
                <div class="border-t border-gray-100 pt-6">
                    <div class="flex justify-between items-end">
                        <span class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Tổng cộng</span>
                        <span class="text-3xl font-black text-black tracking-tight leading-none" x-text="`${total.toLocaleString('vi-VN')} đ`"></span>
                    </div>
                </div>
                
                <div class="pt-4 space-y-4">
                    <a href="{{ route('checkout.form') }}" class="w-full py-4 bg-black text-white rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-gray-900 transform active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                        <span>THANH TOÁN</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                    <button @click="open = false" class="w-full py-3 text-sm font-bold text-gray-400 hover:text-black transition-colors">
                        Tiếp tục mua hàng
                    </button>
                </div>
                
                <p class="text-[10px] text-center text-gray-400 font-bold uppercase tracking-[0.1em]">
                    Cảm ơn bạn đã tin tưởng THE NOTORIOUS
                </p>
            </div>
        </div>
    </div>
</div>
