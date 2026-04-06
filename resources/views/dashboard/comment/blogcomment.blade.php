@extends('layouts.dashboardmaster.master')

@section('title')
    Category Management
@endsection

@section('content')
<x-breadcum aranoz="Comments"></x-breadcum>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Comment Table</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 600px; overflow-y:auto;">
                <table class="table table-hover table-striped mb-0 text-nowrap">
                    <thead class="table-success sticky-top">
                        <tr>
                            <th scope="col" style="width:5%;">Sl.</th>
                            <th scope="col" style="width:10%;">Image</th>
                            <th scope="col" style="width:15%;">Name</th>
                            <th scope="col" style="width:20%;">Email</th>
                            <th scope="col" style="width:20%;">Role</th>
                            <th scope="col" style="width:20%;">Blog Title</th>
                            <th scope="col" style="width:40%;">Comment</th>
                            <th scope="col" style="width:10%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($comments as $comment)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>
                                @php
                                    $imagePath = public_path('images/profile/' . $comment->image);
                                @endphp
                                @if ($comment->image && file_exists($imagePath))
                                    <img src="{{ asset('images/profile/' . $comment->image) }}" class="img-thumbnail" style="width:50px; height:50px; object-fit:cover;">
                                @else
                                    <img src="{{ asset('images/default/default.png') }}" class="img-thumbnail" style="width:50px; height:50px; object-fit:cover;">
                                @endif
                            </td>
                            <td>{{ $comment->user->name }}</td>
                            <td>{{ $comment->user->email }}</td>
                            <td>{{ $comment->user->role }}</td>
                            <td>{{ $comment->blog->title }}</td>
                            <td style="max-width: 400px; overflow-wrap: break-word;">{{ $comment->message }}</td>
                            <td class=" justify-content-center">
                                    <a href="{{ route('blog.comments.delete', $comment->id) }}" class="btn btn-danger btn-sm" title="Delete Comment">
                                        <i class="far fa-trash-alt"></i>
                                    </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="alert alert-warning text-center mb-0 py-2">
                                    No comments found. Please add comments.
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-end">
                {{ $comments->links() }}
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
