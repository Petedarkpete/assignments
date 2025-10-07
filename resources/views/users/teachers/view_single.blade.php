@extends('layouts.page')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/confirm_details.css') }}">
@endpush

@section('content')
<main id="main" class="main">
    <div class="container">
        <div class="teacher-details-container">
            <div class="card mt-4 fade-in">
                <div class="card-header">
                    Teacher Details
                </div>
                <div class="card-body">
                        <div class="teacher-info">
                            <div class="row align-items-start">
                                <div class="col-md-6">
                                    <p><strong>Full Name:</strong> {{ $teachers->name }}</p>
                                    <p><strong>Email:</strong> {{ $teachers->email }}</p>
                                    <p><strong>Phone:</strong> {{ $teachers->phone }}</p>
                                    <p><strong>Gender:</strong> {{ $teachers->gender }}</p>
                                </div>

                                <div class="col-md-6">
                                    <p><strong>Address:</strong> {{ $teachers->address }}</p>
                                    <p><strong>Qualification:</strong> {{ $teachers->qualification }}</p>
                                    <p><strong>Specialization:</strong> {{ $teachers->specialization }}</p>
                                    <p><strong>Join Date:</strong> {{ $teachers->join_date }} years</p>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('test', $teachers->id) }}">
                            @csrf
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">Back</button>
                                <a href="{{ route('teacher.edit', $teachers->id) }}" class="btn btn-secondary">Edit</a>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
@endsection
