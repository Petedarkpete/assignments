@extends('layouts.page')

@section('content')
<main id="main" class="main">
    <div class="container">
        <div class="row text-center pt-3">
            <div class="col-lg-12">
                <div class="pagetitle">
                    <h1>Course Management</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <ul class="nav nav-tabs w-100" id="courseTab" role="tablist">
                    <li class="nav-item col-md-6 text-center">
                        <a class="nav-link active" id="modules-tab" data-toggle="tab" href="#modules" role="tab" aria-controls="modules" aria-selected="true">Modules</a>
                    </li>
                    <li class="nav-item col-md-6 text-center">
                        <a class="nav-link" id="submodules-tab" data-toggle="tab" href="#submodules" role="tab" aria-controls="submodules" aria-selected="false">Submodules</a>
                    </li>
                </ul>
            </div>
        </div>


        <div class="tab-content" id="courseTabContent">

            <div class="tab-pane fade show active" id="modules" role="tabpanel" aria-labelledby="modules-tab">
                <div class="card mt-3">
                    <div class="card-title d-flex justify-content-end p-2">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_module">Add Module</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive m-2">
                            <table class="table table-bordered bg-warning table-sm" id="modules_table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Submodule Title</th>
                                        <th>Module Code</th>
                                        <th>Status</th>
                                        <th>Created On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($modules as $module)
                                        <tr>
                                            <td>{{ $module->id }}</td>
                                            <td>{{ $module->name }}</td>
                                            <td>{{ $module->slug }}</td>
                                            <td>{{ $module->status }}</td>
                                            <td>{{ \Carbon\Carbon::parse($module->created_at)->format('Y-m-d') }}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-primary btn-sm">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                        </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submodules Tab -->
            <div class="tab-pane fade" id="submodules" role="tabpanel" aria-labelledby="submodules-tab">
                <div class="card mt-3">
                    <div class="card-title d-flex justify-content-end p-2">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#add_submodule">Add Submodule</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive m-2">
                            <table class="table table-bordered bg-warning table-sm" id="modules_table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Submodule Title</th>
                                        <th>Module Code</th>
                                        <th>Created On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($modules as $module)
                                        <tr>
                                            <td>{{ $module->id }}</td>
                                            <td>{{ $module->name }}</td>
                                            <td>{{ $module->slug }}</td>
                                            <td>{{ \Carbon\Carbon::parse($module->created_at)->format('Y-m-d') }}</td>
                                            <td><button class="btn btn-warning btn-sm">View</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal for Adding a Module -->
    <div class="modal fade" id="add_module" tabindex="-1" role="dialog" aria-labelledby="addModuleLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModuleLabel">Add Module</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="moduleForm">
                    @csrf
                    <div class="modal-body">
                        <!-- Module Name -->
                        <div class="form-group">
                            <label for="name">Module Name</label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="Enter module name">
                        </div>

                        <!-- Module Slug -->
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" required placeholder="Enter module slug">
                        </div>

                        <!-- Module Icon -->
                        <div class="form-group">
                            <label for="icon">Icon (Optional)</label>
                            <input type="text" class="form-control" id="icon" name="icon" placeholder="Enter icon (e.g., fa fa-book)">
                        </div>

                        <!-- Module URL -->
                        <div class="form-group">
                            <label for="url">URL (Optional)</label>
                            <input type="text" class="form-control" id="url" name="url" placeholder="Enter URL for module">
                        </div>

                        <!-- Module Order -->
                        <div class="form-group">
                            <label for="order">Order</label>
                            <input type="number" class="form-control" id="order" name="order" required placeholder="Enter order of module" min="1" step="1" value="1">
                        </div>

                        <!-- Module Status -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Module</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Adding a Submodule -->
    <div class="modal fade" id="add_submodule" tabindex="-1" role="dialog" aria-labelledby="addSubmoduleLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubmoduleLabel">Add Submodule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="submoduleForm">
                    @csrf
                    <div class="modal-body">
                        <!-- Module Selection -->
                        <div class="form-group">
                            <label for="module_id">Parent Module</label>
                            <select class="form-control" id="module_id" name="module_id" required>
                                <option value="">Select a Module</option>
                                @foreach($modules as $module)
                                    <option value="{{ $module->id }}">{{ $module->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submodule Name -->
                        <div class="form-group">
                            <label for="name">Submodule Name</label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="Enter submodule name">
                        </div>

                        <!-- Submodule URL -->
                        <div class="form-group">
                            <label for="url">URL (Optional)</label>
                            <input type="text" class="form-control" id="url" name="url" placeholder="Enter submodule URL">
                        </div>

                        <!-- Submodule URL -->
                        <div class="form-group">
                            <label for="url">Slug (Optional)</label>
                            <input type="text" class="form-control" id="slug" name="slug" required placeholder="Enter slug URL">
                        </div>

                        <!-- Order -->
                        <div class="form-group">
                            <label for="order">Order</label>
                            <input type="number" class="form-control" id="order" name="order" required placeholder="Enter order" min="1" step="1" value="1">
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save Submodule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function (){
        $('#moduleForm').submit(function (e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                type:'POST',
                url: '{{route("modules.store")}}',
                data: formData,
                success: function (response) {
                    $('#add_module').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Module Saved',
                        text: response.message || 'Module added successfully!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $('#moduleForm')[0].reset();
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    let message = 'Please fix the errors';

                    if (errors) {
                        message = Object.values(errors).map(err => err[0]).join('<br>');
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        html: message
                    });
                }
            })
        })
    })

    $(document).ready(function (){
        $('#submoduleForm').submit(function (e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                type:'POST',
                url: '{{route("sub_modules.store")}}',
                data: formData,
                success: function (response) {
                    $('#add_module').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Sub Module Saved',
                        text: response.message || 'Module added successfully!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $('#submoduleForm')[0].reset();
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    let message = 'Please fix the errors';

                    if (errors) {
                        message = Object.values(errors).map(err => err[0]).join('<br>');
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        html: message
                    });
                }
            })
        })
    })
</script>


</main>

@endsection

