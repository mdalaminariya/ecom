@extends('layouts.frontendmaster.master')

@section('content')
    <section class="breadcrumb breadcrumb_bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb_iner">
                        <div class="breadcrumb_iner_item">
                            <h2>Shop Single</h2>
                            <p>Home <span>-</span> Shop Single</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="row" style="margin-left: 30%; margin-top: 10px;">
        <div class="col-lg-8 mb-5 mb-lg-0">
        @forelse ($products as $product) <div class="blog_left_sidebar">
            <article class="blog_item"> <div class="blog_item_img">
             <img style="height: 40%; width: 100%;" class="card-img rounded-0" src="{{ asset('images/product') }}/{{ $product->thumbnail }}" alt=""> <a href="#" class="blog_item_date">
            <h3>{{ Carbon\Carbon::parse($product->created_at)->format('d') }}</h3>
         <p>{{ Carbon\Carbon::parse($product->created_at)->format('M') }}</p> </a>
         </div>
         <div class="blog_details">
            <a class="d-inline-block" href="single-blog.html">
        <h2>{{ $product->title }}</h2>
    </a>
             @php
               $price = strip_tags($product->price); // removes <p> tags
             @endphp
         <p style="font-size: 18px; font-weight: bold; color: #28a745; margin-top:0;">  {{ $price }} </p>
         <p style="margin-top: -30px">{!! $product->short_description !!}</p>
         <ul class="blog-info-link">
            <li><a href="#"><i class="far fa-user"></i> {{ $product->user->name }} | {{ $product->user->role }}</a></li>
             <li><a href="#"><i class="far fa-comments"></i> {{ $product->comments->count() }} Comments</a></li>
            </ul>
              <!-- Buy Button -->
            <a href="#" class="btn btn-success mt-2">
                <i class="fas fa-shopping-cart"></i> Buy Now
            </a>
        </div>
    </article>
</div>
 {{ $products->links() }}
    @empty <div class="text-center p-5"> <h3 class=" text-danger">
        <b>This Category have no Data!!</b>
    </h3>
    </div>
    @endforelse
</div>
</div>
@endsection
