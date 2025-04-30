@extends('layouts.page')

@section('content')
<main id="main" class="main">
    <div class="container">
        <h3 class="mb-2">Add Subject</h3>
        <div class="card shadow-sm">

            <div class="card-body">
                <form action="{{ route('subject.store') }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Subject Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="code" class="form-label">Subject Code</label>
                        <input type="text" name="code" id="code" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Add Subject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
