@extends('layouts.dashboardmaster.master')

@section('title')
    Registration Management
@endsection

@section('content')
<div class="row">
<x-breadcum aranoz="Registration Management"></x-breadcum>
<div class="col-lg-6 mx-4">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Manager's Table</div>
                  </div>
                  <div class="card-body">
                    <table class="table table-head-bg-success">
                      <thead>
                        <tr>
                          <th scope="col">No.</th>
                          <th scope="col">Name</th>
                          <th scope="col">Role</th>
                          @if(auth()->user()->role == 'admin')
                          <th scope="col">Status</th>
                          <th scope="col">Action</th>
                            @endif
                        </tr>
                      </thead>
                      <tbody>
                     @forelse ($managers as $manager)
                           <tr>
                             <th scope="row">
                                {{ $loop->index + 1 }}
                            </th>
                             <td>
                                {{ $manager->name }}
                             </td>
                             <td>
                                {{ $manager->role }}
                             </td>
                             @if(auth()->user()->role == 'admin')
                             <td>
                                <form id="Ecommarce--{{ $manager->id }}" action="{{ route('management.manager.down',$manager->id) }}" method="post">
                                    @csrf
                                <div class="form-check form-switch">
                                    <input onchange="confirm('Are you want demotion {{ $manager->name }}?') && document.getElementById('Ecommarce--{{ $manager->id }}').submit()" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" {{ $manager->role == 'manager' ? 'checked' : 'deactive' }}>
                                </div>
                                </form>
                             </td>
                              <td>
                                <a href="{{ route('management.assign.existing.role.manager.edit',$manager->id) }}" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a>
                                <a href="{{ route('management.manager.delete',$manager->id) }}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                             </td>
                             @endif
                           </tr>
                           @empty
                           <tr>
                             <td colspan="5" class="text-danger text-center">Please Insert Data.!</td>
                           </tr>
                     @endforelse
                      </tbody>
                    </table>
                  </div>
                </div>
</div>

              {{-- Management Insert Form Start --}}
        <div class="col-lg-5 mx-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Management Insert Form</h4>
                        <hr style="color: gray; width: 104%; margin-left: -2%;">
                        <form action="{{ route('management.register.store') }}" method="post">
                            @csrf
                             <div class="row mb-3">
                                 <label for="inputEmail3" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                     <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="inputEmail3" placeholder="Name">
                                        <div class="invalid-feedback">
                                            @error('name') {{ $message }} @enderror
                                        </div>
                                    </div>
                             </div>
                            <div class="row mb-3">
                                <label for="inputPassword3" class="col-sm-3 col-form-label">E-mail</label>
                                 <div class="col-sm-9">
                                  <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="inputPassword3" placeholder="E-mail">
                                    <div class="invalid-feedback">
                                            @error('email') {{ $message }} @enderror
                                 </div>
                          </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputPassword3" class="col-sm-3 col-form-label">Password</label>
                                 <div class="col-sm-9">
                                  <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="inputPassword3" placeholder="Password">
                                    <div class="invalid-feedback">
                                            @error('password') {{ $message }} @enderror
                                 </div>
                          </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputPassword3" class="col-sm-3 col-form-label">Role</label>
                                 <div class="col-sm-9">
                                  <select class="form-select @error('role') is-invalid @enderror" name="role">
                                    <option value="">Select Role</option>
                                    <option value="manager">Manager</option>
                                    <option value="seller">Seller</option>
                                    <option value="user">User</option>
                                  </select>
                                    <div class="invalid-feedback">
                                            @error('role') {{ $message }} @enderror
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
         {{-- Management Insert Form end --}}
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
