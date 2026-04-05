<!-- Apple-Style Minimalist Banner Slider -->
<section class="banner-slider-container w-full overflow-hidden bg-white">
    <div class="swiper bannerSwiper w-full h-[400px] sm:h-[500px] md:h-[650px]">
        <div class="swiper-wrapper">
            <!-- Slide 1: High Performance Running -->
            <div class="swiper-slide relative bg-gray-50 flex items-center justify-center">
                <div class="absolute inset-0 z-0">
                    <img 
                        src="https://images.unsplash.com/photo-1538805060514-97d9cc17730c?ixlib=rb-4.0.3&auto=format&fit=crop&q=80&w=2000" 
                        alt="Running Performance" 
                        class="w-full h-full object-cover grayscale-[20%] group-hover:scale-110 transition-transform duration-[10000ms]"
                    />
                    <div class="absolute inset-0 bg-black/5"></div>
                </div>
                <div class="relative z-10 w-full max-w-7xl mx-auto px-6 text-center sm:text-left">
                    <div class="max-w-2xl" data-swiper-parallax="-300">
                        <span class="inline-block mb-3 text-xs font-bold uppercase tracking-[0.2em] text-gray-500">New Arrival</span>
                        <h2 class="text-4xl md:text-6xl lg:text-7xl font-black mb-6 tracking-tighter text-black leading-none">
                            TỐC ĐỘ <br/>VƯỢT TRỘI.
                        </h2>
                        <p class="text-lg md:text-xl mb-10 text-gray-700 font-medium max-w-lg leading-relaxed">
                            Trải nghiệm công nghệ đệm khí mới nhất cho những bước chân nhẹ nhàng hơn bao giờ hết.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="#products" class="apple-btn apple-btn-black text-center">Mua ngay</a>
                            <a href="#details" class="apple-btn apple-btn-white text-center">Tìm hiểu thêm</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Minimalist Workout Gear -->
            <div class="swiper-slide relative bg-white flex items-center justify-center">
                <div class="absolute inset-0 z-0">
                    <img 
                        src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&q=80&w=2000" 
                        alt="Workout Motivation" 
                        class="w-full h-full object-cover scale-x-[-1]"
                    />
                    <div class="absolute inset-0 bg-white/20"></div>
                </div>
                <div class="relative z-10 w-full max-w-7xl mx-auto px-6 text-center">
                    <div data-swiper-parallax="-500">
                        <h2 class="text-4xl md:text-6xl lg:text-8xl font-black mb-6 tracking-tighter text-black">
                            SỨC MẠNH <br/>TỪ BÊN TRONG.
                        </h2>
                        <p class="text-lg md:text-xl mb-10 text-gray-800 font-medium max-w-xl mx-auto">
                            Thiết kế tối giản, tập trung tối đa vào hiệu năng luyện tập của bạn.
                        </p>
                        <a href="#products" class="apple-btn apple-btn-black">Bộ sưu tập GYM</a>
                    </div>
                </div>
            </div>

            <!-- Slide 3: Essential Yoga Collection -->
            <div class="swiper-slide relative bg-gray-100 flex items-center justify-center">
                <div class="absolute inset-0 z-0">
                    <img 
                        src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-4.0.3&auto=format&fit=crop&q=80&w=2000" 
                        alt="Yoga Collection" 
                        class="w-full h-full object-cover"
                    />
                    <div class="absolute inset-0 bg-gray-200/30"></div>
                </div>
                <div class="relative z-10 w-full max-w-7xl mx-auto px-6 text-center sm:text-right">
                    <div class="ml-auto max-w-2xl" data-swiper-parallax="-400">
                        <span class="inline-block mb-3 text-xs font-bold uppercase tracking-[0.2em] text-gray-500">Yoga Essentials</span>
                        <h2 class="text-4xl md:text-6xl lg:text-7xl font-black mb-6 tracking-tighter text-black leading-none">
                            TĨNH TẠI. <br/>CÂN BẰNG.
                        </h2>
                        <p class="text-lg md:text-xl mb-10 text-gray-700 font-medium max-w-lg ml-auto">
                            Chất liệu vải siêu mềm mại từ thiên nhiên, đồng hành cùng mọi chuyển động của bạn.
                        </p>
                        <a href="#products" class="apple-btn apple-btn-black">Khám phá ngay</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons - Elegant Minimalist Style -->
        <div class="swiper-button-prev !w-12 !h-12 !left-8 !text-black bg-white/40 hover:bg-white border border-gray-200/50 backdrop-blur-sm rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300">
            <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
        </div>
        <div class="swiper-button-next !w-12 !h-12 !right-8 !text-black bg-white/40 hover:bg-white border border-gray-200/50 backdrop-blur-sm rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300">
            <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
        </div>

        <!-- Pagination Dots - Perfectly Sized -->
        <div class="swiper-pagination !bottom-8" style="--swiper-pagination-color: #000; --swiper-pagination-bullet-inactive-color: #ccc; --swiper-pagination-bullet-size: 10px; --swiper-pagination-bullet-horizontal-gap: 12px; --swiper-pagination-bullet-opacity: 1;"></div>
    </div>
</section>

<style>
    /* Swiper customized styles for the Apple look */
    .bannerSwiper .swiper-pagination-bullet {
        background: var(--swiper-pagination-bullet-inactive-color);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid transparent;
    }
    .bannerSwiper .swiper-pagination-bullet-active {
        width: 24px;
        border-radius: 5px;
        background: #000;
        border-color: #000;
    }
    .bannerSwiper .swiper-button-prev:after, .bannerSwiper .swiper-button-next:after {
        display: none;
    }
</style>
