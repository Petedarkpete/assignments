@extends('layouts.page')

@section('content')
<main id="main" class="main">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-12">
                <div class="pagetitle">
                    <h1>Students</h1>
                </div>
            </div>
        </div>
        <div class="card mt-1">
            @if(session('success'))
                <div class="alert alert-success">
                    <p style="font-size: 0.85rem;">{{ session('success') }}</p>
                </div>
            @endif
            <div class="card-title d-flex justify-content-between align-items-center p-2">

                <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm">Add student</a>
            </div>
            <div class="card-body">
                <div class="table-responsive m-2">
                    <table class="table table-bordered bg-warning table-sm" id="modules_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Gender</th>
                                <th>Specialization</th>
                                <th>Class student</th>
                                <th>Joined On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->user->name }}</td>
                                <td>{{ $student->user->email }}</td>
                                <td>{{ $student->user->phone }}</td>
                                <td>{{ $student->user->gender }}</td>
                                <td>{{ $student->specialization }}</td>
                                <td>

                                </td>
                                <td>{{ $student->join_date}}</td>
                                <td>
                                    <a href="{{ route('student.edit', Crypt::encryptString($student->user->id)) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm delete-button">
                                        <i class="bi bi-trash"></i>
                                        <input type="hidden" id="studentId" value="{{ $student->user->id }}">
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
            $(document).ready(function() {

$('.delete-button').on('click', function(e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var studentId = $(this).find('#studentId').val();
    console.log(studentId);


    Swal.fire({
        title: 'Are you sure to delete this student?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: '/student/' + studentId,
                type: 'DELETE',
                success: function(response) {
                    if(response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });


                        $('button[data-id="' + studentId + '"]').closest('tr').remove();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Something went wrong.'
                    });
                }
            });
        }
    });
});
});
    </script>
@endsection
