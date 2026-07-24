<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProductBulkActionsTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->category = Category::create(['name' => 'Test Category']);
    }

    public function test_admin_can_bulk_delete_selected_products(): void
    {
        $p1 = Product::create([
            'name' => 'Product 1',
            'price' => 100000,
            'stock' => 10,
            'category_id' => $this->category->id,
        ]);
        $p2 = Product::create([
            'name' => 'Product 2',
            'price' => 200000,
            'stock' => 5,
            'category_id' => $this->category->id,
        ]);
        $p3 = Product::create([
            'name' => 'Product 3',
            'price' => 300000,
            'stock' => 15,
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('admin.products.bulk-delete'), [
                'product_ids' => [$p1->id, $p2->id],
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertSoftDeleted('products', ['id' => $p1->id]);
        $this->assertSoftDeleted('products', ['id' => $p2->id]);
        $this->assertDatabaseHas('products', [
            'id' => $p3->id,
            'deleted_at' => null,
        ]);
    }

    public function test_admin_can_bulk_restore_selected_products(): void
    {
        $p1 = Product::create([
            'name' => 'Product 1',
            'price' => 100000,
            'stock' => 10,
            'category_id' => $this->category->id,
        ]);
        $p2 = Product::create([
            'name' => 'Product 2',
            'price' => 200000,
            'stock' => 5,
            'category_id' => $this->category->id,
        ]);
        $p3 = Product::create([
            'name' => 'Product 3',
            'price' => 300000,
            'stock' => 15,
            'category_id' => $this->category->id,
        ]);

        $p1->delete();
        $p2->delete();
        $p3->delete();

        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('admin.trash.products.bulk-restore'), [
                'product_ids' => [$p1->id, $p2->id],
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'id' => $p1->id,
            'deleted_at' => null,
        ]);
        $this->assertDatabaseHas('products', [
            'id' => $p2->id,
            'deleted_at' => null,
        ]);
        $this->assertSoftDeleted('products', ['id' => $p3->id]);
    }

    public function test_bulk_delete_with_no_products_selected_displays_error(): void
    {
        $p1 = Product::create([
            'name' => 'Product 1',
            'price' => 100000,
            'stock' => 10,
            'category_id' => $this->category->id,
        ]);

        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('admin.products.bulk-delete'), [
                'product_ids' => [],
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Vui lòng chọn ít nhất một sản phẩm.');
        $this->assertDatabaseHas('products', [
            'id' => $p1->id,
            'deleted_at' => null,
        ]);
    }

    public function test_bulk_restore_with_no_products_selected_displays_error(): void
    {
        $p1 = Product::create([
            'name' => 'Product 1',
            'price' => 100000,
            'stock' => 10,
            'category_id' => $this->category->id,
        ]);
        $p1->delete();

        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('admin.trash.products.bulk-restore'), [
                'product_ids' => [],
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Vui lòng chọn ít nhất một sản phẩm.');
        $this->assertSoftDeleted('products', ['id' => $p1->id]);
    }
}
