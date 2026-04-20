<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
  /**
   * Display the shopping cart
   */
  public function index(Request $request)
  {
    return view('client.cart.index');
  }

  /**
   * Update cart item quantity from cart page
   */
  public function update(Request $request)
  {
    // This can be handled via AJAX from cart.js
    return response()->json(['success' => true]);
  }

  /**
   * Remove item from cart
   */
  public function destroy(Request $request)
  {
    // This can be handled via AJAX from cart.js
    return response()->json(['success' => true]);
  }
}
