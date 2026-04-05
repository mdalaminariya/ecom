<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Auth;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    // Show checkout page
    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('shopping.cart')->with('error', 'Your cart is empty');
        }

        $total = $cartItems->sum(function($item){
            return $item->product->price * $item->quantity;
        });

        return view('frontend.checkout.index', compact('cartItems', 'total'));
    }

    // Place order
    public function placeOrder(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'country' => 'required',
            'district' => 'required',
            'payment_method' => 'required|in:cod,ssl',
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Cart is empty');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'zip' => $request->zip,
            'country' => $request->country,
            'district' => $request->district,
            'total_amount' => $total,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
]);

        // Clear cart
        Cart::where('user_id', Auth::id())->delete();

        // Payment
        if ($request->payment_method == 'cod') {
            return redirect()->route('payment.success')->with('success', 'Order placed successfully!');
        }

        if ($request->payment_method == 'ssl') {
            return $this->sslPayment($order);
        }
    }
}
