<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRoleAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_access_all_admin_sections(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
            'role' => 'super_admin',
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.dashboard'))
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.products.index'))
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.orders.index'))
            ->assertOk();
    }

    public function test_product_manager_can_access_product_and_category_sections_only(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
            'role' => 'product_manager',
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.dashboard'))
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.products.index'))
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.categories.index'))
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.orders.index'))
            ->assertForbidden();
    }

    public function test_order_manager_can_access_order_section_only(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
            'role' => 'order_manager',
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.dashboard'))
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.orders.index'))
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.products.index'))
            ->assertForbidden();
    }
}
