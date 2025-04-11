@extends('layouts.page')

@section('content')
<main id="main" class="main">
    <div class="container">
        <div class="row text-center pt-3">
            <div class="col-lg-12">
                <div class="pagetitle">
                    <h1>Courses</h1>
                </div><!-- End Page Title -->
            </div>
        </div>

        <table class="table table-bordered bg-info table-sm" id="users_table" width="100%" cellspacing="0">
            <thead>
        <tr>
            <th>Name</th>
            <th>Display Name</th>
            <th>Description</th>
            <th>Permissions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($roles as $role)
        <tr>
            <td>{{ $role->name }}</td>
            <td>{{ $role->display_name }}</td>
            <td>{{ $role->description }}</td>
            <td>
                <ul>
                    @foreach($role->permissions as $permission)
                    <li>{{ $permission->display_name }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection
