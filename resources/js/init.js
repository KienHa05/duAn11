/**
 * Initialization script
 * Sets up Swiper slider, Alpine.js components, animations, and event listeners
 */

import AOS from 'aos';

document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS (Animate On Scroll)
    initAnimations();
    
    // Initialize Banner Swiper
    initBannerSwiper();
    
    // Initialize Header Alpine.js state
    initHeader();
    
    // Setup Event Listeners
    setupEventListeners();
});

/**
 * Initialize AOS Animations
 */
function initAnimations() {
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        offset: 50
    });
}

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
                <svg class="w-6 h-6 group-hover:text-secondary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span class="absolute top-1 right-1 w-5 h-5 bg-secondary text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse">
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
console.log('%c🚀 The Notorious - E-Commerce Platform Initialized', 'color: #3b82f6; font-size: 14px; font-weight: bold;');
