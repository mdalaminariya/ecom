@extends('layouts.dashboardmaster.master')

@section('title')
    Show Product's
@endsection

@section('content')
<x-breadcum aranoz="Product List"></x-breadcum>

<div class="row">
      <div class="col-lg-11" style="margin-left: 4%">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Product Table</div>
                  </div>
                  <div class="card-body">
                    <table class="table table-head-bg-success">
                      <thead>
                        <tr>
                          <th scope="col">No.</th>
                          <th scope="col">Thumbnail</th>
                          <th scope="col">Title</th>
                          <th scope="col">Category title</th>
                          <th scope="col">Price</th>
                          <th scope="col">Status</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                     @foreach ($products as $product)
                           <tr style="border: 1px solid rgba(26, 21, 21, 0.123);">
                             <th scope="row">
                                {{ $loop->index + 1 }}
                            </th>
                             <td>
                                <img src="{{ asset('images/product/'.$product->thumbnail) }}" style="width: 50px; height: 25px;">
                             </td>
                             <td>
                                {{ $product->title }}
                             </td>
                             <td>
                                {!! $product->category->title !!}
                             </td>
                             <td>
                                {!! $product->price !!}
                             </td>
                             <td>
                            <form id="Ecommarce-{{ $product->id }}" action="{{ route('product.status', $product->id) }}" method="post">
                                    @csrf
                                <div class="form-check form-switch btn-lg" style="margin-top: -2rem; margin-left: -1rem;">
                                    <input onchange="document.getElementById('Ecommarce-{{ $product->id }}').submit()" class="form-check-input" type="checkbox" role="switch" {{ $product->status == 'active' ? 'checked' : '' }}>
                                </div>
                            </form>
                             </td>
                             <td class="d-flex gap-2">
                                <a href="javascript:void(0)" type="button" class="btn btn-primary btn-sm" style="height: 35px"  data-bs-toggle="modal" data-bs-target="#showDetails{{ $product->id }}"><i class="fas fa-exclamation-circle"></i></a>
                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-info btn-sm mb-4"><i class="far fa-edit"></i></a>
                                <form action="{{ route('product.destroy', $product->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm mb-4"><i class="far fa-trash-alt"></i></button>
                                </form>
                             </td>
                           </tr>
                           <!-- Modal -->
                                <div class="modal fade" id="showDetails{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="showDetails{{ $product->id }}">{{ $product->id }} - {{ $product->title }}</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-bs-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <img style="height: 40%; width: 40%; margin-left: 30%;" id="ecommerce" src="{{ asset('images/product/'.$product->thumbnail) }}" alt="Select Thumbnail">
                                        <h2>Title {!! $product->title !!}</h2>
                                        <h2>Price {!! $product->price !!}</h2>
                                        <p>Description {!!$product->description !!}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <a href="{{ route('product.edit', $product->id) }}" type="button" class="btn btn-primary">changes</a>
                                    </div>
                                    </div>
                                </div>
                                </div>
                     @endforeach
                      </tbody>
                    </table>
                    {{ $products->links() }}
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
