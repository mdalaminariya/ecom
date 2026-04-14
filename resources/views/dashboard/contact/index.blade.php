@extends('layouts.dashboardmaster.master')

@section('title')
    Contact Messages
@endsection

@section('content')
<x-breadcum aranoz="Contact Messages"></x-breadcum>
<div class="col-lg-12" style="margin-top: -50px;">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-2 text-center">Contact Messages Table</h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 600px; overflow-y:auto;">

                <table class="table table-hover table-striped mb-0 text-nowrap">

                    <thead class="table-success">
                        <tr>
                            <th style="width:5%;">Sl.</th>
                            <th style="width:10%;">Image</th>
                            <th style="width:15%;">Name</th>
                            <th style="width:20%;">Email</th>
                            <th style="width:15%;">Subject</th>
                            <th style="width:25%;">Message</th>
                            <th style="width:10%;">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($contacts as $contact)

                        <tr>
                            <th>{{ $loop->iteration }}</th>

                            <td>
                                @if($contact->image)
                                    <img src="{{ asset('images/profile/' . $contact->image) }}"
                                         class="img-thumbnail"
                                         style="width:50px;height:50px;">
                                @else
                                    <img src="{{ asset('images/default/default.png') }}"
                                         class="img-thumbnail"
                                         style="width:50px;height:50px;">
                                @endif
                            </td>

                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>

                            <td>{{ $contact->subject }}</td>

                            <td>
                                {{ \Illuminate\Support\Str::limit($contact->message, 50) }}
                            </td>

                            <td>
                                <div class="d-flex gap-1">

                                    <!-- VIEW BUTTON -->
                                    <button class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#messageModal{{ $contact->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                <a href="{{ route('contacts.delete', $contact->id) }}" class="btn btn-sm btn-danger"
                                   onclick="return confirm('Are you sure?')">
                                    <i class="far fa-trash-alt"></i>
                                </a>

                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-warning">
                                No contact messages found.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>
                </table>

            </div>

            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-end">
                {{ $contacts->links() }}
            </div>

        </div>
    </div>
</div>


<!-- ================= MODALS (OUTSIDE TABLE) ================= -->
@foreach($contacts as $contact)

<div class="modal fade" id="messageModal{{ $contact->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Message from {{ $contact->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <p><strong>Name:</strong> {{ $contact->name }}</p>
                <p><strong>Email:</strong> {{ $contact->email }}</p>
                <p><strong>Subject:</strong> {{ $contact->subject }}</p>

                <hr>

                <p style="white-space: pre-wrap;">
                    {{ $contact->message }}
                </p>

            </div>

        </div>
    </div>
</div>

@endforeach

@endsection


<!-- ================= TOASTIFY ================= -->
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
