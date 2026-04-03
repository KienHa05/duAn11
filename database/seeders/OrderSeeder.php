<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipment;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            return;
        }

        // Create 10 sample orders
        for ($i = 0; $i < 10; $i++) {
            $user = $users->random();
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $user->id,
                'status' => ['pending', 'confirmed', 'processing', 'shipped', 'delivered'][rand(0, 4)],
                'shipping_method' => ['GHN', 'Viettel', 'VNTE'][rand(0, 2)],
                'shipping_address' => '123 Đường ABC, Quận 1',
                'shipping_details' => 'Tầng 5, Toà nhà XYZ',
                'phone_number' => '0123456789',
                'payment_method' => ['cash', 'bank_transfer', 'credit_card'][rand(0, 2)],
                'payment_status' => ['pending', 'paid', 'failed'][rand(0, 2)],
                'notes' => 'Ghi chú mẫu cho đơn hàng',
                'paid_at' => rand(0, 1) ? now()->subDays(rand(1, 10)) : null,
                'shipped_at' => rand(0, 1) ? now()->subDays(rand(1, 5)) : null,
                'delivered_at' => rand(0, 1) ? now()->subDays(rand(0, 3)) : null,
            ]);

            // Add order items
            $itemCount = rand(1, 3);
            $subtotal = 0;
            for ($j = 0; $j < $itemCount; $j++) {
                $product = $products->random();
                $quantity = rand(1, 3);
                $unitPrice = $product->price;
                $itemSubtotal = $unitPrice * $quantity;
                $subtotal += $itemSubtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $itemSubtotal,
                    'size' => ['XS', 'S', 'M', 'L', 'XL'][rand(0, 4)],
                    'color' => ['Đen', 'Trắng', 'Xám', 'Đỏ'][rand(0, 3)],
                ]);
            }

            // Calculate and update totals
            $shippingCost = 30000;
            $discount = rand(0, 1) ? rand(10000, 50000) : 0;
            $totalAmount = $subtotal + $shippingCost - $discount;

            $order->update([
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'discount' => $discount,
                'total_amount' => max($totalAmount, 0),
            ]);

            // Create shipment if order is shipped or delivered
            if (in_array($order->status, ['shipped', 'delivered'])) {
                Shipment::create([
                    'order_id' => $order->id,
                    'tracking_number' => 'TRK' . str_pad(rand(1000000, 9999999), 7, '0', STR_PAD_LEFT),
                    'carrier' => $order->shipping_method,
                    'status' => $order->status === 'delivered' ? 'delivered' : 'in_transit',
                    'shipped_at' => $order->shipped_at,
                    'estimated_delivery' => $order->shipped_at ? $order->shipped_at->addDays(3) : null,
                    'delivered_at' => $order->delivered_at,
                ]);
            }
        }
    }
}
