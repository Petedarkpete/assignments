@extends('layouts.page')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/confirm_details.css') }}">
@endpush

@section('content')
<main id="main" class="main">
    <div class="container mx-auto py-8">
        <div class="card mt-1">
            @if(session('success'))
                <div class="alert alert-success">
                    <p style="font-size: 0.85rem;">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
         <div class="alert alert-info shadow-sm">
        <h4 class="alert-heading mb-2">Confirm parent Account</h4>
        <p class="mb-0">
            Please review the details below carefully before confirming this parent's account.
            Once confirmed, the parent will be granted access to the system.
        </p>
        </div>

        <div class="parent-details-container">
            <div class="card mt-4 fade-in">
                <div class="card-header">
                    parent Details
                </div>
                <div class="card-body">
                    @foreach ($parents as $parent)
                        <div class="parent-info">
                            <div class="row align-items-start">
                                <div class="col-md-6">
                                    <p><strong>Full Name:</strong> {{ $parent->name }}</p>
                                    <p><strong>Email:</strong> {{ $parent->email }}</p>
                                    <p><strong>Phone:</strong> {{ $parent->phone }}</p>
                                    <p><strong>Gender:</strong> {{ $parent->gender }}</p>
                                </div>

                                <div class="col-md-6">
                                    <p><strong>Address:</strong> {{ $parent->address }}</p>

                                </div>
                            </div>
                        </div>

                        <form method="POST" action="">
                            @csrf
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">Confirm</button>
                                <a href="" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
</main>
@endsection
