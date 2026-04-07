/**
 * Cart Store - Alpine.js store for shopping cart management
 * Handles add, remove, update quantities, and local storage persistence
 */

window.cartStore = function() {
    return {
        items: [],
        subtotal: 0,
        discount: 0,
        shipping: 30000, // Default shipping cost in VND
        total: 0,
        cartCount: 0,
        isAdding: false, // Track if currently adding to prevent spam

        init() {
            this.loadCart();
            this.updateTotals();
        },

        /**
         * Load cart from localStorage
         */
        loadCart() {
            const saved = localStorage.getItem('cart');
            if (saved) {
                this.items = JSON.parse(saved);
                // Count unique products, not total quantity
                this.cartCount = this.items.length;
            }
        },

        /**
         * Save cart to localStorage
         */
        saveCart() {
            localStorage.setItem('cart', JSON.stringify(this.items));
            // Count unique products, not total quantity
            this.cartCount = this.items.length;
            this.dispatchCartUpdated();
        },

        /**
         * Add product to cart (or increase quantity if exists)
         * Returns: 'added' = new product, 'increased' = existing product quantity increased
         */
        addToCart(productId, name, price, imageUrl = '') {
            const existingItem = this.items.find(item => item.id === productId);

            if (existingItem) {
                // Product exists - increase quantity
                existingItem.quantity++;
                this.saveCart();
                this.updateTotals();

                console.log('⬆️ Increased quantity:', { productId, name, newQuantity: existingItem.quantity });

                // Show toast for quantity increase
                this.showToast(`Đã tăng số lượng "${name}"`);
                return 'increased';
            } else {
                // New product - add to cart
                this.items.push({
                    id: productId,
                    name: name,
                    price: price,
                    imageUrl: imageUrl,
                    quantity: 1
                });

                this.saveCart();
                this.updateTotals();

                console.log('✅ Added new product:', { productId, name, price, imageUrl });
                console.log('📦 Cart:', this.items);

                // Show toast for new product
                this.showToast(`Đã thêm "${name}" vào giỏ hàng`);
                return 'added';
            }
        },

        /**
         * Add product to cart with anti-spam protection (for homepage)
         * Prevents double-click by disabling button during add
         */
        addToCartWithLoading(productId, name, price, imageUrl = '') {
            // Prevent spam clicks
            if (this.isAdding) {
                return;
            }

            this.isAdding = true;

            // Add to cart (handles both new and existing products)
            this.addToCart(productId, name, price, imageUrl);

            // Re-enable after a short delay
            setTimeout(() => {
                this.isAdding = false;
            }, 300);
        },

        /**
         * Remove product from cart
         */
        removeFromCart(productId) {
            const index = this.items.findIndex(item => item.id === productId);
            if (index > -1) {
                const itemName = this.items[index].name;
                this.items.splice(index, 1);
                this.saveCart();
                this.updateTotals();
                this.showToast(`Đã xóa "${itemName}" khỏi giỏ hàng`);
            }
        },

        /**
         * Increase product quantity (on cart page - doesn't update badge)
         */
        increaseQuantity(productId) {
            const item = this.items.find(i => i.id === productId);
            if (item) {
                item.quantity++;
                // Only save locally, don't dispatch to header
                localStorage.setItem('cart', JSON.stringify(this.items));
                this.updateTotals();
            }
        },

        /**
         * Decrease product quantity (on cart page - doesn't update badge)
         * Minimum quantity is 1
         */
        decreaseQuantity(productId) {
            const item = this.items.find(i => i.id === productId);
            if (item && item.quantity > 1) {
                item.quantity--;
                // Only save locally, don't dispatch to header
                localStorage.setItem('cart', JSON.stringify(this.items));
                this.updateTotals();
            }
        },

        /**
         * Update cart totals
         */
        updateTotals() {
            this.subtotal = this.items.reduce((sum, item) => {
                return sum + (item.price * item.quantity);
            }, 0);

            // Calculate shipping based on subtotal
            if (this.subtotal >= 500000) {
                this.shipping = 0; // Free shipping for orders >= 500K
            } else {
                this.shipping = 30000;
            }

            // Calculate total
            this.total = this.subtotal + this.shipping - this.discount;
        },

        /**
         * Update cart from external event
         */
        updateCart(event) {
            this.loadCart();
            this.updateTotals();
        },

        /**
         * Dispatch cart updated event
         */
        dispatchCartUpdated() {
            window.dispatchEvent(new CustomEvent('cart-updated', {
                detail: {
                    items: this.items,
                    cartCount: this.cartCount,
                    total: this.total
                }
            }));
        },

        /**
         * Show toast notification
         */
        showToast(message, type = 'success') {
            // Create toast container with Tailwind styling
            const toast = document.createElement('div');
            let bgColor = 'bg-green-500';
            let icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>';

            if (type === 'error') {
                bgColor = 'bg-red-500';
                icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
            }

            toast.className = 'fixed top-6 right-6 z-[9999] animate-in slide-in-from-top-2 fade-in duration-300';
            toast.innerHTML = `
                <div class="${bgColor} text-white rounded-xl shadow-2xl px-6 py-4 flex items-center gap-4 max-w-md">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        ${icon}
                    </svg>
                    <span class="font-medium text-sm">${message}</span>
                </div>
            `;
            document.body.appendChild(toast);

            // Auto-remove after 3 seconds
            setTimeout(() => {
                toast.classList.add('animate-out', 'slide-out-to-top-2', 'fade-out');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);
        },

        /**
         * Clear entire cart
         */
        clearCart() {
            this.items = [];
            this.subtotal = 0;
            this.discount = 0;
            this.cartCount = 0;
            localStorage.removeItem('cart');
            this.dispatchCartUpdated();
        },

        /**
         * Get cart count
         */
        getCartCount() {
            return this.cartCount;
        },

        /**
         * Check if item exists in cart
         */
        hasItem(productId) {
            return this.items.some(item => item.id === productId);
        },

        /**
         * Get item quantity
         */
        getItemQuantity(productId) {
            const item = this.items.find(i => i.id === productId);
            return item ? item.quantity : 0;
        }
    }
}
