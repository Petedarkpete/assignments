@extends('layouts.page')

@section('content')
<main id="main" class="main">
    <div class="container">
        <div class="row text-center pt-3">
            <div class="col-lg-12">
                <div class="pagetitle">
                    <h1>Years</h1>
                </div><!-- End Page Title -->
            </div>
        </div>
        <div class="card">
            <div class="card-title d-flex justify-content-end">
            </div>
            <div class="card-body">
                @if(Session::get('role') == 2)
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addYear">Add Year</button>
                @endif
                <div class="table-responsive m-2">
                    <table class="table table-bordered bg-info table-sm" id="users_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Year</th>
                                <th>Assignments Ratio</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
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
        <div class="modal fade" id="addYear" tabindex="-1" role="dialog" aria-labelledby="add_yearLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Year</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add_year" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="row font-weight-bold">
                                <div class="col-md-6">
                                    <label for="input1">Grade</label>
                                    <select class="form-select" aria-label="Default select example" name="year" required>
                                        <option value="1"> 1</option>
                                        <option value="2"> 2</option>
                                        <option value="3"> 3</option>
                                        <option value="4"> 4</option>
                                    </select>
                                <!-- </div>
                                <div class="col-md-6">
                                    <label for="input2">Course</label>
                                    <input type="text" class="form-control" id="course" placeholder="Course Name" name="course" required>
                                </div> -->
                            </div>
                            
                        </div>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                    </div>
                </form>
                </div>
            </div>
            </div>

        </div>
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
           
            $('#add_year').on('submit', function(e) {
                e.preventDefault(); 
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                var formData = new FormData(this);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Add the CSRF token to the AJAX header
                    }
                }); 

                $.ajax({
                    url: "{{route('add_year')}}", // Your route for processing the form
                    type: 'POST',
                    data: formData,
                    processData: false, // Important for handling files
                    contentType: false, // Important for handling files
                    
                    success: function(response) {
                        // Handle successful response
                        alert('User added successfully');
                        $('#addYear').modal('hide'); // Close the modal
                        $('#add_year')[0].reset(); // Clear the form
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