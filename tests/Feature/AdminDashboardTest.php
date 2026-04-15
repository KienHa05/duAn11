<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['is_admin' => true]);
    }

    public function test_dashboard_shows_expected_kpis_recent_orders_and_low_stock_alerts(): void
    {
        config(['app.timezone' => 'Asia/Bangkok']);

        $category = Category::create(['name' => 'Apparel']);
        User::factory()->count(2)->create();
        Product::create([
            'name' => 'Low Stock Tee',
            'price' => 120000,
            'stock' => 3,
            'category_id' => $category->id,
        ]);
        Product::create([
            'name' => 'Almost Gone Hoodie',
            'price' => 320000,
            'stock' => 10,
            'category_id' => $category->id,
        ]);
        Product::create([
            'name' => 'Healthy Stock Sneaker',
            'price' => 540000,
            'stock' => 25,
            'category_id' => $category->id,
        ]);

        $member = User::factory()->create(['name' => 'Member Buyer']);
        $today = now(config('app.timezone'));

        Order::factory()->create([
            'user_id' => $member->id,
            'order_number' => 'ORD-1001',
            'status' => 'pending',
            'created_at' => $today->copy()->subMinutes(5),
        ]);

        Order::factory()->create([
            'order_number' => 'ORD-1002',
            'status' => 'shipping',
            'created_at' => $today->copy()->subMinutes(10),
        ]);

        Order::factory()->create([
            'order_number' => 'ORD-1003',
            'status' => 'completed',
            'delivered_at' => $today->copy()->subHour(),
            'created_at' => $today->copy()->subHours(2),
        ]);

        Order::factory()->create([
            'order_number' => 'ORD-1004',
            'status' => 'completed',
            'payment_status' => 'paid',
            'paid_at' => $today->copy()->subMinutes(30),
            'total_amount' => 450000,
            'created_at' => $today->copy()->subMinutes(30),
        ]);

        Order::factory()->create([
            'order_number' => 'ORD-1005',
            'status' => 'completed',
            'payment_status' => 'paid',
            'paid_at' => $today->copy()->subDay(),
            'total_amount' => 900000,
            'created_at' => $today->copy()->subDay(),
        ]);

        Order::factory()->create([
            'order_number' => 'ORD-1006',
            'user_id' => null,
            'is_guest' => true,
            'guest_name' => null,
            'guest_email' => 'guest@example.com',
            'created_at' => $today->copy()->subMinutes(1),
        ]);

        Order::factory()->count(5)->create();

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSeeText('Tổng quan vận hành');
        $response->assertSeeText('Tổng sản phẩm');
        $response->assertSeeText('Tổng danh mục');
        $response->assertSeeText('Tổng người dùng');
        $response->assertSeeText('Đơn chờ xác nhận');
        $response->assertSeeText('Đơn đang giao');
        $response->assertSeeText('Đơn hoàn tất hôm nay');
        $response->assertSeeText('Doanh thu hôm nay');
        $response->assertSeeText('Đơn hàng gần đây');
        $response->assertSeeText('Cảnh báo sắp hết hàng');
        $response->assertSeeText('Mã đơn hàng');
        $response->assertSeeText('Khách hàng');
        $response->assertSeeText('Tổng tiền');
        $response->assertSeeText('Trạng thái');
        $response->assertSeeText('Ngày tạo');
        $response->assertSeeText('450,000');
        $response->assertSeeText('ORD-1006');
        $response->assertSeeText('guest@example.com');
        $response->assertSeeText('Low Stock Tee');
        $response->assertSeeText('Almost Gone Hoodie');
        $response->assertDontSeeText('Healthy Stock Sneaker');
        $response->assertDontSeeText('ORD-1005');
        $response->assertSeeText('Chờ xác nhận');
        $response->assertSeeText('Đang giao hàng');
        $response->assertSeeText('Hoàn tất');
        $response->assertDontSeeText('Recent Orders');
        $response->assertDontSeeText('Low Stock Alert');
        $response->assertDontSeeText('pending');
        $response->assertDontSeeText('shipping');
        $response->assertDontSeeText('completed');
        $response->assertDontSeeText('Laravel');
    }

    public function test_dashboard_shows_empty_states_when_no_business_data_exists(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSeeText('Chưa có đơn hàng nào');
        $response->assertSeeText('Chưa có sản phẩm sắp hết');
        $response->assertSeeText('Chưa phát sinh doanh thu hôm nay.');
    }
}
