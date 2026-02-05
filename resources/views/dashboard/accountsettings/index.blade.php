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
                    <div class="card-title text-success">Account Setting's</div>
                  </div>
                  </div>
                  </div>
                  </div>
                  </div>
                  <div class="row">

                    {{-- name update start --}}
<div class="col-xl-6">
 <div class="card">
     <div class="card-body">
         <h5 class="header-title">Name Update Form</h5>
        <form action="{{ route('name.update') }}" method="POST">
             @csrf
            <div class="form-floating mb-3">
                   <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="floatingnameInput" placeholder="Enter Name" value="{{ old('name') }}">
                   <label for="floatingnameInput">Name</label>

                  @error('name')
                        <p class="text-danger">{{ $message }}</p>
                  @enderror
             </div>
             <div>
                <button type="submit" class="btn btn-primary w-md">Save</button>
             </div>
         </form>
    </div>

</div>
</div>

{{-- email update start --}}
<div class="col-xl-6">
<div class="card">
    <div class="card-body">
        <h5 class="header-title">E-mail Update Form</h5>
        <form action="{{ route('email.update') }}" method="POST">
             @csrf
            <div class="form-floating mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="floatingnameInput" placeholder="Enter Email" value="{{ old('email') }}">
                <label for="floatingnameInput">Email</label>

                @error('email')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
             <div>
                <button type="submit" class="btn btn-primary w-md">Save</button>
             </div>
         </form>
    </div>
 <!-- end card body -->
 </div>
  <!-- end card -->
</div>
{{-- email update start --}}

{{-- password update start --}}
<div class="col-xl-6">
<div class="card">
    <div class="card-body">
        <h5 class="header-title">Password Update Form</h5>
        <form action="{{ route('dashboard.password.update') }}" method="POST">
             @csrf
            <div class="form-floating mb-3">
                <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" id="floatingnameInput" placeholder="Enter Email" value="{{ old('current_password') }}">
                <label for="floatingnameInput">Current Password</label>

                @error('current_password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="floatingnameInput" placeholder="Enter Email" value="{{ old('password') }}">
                <label for="floatingnameInput">New Password</label>

                @error('password')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password_confirmation" id="floatingnameInput" placeholder="Enter Email" value="{{ old('password_confirmation') }}">
                <label for="floatingnameInput">Confirm Password</label>
            </div>
             <div>
                <button type="submit" class="btn btn-primary w-md">Save</button>
             </div>
         </form>
    </div>
 </div>
                </div>
                {{-- password update end --}}

                {{-- image update start --}}
<div class="col-xl-6">
<div class="card">
    <div class="card-body">
        <h5 class="header-title">Image Update Form</h5>
        <form action="{{ route('dashboard.image.update') }}" method="POST" enctype="multipart/form-data">
             @csrf
             <div class="mb-3">
                <img style="height: 8rem; margin-left: 30%;" id="ecommerce" src="{{ asset('images/profile') }}/{{ auth()->user()->image }}" alt="">
             </div>
            <div class="form-floating mb-3">
                <input onchange="document.querySelector('#ecommerce').src = window.URL.createObjectURL(this.files[0])" type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="floatingnameInput">
                <label for="floatingnameInput">Image</label>
                @error('image')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
             <div>
                <button type="submit" class="btn btn-primary w-md">Save</button>
             </div>
         </form>
    </div>
 <!-- end card body -->
 </div>
  <!-- end card -->
</div>
{{-- image update end --}}
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



