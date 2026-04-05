@extends('layouts.frontendmaster.master')

@section('content')
    <section class="breadcrumb breadcrumb_bg">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="breadcrumb_iner">
            <div class="breadcrumb_iner_item">
              <h2>Cart Products</h2>
              <p><a href="{{ route('frontend.home') }}">Home</a> <span>-</span>Cart Products</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- breadcrumb start-->

  <!--================Cart Area =================-->
  <section class="cart_area padding_top">
    <div class="container">
      <div class="cart_inner">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Product</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
@php
$cartItems = \App\Models\Cart::with('product')
                ->where('user_id', Auth::id())
                ->get();
$subtotal = 0;
@endphp

@forelse($cartItems as $item)

        @php
            $price = $item->product->price;
            $total = $price * $item->quantity;
            $subtotal += $total;
            @endphp
    <tr>
        <td>
            <img src="{{ asset('images/product/'.$item->product->thumbnail) }}" width="300" alt="">
            <span><b style="font-size: 16px; color: #333;">{{ $item->product->title }}</b></span>
        </td>
        <td>${{ $item->product->formatted_price }}</td>
        <td>
            <form action="{{ route('cart.update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $item->id }}">
                <input style="width: 50px" type="number" name="quantity" value="{{ $item->quantity }}" min="1">
                <button type="submit">Update</button>
            </form>
        </td>
        <td>${{ number_format($total, 0) }}</td>
        <td>
            <form action="{{ route('cart.remove') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $item->id }}">
                <button type="submit">Remove</button>
            </form>
        </td>
        <tr>
    <td colspan="3"><strong>Subtotal</strong></td>
    <td><strong>${{ number_format($subtotal, 0) }}</strong></td>
    </tr>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center">Your cart is empty</td>
    </tr>
@endforelse
            </tbody>
          </table>
          <div class="checkout_btn_inner float-right">
            <a class="btn_1" href="{{ route('frontend.home') }}">Continue Shopping</a>
            <a class="btn_1 checkout_btn_1" href="{{ route('product.checkout') }}">Proceed to checkout</a>
          </div>
        </div>
      </div>
  </section>
  <!--================End Cart Area =================-
@endsection
