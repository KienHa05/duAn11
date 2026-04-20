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

        // Search by name or description
        $search = $request->input('search');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Category filter
        $categoryId = $request->input('category');
        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        // Price range filter
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        if (!empty($minPrice)) {
            $query->where('price', '>=', $minPrice);
        }
        if (!empty($maxPrice)) {
            $query->where('price', '<=', $maxPrice);
        }

        // Sorting
        $sort = $request->input('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default: // newest
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->appends($request->query());
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

        // Fetch related products (same category, excluding current product)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->withoutTrashed()
            ->limit(4)
            ->get();

        return view('client.products.show', compact('product', 'relatedProducts'));
    }
}
