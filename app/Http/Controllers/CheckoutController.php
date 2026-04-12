<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\UserCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\OrderCreatedMail;

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
        // Decode items if it's a JSON string from the hidden input
        if ($request->has('items') && is_string($request->items)) {
            $request->merge([
                'items' => json_decode($request->items, true)
            ]);
        }

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

            // SECURITY: Validate prices from database (don't trust frontend)
            $validatedItems = [];
            $subtotal = 0;

            foreach ($items as $item) {
                // Get product from DB
                $product = Product::findOrFail($item['id']);

                // Compare frontend price with DB price
                // Allow ±1% tolerance for tiny float differences
                $priceDiff = abs($item['price'] - $product->price);
                $tolerance = $product->price * 0.01; // 1% tolerance

                if ($priceDiff > $tolerance) {
                    // Price mismatch - potential fraud attempt
                    throw new \Exception(
                        "Giá sản phẩm '{$product->name}' không khớp. Vui lòng tải lại và thử lại."
                    );
                }

                $validatedItems[] = [
                    'id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price, // Use DB price, not FE price
                ];

                $subtotal += $product->price * $item['quantity'];
            }

            // Calculate totals
            $shipping = $subtotal >= 500000 ? 0 : 30000;
            $discount = $request->discount ?? 0;
            $total = $subtotal + $shipping - $discount;

            // Generate tracking token for secure order tracking (especially for guests)
            $trackingToken = Str::random(64);

            // Create order
            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'tracking_token' => $trackingToken,
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

            // Create order items (using validated prices from DB)
            foreach ($validatedItems as $item) {
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

            // Gửi email xác nhận (Queue background)
            if ($order->customer_email) {
                Mail::to($order->customer_email)->send(new OrderCreatedMail($order));
            }

            // REDIRECT TO THANK YOU PAGE with tracking token
            return redirect()->route('checkout.thank-you', ['tracking_token' => $trackingToken])
                ->with('success', 'Đơn hàng đã được tạo thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi khi tạo đơn hàng: ' . $e->getMessage());
        }
    }

    /**
     * STAGE 3: Thank you page - Show order summary & guest upgrade option
     * Accessible via tracking_token (for guests) or auth check (for members)
     */
    public function thankYou($trackingToken)
    {
        // Find order by tracking token
        $order = Order::where('tracking_token', $trackingToken)->firstOrFail();
        $order->load(['items.product', 'shipment', 'payments']);

        // Check authorization:
        // - If member logged in: can only view their own orders
        // - If guest: can view via tracking_token
        if ($order->user_id && Auth::check() && $order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xem đơn hàng này');
        }

        return view('checkout.thank-you', compact('order', 'trackingToken'));
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

    /**
     * STAGE 3.5: Guest Upgrade to Member
     * Allow guest user to create account with their order email
     * Then link order to newly created user account
     */
    public function guestUpgrade(Request $request, $trackingToken)
    {
        // Find order by tracking token
        $order = Order::where('tracking_token', $trackingToken)->firstOrFail();

        // Only allow upgrade for guest orders
        if (!$order->is_guest || $order->user_id !== null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đơn hàng này không thể nâng cấp thành tài khoản thành viên'
            ], 422);
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải ít nhất 8 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
        ]);

        try {
            DB::beginTransaction();

            // Check if email already exists
            $existingUser = User::where('email', $order->guest_email)->first();

            if ($existingUser) {
                // Email already exists - suggest login instead
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email này đã được đăng ký. Vui lòng đăng nhập thay vào đó.',
                    'email_exists' => true
                ], 422);
            }

            // Create new user account using guest email
            $user = User::create([
                'name' => $order->guest_name,
                'email' => $order->guest_email,
                'phone' => $order->phone_number,
                'password' => bcrypt($request->password),
                'email_verified_at' => now(), // Auto-verify since it's from order
            ]);

            // Link order to newly created user
            $order->update([
                'user_id' => $user->id,
                'is_guest' => false,
            ]);

            // Auto-login the user
            Auth::login($user);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Tài khoản đã được tạo thành công! Chúng tôi sẽ tự động đăng nhập cho bạn.',
                'redirect' => route('orders.history')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Lỗi khi tạo tài khoản: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Check if email exists in system
     * Used during checkout to detect existing accounts
     * Returns user info if exists, or empty if new email
     */
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $email = $request->email;
        $user = User::where('email', $email)->select('id', 'name', 'email', 'phone')->first();

        if ($user) {
            // Email exists - return user info for suggestion
            return response()->json([
                'status' => 'exists',
                'exists' => true,
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ]
            ]);
        } else {
            // Email is new - can proceed with guest checkout
            return response()->json([
                'status' => 'new',
                'exists' => false,
            ]);
        }
    }
}

