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
                                <label class="form-label">Occupation</label>
                                <select name="occupation" class="form-control" required>
                                    <option value="">Select Occupation (Optional)</option>
                                    <option value="Civil Servant">Civil Servant</option>
                                    <option value="Private Servant">Private Servant</option>
                                    <option value="Business">Business</option>
                                    <option value="Farmer">Farmer</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Identification</label>
                                <select name="occupation" id="occupation" class="form-control" required>
                                    <option value="">-- Select --</option>
                                    <option value="national_id">National ID</option>
                                    <option value="passport">Passport</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3" id="national_id_field" style="display: none;">
                                <label class="form-label">ID No.</label>
                                <input type="text" name="national_id_no" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3" id="passport_field" style="display: none;">
                                <label class="form-label">Passport No.</label>
                                <input type="text" name="passport_no" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Has more than one student?</label><br>
                                <div class="form-check form-check-inline mt-1">
                                    <input class="form-check-input" type="radio" name="add_student" id="add_student_yes" value="yes">
                                    <label class="form-check-label" for="add_student_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline mt-1">
                                    <input class="form-check-input" type="radio" name="add_student" id="add_student_no" value="no" checked>
                                    <label class="form-check-label" for="add_student_no">No</label>
                                </div>
                            </div>


                            <div class="col-md-4 mb-3">
                                <label class="form-label">Student Admission No</label>
                                <input type="text" id="admission_no" name="admission_no" class="form-control">
                            </div>
                        </div>

                        <div class="row d-none d-print-block" id="studentInfo">
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
                            <input type="hidden" id="class_id" name="class_id">
                            <input type="hidden" id="teacher_id" name="teacher_id">
                        </div>


                        <div class="d-flex justify-content-between">
                        <button type="button" id="prev-btn" class="btn btn-secondary">Previous</button>
                        <button type="submit" class="btn btn-success" id="submitButton">Submit</button>
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

                            document.getElementById("submitButton").disabled = false;
                        } else {
                            $('#student_name').val('Not found');
                            $('#student_class').val('Not found');
                            $('#student_teacher').val('Not found');
                            $('#class_id').val('');
                            $('#teacher_id').val('');

                            document.getElementById("submitButton").disabled = true;
                        }

                        $('#studentInfo').removeClass('d-none');
                    },
                    error: function () {
                        $('#student_name').val('Not found: Error');
                        $('#student_class').val('Not found: Error');
                        $('#student_teacher').val('Not found: Error');
                        $('#class_id').val('');
                        $('#teacher_id').val('');
                        $('#studentInfo').removeClass('d-none');

                        document.getElementById("submitButton").disabled = true;
                    }
                });
            }
        });

        document.getElementById('occupation').addEventListener('change', function () {
            let value = this.value;
            document.getElementById('national_id_field').style.display = (value === 'national_id') ? 'block' : 'none';
            document.getElementById('passport_field').style.display = (value === 'passport') ? 'block' : 'none';
        });



    </script>


@endsection
