@extends('layouts.dashboardmaster.master')

@section('title')
    Blocked User Management
@endsection


@section('content')
<div class="row">
<x-breadcum aranoz="Blocked User"></x-breadcum>
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
                                <a href="{{ route('management.block.user.delete', $user->id) }}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                             </td>
                             @endif
                           </tr>
                           @empty
                           <td class="text-center" colspan="5">
                                <div class="alert alert-warning text-center mb-0" role="alert">
                                    No blocked users found.
                                </div>
                           </td>
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
