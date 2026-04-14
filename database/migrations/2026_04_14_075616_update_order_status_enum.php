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
        // 1. Expand enum (MySQL only)
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'confirmed', 'shipping', 'completed', 'cancelled', 'returned', 'processing', 'shipped', 'delivered') DEFAULT 'pending'");
        }

        // 2. Data Migration
        DB::table('orders')->where('status', 'shipped')->update(['status' => 'shipping']);
        DB::table('orders')->where('status', 'delivered')->update(['status' => 'completed']);
        DB::table('orders')->where('status', 'processing')->update(['status' => 'confirmed']);

        // 3. Narrow enum (MySQL only)
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'confirmed', 'shipping', 'completed', 'cancelled', 'returned') DEFAULT 'pending'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'confirmed', 'shipping', 'completed', 'cancelled', 'returned', 'processing', 'shipped', 'delivered') DEFAULT 'pending'");
        }
        
        DB::table('orders')->where('status', 'shipping')->update(['status' => 'shipped']);
        DB::table('orders')->where('status', 'completed')->update(['status' => 'delivered']);
        
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'returned') DEFAULT 'pending'");
        }
    }
};
