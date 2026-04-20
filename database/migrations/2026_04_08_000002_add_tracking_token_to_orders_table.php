<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration {
  public function up(): void
  {
    if (!Schema::hasColumn('orders', 'tracking_token')) {

      // 1. Thêm cột
      Schema::table('orders', function (Blueprint $table) {
        $table->string('tracking_token', 255)
          ->nullable()
          ->unique()
          ->after('order_number')
          ->comment('Token bảo mật để theo dõi đơn (Guest dùng)');
      });

      // 2. Generate token bằng PHP (cross-database)
      $orders = DB::table('orders')
        ->whereNull('tracking_token')
        ->get();

      foreach ($orders as $order) {
        DB::table('orders')
          ->where('id', $order->id)
          ->update([
            'tracking_token' => 'TK-' . Str::uuid()
          ]);
      }

      // 3. Thêm index
      Schema::table('orders', function (Blueprint $table) {
        $table->index('tracking_token');
      });
    }
  }

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