<!-- Banner Slider Component -->
<section class="banner-slider-section mb-12">
    <!-- Swiper Banner -->
    <div class="swiper bannerSwiper w-full h-64 sm:h-80 md:h-96 rounded-xl overflow-hidden shadow-lg">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide">
                <div class="relative w-full h-full bg-gradient-to-r from-primary/80 to-secondary/80 flex items-center justify-center overflow-hidden group">
                    <div class="absolute inset-0 opacity-20">
                        <img src="data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E" class="w-full h-full" alt="">
                    </div>
                    <div class="relative z-10 text-center text-white px-6">
                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 animate-pulse">Bộ Sưu Tập Hè 2026</h2>
                        <p class="text-sm sm:text-base md:text-lg mb-6 opacity-90">Khám phá những thiết kế mới nhất với chất lượng premium</p>
                        <a href="#products" class="btn btn-light gap-2 shadow-lg hover:shadow-xl transform transition-transform hover:scale-105">
                            <span class="font-semibold">Xem ngay</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Slide 2 -->
            <div class="swiper-slide">
                <div class="relative w-full h-full bg-gradient-to-r from-accent/80 to-info/80 flex items-center justify-center overflow-hidden">
                    <div class="absolute inset-0 opacity-10">
                        <svg viewBox="0 0 100 100" class="w-full h-full" preserveAspectRatio="xMidYMid slice">
                            <defs>
                                <pattern id="pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                    <circle cx="10" cy="10" r="2" fill="white"/>
                                </pattern>
                            </defs>
                            <rect width="100" height="100" fill="url(#pattern)"/>
                        </svg>
                    </div>
                    <div class="relative z-10 text-center text-white px-6">
                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">Giảm Giá Lên Đến 50%</h2>
                        <p class="text-sm sm:text-base md:text-lg mb-6 opacity-90">Các sản phẩm hot được chọn lọc kỹ càng</p>
                        <a href="#products" class="btn btn-light gap-2 shadow-lg hover:shadow-xl transform transition-transform hover:scale-105">
                            <span class="font-semibold">Mua ngay</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Slide 3 -->
            <div class="swiper-slide">
                <div class="relative w-full h-full bg-gradient-to-r from-success/80 to-warning/80 flex items-center justify-center overflow-hidden">
                    <div class="absolute inset-0 opacity-20">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20'%3E%3Crect fill='%23fff' width='20' height='20'/%3E%3Cpath fill='%23f5f5f5' d='M0 0h10v10H0zm10 10h10v10H10z'/%3E%3C/svg%3E" class="w-full h-full" alt="">
                    </div>
                    <div class="relative z-10 text-center text-white px-6">
                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">Thành Viên Mới</h2>
                        <p class="text-sm sm:text-base md:text-lg mb-6 opacity-90">Nhận ngay ưu đãi 20% cho đơn hàng đầu tiên</p>
                        <a href="#products" class="btn btn-light gap-2 shadow-lg hover:shadow-xl transform transition-transform hover:scale-105">
                            <span class="font-semibold">Tham gia ngay</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation Buttons -->
        <div class="swiper-button-prev !left-4 !w-10 !h-10 bg-white/20 hover:bg-white/40 backdrop-blur-sm rounded-full !text-white transition-all"></div>
        <div class="swiper-button-next !right-4 !w-10 !h-10 bg-white/20 hover:bg-white/40 backdrop-blur-sm rounded-full !text-white transition-all"></div>
        
        <!-- Pagination -->
        <div class="swiper-pagination !bottom-4" style="--swiper-pagination-color: white; --swiper-pagination-bullet-inactive-color: rgba(255, 255, 255, 0.5);"></div>
    </div>
</section>
