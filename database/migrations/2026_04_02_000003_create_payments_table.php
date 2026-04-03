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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->integer('amount')->comment('Số tiền');
            $table->enum('method', ['cash', 'bank_transfer', 'credit_card', 'e_wallet'])->comment('Phương thức thanh toán');
            $table->enum('status', ['pending', 'success', 'failed', 'refunded'])->default('pending')->comment('Trạng thái thanh toán');
            $table->string('transaction_id')->nullable()->unique()->comment('Mã giao dịch');
            $table->text('gateway_response')->nullable()->comment('Response từ gateway');
            $table->timestamp('paid_at')->nullable()->comment('Thời gian thanh toán');
            $table->timestamp('refunded_at')->nullable()->comment('Thời gian hoàn tiền');
            $table->timestamps();

            // Indexes
            $table->index('order_id');
            $table->index('transaction_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
