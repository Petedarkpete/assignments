@extends('layouts.page')

@section('content')
<main id="main" class="main">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-12">
                <div class="pagetitle">
                    <h1>Streams</h1>
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

        <div class="card p-2" id="streamCard">
            <div class="card-title d-flex justify-content-end p-1 m-0">
                @if(Session::get('id') == 1)
                <div class="card-title d-flex justify-content-end p-0 m-0">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addstreamModal">
                        Add Stream
                    </button>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered bg-info table-sm" id="users_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Stream</th>
                                <th>Status</th>
                                <th>Stream Rep</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($streams as $stream)
                                <tr>
                                    <td>{{ $stream->id }}</td>
                                    <td>{{ $stream->stream }}</td>
                                    <td>{{ $stream->status ? 'Active' : 'Inactive' }}</td>
                                    <td>{{ $stream->teacher->user->first_name}} {{ $stream->teacher->user->last_name}}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editstreamModal{{ $stream->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm delete-button">
                                            <i class="bi bi-trash"></i>
                                            <input type="hidden" id="streamId" value="{{ $stream->id }}">
                                        </button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="editstreamModal{{ $stream->id }}" tabindex="-1" aria-labelledby="editstreamModalLabel{{ $stream->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <form action="" method="POST" class="editstreamForm">
                                          @csrf

                                          <div class="modal-header">
                                            <h5 class="modal-title" id="editstreamModalLabel{{ $stream->id }}">Edit stream</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                          </div>

                                          <div class="modal-body">
                                            <div class="mb-3">
                                              <label class="form-label">Stream Name</label>
                                              <input type="text" class="form-control" name="stream" value="{{ $stream->stream }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Stream Rep</label>
                                                <select class="form-select" name="teacher_id" required>
                                                    <option value="">-- Select Stream Rep --</option>
                                                    @foreach($teachers as $teacher)
                                                        <option value="{{ $teacher->id }}" {{ $stream->teacher_id == $teacher->id ? 'selected' : '' }}>
                                                            {{ $teacher->user->first_name }} {{ $teacher->user->last_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                              <label class="form-label">Status</label>
                                              <select name="status" class="form-control">
                                                <option value="1" {{ $stream->status ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ !$stream->status ? 'selected' : '' }}>Inactive</option>
                                              </select>
                                            </div>
                                            <input type="hidden" id="streamIdUpdate" value="{{ $stream->id }}">
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
        <div class="modal fade" id="addstreamModal" tabindex="-1" aria-labelledby="addstreamModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="addstreamForm">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addstreamModalLabel">Add Stream</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="streamName" class="form-label">Stream Name</label>
                                <input type="text" class="form-control" id="streamName" name="stream" required>
                            </div>
                            <div class="mb-3">
                                <label for="teacher_id" class="form-label">Stream Rep</label>
                                <select class="form-select" id="teacher_id" name="teacher_id">
                                    <option value="">-- Select Stream Rep --</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">
                                            {{ $teacher->user->first_name }} {{ $teacher->user->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="streamStatus" class="form-label">Status</label>
                                <select class="form-select" id="streamStatus" name="status">
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
        $('#addstreamForm').on('submit', function(e) {

            e.preventDefault();

            $.ajax({
                url: '/streams/store',
                type: "POST",
                data : $(this).serialize(),
                success : function(response) {
                    if(response.success) {
                        Swal.fire({
                            icon : 'success',
                            title: 'Success',
                            text: response.message,
                            time: 2000,
                            showConfirmButton: true,
                            showProgressBar: true
                        }).then(() => {
                            window.location.href = '/streams/view';
                        });

                        $('#addstreamForm')[0].reset();
                        $('#addstreamModal').modal('hide');

                        // $('#streamCard').html(response.html);
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
        $('.editstreamForm').on('submit', function(e) {
        e.preventDefault();

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        let form = $(this);
        var streamIdUpdate = $('#streamIdUpdate').val();
        console.log('stream ID:', streamIdUpdate);

        $.ajax({
            url: '/streams/update/' + streamIdUpdate,
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
                        window.location.href = '/streams/view';
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
            var streamId = $(this).find('#streamId').val();
            console.log(streamId);


            Swal.fire({
                title: 'Are you sure to delete this stream?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '/streams/' + streamId,
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
                                    window.location.href = '/streams/view';
                                });


                                $('button[data-id="' + streamId + '"]').closest('tr').remove();
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
