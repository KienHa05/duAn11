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
        Schema::table('orders', function (Blueprint $table) {
            // Make user_id nullable for guest orders
            $table->foreignId('user_id')
                ->nullable()
                ->change()
                ->comment('Khách hàng (NULL = Đơn hàng khách)');;
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('is_guest')->default(false)->after('user_id')->comment('Đánh dấu đơn hàng khách');
            $table->string('guest_email', 255)->nullable()->after('is_guest')->comment('Email khách (nếu không login)');
            $table->string('guest_name', 255)->nullable()->after('guest_email')->comment('Tên khách (nếu không login)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['is_guest', 'guest_email', 'guest_name']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('restrict')
                ->change();
        });
    }
};
