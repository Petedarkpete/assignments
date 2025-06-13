@extends('layouts.page')

@section('content')
<main id="main" class="main">

    <div class="container">
        <h3>Add Assignment</h3>

        <div class="card">
            @if(session('success'))
                <div class="alert alert-success">
                    <p style="font-size: 0.85rem;">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <p style="font-size: 0.85rem;">{{ session('error') }}</p>
                </div>
            @endif
            <div class="card-body">

                <form action="/assignments/store" method="POST"  enctype="multipart/form-data">
                    @csrf

                    <div id="step-1">
                        <div class="row mb-2">
                            <!-- Title -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" placeholder="e.g. Math Homework" value="{{ old('title', $assignment->title ?? '') }}" required>
                            </div>

                            <!-- Description -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Write assignment details..." required>{{ old('description', $assignment->description ?? '') }}</textarea>
                            </div>

                            <!-- File Upload -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Attach File (optional)</label>
                                <input type="file" name="file" class="form-control">
                            </div>

                            <!-- Due Date -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Due Date</label>
                                <input type="date" name="due_date" class="form-control" required value="{{ old('due_date', $assignment->due_date ?? '') }}">
                            </div>

                            <!-- External Link -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Link to Resource (optional) </label>
                                <input type="url" name="external_link" class="form-control" placeholder="https://example.com/resource" value="{{ old('external_link', $assignment->external_link ?? '') }}">
                            </div>

                            <!-- Hidden or Selected Fields -->
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Subject</label>
                                <select name="subject_id" class="form-control" required>
                                    <option value="">Select Subject</option>
                                    <option value="{{ $assignment->id }}">{{ old('subject_id', $assignment->name) }}</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Class</label>
                                <select name="class_id" class="form-control" required>
                                    <option value="">Select Class</option>
                                    {{-- @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->label }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Submit Assignment</button>
                        </div>
                    </div>


                </form>
            </div>
        </div>

    </div>



@endsection
