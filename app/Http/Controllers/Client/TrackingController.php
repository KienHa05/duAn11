<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('client.track-order');
    }

    public function process(Request $request)
    {
        $request->validate([
            'tracking_token' => 'required|string',
            'email' => 'required|email'
        ], [
            'tracking_token.required' => 'Vui lòng nhập mã tracking.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Định dạng email không hợp lệ.'
        ]);

        $order = Order::where('tracking_token', $request->tracking_token)->first();

        if (!$order) {
            return back()->withInput()->with('error', 'Không tìm thấy đơn hàng với mã Tracking này.');
        }

        // Validate email
        $validEmail = strtolower(trim($order->customer_email));
        $inputEmail = strtolower(trim($request->email));

        if ($validEmail !== $inputEmail) {
            return back()->withInput()->with('error', 'Email xác thực không chính xác. Xin thử lại.');
        }

        return redirect()->route('checkout.thank-you', ['tracking_token' => $order->tracking_token])
                         ->with('success', 'Xác thực thành công. Dưới đây là trạng thái đơn hàng của bạn.');
    }
}
