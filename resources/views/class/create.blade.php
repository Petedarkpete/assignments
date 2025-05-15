@extends('layouts.page')

@section('content')
<main id="main" class="main">
    <div class="container">
        <h2>Add Class</h2>

        <form action="" method="POST">
            @csrf
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Employee ID</label>
                <input type="text" name="employee_id" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Subject</label>
                <input type="text" name="subject" class="form-control">
            </div>

            <div class="mb-3">
                <label>Joining Date</label>
                <input type="date" name="joining_date" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Add Teacher</button>
        </form>
    </div>
@endsection
