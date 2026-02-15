@extends('layouts.dashboardmaster.master')

@section('content')
    <div class="row">
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
                    <div class="card-title text-success">User Update</div>
                  </div>
                  </div>
                  </div>
                  </div>
                  </div>
    </div>

    <div class="col-lg-11 mx-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Management Insert Form</h4>
                        <hr style="color: gray; width: 102%; margin-left: -1%;">
                        <form action="{{ route('management.assign.existing.role.blogger.update',$blogger->id) }}" method="post">
                            @csrf
                             <div class="row mb-3">
                                 <label for="inputEmail3" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                     <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="inputEmail3" placeholder="Name" value="{{ $blogger->name }}">
                                        <div class="invalid-feedback">
                                            @error('name') {{ $message }} @enderror
                                        </div>
                                    </div>
                             </div>
                            <div class="row mb-3">
                                <label for="inputPassword3" class="col-sm-3 col-form-label">E-mail</label>
                                 <div class="col-sm-9">
                                  <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="inputPassword3" placeholder="E-mail" value="{{ $blogger->email }}">
                                    <div class="invalid-feedback">
                                            @error('email') {{ $message }} @enderror
                                 </div>
                          </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputPassword3" class="col-sm-3 col-form-label">New Password</label>
                                 <div class="col-sm-9">
                                  <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="inputPassword3" placeholder="New Password">
                                    <div class="invalid-feedback">
                                            @error('password') {{ $message }} @enderror
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
@endsection
