@extends('layouts.frontendmaster.master')

@section('content')
<!--================Breadcrumb Area =================-->
<section class="breadcrumb breadcrumb_bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="breadcrumb_iner">
                    <div class="breadcrumb_iner_item">
                        <h2>{{ $blog->title }}</h2>
                        <p><a href="{{ route('frontend.home') }}">Home</a> - {{ $blog->title }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--================Blog Area =================-->
<section class="blog_area single-post-area padding_top">
    <div class="container">
        <div class="row">
            <!-- Main Blog Content -->
            <div class="col-lg-8 posts-list">
                <div class="single-post">
                    <div class="feature-img">
                        <img class="img-fluid"
                             src="{{ $blog->thumbnail ? asset('images/blog/' . $blog->thumbnail) : asset('images/default.png') }}"
                             alt="{{ $blog->title }}">
                    </div>
                    <div class="blog_details">
                        <h2>{{ $blog->title }}</h2>
                        <ul class="blog-info-link mt-3 mb-4">
                            <li><i class="far fa-user"></i> {{ $blog->user->name }}</li>
                            <li><i class="far fa-comments"></i> {{ $blog->blog_comments->count() }} Comments</li>
                        </ul>

                        <div class="mb-4">
                            <h4>Short Description:</h4>
                            <p>{!! $blog->short_description !!}</p>
                        </div>

                        <div class="quote-wrapper">
                            <h4>Description:</h4>
                            {!! $blog->description !!}
                        </div>
                    </div>
                </div>

<div class="comments-area">
    <h4>{{ $blog->blog_comments->count() }} Comments</h4>

    @foreach($blog->blog_comments as $comment)
        @include('frontend.blog.blog-comment', ['comment' => $comment, 'level' => 0])
    @endforeach
</div>
                <!-- Comment Form -->
               <div class="comment-form">
    <h4>Leave a Reply</h4>
    <form action="{{ route('blog.comment.store', $blog->id) }}" method="POST" class="form-contact comment_form">
        @csrf
        <input type="hidden" name="parent_id" id="parent_id" value="">

        <!-- Replying to info -->
        <div id="replying-to" style="display:none; margin-bottom:10px;">
            Replying to: <span id="replying-to-name"></span>
            <a href="javascript:void(0);" onclick="cancelReply()">Cancel</a>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <textarea class="form-control w-100" name="comment" cols="30" rows="6" placeholder="Write Comment" required></textarea>
                </div>
            </div>
            @guest
            <div class="col-sm-6">
                <div class="form-group">
                    <input class="form-control" name="name" type="text" placeholder="Name" required>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <input class="form-control" name="email" type="email" placeholder="Email" required>
                </div>
            </div>
            @endguest
        </div>
        <div class="form-group mt-3">
            <button type="submit" class="btn_3 button-contactForm">Send Comment</button>
        </div>
    </form>
</div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="blog_right_sidebar">
                    <!-- Categories -->
                    <aside class="single_sidebar_widget post_category_widget">
                        <h4 class="widget_title">Categories</h4>
                        <ul class="list cat-list">
                            @foreach ($categories as $category)
                                <li>
                                    <a href="{{ route('category.product', $category->slug) }}" class="d-flex">
                                        <img src="{{ asset('images/category/' . $category->thumbnail) }}" alt="{{ $category->title }}" width="50">
                                        <p class="mx-2">{{ $category->title }}</p>
                                        <p>({{ $category->oneproduct->count() ?? 0 }})</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </aside>

                    <!-- Recent Posts -->
                       <aside class="single_sidebar_widget popular_post_widget">
                            <h3 class="widget_title">Recent Post</h3>
                           @forelse ($recentBlogs as $blog)
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
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Optional JS to handle reply clicks -->
<script>
function setReply(commentId, userName = '') {
    document.getElementById('parent_id').value = commentId;

    if(userName) {
        document.getElementById('replying-to-name').textContent = userName;
        document.getElementById('replying-to').style.display = 'block';
    }

    const form = document.querySelector('.comment-form');
    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function cancelReply() {
    document.getElementById('parent_id').value = '';
    document.getElementById('replying-to').style.display = 'none';
}
</script>
@endsection
