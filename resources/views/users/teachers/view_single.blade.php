@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/confirm_details.css') }}">
@endpush

@section('content')
<div class="teacher-details-container">
    <div class="card mt-4 fade-in">
        <div class="card-header">
            Teacher Details
        </div>
        <div class="card-body">
            @foreach ($teachers as $teacher)
                <div class="teacher-info">
                    <div class="row align-items-start">
                        <div class="col-md-6">
                            <p><strong>Full Name:</strong> {{ $teacher->name }}</p>
                            <p><strong>Email:</strong> {{ $teacher->email }}</p>
                            <p><strong>Phone:</strong> {{ $teacher->phone }}</p>
                            <p><strong>Gender:</strong> {{ $teacher->gender }}</p>
                        </div>

                        <div class="col-md-6">
                            <p><strong>Address:</strong> {{ $teacher->address }}</p>
                            <p><strong>Qualification:</strong> {{ $teacher->qualification }}</p>
                            <p><strong>Specialization:</strong> {{ $teacher->specialization }}</p>
                            <p><strong>Join Date:</strong> {{ $teacher->join_date }} years</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('test', $teacher->id) }}">
                    @csrf
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">Confirm</button>
                        <a href="{{ route('teachers.view') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            @endforeach
        </div>
    </div>
</div>
@endsection
