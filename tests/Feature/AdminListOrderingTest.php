<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminListOrderingTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true]);
    }

    public function test_admin_product_index_shows_newest_products_first(): void
    {
        $category = Category::create(['name' => 'Test Category']);

        Product::create([
            'name' => 'Older Product',
            'price' => 100000,
            'stock' => 10,
            'category_id' => $category->id,
        ]);

        $newerProduct = Product::create([
            'name' => 'Newest Product',
            'price' => 200000,
            'stock' => 20,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.products.index'));

        $response->assertOk();
        $products = $response->viewData('products');

        $this->assertNotNull($products);
        $this->assertSame($newerProduct->id, $products->first()->id);
    }

    public function test_admin_category_index_shows_newest_categories_first(): void
    {
        Category::create(['name' => 'Older Category']);
        $newerCategory = Category::create(['name' => 'Newest Category']);

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.categories.index'));

        $response->assertOk();
        $categories = $response->viewData('categories');

        $this->assertNotNull($categories);
        $this->assertSame($newerCategory->id, $categories->first()->id);
    }

    public function test_admin_order_index_shows_newest_orders_first(): void
    {
        $olderOrder = Order::factory()->create();
        $newerOrder = Order::factory()->create();

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.orders.index'));

        $response->assertOk();
        $orders = $response->viewData('orders');

        $this->assertNotNull($orders);
        $this->assertSame($newerOrder->id, $orders->first()->id);
    }

    public function test_admin_customer_index_shows_newest_customers_first(): void
    {
        $olderCustomer = User::factory()->create(['is_admin' => false, 'email' => 'older.customer@example.com']);
        $newerCustomer = User::factory()->create(['is_admin' => false, 'email' => 'newer.customer@example.com']);

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.customers.index'));

        $response->assertOk();
        $customers = $response->viewData('customers');

        $this->assertNotNull($customers);
        $this->assertSame($newerCustomer->id, $customers->first()->id);
    }
}
