@extends('layouts.dashboardmaster.master')

@section('title')
    Category Management
@endsection

@section('content')
<x-breadcum aranoz="Category List"></x-breadcum>

<div class="row g-4">
    {{-- Category Table --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Category Table</h5>
            </div>
            <div class="card-body p-0">
                {{-- Table scrolls if content is long --}}
                <div class="table-responsive" style="max-height: 600px; overflow-y:auto;">
                    <table class="table table-hover mb-0">
                        <thead class="table-success">
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
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>
                                    <img src="{{ asset('images/category/'.$category->thumbnail) }}" class="img-thumbnail" style="width: 60px; height: 40px;">
                                </td>
                                <td>{{ $category->title }}</td>
                                <td>
                                    <form id="category-status-{{ $category->id }}" action="{{ route('category.status', $category->slug) }}" method="post">
                                        @csrf
                                        <div class="form-check form-switch">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                role="switch"
                                                onchange="document.getElementById('category-status-{{ $category->id }}').submit()"
                                                {{ $category->status == 'active' ? 'checked' : '' }}>
                                        </div>
                                    </form>
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('category.edit', $category->slug) }}" class="btn btn-info btn-sm"><i class="far fa-edit"></i></a>
                                    <a href="{{ route('category.delete', $category->slug) }}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Category Insert Form --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Add New Category</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Category Title">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" id="slug" placeholder="category-slug">
                    </div>

                    <div class="mb-3 text-center">
                        <img id="categoryPreview" src="{{ asset('images/default/default.png') }}" class="img-fluid rounded" style="height: 8rem;">
                    </div>

                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Thumbnail</label>
                        <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail" onchange="document.getElementById('categoryPreview').src = window.URL.createObjectURL(this.files[0])">
                        @error('thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Insert</button>
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
