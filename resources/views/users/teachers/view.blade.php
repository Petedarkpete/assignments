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
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Gender</th>
                                <th>Specialization</th>
                                <th>Class Teacher</th>
                                <th>Joined On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teachers as $teacher)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $teacher->user->name }}</td>
                                <td>{{ $teacher->user->email }}</td>
                                <td>{{ $teacher->user->phone }}</td>
                                <td>{{ $teacher->user->gender }}</td>
                                <td>{{ $teacher->specialization }}</td>
                                <td>
                                    @if($teacher->is_class_teacher)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>
                                <td>{{ $teacher->join_date}}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-button">
                                        <i class="bi bi-trash"></i>
                                        <input type="hidden" id="teacherId" value="{{ $teacher->user->id }}">
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
    var teacherId = $(this).find('#teacherId').val();
    console.log(teacherId);


    Swal.fire({
        title: 'Are you sure to delete this teacher?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: '/teacher/' + teacherId,
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


                        $('button[data-id="' + teacherId + '"]').closest('tr').remove();
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
