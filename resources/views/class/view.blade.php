@extends('layouts.page')

@section('content')
<main id="main" class="main">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-12">
                <div class="pagetitle">
                    <h1>Classes</h1>
                </div><!-- End Page Title -->
            </div>
        </div>
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card p-2" id="classCard">
            <div class="card-title d-flex justify-content-end p-1 m-0">
                @if(Session::get('id') == 1)
                <div class="card-title d-flex justify-content-end p-0 m-0">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addclassModal">
                        Add class
                    </button>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered bg-info table-sm" id="users_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Label</th>
                                <th>Stream</th>
                                <th>Teacher</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($classes as $class)
                                <tr>
                                    <td>  <?php
                                        $gradeString = $class->stream;
                                        $position = strpos($gradeString, ' ');
                                        if ($position !== false) {
                                          echo substr($gradeString, $position + 1);
                                        } else {
                                          echo "N/A";
                                        }
                                      ?>
                                    </td>
                                    <td>{{ $class->label }}</td>
                                    <td>{{ $class->stream }}</td>
                                    <td>{{ $class->name }}</td>
                                    <td>{{ $class->status ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editclassModal{{ $class->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm delete-button">
                                            <i class="bi bi-trash"></i>
                                            <input type="hidden" id="classId" value="{{ $class->id }}">
                                        </button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="editclassModal{{ $class->id }}" tabindex="-1" aria-labelledby="editclassModalLabel{{ $class->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <form action="" method="POST" class="editclassForm">
                                          @csrf

                                          <div class="modal-header">
                                            <h5 class="modal-title" id="editclassModalLabel{{ $class->id }}">Edit class</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                          </div>

                                          <div class="modal-body">
                                            <div class="mb-3">
                                              <label class="form-label">Stream</label>
                                              <select class="form-select" name="stream" id="stream" required>
                                                <option value="">-- Select Stream --</option>
                                                @foreach($classes as $cls)
                                                    <option value="{{ $cls->str_id }}" {{ $cls->stream == $class->stream ? 'selected' : '' }}>
                                                        {{ $cls->stream }}
                                                    </option>
                                                @endforeach
                                              </select>
                                                                                      </div>
                                            <div class="mb-3">
                                              <label class="form-label">Class Label</label>
                                              <input type="text" class="form-control" name="label" value="{{ $class->label }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Class Teacher</label>
                                                <select class="form-select" name="teacher_id" id="teacher_id" required>
                                                    <option value="">-- Change Teacher --</option>
                                                    @if($class->tr_id && $class->name)
                                                        <option value="{{ $class->tr_id }}" selected>
                                                            {{ $class->name }} (Current)
                                                        </option>
                                                    @endif

                                                    @foreach($teachers as $teacher)
                                                        <option value="{{ $teacher->id }}">
                                                            {{ $teacher->user->name ?? 'Unnamed Teacher' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                              <label class="form-label">Status</label>
                                              <select name="status" class="form-control">
                                                <option value="1" {{ $class->status ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ !$class->status ? 'selected' : '' }}>Inactive</option>
                                              </select>
                                            </div>
                                            <input type="hidden" name="class_id" value="{{ $class->id }}" id="classId">
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
        <div class="modal fade" id="addclassModal" tabindex="-1" aria-labelledby="addclassModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="addclassForm">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addclassModalLabel">Add class</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="stream_id" class="form-label">Select Stream</label>
                                <select name="stream_id" id="stream_id" class="form-control" required>
                                    <option value="">-- Select Stream --</option>
                                    @foreach($streams as $stream)
                                        <option value="{{ $stream->id }}">{{ $stream->stream }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="className" class="form-label">Class Label</label>
                                 <select name="label" id="className" class="form-control" required>
                                    <option value="West">West</option>
                                    <option value="East">East</option>
                                    <option value="North">North</option>
                                    <option value="South">South</option>
                                    <option value="Central">Central</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="teacher_id" class="form-label">Class Teacher</label>
                                <select name="teacher_id" id="teacher_id" class="form-control" required>
                                    <option value="">-- Select Class Teacher --</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="classStatus" class="form-label">Status</label>
                                <select class="form-select" id="classStatus" name="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
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
        $('#addclassForm').on('submit', function(e) {

            e.preventDefault();

            $.ajax({
                url: '/class/store',
                type: "POST",
                data : $(this).serialize(),
                success : function(response) {
                    if(response.success) {
                        Swal.fire({
                            icon : 'success',
                            title: 'Class Added Successfully',
                            text: response.message,
                            time: 2000,
                            showConfirmButton: true,
                            showProgressBar: true
                        }).then(() => {
                            window.location.href = '/class/view';
                        });

                        $('#addclassForm')[0].reset();
                        $('#addclassModal').modal('hide');

                        // $('#classCard').html(response.html);
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

    $(document).ready(function() {
        $('.editclassForm').on('submit', function(e) {
        e.preventDefault();

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        let form = $(this);
        var classIdUpdate = $('#classId').val();
        console.log('class ID:', classIdUpdate);

        $.ajax({
            url: '/class/update/' + classIdUpdate,
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
                        window.location.href = '/class/view';
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
});


    $(document).ready(function() {

        $('.delete-button').on('click', function(e) {
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var classId = $(this).find('#classId').val();
            console.log(classId);


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
                        url: '/class/' + classId,
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
                                    window.location.href = '/class/view';
                                });


                                $('button[data-id="' + classId + '"]').closest('tr').remove();
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
