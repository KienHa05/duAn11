<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUsersManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_view_admin_users_and_update_role(): void
    {
        $superAdmin = User::factory()->create([
            'is_admin' => true,
            'role' => 'super_admin',
        ]);

        $targetAdmin = User::factory()->create([
            'is_admin' => true,
            'role' => 'product_manager',
        ]);

        $this->actingAs($superAdmin, 'admin')
            ->get(route('admin.admin-users.index'))
            ->assertOk();

        $this->actingAs($superAdmin, 'admin')
            ->put(route('admin.admin-users.update', $targetAdmin), [
                'role' => 'order_manager',
            ])
            ->assertRedirect();

        $targetAdmin->refresh();
        $this->assertSame('order_manager', $targetAdmin->role);
    }

    public function test_product_manager_cannot_access_admin_users_page(): void
    {
        $productManager = User::factory()->create([
            'is_admin' => true,
            'role' => 'product_manager',
        ]);

        $this->actingAs($productManager, 'admin')
            ->get(route('admin.admin-users.index'))
            ->assertForbidden();
    }
}
