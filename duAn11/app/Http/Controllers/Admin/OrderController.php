<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
  /**
   * Display a listing of the orders.
   */
  public function index()
  {
    $orders = Order::with(['user', 'shipment', 'latestPayment'])
      ->orderBy('created_at', 'desc')
      ->paginate(15);

    return view('admin.orders.index', compact('orders'));
  }

  /**
   * Display the specified order.
   */
  public function show(Order $order)
  {
    $order->load(['user', 'items.product', 'shipment', 'payments']);
    return view('admin.orders.show', compact('order'));
  }

  /**
   * Show the form for editing the order status.
   */
  public function edit(Order $order)
  {
    return view('admin.orders.edit', compact('order'));
  }

  /**
   * Update the order status.
   */
  public function update(Request $request, Order $order)
  {
    $request->validate([
      'status' => 'required|in:pending,confirmed,shipping,completed,cancelled,returned',
      'payment_status' => 'required|in:pending,paid,failed,refunded',
      'notes' => 'nullable|string',
    ]);

    $data = $request->only('status', 'payment_status', 'notes');

    // Automatic logic based on status
    if ($request->status === 'shipping') {
      if (!$order->shipped_at) {
        $data['shipped_at'] = now();
      }
      
      // Update shipment if it exists, or create if not
      if (!$order->shipment) {
        $order->shipment()->create(['status' => 'in_transit']);
      } else {
        $order->shipment->update(['status' => 'in_transit']);
      }
    }

    if ($request->status === 'completed') {
      if (!$order->delivered_at) {
        $data['delivered_at'] = now();
      }
      
      // If payment is pending (likely COD), auto-mark as paid
      if ($order->payment_status === 'pending') {
        $data['payment_status'] = 'paid';
        $data['paid_at'] = now();
      }

      // Update shipment status if exists
      if ($order->shipment) {
        $order->shipment->update(['status' => 'delivered']);
      }
    }

    $order->update($data);

    return redirect()->route('admin.orders.show', $order)->with('success', 'Đơn hàng đã được cập nhật!');
  }

  /**
   * Update shipment tracking
   */
  public function updateShipment(Request $request, Order $order)
  {
    $request->validate([
      'tracking_number' => 'nullable|string',
      'carrier' => 'nullable|string',
      'estimated_delivery' => 'nullable|date',
    ]);

    if (!$order->shipment) {
      $order->shipment()->create($request->all());
    } else {
      $order->shipment->update($request->all());
    }

    return redirect()->route('admin.orders.show', $order)->with('success', 'Thông tin vận chuyển đã được cập nhật!');
  }

  /**
   * Cancel an order
   */
  public function cancel(Request $request, Order $order)
  {
    $request->validate([
      'reason' => 'required|string|max:500',
    ]);

    if ($order->isDelivered()) {
      return back()->with('error', 'Không thể hủy đơn hàng đã giao!');
    }

    $order->update([
      'status' => 'cancelled',
      'notes' => $request->reason,
    ]);

    return redirect()->route('admin.orders.show', $order)->with('success', 'Đơn hàng đã được hủy!');
  }
}
