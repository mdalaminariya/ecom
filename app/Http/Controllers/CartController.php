<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
 public function index()
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $cart = Cart::where('user_id', Auth::id())
                ->with('product')
                ->get();

    return view('frontend.shoppingCart.index', compact('cart'));
}
// Add a product to cart
public function addToCart($id)
{
    $product = Product::findOrFail($id);

    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Please login to add to cart.');
    }

    $user = Auth::user();

    // Check if cart item already exists for this user and product
    $cartItem = Cart::where('user_id', $user->id)->where('product_id', $product->id)->first();

    if ($cartItem) {
        $cartItem->quantity += 1;
        $cartItem->save();
    } else {
        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 1
        ]);
    }

    return redirect()->back()->with('success', 'Product added to cart.');
}

public function getCartData()
{
    if (!Auth::check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

    return response()->json($cartItems);
}
public function update(Request $request)
{
    $cartItem = Cart::where('user_id', Auth::id())
                    ->where('id', $request->id)
                    ->first();

    if ($cartItem) {
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
    }

    return redirect()->back()->with('success', 'Cart updated.');
}

public function remove(Request $request)
{
    $cartItem = Cart::where('user_id', Auth::id())
                    ->where('id', $request->id)
                    ->first();

    if ($cartItem) {
        $cartItem->delete();
    }

    return redirect()->back()->with('success', 'Product removed from cart.');
}

}
