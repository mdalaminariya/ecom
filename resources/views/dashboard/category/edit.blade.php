@extends('layouts.dashboardmaster.master')

@section('content')

<div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Forms</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="#">
                    <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Forms</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Basic Form</a>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-md-12 ">
                <div class="card">
                  <div class="card-header mx-auto">
                    <div class="card-title text-success">Category Update</div>
                  </div>
                  </div>
                  </div>
                  </div>
                  </div>


      <div class="row">
              {{-- category Insert From --}}
              <div class="col-lg-8" style="margin-left: 10%">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Category Update Form</h4>
                        <hr style="color: gray; width: 104%; margin-left: -2%;">
                        <form action="{{ route('category.update',$category->slug) }}" method="post" enctype="multipart/form-data">
                            @csrf
                             <div class="row mb-3">
                                 <label for="inputEmail3" class="col-sm-3 col-form-label">Title</label>
                                <div class="col-sm-9">
                                     <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="inputEmail3" placeholder="Title" value="{{ $category->title }}">
                                        <div class="invalid-feedback">
                                            @error('title') {{ $message }} @enderror
                                        </div>
                                    </div>
                             </div>
                            <div class="row mb-3">
                                <label for="inputPassword3" class="col-sm-3 col-form-label">Slug</label>
                                 <div class="col-sm-9">
                                  <input type="text" name="slug" class="form-control" id="inputPassword3" placeholder="Slug" value="{{ $category->slug }}">
                                 </div>
                          </div>
                            <div class="row mb-2">
                                 <label for="inputPassword5" class="col-sm-3 col-form-label">Thumbnail</label>
                                 <div class="col-sm-9" style="margin-left: 25%; margin-top: -5%;">
                                    <input onchange="document.querySelector('#ecommerce').src = window.URL.createObjectURL(this.files[0])" type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" id="inputPassword5">
                                    <div class="invalid-feedback">
                                            @error('thumbnail') {{ $message }} @enderror
                                        </div>
                                </div>
                                 <div class="mb-3">
                                    <img style="height: 15rem; margin-left: 30%; margin-top: 2%; object-fit: contain;" id="ecommerce" src="{{ asset('images/category') }}/{{ $category->thumbnail }}" alt="">
                                </div>
                            </div>
                            <div class="justify-content-end row">
                              <div class="col-sm-9 mb-2">
                                   <button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
                              </div>
                             </div>
                         </form>
                     </div>
              </div>
        </div>
</div>

@endsection
