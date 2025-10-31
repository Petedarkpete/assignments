@extends('layouts.page')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/confirm_details.css') }}">
@endpush

@section('content')
<main id="main" class="main">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-12">
                <div class="pagetitle">
                    <h1>Students {{ Session::get('id') }}</h1>
                </div>
            </div>
        </div>
        <div class="card mt-1">
            {{-- @if(session('success'))
                <div class="alert alert-success">
                    <p style="font-size: 0.85rem;">{{ session('success') }}</p>
                </div>
            @endif --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card-title d-flex align-items-center p-2">
                @if(Session::get('id') == 1)
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                        Add Student
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBulkStudentModal">
                        Add Bulk Students
                    </button>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive m-2">
                    <table class="table table-bordered enhanced-table bg-warning table-sm" id="modules_table" width="100%" cellspacing="0">
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
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#viewStudentModal{{ $student->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
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
                                    <form id="editstudentForm{{ $student->id }}" class="editstudentForm">
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
                                                        <option value="Male" {{ old('gender', $user->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
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
                                                    <input type="hidden" id="editTeacherId" name="teacher_id" value="{{ $student->teacher_id }}">
                                                </div>

                                                <!-- Admission Number -->
                                                <div class="mb-3">
                                                    <label for="editAdmissionNo" class="form-label">Admission Number</label>
                                                    <input type="text" class="form-control" id="editAdmissionNo" value="{{ $student->admission_number }}" name="admission_number" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Hidden input for student ID (for updates) -->
                                        <input type="hidden" id="editStudentId" name="student_id" value="{{ $student->id }}">
                                        </div>

                                      <div class="modal-footer">
                                        <button type="submit" id="updateStudentBtn{{ $student->id }}" class="btn btn-success">Update</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                            </div>

                            <div class="modal fade" id="viewStudentModal{{ $student->id }}" tabindex="-1" aria-labelledby="viewStudentModalLabel{{ $student->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                      @csrf

                                      <div class="modal-header">
                                        <h5 class="modal-title" id="viewStudentModalLabel{{ $student->id }}">View student</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                      </div>

                                      <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <!-- First Name -->
                                                <div class="mb-3">
                                                    <label for="editFirstName" class="form-label">First Name</label>
                                                    <input type="text" class="form-control" id="editFirstName" value="{{ $student->first_name }}" name="first_name" readonly>
                                                </div>

                                                <!-- Class -->
                                                <div class="mb-3">
                                                    <label for="editClass" class="form-label">Class</label>
                                                    <select name="class_id" id="editClass" class="form-control" readonly>
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
                                                    <input type="number" class="form-control" id="editIndexNumber" value="{{ $student->index_number }}" name="index_number" readonly>
                                                </div>

                                                <!-- Gender -->
                                                <div class="mb-3">
                                                    <label for="editGender" class="form-label">Gender</label>
                                                    <select name="gender" id="editGender" class="form-control" readonly>
                                                        <option value="Male" {{ old('gender', $user->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                                        <option value="Female" {{ old('gender', $user->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <!-- Last Name -->
                                                <div class="mb-3">
                                                    <label for="editLastName" class="form-label">Last Name</label>
                                                    <input type="text" class="form-control" id="editLastName" value="{{ $student->last_name }}" name="last_name" readonly>
                                                </div>

                                                <!-- Teacher Name (readonly) -->
                                                <div class="mb-3">
                                                    <label for="editTeacherName" class="form-label">Teacher</label>
                                                    <input type="text" class="form-control" value="{{ $student->tname }}" id="editTeacherName" readonly>
                                                    <input type="hidden" id="editTeacherId" name="teacher_id" value="{{ $student->teacher_id }}">
                                                </div>

                                                <!-- Admission Number -->
                                                <div class="mb-3">
                                                    <label for="editAdmissionNo" class="form-label">Admission Number</label>
                                                    <input type="text" class="form-control" id="editAdmissionNo" value="{{ $student->admission_number }}" name="admission_number" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Hidden input for student ID (for updates) -->
                                        <input type="hidden" id="editStudentId" name="student_id" >
                                    </div>
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
            <form id="addstudentForm" enctype="multipart/form-data">
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

    <!-- Bulk Upload Students Modal -->
    <div class="modal fade" id="addBulkStudentModal" tabindex="-1" aria-labelledby="addBulkStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <form id="bulkStudentForm" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBulkStudentModalLabel">Add Students in Bulk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="class" class="form-label">Class</label>
                    <select name="class_id" id="bulkClass" class="form-control" required>
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
                    <label for="TeacherName" class="form-label">Teacher</label>
                    <input type="text" class="form-control" id="bulkTeacherName" readonly>
                    <input type="hidden" id="bulkStudentCode" name="teacher_id">
                </div>


                <div class="mb-3">
                    <label for="excelFile" class="form-label">Upload Excel File</label>
                    <input type="file" name="excel_file" id="excelFile" class="form-control" accept=".xls,.xlsx" required>
                    <div class="form-text">Only .xlsx or .xls files allowed. <a href="{{ asset('templates/students_template.xlsx') }}">Download Template</a></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Import Students</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
            </div>
        </form>
        </div>
    </div>


    <script>

        $(document).ready(function() {

            $('#class').on('change', function () {
                fetchTeacherByClass('#class', '#StudentCode');
            });

            $('#bulkClass').on('change', function () {
                fetchTeacherByClass('#bulkClass', '#bulkStudentCode');
            });

            function fetchTeacherByClass(classSelectorId, teacherNameFieldId, teacherIdFieldId) {
                const classId = $(classSelectorId).val();

                $.ajax({
                    url: '/findTeacher/' + classId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log('Teacher Response:', response);
                        if (response.name && response.id) {
                            $('#bulkStudentCode').val(response.id); // not response.name
                            $('#bulkTeacherName').val(response.name);

                        } else {
                            $(teacherNameFieldId).val('No teacher found');
                            $(teacherIdFieldId).val('');
                        }
                    },
                    error: function () {
                        $(teacherNameFieldId).val('Error fetching teacher');
                        $(teacherIdFieldId).val('');
                    }
                });
            }

            $('#bulkClass').on('change', function () {
                fetchTeacherByClass('#bulkClass', '#bulkTeacherName', '#bulkStudentCode');
            });

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

            $('#bulkStudentForm').on('submit', function(e) {
                e.preventDefault();

                const form = $(this)[0];
                const formData = new FormData(form);

                // Logging values for debugging
                console.log('Teacher ID:', formData.get('teacher_id'));
                console.log('Class ID:', formData.get('class_id'));

                const excelFile = formData.get('excel_file');
                if (excelFile) {
                    console.log('Excel File Name:', excelFile.name);
                    console.log('Excel File Type:', excelFile.type);
                    console.log('Excel File Size:', excelFile.size + ' bytes');
                } else {
                    console.log('No Excel file found in formData.');
                }

                $.ajax({
                    url: '/students/import',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Students Imported Successfully',
                                text: response.message || 'All students have been added.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = '/students/view';
                            });

                            $('#bulkStudentForm')[0].reset();
                            $('#addBulkStudentModal').modal('hide');
                        }
                    },
                    error: function(response) {
                        let message = 'Something went wrong.';

                        if (response.responseJSON) {
                            const json = response.responseJSON;

                            // If there's a general error
                            if (json.error) {
                                message = json.error;
                            }

                            // If there are validation failures (from Laravel Excel)
                            else if (json.failures && Array.isArray(json.failures)) {
                                message = 'Some rows failed validation:\n\n';
                                json.failures.forEach(failure => {
                                    message += `Row ${failure.row}: ${failure.attribute} - ${failure.errors.join(', ')}\n`;
                                });
                            }

                            // If there are row-level exceptions (e.g., DB errors)
                            else if (json.errors && Array.isArray(json.errors)) {
                                message = 'Some rows caused errors:\n\n';
                                json.errors.forEach(error => {
                                    message += `Row: ${JSON.stringify(error.row)}\nError: ${error.error}\n\n`;
                                });
                            }
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Import Error',
                            html: `<pre style="text-align:left;white-space:pre-wrap;">${message}</pre>`
                        });
                    }

                });
            });




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

        $(document).on('submit', '.editstudentForm', function(e) {
            e.preventDefault();
            console.log('Form submission captured!');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //create an object from the event clicked
            let form = $('#editstudentForm');
            var formData = form.serialize();
            let studentIdUpdate = $('#editStudentId').val();
            console.log('student ID:', studentIdUpdate);

            // 1️⃣ Show "loading" alert
            Swal.fire({
                title: 'Updating the Student',
                html: 'Please wait...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '/students/update/' + studentIdUpdate,
                type: "POST",
                data: formData,
                success: function(response) {
                    // 2️⃣ Close the loading alert first
                    Swal.close();

                    // 3️⃣ Then show the success alert after a short delay
                    setTimeout(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false,
                            timerProgressBar: true,
                        });
                    }, 200);

                    // 4️⃣ Hide modal afterward
                    form.closest('.modal').modal('hide');
                },
                error: function(response) {
                    Swal.close(); // Close loading alert first
                    Swal.fire({
                        icon: 'error',
                        title: 'Update Failed',
                        text: response.responseJSON?.message || 'An error occurred during update.'
                    });
                }
            });
        });


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
                title: 'Are you sure to delete this class?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '/students/' + studentId,
                        type: 'DELETE',
                        success: function(response) {
                            if(response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = '/students/view';
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
