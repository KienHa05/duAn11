@extends('layouts.app')

@section('title', 'Lịch sử mua hàng - The Notorious')

@section('content')
<div class="min-h-screen bg-white py-20 px-4">
    <div class="container mx-auto max-w-5xl">
        <!-- Header -->
        <div class="mb-16" data-aos="fade-right">
            <h1 class="text-4xl font-black tracking-tighter text-black uppercase">Đơn hàng của bạn</h1>
            <p class="text-gray-400 mt-2 text-sm font-bold tracking-widest uppercase">Quản lý và theo dõi hành trình phong cách</p>
        </div>

        @if ($orders->count() > 0)
            <div class="space-y-6">
                @foreach ($orders as $order)
                    <div class="group bg-white rounded-3xl border border-gray-100 p-8 hover:border-black/10 hover:shadow-2xl hover:shadow-black/5 transition-all duration-500" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                            <!-- Order Info -->
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <span class="text-[10px] font-black uppercase tracking-[0.2em] px-3 py-1 bg-gray-50 text-gray-400 rounded-full">#{{ $order->order_number }}</span>
                                    <span class="text-[10px] font-black uppercase tracking-[0.2em] px-3 py-1 rounded-full
                                        @if ($order->status === 'pending') bg-yellow-50 text-yellow-600
                                        @elseif ($order->status === 'confirmed') bg-blue-50 text-blue-600
                                        @elseif ($order->status === 'shipping') bg-black text-white
                                        @elseif ($order->status === 'completed') bg-green-50 text-green-600
                                        @else bg-red-50 text-red-600 @endif">
                                        {{ $order->status_label }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-2xl font-black tracking-tight text-black">{{ number_format($order->total_amount) }}₫</p>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Đặt ngày {{ $order->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>

                            <!-- Products Preview -->
                            <div class="flex -space-x-4 overflow-hidden py-1">
                                @foreach($order->items->take(3) as $item)
                                    <div class="w-16 h-16 rounded-2xl border-4 border-white overflow-hidden bg-gray-50 flex items-center justify-center shadow-sm">
                                        <img src="{{ $item->product->main_image_url ?? 'https://placehold.co/100x100?text=P' }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                                @if($order->items->count() > 3)
                                    <div class="w-16 h-16 rounded-2xl border-4 border-white bg-gray-100 flex items-center justify-center text-[10px] font-black text-gray-400 shadow-sm">
                                        +{{ $order->items->count() - 3 }}
                                    </div>
                                @endif
                            </div>

                            <!-- Action -->
                            <div class="flex items-center gap-4">
                                <a href="{{ route('orders.show', $order) }}" 
                                    class="h-12 px-8 flex items-center justify-center bg-gray-50 hover:bg-black hover:text-white rounded-2xl text-[11px] font-black uppercase tracking-[0.2em] transition-all active:scale-95">
                                    Chi tiết <span class="hidden sm:inline ml-1">đơn hàng</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($orders->hasPages())
                <div class="mt-16 flex justify-center">
                    {{ $orders->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="py-20 text-center" data-aos="zoom-in">
                <div class="w-24 h-24 bg-gray-50 rounded-[2.5rem] flex items-center justify-center mx-auto mb-8 text-gray-200">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-black tracking-tighter text-black uppercase mb-2">Chưa có đơn hàng</h3>
                <p class="text-gray-400 font-bold text-sm tracking-widest uppercase mb-10">Hãy bắt đầu hành trình phong cách của bạn ngay hôm nay</p>
                <a href="{{ route('home') }}" class="inline-flex h-14 px-10 items-center bg-black text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-gray-800 transition-all active:scale-95 shadow-xl shadow-black/10">
                    Tiếp tục mua sắm
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
