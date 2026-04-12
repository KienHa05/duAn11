<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #111827; background-color: #f9fafb; margin: 0; padding: 20px; }
        .container { max-w-7xl; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; max-width: 600px; border: 1px solid #e5e7eb; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .header { background-color: #000000; text-align: center; padding: 30px 20px; }
        .logo-box { display: inline-block; width: 40px; height: 40px; background-color: #ffffff; color: #000000; font-weight: 900; font-size: 24px; line-height: 40px; border-radius: 8px; margin-bottom: 15px; }
        .header h1 { color: #ffffff; font-size: 20px; margin: 0; letter-spacing: 2px; text-transform: uppercase; }
        .content { padding: 40px 30px; }
        .title { font-size: 24px; font-weight: 700; margin-top: 0; margin-bottom: 20px; }
        .order-info { background-color: #f3f4f6; border-radius: 8px; padding: 15px 20px; margin-bottom: 30px; }
        .order-info p { margin: 5px 0; font-size: 14px; }
        .order-info strong { color: #000000; }
        .table { w-full; border-collapse: collapse; margin-bottom: 30px; width: 100%; }
        .table th { text-align: left; padding: 12px 15px; border-bottom: 2px solid #e5e7eb; color: #6b7280; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; }
        .table td { padding: 15px; border-bottom: 1px solid #e5e7eb; vertical-align: top; }
        .item-name { font-weight: 600; margin: 0 0 5px 0; }
        .item-qty { color: #6b7280; font-size: 13px; margin: 0; }
        .text-right { text-align: right; }
        .summary-row { display: flex; justify-content: space-between; padding: 8px 0; font-size: 14px; }
        .summary-hr { border: 0; border-top: 1px solid #e5e7eb; margin: 15px 0; }
        .summary-total { font-size: 18px; font-weight: 700; padding-top: 10px; border-top: 2px solid #111827; }
        .shipping-box { border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; margin-top: 30px; }
        .shipping-box h3 { margin-top: 0; font-size: 16px; margin-bottom: 15px; }
        .shipping-box p { margin: 5px 0; font-size: 14px; color: #4b5563; }
        .btn { display: inline-block; background-color: #000000; color: #ffffff; text-decoration: none; padding: 14px 30px; border-radius: 6px; font-weight: 600; font-size: 15px; text-align: center; margin-top: 30px; width: 100%; box-sizing: border-box; }
        .footer { text-align: center; padding: 30px; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-box">N</div>
            <h1>NOTORIOUS</h1>
        </div>
        
        <div class="content">
            <h2 class="title">Đơn hàng của bạn đã được tiếp nhận</h2>
            
            <p>Xin chào {{ $order->customer_name }},</p>
            <p>Cám ơn bạn đã mua sắm tại NOTORIOUS. Chúng tôi đã nhận được đơn hàng của bạn và đang tiến hành xử lý.</p>
            
            <div class="order-info">
                <p>Mã đơn hàng: <strong>{{ $order->order_number }}</strong></p>
                <p>Ngày đặt: <strong>{{ $order->created_at->format('d/m/Y H:i') }}</strong></p>
                <p>Mã siêu bảo mật (Tracking Token): <strong>{{ $order->tracking_token }}</strong></p>
            </div>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th class="text-right">Tạm tính</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <p class="item-name">{{ $item->product->name }}</p>
                            <p class="item-qty">Số lượng: x{{ $item->quantity }}</p>
                        </td>
                        <td class="text-right font-semibold">
                            {{ number_format($item->subtotal, 0, ',', '.') }} ₫
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div style="margin-left: auto; width: 60%;">
                <table width="100%" cellspacing="0" cellpadding="5">
                    <tr>
                        <td align="left" style="color: #6b7280; font-size: 14px;">Tổng hàng:</td>
                        <td align="right" style="font-weight: 600; font-size: 14px;">{{ number_format($order->subtotal, 0, ',', '.') }} ₫</td>
                    </tr>
                    <tr>
                        <td align="left" style="color: #6b7280; font-size: 14px;">Vận chuyển:</td>
                        <td align="right" style="font-weight: 600; font-size: 14px;">{{ $order->shipping_cost > 0 ? number_format($order->shipping_cost, 0, ',', '.') . ' ₫' : 'Miễn phí' }}</td>
                    </tr>
                    @if($order->discount > 0)
                    <tr>
                        <td align="left" style="color: #6b7280; font-size: 14px;">Giảm giá:</td>
                        <td align="right" style="color: #dc2626; font-weight: 600; font-size: 14px;">-{{ number_format($order->discount, 0, ',', '.') }} ₫</td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="2"><div class="summary-hr"></div></td>
                    </tr>
                    <tr>
                        <td align="left" style="font-weight: 700; font-size: 16px;">TỔNG CỘNG:</td>
                        <td align="right" style="font-weight: 700; font-size: 18px; color: #000000;">{{ number_format($order->total_amount, 0, ',', '.') }} ₫</td>
                    </tr>
                </table>
            </div>
            
            <div class="shipping-box">
                <h3>Thông Tin Giao Hàng</h3>
                <p><strong>Người nhận:</strong> {{ $order->customer_name }}</p>
                <p><strong>Số điện thoại:</strong> {{ $order->phone_number }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
                @if($order->shipping_details)
                <p><strong>Ghi chú:</strong> {{ $order->shipping_details }}</p>
                @endif
                <p><strong>Phương thức Thanh Toán:</strong> {{ $order->payment_method === 'cash' ? 'Thanh toán COD' : ($order->payment_method === 'bank_transfer' ? 'Chuyển khoản / Bank Transfer' : 'Thẻ Mua Hàng') }}</p>
            </div>
            
            <a href="{{ url('/checkout/thank-you/' . $order->tracking_token) }}" class="btn" style="color: white">Theo Dõi Đơn Hàng Của Bạn Đoán</a>
        </div>
        
        <div class="footer">
            <p>Đây là e-mail tự động, vui lòng không trả lời trực tiếp.</p>
            <p>&copy; {{ date('Y') }} NOTORIOUS PLATFORM. TẤT CẢ QUYỀN ĐƯỢC BẢO LƯU.</p>
        </div>
    </div>
</body>
</html>
