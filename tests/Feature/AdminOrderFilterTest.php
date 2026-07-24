<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderFilterTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true]);
    }

    public function test_filter_by_order_number(): void
    {
        Order::factory()->create(['order_number' => 'ORD12345']);
        Order::factory()->create(['order_number' => 'ORD99999']);

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.orders.index', ['order_number' => '12345']));

        $response->assertOk();
        $orders = $response->viewData('orders');
        $this->assertCount(1, $orders);
        $this->assertEquals('ORD12345', $orders->first()->order_number);
    }

    public function test_filter_by_customer_name_member(): void
    {
        $user = User::factory()->create(['name' => 'Nguyen Van A']);
        Order::factory()->create(['user_id' => $user->id, 'is_guest' => false]);
        Order::factory()->create(); // unrelated order

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.orders.index', ['customer' => 'Nguyen Van']));

        $response->assertOk();
        $orders = $response->viewData('orders');
        $this->assertCount(1, $orders);
    }

    public function test_filter_by_customer_email_member(): void
    {
        $user = User::factory()->create(['email' => 'customer@example.com']);
        Order::factory()->create(['user_id' => $user->id, 'is_guest' => false]);
        Order::factory()->create();

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.orders.index', ['customer' => 'customer@example.com']));

        $response->assertOk();
        $orders = $response->viewData('orders');
        $this->assertCount(1, $orders);
    }

    public function test_filter_by_guest_name(): void
    {
        Order::factory()->create(['is_guest' => true, 'guest_name' => 'Tran Van B', 'user_id' => null]);
        Order::factory()->create();

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.orders.index', ['customer' => 'Tran Van']));

        $response->assertOk();
        $orders = $response->viewData('orders');
        $this->assertCount(1, $orders);
    }

    public function test_filter_by_guest_email(): void
    {
        Order::factory()->create(['is_guest' => true, 'guest_email' => 'guest@test.com', 'user_id' => null]);
        Order::factory()->create();

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.orders.index', ['customer' => 'guest@test.com']));

        $response->assertOk();
        $orders = $response->viewData('orders');
        $this->assertCount(1, $orders);
    }

    public function test_filter_by_status(): void
    {
        Order::factory()->create(['status' => 'completed']);
        Order::factory()->create(['status' => 'pending']);
        Order::factory()->create(['status' => 'cancelled']);

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.orders.index', ['status' => 'completed']));

        $response->assertOk();
        $orders = $response->viewData('orders');
        $this->assertCount(1, $orders);
        $this->assertEquals('completed', $orders->first()->status);
    }

    public function test_filter_by_date_range(): void
    {
        Order::factory()->create(['created_at' => '2025-01-15 10:00:00']);
        Order::factory()->create(['created_at' => '2025-02-20 10:00:00']);
        Order::factory()->create(['created_at' => '2025-03-10 10:00:00']);

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.orders.index', [
                'date_from' => '2025-02-01',
                'date_to' => '2025-02-28',
            ]));

        $response->assertOk();
        $orders = $response->viewData('orders');
        $this->assertCount(1, $orders);
    }

    public function test_filter_by_date_from_only(): void
    {
        Order::factory()->create(['created_at' => '2025-01-15 10:00:00']);
        Order::factory()->create(['created_at' => '2025-03-10 10:00:00']);

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.orders.index', ['date_from' => '2025-02-01']));

        $response->assertOk();
        $orders = $response->viewData('orders');
        $this->assertCount(1, $orders);
    }

    public function test_filter_by_date_to_only(): void
    {
        Order::factory()->create(['created_at' => '2025-01-15 10:00:00']);
        Order::factory()->create(['created_at' => '2025-03-10 10:00:00']);

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.orders.index', ['date_to' => '2025-02-01']));

        $response->assertOk();
        $orders = $response->viewData('orders');
        $this->assertCount(1, $orders);
    }

    public function test_combined_filters(): void
    {
        $user = User::factory()->create(['name' => 'Nguyen Van A']);
        Order::factory()->create([
            'user_id' => $user->id,
            'is_guest' => false,
            'status' => 'completed',
            'created_at' => '2025-01-15 10:00:00',
            'order_number' => 'ORD11111',
        ]);
        // Same customer but different status
        Order::factory()->create([
            'user_id' => $user->id,
            'is_guest' => false,
            'status' => 'pending',
            'created_at' => '2025-01-20 10:00:00',
            'order_number' => 'ORD22222',
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.orders.index', [
                'customer' => 'Nguyen Van A',
                'status' => 'completed',
                'date_from' => '2025-01-01',
                'date_to' => '2025-01-31',
            ]));

        $response->assertOk();
        $orders = $response->viewData('orders');
        $this->assertCount(1, $orders);
        $this->assertEquals('completed', $orders->first()->status);
    }

    public function test_no_filter_returns_all_orders(): void
    {
        Order::factory()->count(5)->create();

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.orders.index'));

        $response->assertOk();
        $orders = $response->viewData('orders');
        $this->assertCount(5, $orders);
    }

    public function test_no_results_shows_empty_without_error(): void
    {
        Order::factory()->create(['order_number' => 'ORD11111']);

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.orders.index', ['order_number' => 'NONEXISTENT']));

        $response->assertOk();
        $orders = $response->viewData('orders');
        $this->assertCount(0, $orders);
    }

    public function test_filter_preserves_pagination(): void
    {
        Order::factory()->count(20)->create(['status' => 'pending']);

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.orders.index', [
                'status' => 'pending',
                'page' => 2,
            ]));

        $response->assertOk();
        $orders = $response->viewData('orders');
        $this->assertEquals(2, $orders->currentPage());
        $this->assertStringContainsString('status=pending', $orders->url(2));
    }

    public function test_does_not_affect_existing_sorting(): void
    {
        $older = Order::factory()->create(['created_at' => '2025-01-01 10:00:00']);
        $newer = Order::factory()->create(['created_at' => '2025-03-01 10:00:00']);

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.orders.index', ['status' => 'pending']));

        $response->assertOk();
        $orders = $response->viewData('orders');
        $this->assertEquals($newer->id, $orders->first()->id);
    }
}