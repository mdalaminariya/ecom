@extends('layouts.frontendmaster.master')

@section('content')
      <!-- breadcrumb start-->
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
    <!-- breadcrumb start-->

    <!--================Blog Area =================-->
    <section class="blog_area padding_top">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-5 mb-lg-0">
                   @forelse ($products as $product)
                     <div class="blog_left_sidebar">
                         <article class="blog_item">
                             <div class="blog_item_img">
                                 <img href="{{ route('product.details', $product->slug) }}" style="height: 50%; width: 50%;" class="card-img rounded-0" src="{{ asset('images/product') }}/{{ $product->thumbnail }}" alt="">
                                 <a href="{{ route('product.details', $product->slug) }}" class="blog_item_date">
                                     <h3>{{ Carbon\Carbon::parse($product->created_at)->format('d') }}</h3>
                                     <p>{{ Carbon\Carbon::parse($product->created_at)->format('M') }}</p>
                                 </a>
                             </div>

                             <div class="blog_details">
                                 <a class="d-inline-block" href="{{ route('product.details', $product->slug) }}">
                                     <h2>{{ $product->title }}</h2>
                                    </a>
                                @php
                                    $price = strip_tags($product->price); // removes <p> tags
                                @endphp
                                <p style="font-size: 18px; font-weight: bold; color: #28a745; margin-top:0;">
                                    {{ $price }}
                                </p>
                                    <p style="margin-top: -30PX">{!! $product->short_description !!}</p>
                                 <ul class="blog-info-link mb-2">
                                     <li><a href="#"><i class="far fa-user"></i> {{ $product->user->name }} | {{ $product->user->role }}</a></li>
                                     <li><a href="#"><i class="far fa-comments"></i> 03 Comments</a></li>
                                 </ul>
                                   <!-- Buy Button -->
                                    <a href="#" class="btn btn-success mt-2">
                                        <i class="fas fa-shopping-cart"></i> Buy Now
                                    </a>
                             </div>
                         </article>
                     </div>
                     {{ $products->links() }}
                   @empty
                     <div class="text-center p-5">
                <h3 class=" text-danger"><b>This Category have no Data!!</b></h3>
            </div>
                   @endforelse
                </div>
                <div class="col-lg-4">
                    <div class="blog_right_sidebar">
               <aside class="single_sidebar_widget search_widget">
                <form action="{{ route('product.search') }}" method="GET">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="text" name="search" class="form-control" placeholder="Search Keyword" value="{{ request('search') }}" autocomplete="off">
                            <button class="btn btn-primary" type="submit">
                                <i class="ti-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </aside>
                        <aside class="single_sidebar_widget post_category_widget">
                            <h4 class="widget_title">Category</h4>
                            @foreach ($cats as $cat)
                                <ul class="list cat-list">
                                    <li>
                                        <a href="#" class="d-flex">
                                            <p>{{ $cat->title }}</p>
                                            <p> ({{ $cat->oneproduct->count() }})</p>
                                        </a>
                                    </li>
                                </ul>
                            @endforeach
                        </aside>

                        <aside class="single_sidebar_widget popular_post_widget">
                            <h3 class="widget_title">Recent Post</h3>
                            @foreach ($producs as $product)
                                <div class="media post_item">
                                    <img style="width: 30%; height: 30%;" src="{{ asset('images/product') }}/{{ $product->thumbnail }}" alt="post">
                                    <div class="media-body">
                                        <a href="single-blog.html">
                                            <h3>{{ $product->title }}</h3>
                                        </a>
                                        <p>{{ $product->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </aside>
                        <aside class="single_sidebar_widget tag_cloud_widget">
                            <h4 class="widget_title">Tag Clouds</h4>
                            <ul class="list">
                                <li>
                                    <a href="#">project</a>
                                </li>
                                <li>
                                    <a href="#">love</a>
                                </li>
                                <li>
                                    <a href="#">technology</a>
                                </li>
                                <li>
                                    <a href="#">travel</a>
                                </li>
                                <li>
                                    <a href="#">restaurant</a>
                                </li>
                                <li>
                                    <a href="#">life style</a>
                                </li>
                                <li>
                                    <a href="#">design</a>
                                </li>
                                <li>
                                    <a href="#">illustration</a>
                                </li>
                            </ul>
                        </aside>

@if(!$subscribed)
<aside class="single_sidebar_widget newsletter_widget">
    <h4 class="widget_title">Newsletter</h4>

    <form id="newsletterForm">
        @csrf
        <div class="form-group">
            <input type="email" name="email" class="form-control"
                placeholder="Enter email" required>
        </div>

        <button class="button rounded-0 primary-bg text-white w-100 btn_1">
            Subscribe
        </button>
    </form>

    <p id="newsletterMessage" class="mt-2"></p>
</aside>
@else
<div class="alert alert-success">
    ✅ You are already subscribed to our newsletter
</div>
@endif

<script>
document.getElementById('newsletterForm').addEventListener('submit', function(e) {

    e.preventDefault();

    const form = e.target;
    const email = form.email.value;
    const token = form.querySelector('input[name="_token"]').value;
    const messageEl = document.getElementById('newsletterMessage');

    fetch("{{ route('newsletter.subscribe') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ email: email })
    })
    .then(async response => {

        const data = await response.json();

        if (!response.ok) {
            if (data.errors && data.errors.email) {
                throw new Error(data.errors.email[0]);
            }
            throw new Error(data.message || 'Server error');
        }

        return data;
    })
    .then(data => {
        messageEl.textContent = data.success;
        messageEl.className = 'text-success mt-2';
        form.reset();
    })
    .catch(err => {
        messageEl.textContent = err.message;
        messageEl.className = 'text-danger mt-2';
    });

});
</script>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
