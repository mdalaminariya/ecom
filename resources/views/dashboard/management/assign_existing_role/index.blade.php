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
                    <div class="card-title text-success">Assign Existing Role</div>
                  </div>
                  </div>
                  </div>
                  </div>
</div>

<div class="row">
<div class="col-lg-11 mx-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Assign Existing Role</h4>
                        <hr style="color: gray; width: 103%; margin-left: -1.5%;">
                        <form action="{{ route('management.assign.existing.role.store') }}" method="post">
                            @csrf

                            <div class="row mb-2">
                                <label for="inputPassword3" class="col-sm-3 col-form-label">Manage User's</label>
                                 <div class="col-sm-9">
                                  <select class="form-select @error('user_id') is-invalid @enderror" name="user_id">
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                  </select>
                                    <div class="invalid-feedback">
                                            @error('user_id') {{ $message }} @enderror
                                 </div>
                          </div>
                            </div>

                            <div class="row mb-2">
                                <label for="inputPassword3" class="col-sm-3 col-form-label">Manage Role</label>
                                 <div class="col-sm-9">
                                  <select class="form-select @error('role') is-invalid @enderror" name="role">
                                    <option value="">Select Role</option>
                                    <option value="manager">Manager</option>
                                    <option value="blogger">Blogger</option>
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
</div>

<div class="row">
    {{-- Blogger Show page Sart --}}
    <div class="col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Blogger's Table</div>
                  </div>
                  <div class="card-body">
                    <table class="table table-head-bg-success">
                      <thead>
                        <tr>
                          <th scope="col">No.</th>
                          <th scope="col">Name</th>
                          <th scope="col">Role</th>
                          @if(auth()->user()->role == 'admin' || auth()->user()->role == 'manager')
                          <th scope="col">Status</th>
                          <th scope="col">Action</th>
                            @endif
                        </tr>
                      </thead>
                      <tbody>
                     @forelse ($bloggers as $blogger)
                           <tr>
                             <th scope="row">
                                {{ $loop->index + 1 }}
                            </th>
                             <td>
                                {{ $blogger->name }}
                             </td>
                             <td>
                                {{ $blogger->role }}
                             </td>
                             @if(auth()->user()->role == 'admin')
                             <td>
                                <form id="Ecommarce--{{ $blogger->id }}" action="{{ route('management.assign.existing.role.blogger.down', $blogger->id) }}" method="post">
                                    @csrf
                                <div class="form-check form-switch">
                                    <input onchange="confirm('Are you want demotion {{ $blogger->name }}?') && document.getElementById('Ecommarce--{{ $blogger->id }}').submit()" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" {{ $blogger->role == 'blogger' ? 'checked' : 'deactive' }}>
                                </div>
                                </form>
                             </td>
                              <td>
                                <a href="{{ route('management.assign.existing.role.blogger.edit', $blogger->id) }}" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a>
                                <a href="{{ route('management.assign.existing.role.blogger.delete', $blogger->id) }}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
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
                {{-- Blogger Show page End --}}

                {{-- User Show page Start --}}
<div class="col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">User's Table</div>
                  </div>
                  <div class="card-body">
                    <table class="table table-head-bg-success">
                      <thead>
                        <tr>
                          <th scope="col">No.</th>
                          <th scope="col">Name</th>
                          <th scope="col">Role</th>
                          @if(auth()->user()->role == 'admin')
                          <th scope="col">Blocked</th>
                          <th scope="col">Action</th>
                            @endif
                        </tr>
                      </thead>
                       <tbody>
                     @forelse ($users as $user)
                           <tr>
                             <th scope="row">
                                {{ $loop->index + 1 }}
                            </th>
                             <td>
                                {{ $user->name }}
                             </td>
                             <td>
                                {{ $user->role }}
                             </td>
                             @if(auth()->user()->role == 'admin')
                             <td>
                                <form id="Ecommarce--{{ $user->id }}" action="{{ route('management.assign.existing.role.user.block', $user->id) }}" method="post">
                                    @csrf
                                <div class="form-check form-switch">
                                    <input onchange="confirm('Are you want blocked this user {{ $user->name }}?') && document.getElementById('Ecommarce--{{ $user->id }}').submit()" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" {{ $user->role == 'user' ? 'checked' : '' }}>
                                </div>
                             </td>
                              <td>
                                <a href="{{ route('management.assign.existing.role.user.edit', $user->id) }}" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a>
                                <a href="{{ route('management.assign.existing.role.user.delete', $user->id) }}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
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
            {{-- User Show page End --}}
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
