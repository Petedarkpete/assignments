@extends('layouts.page')

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
        <h4 class="alert-heading mb-2">Confirm Teacher Account</h4>
        <p class="mb-0">
            Please review the details below carefully before confirming this teacher's account.
            Once confirmed, the teacher will be granted access to the system.
        </p>
    </div>

    <div class="card mt-4">
            <div class="card-header">Teacher Details</div>
                <div class="card-body">
                    @foreach ($teachers as $teacher)
                        <p><strong>Name:</strong> {{ $teacher->name }}</p>
                        <p><strong>Email:</strong> {{ $teacher->email }}</p>
                        <p><strong>Phone:</strong> {{ $teacher->phone }}</p>

                        <form method="POST" action="{{ route('test', $teacher->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-success">Confirm</button>
                            <a href="{{ route('teachers.view') }}" class="btn btn-secondary">Cancel</a>

                        </form>
                        <a href="{{ route('test', $teacher->id )}}" class="btn btn-secondary">Confirm</a>


                    @endforeach
                </div>
            </div>
    </div>
</main>
@endsection
