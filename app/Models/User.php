<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'phone', 'password', 'is_admin', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    public const ROLE_SUPER_ADMIN = 'super_admin';
    public const ROLE_PRODUCT_MANAGER = 'product_manager';
    public const ROLE_ORDER_MANAGER = 'order_manager';

    public static function roles(): array
    {
        return [
            self::ROLE_SUPER_ADMIN,
            self::ROLE_PRODUCT_MANAGER,
            self::ROLE_ORDER_MANAGER,
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->is_admin && ($this->role ?: self::ROLE_SUPER_ADMIN) === self::ROLE_SUPER_ADMIN;
    }

    public function isProductManager(): bool
    {
        return $this->is_admin && ($this->role ?: self::ROLE_SUPER_ADMIN) === self::ROLE_PRODUCT_MANAGER;
    }

    public function isOrderManager(): bool
    {
        return $this->is_admin && ($this->role ?: self::ROLE_SUPER_ADMIN) === self::ROLE_ORDER_MANAGER;
    }

    public function hasPermission(string $permission): bool
    {
        if (!$this->is_admin) {
            return false;
        }

        $role = $this->role ?: self::ROLE_SUPER_ADMIN;

        return match ($role) {
            self::ROLE_SUPER_ADMIN => true,
            self::ROLE_PRODUCT_MANAGER => in_array($permission, ['dashboard', 'products', 'categories'], true),
            self::ROLE_ORDER_MANAGER => in_array($permission, ['dashboard', 'orders'], true),
            default => false,
        };
    }
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Relationships
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
