@extends('layouts.dashboardmaster.master')

@section('title')
    Show Product's
@endsection

@section('content')
<x-breadcum aranoz="Product List"></x-breadcum>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm">

            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Product Table</h5>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-hover align-middle text-center">

                    <thead class="table-success">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Best</th>
                            <th>Banner</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <img src="{{ asset('images/product/'.$product->thumbnail) }}"
                                     class="img-thumbnail"
                                     style="width: 60px; height: 60px; object-fit: cover;">
                            </td>

                            <td>{{ $product->title }}</td>

                            <td>{{ $product->category->title ?? '-' }}</td>

                            <td><strong>৳{{ $product->price }}</strong></td>

                            <!-- STATUS -->
                            <td>
                                <form id="status-{{ $product->id }}" action="{{ route('product.status', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               onchange="this.form.submit()"
                                               {{ $product->status == 'active' ? 'checked' : '' }}>
                                    </div>
                                </form>
                            </td>

                            <!-- BEST SELLER -->
                            <td>
                                <form id="best-{{ $product->id }}" action="{{ route('product.best.seller', $product->slug) }}" method="POST">
                                    @csrf
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="is_best_seller"
                                               value="1"
                                               onchange="this.form.submit()"
                                               {{ $product->is_best_seller ? 'checked' : '' }}>
                                    </div>
                                </form>
                            </td>

                            <!-- BANNER -->
                            <td>
                                <form id="banner-{{ $product->id }}" action="{{ route('product.banner', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="is_banner"
                                               value="1"
                                               onchange="this.form.submit()"
                                               {{ $product->is_banner ? 'checked' : '' }}>
                                    </div>
                                </form>
                            </td>

                            <!-- ACTIONS -->
                            <td>
                                <div class="d-flex justify-content-center gap-2">

                                    <!-- View -->
                                    <button class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#showDetails{{ $product->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    <!-- Edit -->
                                    <a href="{{ route('product.edit', $product->id) }}"
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('product.destroy', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this product?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                        <!-- MODAL -->
                        <div class="modal fade" id="showDetails{{ $product->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            {{ $product->title }}
                                        </h5>
                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body text-center">
                                        <img src="{{ asset('images/product/'.$product->thumbnail) }}"
                                             class="img-fluid mb-3"
                                             style="max-height: 200px; object-fit: cover;">

                                        <h4>${{ $product->price }}</h4>

                                        <p class="text-muted mt-3">
                                            {!! $product->description !!}
                                        </p>
                                    </div>

                                    <div class="modal-footer">
                                        <a href="{{ route('product.edit', $product->id) }}"
                                           class="btn btn-primary">
                                            Edit Product
                                        </a>
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="9">
                                <div class="alert alert-warning mb-0">
                                    No products found. Please add products.
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>

                <div class="mt-3">
                    {{ $products->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

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
