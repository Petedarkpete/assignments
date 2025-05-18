@extends('layouts.page')

@section('content')
<main id="main" class="main">

    <div class="container">
        <h3>Add parent</h3>

        <div class="card">
            <div class="card-body">
                <!-- Progress Bar -->
                <div class="progress mb-4" style="height: 25px;">
                    <div id="form-progress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 50%;">
                        Step 1 of 2: Personal Info
                    </div>
                </div>

                <form action="/parents/store" method="POST"  enctype="multipart/form-data">
                    @csrf

                    <!-- Step 1: Personal Information -->
                    <div id="step-1">
                        <h5 class="mb-3">Personal Information</h5>

                        <div class="row mb-2">
                            <div class=" col-md-4 mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                            <div class=" col-md-4 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>

                            <div class=" col-md-4 mb-3">
                                <label class="form-label">Other Names</label>
                                <input type="text" name="other_names" class="form-control" required>
                            </div>

                            <div class=" col-md-4 mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" required >
                            </div>
                            <div class=" col-md-4 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="number" name="phone" class="form-control" required>
                            </div>
                            <div class=" col-md-4 mb-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-control" required>
                                    <option value="">Select Gender</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                            <div class=" col-md-4 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" required>
                            </div>
                            <div class=" col-md-4 mb-3">
                                <label class="form-label">Profile Photo</label>
                                <input type="file" name="profile_photo" class="form-control">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                        <button type="button" id="next-btn" class="btn btn-primary">Next</button>
                        </div>
                    </div>

                    <!-- Step 2: Legal & Student Information -->
                    <div id="step-2" style="display: none;">
                        <h5 class="mb-3">Legal & Student Information</h5>

                        <div class="row mb-3">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Relationship</label>
                                <select name="relationship" class="form-control" required>
                                    <option value="">-- Select Relationship --</option>
                                    <option value="Mother">Mother</option>
                                    <option value="Father">Father</option>
                                    <option value="Guardian">Guardian</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Student Admission No</label>
                                <input type="text" id="admission_no" name="admission_no" class="form-control">
                            </div>
                            <div id="student_info" class="mt-3"></div>
                        </div>
                        <div class="row" id="studentInfo">
                            <div class="col-md-4 mb-3" id="student_name_group">
                                <label class="form-label">Name</label>
                                <input type="text" id="student_name" class="form-control" readonly>
                            </div>

                            <div class="col-md-4 mb-3" id="student_class_group">
                                <label class="form-label">Class</label>
                                <input type="text" id="student_class" class="form-control" readonly>
                            </div>

                            <div class="col-md-4 mb-3" id="student_teacher_group">
                                <label class="form-label">Teacher</label>
                                <input type="text" id="student_teacher" class="form-control" readonly>
                            </div>
                        </div>


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

        nextBtn.addEventListener('click', function () {
            const requiredFields = step1.querySelectorAll('input[required], select[required]');
            let allFilled = true;

            requiredFields.forEach(field => {

                const existingError = field.parentElement.querySelector('.error-message');
                if (existingError) {
                    existingError.remove();
                }

                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    allFilled = false;

                    const error = document.createElement('small');
                    error.classList.add('text-danger', 'error-message');
                    error.innerText = 'This field is required';
                    field.parentElement.appendChild(error);
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (allFilled) {
                step1.style.display = 'none';
                step2.style.display = 'block';
                progressBar.style.width = '100%';
                progressBar.innerText = '2 of 2: Legal & Student Info';
            }
        });

        prevBtn.addEventListener('click', function () {
            step1.style.display = 'block';
            step2.style.display = 'none';
            progressBar.style.width = '50%';
            progressBar.innerText = '1 of 2: Personal Info';
        });

        $('#admission_no').on('blur', function () {

            let admissionNo = $(this).val().trim();
            console.log("admission " + admissionNo);


            if (admissionNo !== '') {
                $.ajax({
                    url: '/findStudent',
                    method: 'GET',
                    data: { admission_no: admissionNo },
                    success: function (response) {
                        if (response.success) {
                            $('#student_name').val(response.name);
                            $('#student_class').val(response.class);
                            $('#student_teacher').val(response.teacher);

                            $('#class_id').val(response.class_id);
                            $('#teacher_id').val(response.teacher_id);

                            // Show the hidden fields
                            $('#student_name_group').show();
                            $('#student_class_group').show();
                            $('#student_teacher_group').show();
                        } else {
                            // Hide and clear if student not found
                            $('#student_name_group, #student_class_group, #student_teacher_group').hide();
                            $('#student_name, #student_class, #student_teacher').val('');
                            $('#class_id, #teacher_id').val('');

                            Swal.fire({
                                icon: 'error',
                                title: 'Student Not Found',
                                text: response.message
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while fetching student details.'
                        });
                    }
                });
            }
        });

        

    </script>


@endsection
