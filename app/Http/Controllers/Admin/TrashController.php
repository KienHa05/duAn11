<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\ImageService;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function index(Request $request)
    {
        $productSearch = $request->input('product_search');
        $categorySearch = $request->input('category_search');

        $products = Product::onlyTrashed()
            ->withCount('orderItems')
            ->when($productSearch, function ($query, string $productSearch) {
                $query->where('name', 'like', '%' . $productSearch . '%');
            })
            ->orderByDesc('deleted_at')
            ->paginate(10, ['*'], 'product_page')
            ->withQueryString();

        $categories = Category::onlyTrashed()
            ->when($categorySearch, function ($query, string $categorySearch) {
                $query->where('name', 'like', '%' . $categorySearch . '%');
            })
            ->orderByDesc('deleted_at')
            ->paginate(10, ['*'], 'category_page')
            ->withQueryString();

        return view('admin.trash.index', compact('products', 'categories', 'productSearch', 'categorySearch'));
    }

    public function restoreProduct(int $id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.trash.index')
            ->with('success', "Sản phẩm \"$product->name\" đã được khôi phục!");
    }

    public function forceDeleteProduct(int $id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        if ($product->orderItems()->exists()) {
            return redirect()->route('admin.trash.index')
                ->with('error', "Không thể xóa vĩnh viễn sản phẩm \"$product->name\" vì đã tồn tại trong đơn hàng.");
        }

        if ($product->image) {
            ImageService::deleteImage($product->image);
        }

        $productName = $product->name;
        $product->forceDelete();

        return redirect()->route('admin.trash.index')
            ->with('success', "Sản phẩm \"$productName\" đã được xóa vĩnh viễn!");
    }

    public function restoreCategory(int $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('admin.trash.index')
            ->with('success', "Danh mục \"$category->name\" đã được khôi phục!");
    }

    public function forceDeleteCategory(int $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $categoryName = $category->name;
        $category->forceDelete();

        return redirect()->route('admin.trash.index')
            ->with('success', "Danh mục \"$categoryName\" đã được xóa vĩnh viễn!");
    }
}