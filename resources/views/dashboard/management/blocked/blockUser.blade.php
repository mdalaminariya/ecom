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
                    <div class="card-title text-success">Blocked User's</div>
                  </div>
                  </div>
                  </div>
                  </div>
</div>

<div class="row">
       <div class="col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Block User's Table</div>
                  </div>
                  <div class="card-body">
                    <table class="table table-head-bg-success">
                      <thead>
                        <tr>
                          <th scope="col">No.</th>
                          <th scope="col">Name</th>
                          <th scope="col">Role</th>
                          @if(auth()->user()->role == 'admin' || auth()->user()->role == 'manager')
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
                                <form id="Ecommarce--{{ $user->id }}" action="{{ route('management.user.unblock', $user->id) }}" method="post">
                                    @csrf
                                <div class="form-check form-switch">
                                    <input onchange="confirm('Are you want Unblocked {{ $user->name }}?') && document.getElementById('Ecommarce--{{ $user->id }}').submit()" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" {{ $user->role == 'user' ? 'checked' : 'deactive' }}>
                                </div>
                                </form>
                             </td>
                              <td>
                                <a href="{{ route('management.assign.existing.role.blogger.block', $user->id) }}" class="btn btn-info btn-sm"><i class="fas fa-user-alt-slash"></i></a>
                                <a href="{{ route('management.assign.existing.role.blogger.delete', $user->id) }}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
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
