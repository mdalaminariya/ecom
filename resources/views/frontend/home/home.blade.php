@extends('layouts.frontendmaster.master')

@section('content')
        <!-- banner part start-->
    <section class="banner_part">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">

                <div class="banner_slider owl-carousel">

                    @foreach ($products as $product)
                        <div class="single_banner_slider">
                            <div class="row">

                                <div class="col-lg-5 col-md-8">
                                    <div class="banner_text">
                                        <div class="banner_text_iner">

                                            <h1>{{ $product->title }}</h1>

                                            <p>{!! Str::limit($product->short_description ?? 'No description available', 30) !!}</p>

                                            <a href="#" class="btn_2">
                                                Buy Now
                                            </a>

                                        </div>
                                    </div>
                                </div>

                                <div class="banner_img d-flex justify-content-end align-items-center">
                                    <img style="width: 80%; height: 80%;" src="{{ asset('images/product') }}/{{ $product->thumbnail }}" alt="">
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div> <!-- ✅ CLOSE HERE -->

                <div class="slider-counter"></div>

            </div>
        </div>
    </div>
</section>
    <!-- banner part start-->

    <!-- feature_part start-->
<section class="feature_part padding_top">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section_tittle text-center">
                    <h2>Featured Category</h2>
                </div>
            </div>
        </div>

        <div class="row flex-nowrap overflow-auto">
            @forelse ($categories as $category)
        <div class="col-lg-3 col-md-4 col-6 mb-4">
            <div class="single_feature_post_text text-center" style="background: none;">
                <img style="width:100%; height:80%; margin-top: -20px;"
                     src="{{ asset('images/category/'.$category->thumbnail) }}"
                     alt="">
                    <p><b>{{ $category->title }}</b> <span>{{ $category->oneproduct->count()}}</span></p>
                <a href="{{ route('category.product', $category->slug) }}" class="feature_btn mt-3 d-inline-block">
                    {{ $category->title }}
                    <i class="fas fa-play"></i>
                </a>

            </div>
        </div>

    @empty
        <p class="text-center">No categories found</p>
        @endforelse
    </div>
{{ $categories->links() }}

    </div>
</section>
    <!-- upcoming_event part start-->

    <!-- product_list start-->
    <section class="product_list section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="section_tittle text-center">
                        <h2>awesome <span>shop</span></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="product_list_slider owl-carousel">
                        <div class="single_product_list_slider">
                            <div class="row align-items-center justify-content-between">
                                @foreach ($products as $product)
                                <div class="col-lg-3 col-sm-4">
                                      <div class="single_product_item">
                                          <img src="{{ asset('images/product') }}/{{ $product->thumbnail }}" alt="">
                                          <div class="single_product_text">
                                              <h4>{{ $product->title }}</h4>
                                                          @php
                                                            $price = strip_tags($product->price); // removes <p> tags
                                                            @endphp
                                                        <p style="font-size: 18px; font-weight: bold; color: #28a745; margin-top:0;">  {{ $price }} </p>
                                              <a href="#" class="add_cart">+ add to cart<i class="ti-heart"></i></a>
                                          </div>
                                      </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </section>
    <!-- product_list part start-->

    <!-- awesome_shop start-->
    <section class="our_offer section_padding">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 col-md-6">
                    <div class="offer_img">
                        <img src="{{ asset('frontend') }}/assets/img/offer_img.png" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="offer_text">
                        <h2>Weekly Sale on
                            60% Off All Products</h2>
                        <div class="date_countdown">
                            <div id="timer">
                                <div id="days" class="date"></div>
                                <div id="hours" class="date"></div>
                                <div id="minutes" class="date"></div>
                                <div id="seconds" class="date"></div>
                            </div>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="enter email address"
                                aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <a href="#" class="input-group-text btn_2" id="basic-addon2">book now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- awesome_shop part start-->

    <!-- product_list part start-->
    <section class="product_list best_seller section_padding">
    <div class="container">

        <!-- Section Title -->
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="section_tittle text-center">
                    <h2>Best Sellers <span>shop</span></h2>
                </div>
            </div>
        </div>

        <!-- Product Slider -->
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-12">

                <div class="best_product_slider owl-carousel">

                    @forelse($bestProducts as $product)
                        <div class="single_product_item">

                            <!-- Product Image -->
                            <img src="{{ asset('images/product/' . $product->thumbnail) }}" alt="{{ $product->title }}">

                            <!-- Product Info -->
                            <div class="single_product_text">

                                <h4>{{ $product->title }}</h4>

                                @php
                                    $price = strip_tags($product->price);
                                @endphp

                                <p style="font-size: 18px; font-weight: bold; color: #28a745; margin-top:0;">
                                    {{ $price }}
                                </p>

                            </div>

                        </div>
                    @empty
                        <div class="col-lg-12 text-center">
                            <p style="color:red; font-weight:bold;">Best Seller Empty</p>
                        </div>
                    @endforelse

                </div>

            </div>
        </div>

    </div>
</section>
    <!-- product_list part end-->
@endsection
