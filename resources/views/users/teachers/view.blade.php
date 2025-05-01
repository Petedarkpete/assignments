@extends('layouts.page')

@section('content')
<main id="main" class="main">
    <div class="container">
        <div class="row text-center pt-3">
            <div class="col-lg-12">
                <div class="pagetitle">
                    <h1>Teachers</h1>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            @if(session('success'))
                <div class="alert alert-success">
                    <p style="font-size: 0.85rem;">{{ session('success') }}</p>
                </div>
            @endif
            <div class="card-title d-flex justify-content-between align-items-center p-2">

                <a href="{{ route('teachers.create') }}" class="btn btn-primary btn-sm">Add Teacher</a>
            </div>
            <div class="card-body">
                <div class="table-responsive m-2">
                    <table class="table table-bordered bg-warning table-sm" id="modules_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Submodule Title</th>
                                <th>Module Code</th>
                                <th>Status</th>
                                <th>Created On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
