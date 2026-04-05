
<!doctype html>
<html lang="zxx">
    @php
    $subscribed = session()->has('newsletter_email') &&
                  \App\Models\Newsletter::where('email', session('newsletter_email'))->exists();
@endphp

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>aranoz</title>
    <link rel="icon" href="{{ asset('frontend') }}/assets/img/favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/bootstrap.min.css">
    <!-- animate CSS -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/animate.css">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/owl.carousel.min.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/all.css">
    <!-- flaticon CSS -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/flaticon.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/themify-icons.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/magnific-popup.css">
    <!-- swiper CSS -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/slick.css">
    <!-- style CSS -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/style.css">
    {{-- font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <!--::header part start::-->
    <header class="main_menu home_menu">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="index.html"> <img src="{{ asset('frontend') }}/assets/img/logo.png" alt="logo"> </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="menu_icon"><i class="fas fa-bars"></i></span>
                        </button>

                        <div class="collapse navbar-collapse main-menu-item" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('frontend.home') }}">Home</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="blog.html" id="navbarDropdown_1"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Shop
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown_1">
                                        <a class="dropdown-item" href="{{ route('frontend.shop') }}"> shop category</a>

                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="blog.html" id="navbarDropdown_3"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        pages
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown_2">
                                        <a class="dropdown-item" href="{{ route('login') }}"> login</a>
                                        <a class="dropdown-item" href="tracking.html">tracking</a>
                                        <a class="dropdown-item" href="{{ route('product.checkout') }}">product checkout</a>
                                        <a class="dropdown-item" href="{{ route('shopping.cart') }}">shopping cart</a>
                                        <a class="dropdown-item" href="confirmation.html">confirmation</a>
                                        <a class="dropdown-item" href="elements.html">elements</a>
                                    </div>
                                </li>
                                    <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="{{ route('blog.index') }}" id="navbarDropdown_2"
                                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Blog
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown_2">
                                        @foreach ($blogs as $blog)
                                            <a class="dropdown-item" href="{{ route('blog.show', $blog) }}">
                                                Blogs
                                            </a>
                                        @endforeach
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="contact.html">Contact</a>
                                </li>
                            </ul>
                        </div>
         <div class="hearer_icon d-flex">
    <a id="search_1" href="javascript:void(0)"><i class="ti-search"></i></a>
<div class="cart-wrapper dropdown" style="position: relative;">
    <a href="{{ route('shopping.cart') }}" class="cart-icon" id="navbarDropdown3" data-toggle="dropdown" style="position: relative; display: inline-block;">
        <i class="fas fa-shopping-cart"></i>

        @if($cartCount > 0)
            <span class="cart-count">{{ $cartCount }}</span>
        @endif
    </a>

    <div class="dropdown-menu dropdown-menu-right cart-dropdown p-3">
        @if($cartCount > 0)
            @foreach($cartItems as $item)
                <div class="cart-item d-flex justify-content-between mb-2">
                    <div>
                        <img src="{{ asset('images/product/'.$item->product->thumbnail) }}" width="45">
                        {{ $item->product->title }}
                    </div>
                    <div>
                        x{{ $item->quantity }} <br>
                        ${{ number_format($item->product->price * $item->quantity, 0) }}
                    </div>
                </div>
            @endforeach

            <hr>

            <div class="d-flex justify-content-between">
                <strong>Total:</strong>
                <strong>${{ number_format($cartTotal, 0) }}</strong>
            </div>

            <a href="{{ route('shopping.cart') }}" class="btn btn-primary btn-sm w-100 mt-2">
                View Cart
            </a>
        @else
            <p class="text-center mb-0">Your cart is empty</p>
        @endif
    </div>
</div>
</div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="search_input" id="search_input_box">
            <div class="container">
                <form class="d-flex justify-content-between search-inner">
                    <input type="text" class="form-control" id="search_input" placeholder="Search Here">
                    <button type="submit" class="btn"></button>
                    <span class="ti-close" id="close_search" title="Close Search"></span>
                </form>
            </div>
        </div>
    </header>
    <!-- Header part end-->

   <div style="margin-top: 5%" class="main-content">
    @yield('content')
    </div>

        <!--::footer_part start::-->
    <footer class="footer_part">
        <div class="container">
            <div class="row justify-content-around">
                <div class="col-sm-6 col-lg-2">
                    <div class="single_footer_part">
                        <h4>Top Products</h4>
                        <ul class="list-unstyled">
                            <li><a href="">Managed Website</a></li>
                            <li><a href="">Manage Reputation</a></li>
                            <li><a href="">Power Tools</a></li>
                            <li><a href="">Marketing Service</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-2">
                    <div class="single_footer_part">
                        <h4>Quick Links</h4>
                        <ul class="list-unstyled">
                            <li><a href="">Jobs</a></li>
                            <li><a href="">Brand Assets</a></li>
                            <li><a href="">Investor Relations</a></li>
                            <li><a href="">Terms of Service</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-2">
                    <div class="single_footer_part">
                        <h4>Features</h4>
                        <ul class="list-unstyled">
                            <li><a href="">Jobs</a></li>
                            <li><a href="">Brand Assets</a></li>
                            <li><a href="">Investor Relations</a></li>
                            <li><a href="">Terms of Service</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-2">
                    <div class="single_footer_part">
                        <h4>Resources</h4>
                        <ul class="list-unstyled">
                            <li><a href="">Guides</a></li>
                            <li><a href="">Research</a></li>
                            <li><a href="">Experts</a></li>
                            <li><a href="">Agencies</a></li>
                        </ul>
                    </div>
                </div>
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
<div class="alert alert-success" style="height: 50px">
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
        <div class="copyright_part">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="copyright_text">
                            <P><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="ti-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></P>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="footer_icon social_icon">
                            <ul class="list-unstyled">
                                <li><a href="#" class="single_social_icon"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#" class="single_social_icon"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#" class="single_social_icon"><i class="fas fa-globe"></i></a></li>
                                <li><a href="#" class="single_social_icon"><i class="fab fa-behance"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--::footer_part end::-->


    <!-- jquery plugins here-->
    <script src="{{ asset('frontend') }}/assets/js/jquery-1.12.1.min.js"></script>
    <!-- popper js -->
    <script src="{{ asset('frontend') }}/assets/js/popper.min.js"></script>
    <!-- bootstrap js -->
    <script src="{{ asset('frontend') }}/assets/js/bootstrap.min.js"></script>
    <!-- easing js -->
    <script src="{{ asset('frontend') }}/assets/js/jquery.magnific-popup.js"></script>
    <!-- swiper js -->
    <script src="{{ asset('frontend') }}/assets/js/swiper.min.js"></script>
    <!-- swiper js -->
    <script src="{{ asset('frontend') }}/assets/js/masonry.pkgd.js"></script>
    <!-- particles js -->
    <script src="{{ asset('frontend') }}/assets/js/owl.carousel.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/jquery.nice-select.min.js"></script>
    <!-- slick js -->
    <script src="{{ asset('frontend') }}/assets/js/slick.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/jquery.counterup.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/waypoints.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/contact.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/jquery.ajaxchimp.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/jquery.form.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/jquery.validate.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/mail-script.js"></script>
    <!-- custom js -->
    <script src="{{ asset('frontend') }}/assets/js/custom.js"></script>

    <script>
    function toggleReply(id) {
        let form = document.getElementById('reply-form-' + id);

        if (form.style.display === "none") {
            form.style.display = "block";
        } else {
            form.style.display = "none";
        }
    }
</script>
</body>

</html>
