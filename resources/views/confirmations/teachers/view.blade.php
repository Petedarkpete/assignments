@extends('layouts.page')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/confirm_details.css') }}">
@endpush

@section('content')

<main id="main" class="main">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-12">
                <div class="pagetitle">
                    <h1>Confirm Teachers</h1>
                </div>
            </div>
        </div>
        <div class="card mt-1">
            @if(session('error'))
                <div class="alert alert-danger">
                    <p style="font-size: 0.85rem;">{{ session('error') }}</p>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card-body">
                <div class="table-responsive m-2">
                    <div class="table-container table-fade-in">

                    <table class="table table-bordered enhanced-table bg-warning table-sm" id="modules_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teachers as $teacher)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $teacher->name }}</td>
                                <td>{{ $teacher->phone }}</td>
                                <td>{{ $teacher->email }}</td>
                                <td>
                                    <a href="/teachers/{{ $teacher->id }}/view" class="btn btn-success btn-sm">
                                        <em><i class="bi bi-check-circle"></i> &nbsp;Confirm</em>
                                    </a>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
