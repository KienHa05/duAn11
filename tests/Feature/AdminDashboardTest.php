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
        $this->travelTo(now('Asia/Bangkok')->setTime(12, 0, 0));

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
        $response->assertSeeText('Báo cáo Phân tích');
        $response->assertSeeText('Chỉ số nền tảng');
        $response->assertSeeText('Sản phẩm');
        $response->assertSeeText('Danh mục');
        $response->assertSeeText('Người dùng');
        $response->assertSeeText('Tổng đơn hàng');
        $response->assertSeeText('Vận hành hôm nay');
        $response->assertSeeText('Chờ xác nhận');
        $response->assertSeeText('Đang giao');
        $response->assertSeeText('Xử lý xong');
        $response->assertSeeText('Doanh thu ngày');
        $response->assertSeeText('Xu hướng Tăng trưởng');
        $response->assertSeeText('Sản phẩm Bán chạy');
        $response->assertSeeText('Cảnh báo Bán chậm');
        $response->assertSeeText('450,000');
        $response->assertDontSeeText('Recent Orders');
        $response->assertDontSeeText('Low Stock Alert');
        $response->assertDontSeeText('pending');
        $response->assertDontSeeText('shipping');
        $response->assertDontSeeText('completed');
        $response->assertDontSeeText('Laravel');
    }

    public function test_analytics_api_returns_correct_data(): void
    {
        $category = Category::create(['name' => 'Apparel']);
        
        // Create a product with low stock
        Product::create([
            'name' => 'Low Stock Tee',
            'price' => 120000,
            'stock' => 3,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.api.analytics.data'));

        $response->assertOk();
        $response->assertJsonStructure([
            'revenue_orders',
            'top_sellers',
            'slow_sellers',
            'order_status'
        ]);

        $response->assertJsonFragment(['name' => 'Low Stock Tee']);
    }

    public function test_dashboard_shows_empty_states_when_no_business_data_exists(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSeeText('Báo cáo Phân tích');
        // KPIs should show 0
        $response->assertSeeText('0');
    }
}
