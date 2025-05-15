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
            <div class="card-title d-flex align-items-center p-2">
                @if(Session::get('id') == 1)
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                        Add Student
                    </button>
                @endif
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
                            {{-- <tr>
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
                            </tr> --}}
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="addStudentForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="StudentName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="StudentName" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="StudentCode" class="form-label">Class</label>
                                    <select name="class" id="class" class="form-control" required>
                                        <option value="">-- Select Class --</option>
                                        @foreach($classes as $class)
                                            @php
                                                preg_match('/\d+/', $class->stream, $matches);
                                                $grade_number = $matches[0] ?? '';
                                            @endphp
                                            <option value="{{ $class->id }}">{{ $grade_number }} {{ $class->label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="StudentStatus" class="form-label">Status</label>
                                    <select class="form-select" id="StudentStatus" name="status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="StudentName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="StudentName" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="StudentCode" class="form-label">Teacher</label>
                                    <input type="text" class="form-control" id="StudentCode" name="code" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="StudentStatus" class="form-label">Status</label>
                                    <select class="form-select" id="StudentStatus" name="status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-sm">Save</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
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

        $('#class').on('change', function (){
            const classId = $(this).val();
            const streamLabel = $(this).find('option:selected').text();

            console.log('Selected Class ID:', classId);
            console.log('Displayed Stream Label:', streamLabel);

            $.ajax({
                url : '/findTeacher/' + classId,
                type : 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.name) {
                        $('#StudentCode').val(response.name);
                    } else {
                        $('#StudentCode').val('No teacher found');
                    }
                },
                error: function () {
                    $('#StudentCode').val('Error fetching teacher');
                }

                })
            })
        });

    </script>
@endsection
