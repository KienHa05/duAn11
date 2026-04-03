<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique()->comment('Mã đơn hàng');
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict')->comment('Khách hàng');
            $table->enum('status', ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'returned'])->default('pending')->comment('Trạng thái đơn hàng');
            $table->string('shipping_method', 50)->nullable()->comment('Phương thức vận chuyển');
            $table->string('shipping_address')->comment('Địa chỉ giao hàng');
            $table->text('shipping_details')->nullable()->comment('Chi tiết địa chỉ');
            $table->string('phone_number', 20)->comment('Số điện thoại');
            $table->enum('payment_method', ['cash', 'bank_transfer', 'credit_card', 'e_wallet'])->comment('Phương thức thanh toán');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending')->comment('Trạng thái thanh toán');
            $table->integer('subtotal')->default(0)->comment('Tổng tiền hàng');
            $table->integer('shipping_cost')->default(0)->comment('Phí vận chuyển');
            $table->integer('discount')->default(0)->comment('Chiết khấu');
            $table->integer('total_amount')->default(0)->comment('Tổng tiền thanh toán');
            $table->text('notes')->nullable()->comment('Ghi chú');
            $table->timestamp('paid_at')->nullable()->comment('Thời gian thanh toán');
            $table->timestamp('shipped_at')->nullable()->comment('Thời gian gửi hàng');
            $table->timestamp('delivered_at')->nullable()->comment('Thời gian giao hàng');
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('order_number');
            $table->index('user_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
