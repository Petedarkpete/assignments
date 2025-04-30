@extends('layouts.page')

@section('content')
<main id="main" class="main">
    <div class="container">
        <h2>Add Class</h2>

        <form method="POST">
            @csrf
            <div class="form-group">
                <label for="code">Subject Code</label>
                <input type="text" name="code" id="code" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="name">Subject Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success mt-3">Add Subject</button>
        </form>

    </div>
@endsection
