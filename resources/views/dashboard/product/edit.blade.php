@extends('layouts.dashboardmaster.master')

@section('title')
    Show Product's
@endsection

@section('content')
<x-breadcum aranoz="Product Edit"></x-breadcum>
    <div class="row">
         <div class="col-lg-10" style="margin-left: 8%">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Product Update Form</h4>
                        <hr style="color: gray; width: 102.8%; margin-left: -1.5%;">
                        <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                                <div class="row mb-3">
                                 <label for="inputEmail3" class="col-sm-3 col-form-label">Categorie's</label>
                                <div class="col-sm-9">
                                    <div class="col-md-6">
                                                <select class="form-control" data-toggle="select2" name="category_id">
                                                    <option>Select</option>
                                                    <optgroup label="{{env('APP_SLOGAN')}}">
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}" @selected($category->id == $product->category_id)>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                        <div class="invalid-feedback">
                                            @error('category_id') {{ $message }} @enderror
                                        </div>
                                    </div>
                             </div>
                             <div class="row mb-3">
                                 <label for="inputEmail3" class="col-sm-3 col-form-label">Title</label>
                                <div class="col-sm-9">
                                     <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="inputEmail3" placeholder="Title" value="{{ $product->title }}">
                                        <div class="invalid-feedback">
                                            @error('title') {{ $message }} @enderror
                                        </div>
                                    </div>
                             </div>
                             <div class="row mb-3">
                                 <label for="inputEmail3" class="col-sm-3 col-form-label">Slug</label>
                                <div class="col-sm-9">
                                     <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" id="inputEmail3" placeholder="Slug" value="{{ $product->slug }}">
                                        <div class="invalid-feedback">
                                            @error('slug') {{ $message }} @enderror
                                        </div>
                                    </div>
                             </div>
                            <div class="row mb-3">
                                <label for="inputPassword3" class="col-sm-3 col-form-label">Price</label>
                                 <div class="col-sm-9">
                                <textarea id="price" type="text" name="price" class="form-control @error('price') is-invalid @enderror">{!! $product->price !!}</textarea>
                                   <div class="invalid-feedback">
                                            @error('price') {{ $message }} @enderror
                                        </div>
                            </div>
                          </div>
                            <div class="row mb-3">
                                <label for="inputPassword3" class="col-sm-3 col-form-label">short_description</label>
                                 <div class="col-sm-9">
                                  <textarea id="shortNote" type="text" name="short_description" class="form-control @error('short_description') is-invalid @enderror">{!! $product->short_description !!}</textarea>
                                  <div class="invalid-feedback">
                                            @error('short_description') {{ $message }} @enderror
                                        </div>
                                 </div>
                          </div>
                            <div class="row mb-3">
                                <label for="inputPassword3" class="col-sm-3 col-form-label">Discription</label>
                                 <div class="col-sm-9">
                                  <textarea id="longNote" type="text" name="description" class="form-control @error('description') is-invalid @enderror">{!! $product->description !!}</textarea>
                                  <div class="invalid-feedback">
                                            @error('description') {{ $message }} @enderror
                                        </div>
                                 </div>
                          </div>
                           <div class="mb-3">
                                 <img style="height: 35%; width: 35%; margin-left: 40%;" id="ecommerce" src="{{ asset('images/product/'.$product->thumbnail) }}" alt="Select Thumbnail">
                            </div>
                            <div class="row mb-2">
                                 <label for="inputPassword5" class="col-sm-3 col-form-label">Thumbnail</label>
                                 <div class="col-sm-9">
                                    <input onchange="document.querySelector('#ecommerce').src = window.URL.createObjectURL(this.files[0])" type="file" class="form-control @error('thumbnail') is-invalid @enderror" name="thumbnail" id="floatingnameInput">
                                    <div class="invalid-feedback">
                                            @error('thumbnail') {{ $message }} @enderror
                                        </div>
                                </div>
                            </div>
                            <div class="justify-content-end row">
                              <div class="col-sm-9">
                                   <button type="submit" class="btn btn-success waves-effect waves-light">Update Product</button>
                              </div>
                             </div>
                         </form>
                     </div>
              </div>
        </div>
    </div>
@endsection
@section('script')

<script>
    tinymce.init({
      selector: '#price',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
  </script>
  <script>
    tinymce.init({
      selector: '#shortNote',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
  </script>
<script>
    tinymce.init({
      selector: '#longNote',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
  </script>
@endsection
