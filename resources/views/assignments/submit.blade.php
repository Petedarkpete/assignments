@extends('layouts.page')

@section('content')
<main id="main" class="main">
    <div class="container">
        <div class="row text-center pt-3">
            <div class="col-lg-12">
                <div class="pagetitle">
                    <h1>My Assignments</h1>
                </div><!-- End Page Title -->
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive m-2">
                    <table class="table table-bordered bg-info table-sm" id="users_table" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Course</th>
                                <th>Year</th>
                                <th>Title</th>
                                <th>Details</th>
                                <th>Uploaded Date</th>
                                <th>Deadline</th>
                                <th>Download</th>
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
</main>

@endsection