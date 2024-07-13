@extends('layouts.page')

@section('content')
<main id="main" class="main">
    <div class="container">
    <div class="row text-center pt-3">
            <div class="col-lg-12">
            <div class="pagetitle">
                <h1>Upload Assignments</h1>
            </div><!-- End Page Title -->
            </div>
        </div>

        <div class="card">
            <div class="card-title d-flex justify-content-end">
                <div class="col-12">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_assignment">Add Assignment</button>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered bg-info table-sm" id="users_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Adm No</th>
                                <th>Email</th>
                                <th>Year</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>tt</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm">Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_assignment" tabindex="-1" role="dialog" aria-labelledby="add_assignmentLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Assignment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('upload_assignment')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <div class="row font-weight-bold">
                    <div class="col-md-6">
                        <label for="input1">Year</label>
                        <select class="form-select" aria-label="Default select example" name="year" required>
                            <option value="1">Year 1</option>
                            <option value="2">Year 2</option>
                            <option value="3">Year 3</option>
                            <option value="4">Year 4</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="input2">Course</label>
                        <input type="text" class="form-control" id="input2" placeholder="Course Name" name="course" required>
                    </div>
                    <div class="col-md-6">
                        <label for="input1">Assignment Title</label>
                        <input type="text" class="form-control" id="input1" placeholder="" name="assignment_title" required>
                    </div>
                    <div class="col-md-6">
                        <label for="input2">Other Details</label>
                        <input type="text" class="form-control" id="input2" placeholder="Optional" name="other_details">
                    </div>
                    <div class="col-md-6">
                        <label for="input2">Deadline</label>
                        <input type="date" class="form-control" id="input2" placeholder="" name="deadline" required>
                    </div>
                    <div class="col-md-6">
                        <label for="input2">Upload</label>
                        <input type="file" class="form-control" id="input2" placeholder="" name="files[]">
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
</main>

@endsection