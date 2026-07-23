<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTrashManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['is_admin' => true]);
    }

    public function test_admin_trash_shows_only_soft_deleted_products_and_categories(): void
    {
        $activeCategory = Category::create(['name' => 'Active Category']);
        $deletedCategory = Category::create(['name' => 'Deleted Category']);
        $activeProduct = Product::create([
            'name' => 'Active Product',
            'price' => 100000,
            'stock' => 10,
            'category_id' => $activeCategory->id,
        ]);
        $olderDeletedProduct = Product::create([
            'name' => 'Older Deleted Product',
            'price' => 120000,
            'stock' => 5,
            'category_id' => $activeCategory->id,
        ]);
        $newerDeletedProduct = Product::create([
            'name' => 'Newer Deleted Product',
            'price' => 150000,
            'stock' => 7,
            'category_id' => $activeCategory->id,
        ]);

        $olderDeletedProduct->delete();
        $olderDeletedProduct->forceFill(['deleted_at' => now()->subDay()])->save();
        $newerDeletedProduct->delete();
        $deletedCategory->delete();

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.trash.index'));

        $response->assertOk();
        $response->assertSee('Thùng rác');
        $response->assertDontSee('Th&amp;ugrave;ng r&amp;aacute;c', false);
        $response->assertSee('Older Deleted Product');
        $response->assertSee('Newer Deleted Product');
        $response->assertSee('Deleted Category');
        $response->assertDontSee($activeProduct->name);
        $response->assertDontSee($activeCategory->name);

        $products = $response->viewData('products');
        $categories = $response->viewData('categories');

        $this->assertSame($newerDeletedProduct->id, $products->first()->id);
        $this->assertSame($deletedCategory->id, $categories->first()->id);
    }

    public function test_admin_can_restore_product_and_category_from_trash(): void
    {
        $category = Category::create(['name' => 'Restorable Category']);
        $product = Product::create([
            'name' => 'Restorable Product',
            'price' => 100000,
            'stock' => 10,
            'category_id' => $category->id,
        ]);

        $product->delete();
        $category->delete();

        $this->actingAs($this->admin, 'admin')
            ->post(route('admin.trash.products.restore', $product->id))
            ->assertRedirect(route('admin.trash.index'));

        $this->actingAs($this->admin, 'admin')
            ->post(route('admin.trash.categories.restore', $category->id))
            ->assertRedirect(route('admin.trash.index'));

        $this->assertDatabaseHas('products', ['id' => $product->id, 'deleted_at' => null]);
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'deleted_at' => null]);
    }

    public function test_admin_cannot_permanently_delete_product_used_by_order_items(): void
    {
        $category = Category::create(['name' => 'Sold Product Category']);
        $product = Product::create([
            'name' => 'Sold Product',
            'price' => 100000,
            'stock' => 10,
            'category_id' => $category->id,
        ]);
        $order = Order::create([
            'order_number' => 'ORD-TRASH-001',
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => 'cash',
            'subtotal' => 100000,
            'shipping_cost' => 0,
            'total_amount' => 100000,
            'phone_number' => '0900000000',
            'shipping_address' => 'Test address',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'unit_price' => 100000,
            'subtotal' => 100000,
        ]);

        $product->delete();

        $this->actingAs($this->admin, 'admin')
            ->delete(route('admin.trash.products.force-delete', $product->id))
            ->assertRedirect(route('admin.trash.index'))
            ->assertSessionHas('error');

        $this->assertSoftDeleted('products', ['id' => $product->id]);
        $this->assertDatabaseHas('order_items', ['product_id' => $product->id]);
    }
    public function test_admin_can_permanently_delete_product_and_category_from_trash(): void
    {
        $category = Category::create(['name' => 'Disposable Category']);
        $product = Product::create([
            'name' => 'Disposable Product',
            'price' => 100000,
            'stock' => 10,
            'category_id' => $category->id,
        ]);

        $product->delete();
        $category->delete();

        $this->actingAs($this->admin, 'admin')
            ->delete(route('admin.trash.products.force-delete', $product->id))
            ->assertRedirect(route('admin.trash.index'));

        $this->actingAs($this->admin, 'admin')
            ->delete(route('admin.trash.categories.force-delete', $category->id))
            ->assertRedirect(route('admin.trash.index'));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
