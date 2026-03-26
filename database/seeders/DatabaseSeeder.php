<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create categories
        $categories = [
            ['name' => 'Áo thun'],
            ['name' => 'Áo khoác'],
            ['name' => 'Quần'],
            ['name' => 'Giày'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create products
        $products = [
            ['name' => 'Áo thun The Notorious', 'price' => 250000, 'stock' => 50, 'category_id' => 1],
            ['name' => 'Áo khoác thể thao', 'price' => 450000, 'stock' => 30, 'category_id' => 2],
            ['name' => 'Quần jogger', 'price' => 350000, 'stock' => 40, 'category_id' => 3],
            ['name' => 'Giày sneaker', 'price' => 650000, 'stock' => 20, 'category_id' => 4],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
