@extends('layouts.frontendmaster.master')

@section('content')
  <section class="breadcrumb breadcrumb_bg">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="breadcrumb_iner">
            <div class="breadcrumb_iner_item">
              <h2>Cart Products</h2>
              <p><a style="text-decoration: none; color: #333;" href="{{ route('frontend.home') }}">Home</a> <span>-</span>Cart Products</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<div class="container py-5">
    <h2 class="mb-4 text-center">Category List</h2>

    @if($Categories->count() > 0)
    <div class="row g-4">
        @foreach($Categories as $category)
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="category-card text-center p-3 rounded shadow-sm h-100">
                <div class="category-image mb-3">
                    @if($category->thumbnail)
                        <img src="{{ asset('images/category/'.$category->thumbnail) }}" alt="{{ $category->title }}">
                    @else
                        <div class="no-image">No Image</div>
                    @endif
                </div>
                <h5 class="category-title mb-2">
                    <a href="{{ route('category.product', $category->slug) }}">{{ $category->title }}</a>
                </h5>
                <span class="badge bg-primary"><a href="{{ route('category.product', $category->slug) }}" class="text-white text-decoration-none">{{ $category->oneproduct->count() }} Products</a></span>
            </div>
        </div>
        @endforeach
    </div>
    @else
        <p class="text-center text-danger mt-5"><b>No categories found</b></p>
    @endif
</div>

<style>
/* Card Styling */
.category-card {
    background: #fff;
    transition: transform 0.3s, box-shadow 0.3s;
    cursor: pointer;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}

/* Image Styling */
.category-image img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 10px;
}

.category-image .no-image {
    width: 100%;
    height: 180px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    color: #dc3545;
    border-radius: 10px;
    font-weight: bold;
}

.category-title a {
    text-decoration: none;
    color: #333;
    font-size: 1.2rem;
    font-weight: 600;
}

.category-title a:hover {
    color: #0d6efd;
}
</style>
@endsection
