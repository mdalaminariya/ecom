@extends('layouts.dashboardmaster.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Subscriber List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="btn-success">SL No</th>
                                <th class="btn-success">ID</th>
                                <th class="btn-success">Email</th>
                                <th class="btn-success">Subscribed At</th>
                                <th class="btn-success">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subscribers as $subscriber)
                            <tr>
                                 <th scope="row">
                                {{ $loop->index + 1 }}
                            </th>
                                <td>{{ $subscriber->id }}</td>
                                <td>{{ $subscriber->email }}</td>
                                <td>{{ $subscriber->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                <a href="{{ route('subscriber.delete',$subscriber->id) }}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
