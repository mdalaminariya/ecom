@extends('layouts.frontendmaster.master')

@section('content')
  <!--================Single Product Area =================-->
  <div class="product_image_area section_padding">
    <div class="container">
      <div class="row s_product_inner justify-content-between">
        <div class="col-lg-7 col-xl-7">
            <div class="product_slider_img">
                <div id="vertical">
                    <!-- Main Image -->
                    <div class="main-img">
                    <img src="{{ asset('images/product') }}/{{ $product->thumbnail }}" />
                    </div>

                    <!-- Overlay Thumbnails -->
                    <div class="overlay-thumbnails">
                    <img src="{{ asset('images/product') }}/{{ $product->thumbnail }}" />
                    <img src="{{ asset('images/product') }}/{{ $product->thumbnail }}" />
                    <img src="{{ asset('images/product') }}/{{ $product->thumbnail }}" />
                    </div>
                </div>
                </div>
        </div>
        <div class="col-lg-5 col-xl-4">
          <div class="s_product_text">
            <h3>{{ $product->title }}</h3>
                @php
                $price = strip_tags($product->price); // removes <p> tags
                @endphp
            <h2>${{ $price }}</h2>
            <ul class="list">
              <li>
                <a class="active" href="#">
                  <span>Category</span> : <a href="{{ route('category.product', $product->category->slug) }}">{{ $product->category->title }}</a>
                </a>
              </li>
              <li>
                <a href="#"> <span>Availibility</span> : In Stock</a>
              </li>
            </ul>
            <p>
              {!! $product->short_description !!}
            </p>
            <div class="card_area d-flex justify-content-between align-items-center">
              <div class="product_count">
                <span class="inumber-decrement"> <i class="ti-minus"></i></span>
                <input class="input-number" type="text" value="1" min="0" max="10">
                <span class="number-increment"> <i class="ti-plus"></i></span>
              </div>
              <a href="{{ route('cart.add', $product->id) }}" class="btn_3">add to cart</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--================End Single Product Area =================-->

  <!--================Product Description Area =================-->
  <section class="product_description_area">
    <div class="container">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
            aria-selected="true">Description</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
            aria-selected="false">Specification</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
            aria-selected="false">Comments</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review"
            aria-selected="false">Reviews</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
          <p>
            {!! $product->description !!}
          </p>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <div class="table-responsive">
            <table class="table">
              <tbody>
                <tr>
                  <td>
                    <h5>{!! $product->specification !!}</h5>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-content" id="myTabContent">

            <!-- COMMENTS TAB -->
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <div class="row">

                    <!-- Comments List -->
                    <div class="col-lg-6">
                        <div class="comment_list">
                            @foreach ($comments as $comment)
                                @include('partials.comment', ['comment' => $comment, 'product' => $product])
                            @endforeach
                        </div>
                    </div>

                    <!-- Comment Submission Form -->
                    <div class="col-lg-6">
                        <div class="review_box">
                            <h4>Post a Comment</h4>
                            <form action="{{ route('comments.store') }}" method="POST" class="row contact_form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name" placeholder="Your Full Name" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email" placeholder="Email Address">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" name="message" rows="3" placeholder="Message" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn_3">Submit Now</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <!-- REVIEW TAB -->
        <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
            <div class="row">

                {{-- LEFT SIDE: Overall Rating + Reviews --}}
                <div class="col-lg-6">
                    {{-- Overall Rating Box --}}
                    <div class="row total_rate">
                        <div class="col-6">
                            <div class="box_total">
                                <h5>Overall</h5>
                                @php
                                    $averageRating = $comments->avg('rating');
                                    $roundedAverage = round($averageRating, 1);
                                @endphp
                                <h4>{{ $roundedAverage }}</h4>
                                <h6>({{ $comments->count() }} Reviews)</h6>

                                {{-- Visual stars for average --}}
                                <div class="rating" style="margin-top:5px;">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($averageRating))
                                            <i class="fa-solid fa-star" style="color: gold;"></i>
                                        @elseif($i - $averageRating < 1)
                                            <i class="fa-solid fa-star-half-stroke" style="color: gold;"></i>
                                        @else
                                            <i class="fa-regular fa-star" style="color: #ccc;"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            {{-- Rating breakdown --}}
                            <div class="rating_list">
                                <h3>Based on {{ $comments->count() }} Reviews</h3>
                                <ul class="list">
                                    @for ($i = 5; $i >= 1; $i--)
                                        @php
                                            $countStars = $comments->where('rating', '>=', $i)->count();
                                        @endphp
                                        <li>
                                            <a href="#">{{ $i }} Star
                                                @for ($j = 0; $j < 5; $j++)
                                                    <i class="fa-solid fa-star" style="color: gold;"></i>
                                                @endfor
                                                {{ $countStars }}
                                            </a>
                                        </li>
                                    @endfor
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Individual Reviews List --}}
                   <div class="review_list" style="margin-top:20px;">

        @foreach ($comments as $comment)

            @php
                $colors = ['#ff6b6b', '#4dabf7', '#51cf66', '#ffd43b', '#845ef7'];
                $bg = $colors[crc32($comment->name) % count($colors)];
            @endphp

            <div class="review_item" style="margin-bottom:20px;">

                <div class="media" style="display:flex; gap:10px; align-items:flex-start;">

                    {{-- Avatar --}}
                    <div style=" width:50px; height:50px;border-radius:50%;background:{{ $bg }};
                        color:#fff;display:flex;align-items:center;justify-content:center;
                        font-weight:bold;font-size:20px;text-transform:uppercase;flex-shrink:0;
                    ">
                        {{ strtoupper(substr($comment->name, 0, 1)) }}
                    </div>

                    {{-- Content --}}
                    <div class="media-body" style="flex:1;">

                        <h4 style="margin-bottom:5px;">
                            {{ $comment->name }}
                        </h4>

                        {{-- Rating --}}
                        <div style="margin-bottom:8px;">
                            @for ($i = 1; $i <= 5; $i++)
                                @if($i <= floor($comment->rating))
                                    <i class="fa-solid fa-star" style="color:#ffd700;"></i>
                                @elseif($i - $comment->rating < 1)
                                    <i class="fa-solid fa-star-half-stroke" style="color:#ffd700;"></i>
                                @else
                                    <i class="fa-regular fa-star" style="color:#ccc;"></i>
                                @endif
                            @endfor
                        </div>

                        {{-- Message --}}
                        <p style="margin:0; color:#555; line-height:1.5;">
                            {{ $comment->message }}
                        </p>
                       @if($comment->image)
                            <div style="margin-top:10px;">
                                <img src="{{ asset('images/comments/' . $comment->image) }}"
                                    style="width:150px; height:auto; border-radius:8px;">
                            </div>
                        @endif

                        {{-- Reply Button --}}
                        <button onclick="toggleReply({{ $comment->id }})"
                            style="margin-top:8px; font-size:13px; color:#007bff; border:none; background:none; cursor:pointer;">
                            Reply
                        </button>

                        {{-- Reply Form --}}
                        <div id="reply-form-{{ $comment->id }}" style="display:none; margin-top:10px;">
                            <form method="POST" action="{{ route('comments.store') }}">
                                @csrf

                                <input type="hidden" name="product_id" value="{{ $comment->product_id }}">
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">

                                <textarea name="message" required
                                    style="width:100%; padding:8px; margin-bottom:8px;"
                                    placeholder="Write a reply..."></textarea>

                                <button type="submit"
                                    style="padding:6px 12px; background:#28a745; color:#fff; border:none;">
                                    Send Reply
                                </button>
                            </form>
                        </div>

                        {{-- Replies --}}
                        @if($comment->replies->count())
                            <div style="margin-left:60px; margin-top:15px; border-left:2px solid #eee; padding-left:10px;">

                                @foreach ($comment->replies as $reply)
                                    <div style="margin-bottom:10px;">

                                        <strong>{{ $reply->name }}</strong>

                                        <p style="margin:0; color:#666;">
                                            {{ $reply->message }}
                                        </p>

                                        </div>
                                    @endforeach

                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Pagination --}}
            <div class="d-flex justify-content-center">
                {{ $comments->links() }}
            </div>

            </div>
                    <script>
                    function toggleReply(id) {
                        let el = document.getElementById('reply-form-' + id);
                        el.style.display = (el.style.display === 'none') ? 'block' : 'none';
                    }
                    </script>
                </div>

                {{-- RIGHT SIDE: Add Review Form --}}
                <div class="col-lg-6">
                    <div class="review_box">
                        <h4>Add a Review</h4>
                        <p>Your Rating:</p>

                        {{-- Star UI --}}
                        <ul class="list" id="star-list">
                            @for ($i = 1; $i <= 5; $i++)
                                <li style="display:inline-block; margin-right:5px;">
                                    <i class="fa-regular fa-star star"
                                    data-value="{{ $i }}"
                                    style="cursor:pointer; color:#ccc; font-size:24px;"></i>
                                </li>
                            @endfor
                        </ul>

                        <p id="rating-text">0 Star</p>


                       <form action="{{ route('comments.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="rating" id="rating" value="0">

                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                            </div>

                            <div class="form-group">
                                <textarea name="message" class="form-control" placeholder="Review" required></textarea>
                            </div>

                            {{-- IMAGE UPLOAD --}}
                            <div class="mb-3">
                                <img id="preview-image"
                                    style="height:8rem; margin-left:30%;"
                                    src="{{ asset('images/default/default.png') }}"alt="Default Image">
                            </div>

                            <div class="form-group">
                                <input type="file" name="image" id="imageInput" class="form-control">
                            </div>
                            <script>
                                document.getElementById('imageInput').addEventListener('change', function (event) {
                                    const file = event.target.files[0];

                                    if (file) {
                                        const reader = new FileReader();

                                        reader.onload = function (e) {
                                            document.getElementById('preview-image').src = e.target.result;
                                        };

                                        reader.readAsDataURL(file);
                                    }
                                });
                                </script>
                            <button type="submit" class="btn_3">Submit Review</button>
                        </form>
                        {{-- FORM END --}}
                    </div>
                </div>

                {{-- JS --}}
                <script>
                    let stars = document.querySelectorAll('.star');
                    let ratingInput = document.getElementById('rating');
                    let ratingText = document.getElementById('rating-text');

                    function setRating(rating) {
                        ratingInput.value = rating;
                        ratingText.innerText = rating + " Star";

                        stars.forEach(star => {
                            let val = parseInt(star.getAttribute('data-value'));
                            if (val <= rating) {
                                star.classList.remove('fa-regular');
                                star.classList.add('fa-solid');
                                star.style.color = 'gold';
                            } else {
                                star.classList.remove('fa-solid');
                                star.classList.add('fa-regular');
                                star.style.color = '#ccc';
                            }
                        });
                    }

                    stars.forEach(star => {
                        star.addEventListener('click', function () {
                            setRating(parseInt(this.getAttribute('data-value')));
                        });
                    });

                    // ❌ Prevent submit if no rating
                    document.querySelector('form').addEventListener('submit', function(e){
                        if(ratingInput.value == 0){
                            e.preventDefault();
                            alert('Please select a rating!');
                        }
                    });
                </script>

            </div>
        </div>

        </div>
      </div>
    </div>
  </section>
  <!--================End Product Description Area =================-->

  <!-- product_list part start-->
  <section class="product_list best_seller">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="section_tittle text-center">
            <h2>Best Sellers <span>shop</span></h2>
          </div>
        </div>
      </div>
      <div class="row align-items-center justify-content-between">
          <div class="col-lg-12">
              <div class="best_product_slider owl-carousel">
                  @foreach ($producs as $product)
                <div class="single_product_item">
                  <img src="{{ asset('images/product') }}/{{ $product->thumbnail }}" alt="">
                  <div class="single_product_text">
                    <h4>{{ $product->title }}</h4>
                    @php
                    $price = strip_tags($product->price);
                    @endphp
                    <h3>{{ $price }}</h3>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>

   </div>
  </section>
@endsection


@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        @if ($errors->any())
            Toastify({
                text: "{{ $errors->first() }}",
                duration: 4000,
                close: true,
                gravity: "top",
                position: "center",
                backgroundColor: "linear-gradient(to right, #FF0112, #D21302)",
            }).showToast();
        @endif

        @if (session('success'))
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "center",
                backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
            }).showToast();
        @endif

        @if (session('error'))
            Toastify({
                text: "{{ session('error') }}",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "center",
                backgroundColor: "linear-gradient(to right, #FF0112, #D21302)",
            }).showToast();
        @endif

    });
</script>
@endsection
