<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::withoutTrashed()->with('category');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        $products = $query->paginate(12);
        $categories = Category::all();
        
        // Get cart count from localStorage (handled by frontend, defaults to 0)
        $cartCount = 0;

        return view('client.home', compact('products', 'categories', 'cartCount'));
    }

    public function show(Product $product)
    {
        // Make sure product is not deleted
        if ($product->trashed()) {
            abort(404);
        }
        
        $product->load('category');
        return view('client.products.show', compact('product'));
    }

    /**
     * API endpoint for live search
     */
    public function searchApi(Request $request)
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return response()->json([
                'products' => [],
                'categories' => []
            ]);
        }

        $products = Product::withoutTrashed()
            ->where('name', 'like', "%{$query}%")
            ->with('category')
            ->limit(5)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => number_format($product->price, 0, ',', '.') . ' ₫',
                    'image' => $product->image_url,
                    'url' => route('client.products.show', $product),
                    'category' => $product->category->name ?? 'N/A'
                ];
            });

        $categories = Category::where('name', 'like', "%{$query}%")
            ->limit(3)
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'url' => route('home') . '?category=' . $category->id
                ];
            });

        return response()->json([
            'products' => $products,
            'categories' => $categories
        ]);
    }
}
