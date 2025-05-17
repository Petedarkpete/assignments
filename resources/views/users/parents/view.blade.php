@extends('layouts.page')

@section('content')
<main id="main" class="main">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-12">
                <div class="pagetitle">
                    <h1>Parents</h1>
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
                <div class="card-title d-flex justify-content-between align-items-center p-2">

                    <a href="{{ url('parents/create') }}" class="btn btn-primary btn-sm">Add Parent</a>
                </div>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBulkparentModal">
                        Add Bulk parents
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
                            @foreach ($parents as $parent)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $parent->name }}</td>
                                <td> <?php
                                    $gradeString = $parent->stream;
                                    $position = strpos($gradeString, ' ');
                                    if ($position !== false) {
                                      echo substr($gradeString, $position + 1);
                                    } else {
                                      echo "N/A";
                                    }
                                  ?> {{ $parent->label }}</td>
                                <td>{{ $parent->tname }}</td>
                                <td>{{ $parent->index_number }}</td>
                                <td>{{ $parent->admission_number }}</td>
                                <td>{{ $parent->gender }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editparentModal{{ $parent->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-button">
                                        <i class="bi bi-trash"></i>
                                        <input type="hidden" id="parentId" value="{{ $parent->id }}">
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="editparentModal{{ $parent->id }}" tabindex="-1" aria-labelledby="editparentModalLabel{{ $parent->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                    <form action="editparentForm" method="POST" class="editparentForm">
                                      @csrf

                                      <div class="modal-header">
                                        <h5 class="modal-title" id="editparentModalLabel{{ $parent->id }}">Edit parent</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                      </div>

                                      <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <!-- First Name -->
                                                <div class="mb-3">
                                                    <label for="editFirstName" class="form-label">First Name</label>
                                                    <input type="text" class="form-control" id="editFirstName" value="{{ $parent->first_name }}" name="first_name" required>
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
                                                    <input type="number" class="form-control" id="editIndexNumber" value="{{ $parent->index_number }}" name="index_number" required>
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
                                                    <input type="text" class="form-control" id="editLastName" value="{{ $parent->last_name }}" name="last_name" required>
                                                </div>

                                                <!-- Teacher Name (readonly) -->
                                                <div class="mb-3">
                                                    <label for="editTeacherName" class="form-label">Teacher</label>
                                                    <input type="text" class="form-control" value="{{ $parent->tname }}" id="editTeacherName" readonly>
                                                    <input type="hidden" id="editTeacherId" name="teacher_id" value="{{ $parent->teacher_id }}">
                                                </div>

                                                <!-- Admission Number -->
                                                <div class="mb-3">
                                                    <label for="editAdmissionNo" class="form-label">Admission Number</label>
                                                    <input type="text" class="form-control" id="editAdmissionNo" value="{{ $parent->admission_number }}" name="admission_number" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Hidden input for parent ID (for updates) -->
                                        <input type="hidden" id="editparentId" name="parent_id">
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

    <div class="modal fade" id="addparentModal" tabindex="-1" aria-labelledby="addparentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="addparentForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addparentModalLabel">Add parent</h5>
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
                                    <input type="hidden" id="parentCode" name="teacher_id">
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

    <!-- Bulk Upload parents Modal -->
    <div class="modal fade" id="addBulkparentModal" tabindex="-1" aria-labelledby="addBulkparentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <form id="bulkparentForm" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBulkparentModalLabel">Add parents in Bulk</h5>
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
                    <input type="hidden" id="bulkparentCode" name="teacher_id">
                </div>


                <div class="mb-3">
                    <label for="excelFile" class="form-label">Upload Excel File</label>
                    <input type="file" name="excel_file" id="excelFile" class="form-control" accept=".xls,.xlsx" required>
                    <div class="form-text">Only .xlsx or .xls files allowed. <a href="{{ asset('template/parents_template.xlsx') }}">Download Template</a></div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Import parents</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
            </div>
        </form>
        </div>
    </div>


    <script>

        $(document).ready(function() {

            $('#class').on('change', function () {
                fetchTeacherByClass('#class', '#parentCode');
            });

            $('#bulkClass').on('change', function () {
                fetchTeacherByClass('#bulkClass', '#bulkparentCode');
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
                            $('#bulkparentCode').val(response.id); // not response.name
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
                fetchTeacherByClass('#bulkClass', '#bulkTeacherName', '#bulkparentCode');
            });

            $('.delete-button').on('click', function(e) {
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var parentId = $(this).find('#parentId').val();
                console.log(parentId);


                Swal.fire({
                    title: 'Are you sure to delete this parent?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: '/parent/' + parentId,
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


                                    $('button[data-id="' + parentId + '"]').closest('tr').remove();
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
                            $('#parentCode').val(response.id);
                        } else {
                            $('#TeacherName').val('No teacher found');
                            $('#parentCode').val('');
                        }
                    },
                    error: function () {
                        $('#TeacherName').val('Error fetching teacher');
                        $('#parentCode').val('');
                    }
                });
            });

            $('#bulkparentForm').on('submit', function(e) {
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
                    url: '/parents/import',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'parents Imported Successfully',
                                text: response.message || 'All parents have been added.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = '/parents/view';
                            });

                            $('#bulkparentForm')[0].reset();
                            $('#addBulkparentModal').modal('hide');
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




        $('#addparentForm').on('submit', function(e) {

            e.preventDefault();

            $.ajax({
                url: '/parents/store',
                type: "POST",
                data : $(this).serialize(),
                success : function(response) {
                    if(response.success) {
                        Swal.fire({
                            icon : 'success',
                            title: 'parent Added Successfully',
                            text: response.message,
                            time: 2000,
                            showConfirmButton: true,
                            showProgressBar: true
                        }).then(() => {
                            window.location.href = '/parents/view';
                        });

                        $('#addparentForm')[0].reset();
                        $('#addparentModal').modal('hide');

                        // $('#parentCard').html(response.html);
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

        $('.editparentForm').on('submit', function(e) {
            e.preventDefault();

            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

            let form = $(this);
            var parentIdUpdate = $('#parentId').val();
            console.log('parent ID:', parentIdUpdate);

            $.ajax({
                url: '/parents/update/' + parentIdUpdate,
                type: "POST",
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false,
                            timerProgressBar: true,
                        }).then(() => {
                            window.location.href = '/parents/view';
                        });

                        form.closest('.modal').modal('hide');
                    }
                },
                error: function(response) {
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
            var parentId = $(this).find('#parentId').val();
            console.log(parentId);


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
                        url: '/parents/' + parentId,
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
                                    window.location.href = '/parents/view';
                                });


                                $('button[data-id="' + parentId + '"]').closest('tr').remove();
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
