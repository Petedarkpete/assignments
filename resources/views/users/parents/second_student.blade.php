@extends('layouts.page')

@section('content')
<main id="main" class="main">

    <div class="container">
        <h3>Add parent</h3>

        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        <p style="font-size: 0.85rem;">{{ session('success') }}</p>
                    </div>
                @endif

                <form action="/parents/second_student_store" method="POST"  enctype="multipart/form-data">
                    @csrf

                        <div class="row mb-3">

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Student Admission No</label>
                                <input type="text" id="admission_no" name="admission_no" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Add another student?</label><br>
                                <div class="form-check form-check-inline mt-1">
                                    <input class="form-check-input" type="radio" name="add_student" id="add_student_yes" value="yes">
                                    <label class="form-check-label" for="add_student_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline mt-1">
                                    <input class="form-check-input" type="radio" name="add_student" id="add_student_no" value="no" checked>
                                    <label class="form-check-label" for="add_student_no">No</label>
                                </div>
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
                            <input type="hidden" name="parent_id" value="{{ session('parent_id') }}">
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success" id="submitButton">Submit</button>
                            <a href="{{ url('parents/view') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                </form>
            </div>
        </div>

    </div>

    <script>

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
    </script>
@endsection
