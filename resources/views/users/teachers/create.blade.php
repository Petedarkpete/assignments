@extends('layouts.page')

@section('content')
<main id="main" class="main">

    <div class="container">
        <h3>Add Teacher</h3>

        <div class="card">
            <div class="card-body">
                <!-- Progress Bar -->
                <div class="progress mb-4" style="height: 25px;">
                <div id="form-progress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%;">
                    Step 1 of 2: Personal Info
                </div>
                </div>

                <form id="teacher-form" method="POST"  enctype="multipart/form-data">
                @csrf

                <!-- Step 1: Personal Information -->
                <div id="step-1">
                    <h5 class="mb-3">Personal Information</h5>

                    <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    </div>

                    <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone_number" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-control">
                        <option value="">Select Gender</option>
                        <option>Male</option>
                        <option>Female</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control">
                    </div>
                    </div>

                    <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Profile Photo</label>
                        <input type="file" name="profile_photo" class="form-control">
                    </div>
                    </div>

                    <div class="d-flex justify-content-end">
                    <button type="button" id="next-btn" class="btn btn-primary">Next</button>
                    </div>
                </div>

                <!-- Step 2: Professional Information -->
                <div id="step-2" style="display: none;">
                    <h5 class="mb-3">Professional Information</h5>

                    <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Qualification</label>
                        <input type="text" name="qualification" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Specialization</label>
                        <input type="text" name="specialization" class="form-control">
                    </div>
                    </div>

                    <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label">Subjects</label>
                        <input type="text" name="subjects" class="form-control" placeholder="e.g., Math, Science">
                    </div>
                    </div>

                    <input type="hidden" name="role" value="teacher">

                    <div class="d-flex justify-content-between">
                    <button type="button" id="prev-btn" class="btn btn-secondary">Previous</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>

                </form>
            </div>
        </div>

    </div>

    <script>
        const nextBtn = document.getElementById('next-btn');
        const prevBtn = document.getElementById('prev-btn');
        const step1 = document.getElementById('step-1');
        const step2 = document.getElementById('step-2');
        const progressBar = document.getElementById('form-progress');

        nextBtn.addEventListener('click', function() {
          step1.style.display = 'none';
          step2.style.display = 'block';
          progressBar.style.width = '100%';
          progressBar.innerText = 'Step 2 of 2: Professional Info';
        });

        prevBtn.addEventListener('click', function() {
          step1.style.display = 'block';
          step2.style.display = 'none';
          progressBar.style.width = '50%';
          progressBar.innerText = 'Step 1 of 2: Personal Info';
        });
      </script>

@endsection
