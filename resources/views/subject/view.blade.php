@extends('layouts.page')

@section('content')
<main id="main" class="main">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-12">
                <div class="pagetitle">
                    <h1>Subjects</h1>
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

        <div class="card p-2" id="subjectCard">
            <div class="card-title d-flex justify-content-end p-1 m-0">
                @if(Session::get('id') == 1)
                <div class="card-title d-flex justify-content-end p-0 m-0">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addSubjectModal">
                        Add Subject
                    </button>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered bg-info table-sm" id="users_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $subject)
                                <tr>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->code }}</td>
                                    <td>{{ $subject->status ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm delete-button">
                                            <i class="bi bi-trash"></i>
                                            <input type="hidden" id="subjectId" value="{{ $subject->id }}">
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addSubjectModal" tabindex="-1" aria-labelledby="addSubjectModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="addSubjectForm">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addSubjectModalLabel">Add Subject</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="subjectName" class="form-label">Subject Name</label>
                                <input type="text" class="form-control" id="subjectName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="subjectCode" class="form-label">Subject Code</label>
                                <input type="text" class="form-control" id="subjectCode" name="code">
                            </div>
                            <div class="mb-3">
                                <label for="subjectStatus" class="form-label">Status</label>
                                <select class="form-select" id="subjectStatus" name="status">
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
</main>
<script>
    $(document).ready(function() {
        $('#addSubjectForm').on('submit', function(e) {

            e.preventDefault();

            $.ajax({
                url: '/subject/store',
                type: "POST",
                data : $(this).serialize(),
                success : function(response) {
                    if(response.success) {
                        Swal.fire({
                            icon : 'success',
                            title: 'Subject Added Successfully',
                            text: response.message,
                            time: 2000,
                            showConfirmButton: true,
                            showProgressBar: true
                        });

                        $('#addSubjectForm')[0].reset();
                        $('#addSubjectModal').modal('hide');

                        $('#subjectCard').html(response.html);
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

        $('.delete-button').on('click', function(e) {
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var subjectId = $(this).find('#subjectId').val();
            console.log(subjectId);


            Swal.fire({
                title: 'Are you sure to delete this subject?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '/subject/' + subjectId,
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


                                $('button[data-id="' + subjectId + '"]').closest('tr').remove();
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
