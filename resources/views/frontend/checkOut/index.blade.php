@extends('layouts.frontendmaster.master')


@section('content')
    <div class="container">
         <!-- breadcrumb start-->
  <section class="breadcrumb breadcrumb_bg">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="breadcrumb_iner">
            <div class="breadcrumb_iner_item">
              <h2>Product Checkout</h2>
              <p><a href="{{ route('frontend.home') }}">Home</a> <span>-</span> Shop Single</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- breadcrumb start-->

  <!--================Checkout Area =================-->
  <section class="checkout_area padding_top">
    <div class="container">
      <div class="returning_customer">
        <div class="check_title">
          <h2>
            Returning Customer?
            <a href="{{ route('login') }}">Click here to login</a>
          </h2>
        </div>
        <p>
          If you have shopped with us before, please enter your details in the
          boxes below. If you are a new customer, please proceed to the
          Billing & Shipping section.
        </p>
        <form class="row contact_form" action="#" method="post" novalidate="novalidate">
          <div class="col-md-6 form-group p_star">
            <input type="text" class="form-control" id="name" name="name" value=" " />
            <span class="placeholder" data-placeholder="Username or Email"></span>
          </div>
          <div class="col-md-6 form-group p_star">
            <input type="password" class="form-control" id="password" name="password" value="" />
            <span class="placeholder" data-placeholder="Password"></span>
          </div>
          <div class="col-md-12 form-group">
            <button type="submit" value="submit" class="btn_3">
              log in
            </button>
            <div class="creat_account">
              <input type="checkbox" id="f-option" name="selector" />
              <label for="f-option">Remember me</label>
            </div>
            <a class="lost_pass" href="#">Lost your password?</a>
          </div>
        </form>
      </div>
      <div class="cupon_area">
        <div class="check_title">
          <h2>
            Have a coupon?
            <a href="#">Click here to enter your code</a>
          </h2>
        </div>
        <input type="text" placeholder="Enter coupon code" />
        <a class="tp_btn" href="#">Apply Coupon</a>
      </div>
      <div class="billing_details">
        <div class="row">
          <div class="col-lg-8">
            <h3>Billing Details</h3>
            <form class="row contact_form" action="{{ route('checkout.placeOrder') }}" method="POST" novalidate="novalidate">
    @csrf

    <div class="col-md-6 form-group p_star">
        <input type="text" class="form-control"  name="first_name" placeholder="First Name" />
    </div>

    <div class="col-md-6 form-group p_star">
        <input type="text" class="form-control"  name="last_name" placeholder="Last Name" />
    </div>

    <div class="col-md-12 form-group">
        <input type="text" class="form-control" name="company" placeholder="Company Name" />
    </div>

    <div class="col-md-6 form-group p_star">
        <input type="text" class="form-control"  name="phone" placeholder="Phone Number" />
    </div>

    <div class="col-md-6 form-group p_star">
        <input type="email" class="form-control"  name="email" placeholder="Email Address" />
    </div>

    <div class="col-md-12 form-group p_star">
        <input type="text" class="form-control" name="address" placeholder="Address" />
    </div>

    <div class="col-md-12 form-group p_star">
        <input type="text" class="form-control" name="city" placeholder="Town/City" />
    </div>

    <div class="col-md-12 form-group p_star">
        <input type="text" class="form-control" name="zip" placeholder="Postcode/ZIP" />
    </div>

 <div class="col-md-12 form-group">
    <label for="country">Country</label>
    <select name="country" id="country" class="form-control">
        <option value="" disabled selected>Select Country</option>
        <option value="Bangladesh">Bangladesh</option>
        <option value="India">India</option>
    </select>
</div>

<div class="col-md-12 form-group">
    <label for="district">District</label>
    <select name="district" id="district" class="form-control">
        <option value="" disabled selected>Select District</option>
        <option value="Dhaka">Dhaka</option>
        <option value="Chittagong">Chittagong</option>
    </select>
</div>

    <div class="col-md-12 form-group">
        <button type="submit" class="btn btn-primary">Place Order</button>
    </div>
</form>

          </div>
          <div class="col-lg-4">
            <div class="order_box">
              <h2>Your Order</h2>
<ul class="list">
    @foreach($cartItems as $item)
    <li>
        <a href="#">
            <img src="{{ asset('images/product') }}/{{ $item->product->thumbnail }}" alt="{{ $item->product->name }}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
            {{ $item->product->name }}
            <span class="middle">x {{ $item->quantity }}</span>
            <span class="last">
                ${{ $item->product->price * $item->quantity }}
            </span>
        </a>
    </li>
    @endforeach
</ul>

<ul class="list list_2">
    <li>
        <a href="#">Subtotal
            <span>${{ number_format($total, 2) }}</span>
        </a>
    </li>

    <li>
        <a href="#">Shipping
            <span>$50.00</span>
        </a>
    </li>

    <li>
        <a href="#">Total
            <span>${{ number_format($total + 50, 2) }}</span>
        </a>
    </li>
</ul>
            <div class="payment_methods">

                <!-- Cash on Delivery -->
                <div class="payment_item">
                    <input type="radio" id="cod" name="payment_method" value="cod" checked>
                    <label for="cod" class="payment_label">
                        <span class="payment_icon">💵</span>
                        <span class="payment_text">Cash on Delivery</span>
                    </label>
                </div>

                <!-- bKash Payment -->
                <div class="payment_item">
                    <input type="radio" id="bkash" name="payment_method" value="ssl">
                    <label for="bkash" class="payment_label">
                        <img src="{{ asset('images/bkashPng/BKash-bKash2-Logo.wine.png') }}"
                            alt="bKash" class="payment_icon">
                        <span class="payment_text">bKash Payment</span>
                    </label>
                </div>

            </div>
              <div class="creat_account">
                <input type="checkbox" id="f-option4" name="selector" />
                <label for="f-option4">I’ve read and accept the </label>
                <a href="#">terms & conditions*</a>
              </div>
              <a class="btn_3" href="#">Proceed to Paypal</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--================End Checkout Area =================-->
    </div>
@endsection
