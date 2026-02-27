@extends('layouts.dashboardmaster.master')

@section('title')
    Seller Update
@endsection

@section('content')
<x-breadcum aranoz="Seller Update"></x-breadcum>
    <div class="col-lg-11 mx-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Seller Update Form</h4>
                        <hr style="color: gray; width: 102%; margin-left: -1%;">
                        <form action="{{ route('management.assign.existing.role.seller.update',$seller->id) }}" method="post">
                            @csrf
                             <div class="row mb-3">
                                 <label for="inputEmail3" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                     <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="inputEmail3" placeholder="Name" value="{{ $seller->name }}">
                                        <div class="invalid-feedback">
                                            @error('name') {{ $message }} @enderror
                                        </div>
                                    </div>
                             </div>
                            <div class="row mb-3">
                                <label for="inputPassword3" class="col-sm-3 col-form-label">E-mail</label>
                                 <div class="col-sm-9">
                                  <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="inputPassword3" placeholder="E-mail" value="{{ $seller->email }}">
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
                                   <button type="submit" class="btn btn-success waves-effect waves-light">Change</button>
                              </div>
                             </div>
                         </form>
                     </div>
              </div>
        </div>
@endsection
