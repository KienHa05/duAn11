<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_number' => 'ORD' . fake()->unique()->numberBetween(10000, 99999),
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => 'cod',
            'total_amount' => 100000,
            'subtotal' => 100000,
            'shipping_cost' => 0,
            'phone_number' => fake()->phoneNumber(),
            'shipping_address' => fake()->address(),
        ];
    }
}
