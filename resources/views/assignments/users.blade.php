@extends('layouts.page')

@section('content')
<main id="main" class="main">
    <div class="container">
        <div class="row text-center pt-3">
            <div class="col-lg-12">
            <div class="pagetitle">
                <h1>Users</h1>
            </div><!-- End Page Title -->
            </div>
        </div>
    </div>
    
    <div class="container">
        @if(session('successful'))
            <div class="alert alert-success">
                {{ session('successful') }}
            </div>
        @endif
        <div class="card">
        <div class="card-title d-flex justify-content-end">
            <div class="col-12">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_user_modal">Add Single User</button>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">Add Bulk Users</button>
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
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id}}</td>
                                <td>{{ $user->name}}</td>
                                <td>{{ $user->admission}}</td>
                                <td>{{ $user->email}}</td>
                                <td>{{ $user->year}}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit_user_modal{{ $user->id}}">
                                        Edit
                                    </button>
                                    <div class="modal fade" id="edit_user_modal{{ $user->id}}" tabindex="-1" role="dialog" aria-labelledby="edit_user_modalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit User</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="add_user" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="input1">Name</label>
                                                                    <input type="text" class="form-control" id="name" placeholder="">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="input2">Admission No</label>
                                                                    <input type="text" class="form-control" id="admission" placeholder="CCS/00XXX/XXX">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="input1">Email</label>
                                                                    <input type="email" class="form-control" id="input1" placeholder="example@gmail.com">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="input2">Year</label>
                                                                    <input type="text" class="form-control" id="input2" placeholder="Your Year of Study">
                                                                    <input type="hidden" name="role" value="3">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" id="submit-user">Submit</button>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Bulk Users</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('import') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="">Select Excel File</label>
                <input type="file" name="file" class="form-control">
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

<div class="modal fade" id="add_user_modal" tabindex="-1" role="dialog" aria-labelledby="add_user_modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Single Users</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('add_user') }}" method="post" enctype="multipart/form-data">
        <div class="modal-body">
            @csrf
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label for="input1">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="All Names">
                    </div>
                    <div class="col-md-6">
                        <label for="input2">Admission No</label>
                        <input type="text" class="form-control" name="admission" placeholder="CCS/00XXX/XXX">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="input1">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="example@gmail.com">
                    </div>
                    <div class="col-md-6">
                        <label for="input2">Year</label>
                        <input type="text" class="form-control" name="year" placeholder="Your Year of Study">
                        <input type="hidden" name="role" value="3">
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

<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Import Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ session('error') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="errorSuccess" tabindex="-1" role="dialog" aria-labelledby="errorSuccessLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorSuccessLabel">Import Successfull</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ session('error') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        @if(session('error'))
            $('#errorModal').modal('show');
        @endif
    });

    $(document).ready(function() {
        @if(session('success'))
            $('#errorSuccess').modal('show');
        @endif
    });

    // $(document).ready(function() {
    //     $('#submit-user').click(function(e){
    //         e.preventDefault();
            
    //         var formData=new FormData($('add_user')[0])
    //         $.ajax({
    //             url: "{{ route('add_user') }}",
    //             method: "POST",
    //             data: {
    //                 "_token": "{{ csrf_token() }}",
    //             },
    //             success: function(response) {
    //                 console.log(response);
    //             }
    //             error: function(response) {
    //                 console.log(response);
    //             }
    //             // complete: function(response) {
    //             //     console.log(response);
    //             // }

    //         });
    //     });
    // });
</script>
</main>

@endsection