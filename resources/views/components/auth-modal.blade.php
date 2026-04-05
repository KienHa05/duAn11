<!-- Auth Modal Component -->
<dialog id="auth_modal" class="modal modal-bottom sm:modal-middle">
  <div class="modal-box bg-white dark:bg-[#1d1d1f] rounded-[2rem] p-8 max-w-md w-full shadow-2xl transition-colors duration-300" x-data="{ isLogin: true }">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-4 top-4 text-gray-500 hover:bg-gray-100 dark:hover:bg-[#333] dark:text-gray-400">✕</button>
    </form>

    <div class="text-center mb-8">
        <h3 class="font-semibold text-2xl tracking-tight text-black dark:text-white mb-2" x-text="isLogin ? 'Đăng nhập' : 'Tạo tài khoản Notorious'"></h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm" x-text="isLogin ? 'Đăng nhập để trải nghiệm mua sắm nhanh chóng.' : 'Tham gia cộng đồng Notorious ngay hôm nay.'"></p>
    </div>

    <!-- Login Form -->
    <form action="#" method="POST" x-show="isLogin" class="space-y-4">
        <div>
            <input type="email" placeholder="Email của bạn" class="w-full px-5 py-4 bg-[#f5f5f7] dark:bg-[#2c2c2e] border border-transparent focus:border-black dark:focus:border-white focus:bg-white dark:focus:bg-[#1d1d1f] rounded-2xl outline-none text-black dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all" required>
        </div>
        <div>
            <input type="password" placeholder="Mật khẩu" class="w-full px-5 py-4 bg-[#f5f5f7] dark:bg-[#2c2c2e] border border-transparent focus:border-black dark:focus:border-white focus:bg-white dark:focus:bg-[#1d1d1f] rounded-2xl outline-none text-black dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all" required>
        </div>
        <div class="flex justify-between items-center text-sm px-1">
            <label class="flex items-center gap-2 cursor-pointer text-gray-600 dark:text-gray-400">
                <input type="checkbox" class="checkbox checkbox-sm rounded-md border-gray-300 dark:border-gray-600 checked:bg-black dark:checked:bg-white checked:border-black dark:checked:border-white"> Nhớ mật khẩu
            </label>
            <a href="#" class="text-blue-600 dark:text-[#2997ff] hover:underline">Quên mật khẩu?</a>
        </div>
        <button type="submit" class="w-full py-4 mt-4 bg-black dark:bg-white text-white dark:text-black font-semibold rounded-2xl hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors">Đăng nhập</button>
    </form>

    <!-- Register Form -->
    <form action="#" method="POST" x-show="!isLogin" class="space-y-4" style="display: none;">
        <div>
            <input type="text" placeholder="Họ và tên" class="w-full px-5 py-4 bg-[#f5f5f7] dark:bg-[#2c2c2e] border border-transparent focus:border-black dark:focus:border-white focus:bg-white dark:focus:bg-[#1d1d1f] rounded-2xl outline-none text-black dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all" required>
        </div>
        <div>
            <input type="email" placeholder="Email của bạn" class="w-full px-5 py-4 bg-[#f5f5f7] dark:bg-[#2c2c2e] border border-transparent focus:border-black dark:focus:border-white focus:bg-white dark:focus:bg-[#1d1d1f] rounded-2xl outline-none text-black dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all" required>
        </div>
        <div>
            <input type="password" placeholder="Mật khẩu" class="w-full px-5 py-4 bg-[#f5f5f7] dark:bg-[#2c2c2e] border border-transparent focus:border-black dark:focus:border-white focus:bg-white dark:focus:bg-[#1d1d1f] rounded-2xl outline-none text-black dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition-all" required>
        </div>
        <button type="submit" class="w-full py-4 mt-4 bg-black dark:bg-white text-white dark:text-black font-semibold rounded-2xl hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors">Đăng ký</button>
    </form>

    <div class="mt-8 pt-6 border-t border-gray-100 dark:border-[#333] text-center text-sm">
        <p class="text-gray-500 dark:text-gray-400" x-show="isLogin">
            Bạn chưa có tài khoản?
            <button type="button" @click="isLogin = false" class="text-blue-600 dark:text-[#2997ff] font-medium hover:underline">Đăng ký ngay</button>
        </p>
        <p class="text-gray-500 dark:text-gray-400" x-show="!isLogin" style="display: none;">
            Đã có tài khoản?
            <button type="button" @click="isLogin = true" class="text-blue-600 dark:text-[#2997ff] font-medium hover:underline">Đăng nhập</button>
        </p>
    </div>
  </div>
  <form method="dialog" class="modal-backdrop bg-black/40 backdrop-blur-sm">
    <button>close</button>
  </form>
</dialog>
