<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add tracking_token column if it doesn't exist
        if (!Schema::hasColumn('orders', 'tracking_token')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('tracking_token', 255)
                    ->nullable()
                    ->unique()
                    ->after('order_number')
                    ->comment('Token bảo mật để theo dõi đơn (Guest dùng)');
            });

            // Generate tokens for existing orders
            DB::statement("UPDATE `orders` SET `tracking_token` = CONCAT('TK-', UUID()) WHERE `tracking_token` IS NULL");

            // Add index
            Schema::table('orders', function (Blueprint $table) {
                $table->index('tracking_token');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('orders', 'tracking_token')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropUnique(['tracking_token']);
                $table->dropIndex(['tracking_token']);
                $table->dropColumn('tracking_token');
            });
        }
    }
};



