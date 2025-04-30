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
        
        <div class="card p-2">
            <div class="card-title d-flex justify-content-end p-1 m-0">
                @if(Session::get('id') == 1)
                    <div class="card-title d-flex justify-content-end p-0 m-0">
                        <a href="{{ route('subject.create') }}" class="btn btn-primary btn-sm">Add Subject</a>
                    </div>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered bg-info table-sm" id="users_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>Year(s)</th>
                                <th>Total Assignments</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm">Submit</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- <div class="modal fade" id="addClass" tabindex="-1" role="dialog" aria-labelledby="addClassLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Class</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add_class" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="row font-weight-bold">
                                <div class="col-md-6">
                                    <label for="input2">Class</label>
                                    <input type="text" class="form-control" id="course" placeholder="E.g., 1,2,3" name="class" required>
                                </div>
                                @foreach($grades as $grade)
                                <div class="col-md-6">
                                    <label for="input1">Gradesss</label>
                                    <select class="form-select" aria-label="Default select example" name="year" required>
                                        <option value="{{ $grade->id }}">{{ $grade->year }}</option>
                                    </select>
                                </div>
                                @endforeach
                                <div class="col-md-6">
                                    <label for="input1">Teacher</label>
                                    <select class="form-select" aria-label="Default select example" name="user" required>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>

                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                </div>
            </div>
            </div>

        </div> --}}
        <script>
            $(document).ready(function() {
                // @if(session('error'))
                //     $('#errorModal').modal('show');
                // @endif

                // @if(session('success'))
                //     $('#errorSuccess').modal('show');
                // @endif

                // @if(session('success_edit'))
                //     $('#Modaleditsuccess').modal('show');
                // @endif

                // @if(session('success_delete'))
                //     $('#Modaleditdelete').modal('show');
                // @endif

            $('#add_class').on('submit', function(e) {
                e.preventDefault();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                var formData = new FormData(this);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Add the CSRF token to the AJAX header
                    }
                });

                $.ajax({
                    url: "{{route('add_class')}}", // Your route for processing the form
                    type: 'POST',
                    data: formData,
                    processData: false, // Important for handling files
                    contentType: false, // Important for handling files

                    success: function(response) {
                        // Handle successful response
                        alert('User added successfully');
                        $('#addClass').modal('hide'); // Close the modal
                        $('#add_class')[0].reset(); // Clear the form
                    },
                    error: function(xhr, status, error) {
                        console.log('Error Status:', status);
                        console.log('Error:', error);
                        console.log('Response Text:', xhr.responseText); // Display error message
                        alert('An error occurred while adding the user.');
                    }
                });
            });
            });
        </script>
</main>

@endsection
