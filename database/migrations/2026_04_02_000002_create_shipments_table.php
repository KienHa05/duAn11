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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained('orders')->onDelete('cascade');
            $table->string('tracking_number')->nullable()->unique()->comment('Mã theo dõi');
            $table->string('carrier', 50)->nullable()->comment('Đơn vị vận chuyển');
            $table->enum('status', ['pending', 'processing', 'in_transit', 'out_for_delivery', 'delivered', 'failed'])->default('pending')->comment('Trạng thái vận chuyển');
            $table->timestamp('shipped_at')->nullable()->comment('Thời gian gửi hàng');
            $table->timestamp('estimated_delivery')->nullable()->comment('Dự kiến giao hàng');
            $table->timestamp('delivered_at')->nullable()->comment('Thời gian giao hàng');
            $table->text('delivery_notes')->nullable()->comment('Ghi chú từ giao hàng');
            $table->timestamps();

            // Indexes
            $table->index('order_id');
            $table->index('tracking_number');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
