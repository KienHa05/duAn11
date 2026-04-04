/**
 * Initialization script
 * Sets up Swiper slider, Alpine.js components, and event listeners
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Banner Swiper
    initBannerSwiper();
    
    // Initialize Header Alpine.js state
    initHeader();
    
    // Setup Event Listeners
    setupEventListeners();
});

/**
 * Initialize Banner Swiper
 */
function initBannerSwiper() {
    const bannerSwiper = new Swiper('.bannerSwiper', {
        slidesPerView: 1,
        spaceBetween: 0,
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            dynamicBullets: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        parallax: true,
        speed: 800,
    });
}

/**
 * Initialize Header Alpine.js state
 */
function initHeader() {
    // Get initial cart count from data attribute or localStorage
    const savedCart = localStorage.getItem('cart');
    const cartCount = savedCart ? JSON.parse(savedCart).length : 0;
    
    // Update header cart count
    const cartCountBadge = document.querySelector('[data-cart-count]');
    if (cartCountBadge) {
        cartCountBadge.textContent = cartCount;
    }
}

/**
 * Setup Event Listeners
 */
function setupEventListeners() {
    // Listen for cart drawer toggle
    document.addEventListener('toggle-cart-drawer', () => {
        const checkbox = document.getElementById('cart-drawer');
        if (checkbox) {
            checkbox.checked = !checkbox.checked;
        }
    });
    
    // Update cart count when cart is updated
    window.addEventListener('cart-updated', (e) => {
        const cartCountBadge = document.querySelector('header button[data-cart-count]');
        if (cartCountBadge && e.detail.cartCount > 0) {
            cartCountBadge.innerHTML = `
                <svg class="w-6 h-6 group-hover:text-primary transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m10 0h2m-2 0h-2.5m0 0a1 1 0 11-2 0 1 1 0 012 0zM14 13h2m0 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                </svg>
                <span class="absolute top-0 right-0 bg-error text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                    ${e.detail.cartCount}
                </span>
            `;
        }
    });
    
    // Mobile menu toggle functionality
    const mobileMenuToggle = document.querySelector('[data-mobile-menu-toggle]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');
    
    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }
    
    // Close mobile menu when clicking a link
    const mobileMenuLinks = document.querySelectorAll('[data-mobile-menu] a');
    mobileMenuLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (mobileMenu) {
                mobileMenu.classList.add('hidden');
            }
        });
    });
}

/**
 * Utility: Format currency
 */
window.formatCurrency = function(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
        minimumFractionDigits: 0
    }).format(amount);
}

/**
 * Utility: Smooth scroll to element
 */
window.smoothScroll = function(selector) {
    const element = document.querySelector(selector);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

/**
 * Log initialization complete
 */
console.log('The Notorious - E-Commerce Platform Initialized');
