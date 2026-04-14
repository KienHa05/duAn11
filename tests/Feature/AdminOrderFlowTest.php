<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderFlowTest extends TestCase
{
  use RefreshDatabase;

  protected $admin;

  protected function setUp(): void
  {
    parent::setUp();
    $this->admin = User::factory()->create(['is_admin' => true]);
  }

  public function test_admin_can_update_order_to_shipping_and_auto_sets_shipped_at()
  {
    $order = Order::factory()->create(['status' => 'pending']);

    $response = $this->actingAs($this->admin, 'admin')
      ->put(route('admin.orders.update', $order), [
        'status' => 'shipping',
        'payment_status' => 'pending',
      ]);

    $response->assertStatus(302);
    $order->refresh();

    $this->assertEquals('shipping', $order->status);
    $this->assertNotNull($order->shipped_at);
  }

  public function test_admin_can_update_order_to_completed_and_auto_sets_delivered_at_and_paid()
  {
    $order = Order::factory()->create([
      'status' => 'shipping',
      'payment_status' => 'pending'
    ]);

    $response = $this->actingAs($this->admin, 'admin')
      ->put(route('admin.orders.update', $order), [
        'status' => 'completed',
        'payment_status' => 'pending', // Even if submitted as pending, should auto-switch to paid
      ]);

    $response->assertStatus(302);
    $order->refresh();

    $this->assertEquals('completed', $order->status);
    $this->assertNotNull($order->delivered_at);
    $this->assertEquals('paid', $order->payment_status);
    $this->assertNotNull($order->paid_at);
  }
}
