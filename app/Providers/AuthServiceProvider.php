<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\User;
use App\Policies\OrderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The model to policy mappings for the application.
   *
   * @var array<class-string, class-string>
   */
  protected $policies = [
    Order::class => OrderPolicy::class,
  ];

  /**
   * Register any authentication / authorization services.
   */
  public function boot(): void
  {
    Gate::define('access-dashboard', function (?User $user) {
      return $user && $user->is_admin && ($user->isSuperAdmin() || $user->hasPermission('dashboard'));
    });

    Gate::define('access-products', function (?User $user) {
      return $user && $user->is_admin && ($user->isSuperAdmin() || $user->hasPermission('products'));
    });

    Gate::define('access-categories', function (?User $user) {
      return $user && $user->is_admin && ($user->isSuperAdmin() || $user->hasPermission('categories'));
    });

    Gate::define('access-trash', function (?User $user) {
      return $user && $user->is_admin && ($user->isSuperAdmin() || $user->hasPermission('products') || $user->hasPermission('categories'));
    });

    Gate::define('access-orders', function (?User $user) {
      return $user && $user->is_admin && ($user->isSuperAdmin() || $user->hasPermission('orders'));
    });

    Gate::define('access-customers', function (?User $user) {
      return $user && $user->is_admin && ($user->isSuperAdmin() || $user->hasPermission('customers'));
    });

    Gate::define('access-admin-users', function (?User $user) {
      return $user && $user->is_admin && $user->isSuperAdmin();
    });
  }
}
