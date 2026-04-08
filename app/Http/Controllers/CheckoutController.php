<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * STAGE 1 & 2: Show checkout form (guest checkout)
     * User fills basic info without login
     */
    public function showCheckout()
    {
        return view('checkout.form');
    }

    /**
     * STAGE 3: After login - migrate localStorage cart to database
     * Logic:
     * - FOR each item in localStorage:
     *   - IF product_id exists in user's cart: quantity += local.quantity
     *   - ELSE: INSERT new item
     * - Clear localStorage after migration
     */
    public function migrateCart(Request $request)
    {
        // Validate user is authenticated
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $localItems = $request->items;

        try {
            foreach ($localItems as $item) {
                // Check if item exists in user's cart
                $existingCart = UserCart::where('user_id', $user->id)
                    ->where('product_id', $item['id'])
                    ->first();

                if ($existingCart) {
                    // EXISTS: Update quantity (add local quantity)
                    $existingCart->update([
                        'quantity' => $existingCart->quantity + $item['quantity']
                    ]);
                } else {
                    // NOT EXISTS: Insert new item
                    UserCart::create([
                        'user_id' => $user->id,
                        'product_id' => $item['id'],
                        'quantity' => $item['quantity'],
                    ]);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Giỏ hàng đã được cập nhật',
                'cart_count' => UserCart::where('user_id', $user->id)->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lỗi khi cập nhật giỏ hàng: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * STAGE 4: Create order from checkout form
     * Handles both guest and registered checkout
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'shipping_details' => 'nullable|string',
            'payment_method' => 'required|in:cash,bank_transfer,credit_card,e_wallet',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer|exists:products,id',
            'items.*.price' => 'required|integer|min:0',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $items = $request->items;

            // Calculate totals
            $subtotal = collect($items)->sum(fn($item) => $item['price'] * $item['quantity']);
            $shipping = $subtotal >= 500000 ? 0 : 30000;
            $discount = $request->discount ?? 0;
            $total = $subtotal + $shipping - $discount;

            // Create order
            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'user_id' => $user?->id,
                'is_guest' => !$user,
                'guest_name' => $request->name,
                'guest_email' => $request->email,
                'status' => 'pending',
                'shipping_method' => $request->shipping_method ?? 'standard',
                'shipping_address' => $request->address,
                'shipping_details' => $request->shipping_details,
                'phone_number' => $request->phone,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'subtotal' => $subtotal,
                'shipping_cost' => $shipping,
                'discount' => $discount,
                'total_amount' => $total,
            ]);

            // Create order items
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }

            // If logged in: clear user cart from database
            if ($user) {
                UserCart::clearCart($user->id);
            }

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Đơn hàng đã được tạo thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi khi tạo đơn hàng: ' . $e->getMessage());
        }
    }

    /**
     * Show order details (for both guest and registered users)
     */
    public function show(Order $order)
    {
        // Allow guest to view their order with order number (no auth needed for guest orders)
        // or allow authed user to view their order
        if ($order->user_id && $order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $order->load(['items.product', 'shipment', 'payments']);
        return view('orders.show', compact('order'));
    }

    /**
     * Get order history for authenticated user
     */
    public function history()
    {
        $this->middleware('auth');

        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.history', compact('orders'));
    }

    /**
     * Generate unique order number
     * Format: ORD-YYMMDD-XXXXX
     */
    private function generateOrderNumber()
    {
        $date = now()->format('ymd');
        $count = Order::whereDate('created_at', today())->count() + 1;
        return 'ORD-' . $date . '-' . str_pad($count, 5, '0', STR_PAD_LEFT);
    }
}
