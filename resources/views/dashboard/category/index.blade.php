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
                    <div class="card-title text-success">Category</div>
                  </div>
                  </div>
                  </div>
                  </div>
                  </div>

<div class="row">
    <div class="col-lg-6 mx-5">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Category Table</div>
                  </div>
                  <div class="card-body">
                    <table class="table table-head-bg-success">
                      <thead>
                        <tr>
                          <th scope="col">No.</th>
                          <th scope="col">Thumbnail</th>
                          <th scope="col">Title</th>
                          <th scope="col">Status</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                     @foreach ($categories as $category)
                           <tr>
                             <th scope="row">
                                {{ $loop->index + 1 }}
                            </th>
                             <td>
                                <img src="{{ asset('images/category/'.$category->thumbnail) }}" style="width: 50px; height: 30px;">
                             </td>
                             <td>
                                {{ $category->title }}
                             </td>
                             <td>
                                <form id="Ecommarce" action="{{ route('category.status',$category->slug) }}" method="post">
                                    @csrf
                                <div class="form-check form-switch">
                                    <input onchange="document.getElementById('Ecommarce').submit()" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" {{ $category->status == 'active' ? 'checked' : 'deactive' }}>
                                </div>
                                </form>
                             </td>
                             <td class="d-flex gap-2">
                                <a href="{{ route('category.edit',$category->slug) }}" class="btn btn-info btn-sm"><i class="far fa-edit"></i></a>
                                <a href="{{ route('category.delete',$category->slug) }}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                             </td>
                           </tr>
                     @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              {{-- category Insert From --}}
              <div class="col-lg-5" style="margin-left: -30px">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Category Insert Form</h4>
                        <hr style="color: gray; width: 107.8%; margin-left: -4%;">
                        <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                             <div class="row mb-3">
                                 <label for="inputEmail3" class="col-sm-3 col-form-label">Title</label>
                                <div class="col-sm-9">
                                     <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="inputEmail3" placeholder="Title">
                                        <div class="invalid-feedback">
                                            @error('title') {{ $message }} @enderror
                                        </div>
                                    </div>
                             </div>
                            <div class="row mb-3">
                                <label for="inputPassword3" class="col-sm-3 col-form-label">Slug</label>
                                 <div class="col-sm-9">
                                  <input type="text" name="slug" class="form-control" id="inputPassword3" placeholder="Slug">
                                 </div>
                          </div>
                            <div class="row mb-2">
                                 <label for="inputPassword5" class="col-sm-3 col-form-label">Thumbnail</label>
                                 <div class="col-sm-9">
                                    <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" id="inputPassword5">
                                    <div class="invalid-feedback">
                                            @error('thumbnail') {{ $message }} @enderror
                                        </div>
                                </div>
                            </div>
                            <div class="justify-content-end row">
                              <div class="col-sm-9">
                                   <button type="submit" class="btn btn-success waves-effect waves-light">Insert</button>
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
