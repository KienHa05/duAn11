<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Auth::user()->wishlistProducts()->paginate(12);

        return view('client.wishlist.index', compact('products'));
    }

    /**
     * Toggle the product in the user's wishlist.
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = Auth::user();
        $productId = $request->product_id;

        $wishlist = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $status = 'removed';
            $message = 'Đã xóa khỏi danh sách yêu thích.';
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
            $status = 'added';
            $message = 'Đã thêm vào danh sách yêu thích.';
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'status' => $status,
                'message' => $message,
            ]);
        }

        return back()->with('success', $message);
    }
}
