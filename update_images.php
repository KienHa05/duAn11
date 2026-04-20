<?php
use App\Models\Product;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

Product::whereNotNull('image')
    ->where('image', 'not like', 'products/%')
    ->get()
    ->each(function ($product) {
        $product->update(['image' => 'products/' . $product->image]);
        echo "Updated product ID: {$product->id}\n";
    });
