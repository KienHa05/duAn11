# E-commerce Laravel Project

Dự án này đang được phát triển theo mô hình e-commerce cơ bản với Laravel, tích hợp giao diện người dùng, giỏ hàng, thanh toán/đặt hàng, quản trị admin và thống kê bán hàng.

## Tình trạng tiến độ

Dự án đã hoàn thành các module cốt lõi sau:

### 1. Giao diện khách hàng
- Trang chủ sản phẩm
- Trang chi tiết sản phẩm
- Tìm kiếm và lọc sản phẩm cơ bản
- Hiển thị danh mục sản phẩm

### 2. Giỏ hàng và đặt hàng
- Thêm sản phẩm vào giỏ hàng
- Cập nhật số lượng sản phẩm trong giỏ
- Xóa sản phẩm khỏi giỏ
- Hỗ trợ đặt hàng cho khách vãng lai và khách đã đăng nhập
- Xử lý lưu thông tin đơn hàng và mã tracking

### 3. Tài khoản và xác thực
- Đăng nhập khách hàng
- Đăng ký tài khoản khách hàng
- Quản lý thông tin hồ sơ người dùng
- Xem lịch sử đơn hàng của người dùng
- Đăng nhập quản trị viên riêng biệt
- Phân quyền admin và client

### 4. Quản trị Admin
- Dashboard quản trị
- Quản lý sản phẩm: thêm, sửa, xóa, khôi phục, xóa vĩnh viễn
- Quản lý danh mục
- Quản lý đơn hàng: xem, chỉnh sửa trạng thái, cập nhật vận chuyển, hủy đơn
- Thống kê bán hàng: doanh thu, số đơn hàng, sản phẩm bán chạy/slow seller, phân bố trạng thái đơn

### 5. Tính năng bổ sung
- Upload ảnh cho sản phẩm
- Soft delete cho sản phẩm
- Tích hợp các route API cho checkout và kiểm tra email
- Hỗ trợ tracking đơn hàng

## Công nghệ sử dụng
- Laravel 13
- PHP 8.3
- Vite + Tailwind CSS + DaisyUI
- Alpine.js, AOS, GSAP, Swiper
- MySQL / Laravel migrations

## Cách chạy dự án

### Yêu cầu
- PHP 8.3+
- Composer
- Node.js + npm
- Database sẵn sàng

### Bước chạy
```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run build
php artisan serve
```

## Điểm hiện tại
Dự án đã đi được tới giai đoạn “core e-commerce flow” hoàn chỉnh ở phía khách hàng và quản trị. Các chức năng chính về mua hàng, quản lý đơn hàng và thống kê admin đã được triển khai.

## Kế hoạch tiếp theo
- Tích hợp cổng thanh toán thực tế
- Gửi email thông báo đặt hàng và trạng thái đơn hàng
- Hoàn thiện test tự động
- Tối ưu trải nghiệm UI/UX và bảo mật