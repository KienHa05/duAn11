<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardStatsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true]);
    }

    public function test_dashboard_shows_product_count(): void
    {
        Product::create(['name' => 'P1', 'price' => 100, 'stock' => 10]);
        Product::create(['name' => 'P2', 'price' => 200, 'stock' => 20]);
        Product::create(['name' => 'P3', 'price' => 300, 'stock' => 30]);

        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.dashboard'));

        $response->assertOk();
        $overview = $response->viewData('overview');
        $this->assertEquals(3, $overview['products']);
    }

    public function test_dashboard_shows_category_count(): void
    {
        Category::create(['name' => 'C1']);
        Category::create(['name' => 'C2']);

        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.dashboard'));

        $response->assertOk();
        $overview = $response->viewData('overview');
        $this->assertEquals(2, $overview['categories']);
    }

    public function test_dashboard_shows_order_count(): void
    {
        Order::factory()->count(4)->create();

        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.dashboard'));

        $response->assertOk();
        $overview = $response->viewData('overview');
        $this->assertEquals(4, $overview['orders']);
    }

    public function test_dashboard_shows_customer_count(): void
    {
        User::factory()->count(3)->create(['is_admin' => false]);
        User::factory()->create(['is_admin' => true]); // admin not counted

        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.dashboard'));

        $response->assertOk();
        $overview = $response->viewData('overview');
        $this->assertEquals(3, $overview['customers']);
    }

    public function test_dashboard_shows_total_revenue(): void
    {
        Order::factory()->create(['total_amount' => 500000, 'payment_status' => 'paid']);
        Order::factory()->create(['total_amount' => 300000, 'payment_status' => 'paid']);
        Order::factory()->create(['total_amount' => 200000, 'payment_status' => 'pending']); // not counted

        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.dashboard'));

        $response->assertOk();
        $overview = $response->viewData('overview');
        $this->assertEquals(800000, $overview['total_revenue']);
    }

    public function test_dashboard_shows_orders_by_status(): void
    {
        Order::factory()->create(['status' => 'pending']);
        Order::factory()->count(2)->create(['status' => 'completed']);
        Order::factory()->create(['status' => 'cancelled']);

        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.dashboard'));

        $response->assertOk();
        $stats = $response->viewData('orderStatusStats');
        $this->assertEquals(1, $stats['pending']);
        $this->assertEquals(2, $stats['completed']);
        $this->assertEquals(1, $stats['cancelled']);
        $this->assertEquals(0, $stats['confirmed']);
        $this->assertEquals(0, $stats['shipping']);
        $this->assertEquals(0, $stats['returned']);
    }

    public function test_dashboard_shows_monthly_chart_data(): void
    {
        Order::factory()->create([
            'total_amount' => 100000,
            'payment_status' => 'paid',
            'created_at' => now()->startOfYear(),
        ]);

        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.dashboard'));

        $response->assertOk();
        $chartData = $response->viewData('monthlyChartData');
        $this->assertCount(12, $chartData['labels']);
        $this->assertCount(12, $chartData['revenue']);
        $this->assertCount(12, $chartData['orders']);
        $this->assertEquals(now()->year, $chartData['year']);
    }

    public function test_dashboard_works_without_data(): void
    {
        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.dashboard'));

        $response->assertOk();
        $overview = $response->viewData('overview');
        $stats = $response->viewData('orderStatusStats');
        $chartData = $response->viewData('monthlyChartData');

        $this->assertEquals(0, $overview['products']);
        $this->assertEquals(0, $overview['categories']);
        $this->assertEquals(0, $overview['orders']);
        $this->assertEquals(0, $overview['customers']);
        $this->assertEquals(0, $overview['total_revenue']);
        $this->assertEquals(0, $stats['pending']);
        $this->assertEquals(0, $stats['completed']);
        $this->assertEquals(0, $stats['cancelled']);
        $this->assertCount(12, $chartData['labels']);
        $this->assertEquals(0, array_sum($chartData['revenue']));
        $this->assertEquals(0, array_sum($chartData['orders']));
    }

    public function test_dashboard_kpis_remain_unchanged(): void
    {
        Order::factory()->create(['status' => 'pending']);
        Order::factory()->create(['status' => 'shipping']);
        Order::factory()->create([
            'status' => 'completed',
            'payment_status' => 'paid',
            'total_amount' => 150000,
            'delivered_at' => now(),
            'paid_at' => now(),
        ]);

        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.dashboard'));

        $response->assertOk();
        $kpis = $response->viewData('kpis');
        $this->assertEquals(1, $kpis['pending_orders']);
        $this->assertEquals(1, $kpis['shipping_orders']);
        $this->assertEquals(1, $kpis['completed_today']);
        $this->assertEquals(150000, $kpis['revenue_today']);
    }
}
