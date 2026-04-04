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
                this.cartCount = this.items.reduce((sum, item) => sum + item.quantity, 0);
            }
        },
        
        /**
         * Save cart to localStorage
         */
        saveCart() {
            localStorage.setItem('cart', JSON.stringify(this.items));
            this.cartCount = this.items.reduce((sum, item) => sum + item.quantity, 0);
            this.dispatchCartUpdated();
        },
        
        /**
         * Add product to cart
         */
        addToCart(productId, name, price) {
            const existingItem = this.items.find(item => item.id === productId);
            
            if (existingItem) {
                existingItem.quantity++;
            } else {
                this.items.push({
                    id: productId,
                    name: name,
                    price: price,
                    quantity: 1
                });
            }
            
            this.saveCart();
            this.updateTotals();
            
            // Show toast notification
            this.showToast(`Đã thêm "${name}" vào giỏ hàng`);
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
         * Increase product quantity
         */
        increaseQuantity(productId) {
            const item = this.items.find(i => i.id === productId);
            if (item) {
                item.quantity++;
                this.saveCart();
                this.updateTotals();
            }
        },
        
        /**
         * Decrease product quantity
         */
        decreaseQuantity(productId) {
            const item = this.items.find(i => i.id === productId);
            if (item && item.quantity > 1) {
                item.quantity--;
                this.saveCart();
                this.updateTotals();
            } else if (item && item.quantity === 1) {
                this.removeFromCart(productId);
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
            // Create a simple toast div
            const toast = document.createElement('div');
            toast.className = `toast toast-top toast-right`;
            toast.innerHTML = `
                <div class="alert alert-${type} rounded-lg shadow-lg">
                    <svg class="stroke-current shrink-0 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        ${type === 'success' ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>' : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'}
                    </svg>
                    <span>${message}</span>
                </div>
            `;
            document.body.appendChild(toast);
            
            // Remove toast after 3 seconds
            setTimeout(() => {
                toast.remove();
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
