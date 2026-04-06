@extends('layouts.frontendmaster.master')
@section('title')
    Blog
@endsection

@section('content')
       <!--================Home Banner Area =================-->
    <!-- breadcrumb start-->
    <section class="breadcrumb breadcrumb_bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="breadcrumb_iner">
                        <div class="breadcrumb_iner_item">
                            <h2>Shop Single</h2>
                            <p><a href="{{ route('frontend.home') }}">Home</a><span>-</span> Shop Single</p>
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
                    <div class="blog_left_sidebar">
                        @forelse ($blogs as $blog)
                            <article class="blog_item">
                                <div class="blog_item_img">
                                    <img class="card-img rounded-0" src="{{ asset('images/blog/'.$blog->thumbnail) }}" alt="">
                                    <a href="#" class="blog_item_date">
                                        <h3>{{ \Carbon\Carbon::parse($blog->created_at)->format('d') }}</h3>
                                        <p>{{ \Carbon\Carbon::parse($blog->created_at)->format('M') }}</p>
                                    </a>
                                </div>

                                <div class="blog_details">
                                    <a class="d-inline-block" href="{{ route('blog.details', $blog->slug) }}">
                                        <h2>{{ $blog->title }}</h2>
                                    </a>
                                    <p>{!! $blog->short_description !!}</p>
                                    <ul class="blog-info-link">
                                        <li><a href="#"><i class="far fa-user"></i> {{ $blog->user->name }} | {{ $blog->user->role }}</a></li>
                                         <li><a href="#"><i class="far fa-comments"></i> {{ $blog->blog_comments->count() }} Comments</a></li>
                                    </ul>
                                </div>
                            </article>
                        @empty
                                <div>
                                    <td>No blogs found.</td>
                                </div>
                        @endforelse

                        <nav class="blog-pagination justify-content-center d-flex">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a href="#" class="page-link" aria-label="Previous">
                                        <i class="ti-angle-left"></i>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a href="#" class="page-link">1</a>
                                </li>
                                <li class="page-item active">
                                    <a href="#" class="page-link">2</a>
                                </li>
                                <li class="page-item">
                                    <a href="#" class="page-link" aria-label="Next">
                                        <i class="ti-angle-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog_right_sidebar">
                        <aside class="single_sidebar_widget search_widget">
                            <form action="#">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder='Search Keyword'
                                            onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = 'Search Keyword'">
                                        <div class="input-group-append">
                                            <button class="btn" type="button"><i class="ti-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <button class="button rounded-0 primary-bg text-white w-100 btn_1"
                                    type="submit">Search</button>
                            </form>
                        </aside>

                        <aside class="single_sidebar_widget post_category_widget">
                            <h4 class="widget_title">Category</h4>
                            @forelse ($categories as $category)
                                <ul class="list cat-list">
                                    <li>
                                        <a href="{{ route('category.product', $category->slug) }}" class="d-flex">
                                            <img src="{{ asset('images/category/' . $category->thumbnail) }}" alt="{{ $category->title }}" width="50">
                                            <p class="mx-2">{{ $category->title }}</p>
                                            <p >({{ $category->oneproduct->count() }})</p>
                                        </a>
                                    </li>
                                </ul>
                            @empty

                            @endforelse
                        </aside>

                        <aside class="single_sidebar_widget popular_post_widget">
                            <h3 class="widget_title">Recent Post</h3>
                           @forelse ($blogs as $blog)
                             <div class="media post_item">
                                 <img src="{{ asset('images/blog/' . $blog->thumbnail) }}" alt="post" width="50">
                                 <div class="media-body">
                                     <a href="single-blog.html">
                                         <h3>{{ $blog->title }}</h3>
                                         <h3>{!! Str::limit($blog->short_description, 30) !!}</h3>
                                     </a>
                                     <p>{{ $blog->created_at->format('M j, Y') }}</p>
                                 </div>
                             </div>
                           @empty
                             <div>
                                    <td>No recent posts found.</td>
                             </div>
                           @endforelse
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


                        <aside class="single_sidebar_widget instagram_feeds">
                            <h4 class="widget_title">Instagram Feeds</h4>
                            <ul class="instagram_row flex-wrap">
                                <li>
                                    <a href="#">
                                        <img class="img-fluid" src="img/post/post_5.png" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img class="img-fluid" src="img/post/post_6.png" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img class="img-fluid" src="img/post/post_7.png" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img class="img-fluid" src="img/post/post_8.png" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img class="img-fluid" src="img/post/post_9.png" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img class="img-fluid" src="img/post/post_10.png" alt="">
                                    </a>
                                </li>
                            </ul>
                        </aside>


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
<div class="alert alert-success" style="height: 50px">
    ✅ You are already subscribed to our newsletter
</div>
@endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================Blog Area =================-->
@endsection
