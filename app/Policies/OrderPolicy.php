<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine whether the admin can view any orders
     */
    public function viewAny(?User $user): bool
    {
        // Admin only
        return $user && $user->is_admin === true;
    }

    /**
     * Determine whether the user can view the order
     * - Admin can always view
     * - Member can view their own orders
     * - Guest can view via tracking_token
     */
    public function view(?User $user, Order $order): bool
    {
        // Admin can view any order
        if ($user && $user->is_admin === true) {
            return true;
        }

        // Member viewing their own order
        if ($user && $order->user_id === $user->id && !$order->is_guest) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the admin can update the order
     */
    public function update(?User $user, Order $order): bool
    {
        // Admin only
        return $user && $user->is_admin === true;
    }

    /**
     * Determine whether the admin can delete the order
     */
    public function delete(?User $user, Order $order): bool
    {
        // Admin only - but soft delete is used, so this is mostly for audit
        return $user && $user->is_admin === true;
    }
}
