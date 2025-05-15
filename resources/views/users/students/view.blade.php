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
                                <th>Class</th>
                                <th>Teacher</th>
                                <th>Index No</th>
                                <th>Admission No</th>
                                <th>Gender</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->name }}</td>
                                <td> <?php
                                    $gradeString = $student->stream;
                                    $position = strpos($gradeString, ' ');
                                    if ($position !== false) {
                                      echo substr($gradeString, $position + 1);
                                    } else {
                                      echo "N/A";
                                    }
                                  ?> {{ $student->label }}</td>
                                <td>{{ $student->tname }}</td>
                                <td>{{ $student->index_number }}</td>
                                <td>{{ $student->admission_number }}</td>
                                <td>{{ $student->gender }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editstudentModal{{ $student->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-button">
                                        <i class="bi bi-trash"></i>
                                        <input type="hidden" id="studentId" value="{{ $student->id }}">
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="editstudentModal{{ $student->id }}" tabindex="-1" aria-labelledby="editstudentModalLabel{{ $student->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                    <form action="" method="POST" class="editstudentForm">
                                      @csrf

                                      <div class="modal-header">
                                        <h5 class="modal-title" id="editstudentModalLabel{{ $student->id }}">Edit student</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                      </div>

                                      <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <!-- First Name -->
                                                <div class="mb-3">
                                                    <label for="editFirstName" class="form-label">First Name</label>
                                                    <input type="text" class="form-control" id="editFirstName" value="{{ $student->first_name }}" name="first_name" required>
                                                </div>

                                                <!-- Class -->
                                                <div class="mb-3">
                                                    <label for="editClass" class="form-label">Class</label>
                                                    <select name="class_id" id="editClass" class="form-control" required>
                                                        <option value="">-- Select Class --</option>
                                                        @foreach($classes as $cls)
                                                            <option value="{{ $cls->id }}" {{ $cls->stream == $cls->stream ? 'selected' : '' }}>
                                                                {{ $cls->stream }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Index Number -->
                                                <div class="mb-3">
                                                    <label for="editIndexNumber" class="form-label">Index Number</label>
                                                    <input type="number" class="form-control" id="editIndexNumber" value="{{ $student->index_number }}" name="index_number" required>
                                                </div>

                                                <!-- Gender -->
                                                <div class="mb-3">
                                                    <label for="editGender" class="form-label">Gender</label>
                                                    <select name="gender" id="editGender" class="form-control" required>
                                                        <option value="">Select Gender</option>
                                                        <option value="Male" {{ old('gender', $user->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                                        <option value="Female" {{ old('gender', $user->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <!-- Last Name -->
                                                <div class="mb-3">
                                                    <label for="editLastName" class="form-label">Last Name</label>
                                                    <input type="text" class="form-control" id="editLastName" value="{{ $student->last_name }}" name="last_name" required>
                                                </div>

                                                <!-- Teacher Name (readonly) -->
                                                <div class="mb-3">
                                                    <label for="editTeacherName" class="form-label">Teacher</label>
                                                    <input type="text" class="form-control" value="{{ $student->tname }}" id="editTeacherName" readonly>
                                                    <input type="hidden" id="editTeacherId" name="teacher_id">
                                                </div>

                                                <!-- Admission Number -->
                                                <div class="mb-3">
                                                    <label for="editAdmissionNo" class="form-label">Admission Number</label>
                                                    <input type="text" class="form-control" id="editAdmissionNo" value="{{ $student->admission_number }}" name="admission_number" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Hidden input for student ID (for updates) -->
                                        <input type="hidden" id="editStudentId" name="student_id">
                                    </div>

                                      <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Update</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="addstudentForm">
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
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name="first_name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="class" class="form-label">Class</label>
                                    <select name="class_id" id="class" class="form-control" required>
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
                                    <label for="indexNo" class="form-label">Index Number</label>
                                    <input type="number" class="form-control" id="index_number" name="index_number" required>
                                </div>

                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="" disabled selected>Select gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="last_name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="TeacherName" class="form-label">Teacher</label>
                                    <input type="text" class="form-control" id="TeacherName" readonly>
                                    <input type="hidden" id="StudentCode" name="teacher_id">
                                </div>

                                <div class="mb-3">
                                    <label for="admNo" class="form-label">Admission Number</label>
                                    <input type="text" class="form-control" id="admNo" name="admission_number" required>
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

        $('#class').on('change', function () {
            const classId = $(this).val();

            if (!classId) return;

            $.ajax({
                url: '/findTeacher/' + classId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.name && response.id) {
                        $('#TeacherName').val(response.name);
                        $('#StudentCode').val(response.id);
                    } else {
                        $('#TeacherName').val('No teacher found');
                        $('#StudentCode').val('');
                    }
                },
                error: function () {
                    $('#TeacherName').val('Error fetching teacher');
                    $('#StudentCode').val('');
                }
            });
        });

        });

        $(document).ready(function() {
        $('#addstudentForm').on('submit', function(e) {

            e.preventDefault();

            $.ajax({
                url: '/students/store',
                type: "POST",
                data : $(this).serialize(),
                success : function(response) {
                    if(response.success) {
                        Swal.fire({
                            icon : 'success',
                            title: 'student Added Successfully',
                            text: response.message,
                            time: 2000,
                            showConfirmButton: true,
                            showProgressBar: true
                        }).then(() => {
                            window.location.href = '/students/view';
                        });

                        $('#addstudentForm')[0].reset();
                        $('#addstudentModal').modal('hide');

                        // $('#studentCard').html(response.html);
                    }
                },
                error : function(response) {
                    if(response.responseJSON && response.responseJSON.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.responseJSON.error
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Unexpected Error',
                            text: 'Something went wrong.'
                        });
                    }
                }
            });
        });

    });

    </script>
@endsection
