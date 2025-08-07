<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/users', [App\Http\Controllers\UserController:: class, 'index'])->name('users');

//for modules
Route::get('/modules', [App\Http\Controllers\ModuleController:: class, 'index'])->name('modules');
Route::post('/modules/store', [App\Http\Controllers\ModuleController:: class, 'store'])->name('modules.store');
Route::post('/sub_modules/store', [App\Http\Controllers\ModuleController:: class, 'storeSubModule'])->name('sub_modules.store');

//for users
Route::get('/teachers/view', [App\Http\Controllers\UserController:: class, 'teachersView'])->name('teachers.view');
Route::get('/teachers/create', [App\Http\Controllers\UserController:: class, 'teacherCreate'])->name('teachers.create');
Route::post('/teachers/store', [App\Http\Controllers\UserController:: class, 'teacherStore'])->name('teachers.store');
Route::delete('/teacher/{id}', [App\Http\Controllers\UserController::class, 'destroyTeacher'])->name('teacher.destroy');
Route::get('/teacher/{id}/edit', [App\Http\Controllers\UserController::class, 'teacherEdit'])->name('teacher.edit');
Route::post('/teachers/update', [App\Http\Controllers\UserController:: class, 'teacherUpdate'])->name('teachers.update');


Route::post('/add_user', [App\Http\Controllers\UserController:: class, 'add_user'])->name('add_user');
Route::post('/add_parent', [App\Http\Controllers\UserController:: class, 'add_parent'])->name('add_parent');
Route::post('/add_year', [App\Http\Controllers\YearController:: class, 'add_year'])->name('add_year');
Route::post('/add_class', [App\Http\Controllers\ClassController:: class, 'add_class'])->name('add_class');

Route::post('/edit_user/{id}', [App\Http\Controllers\UserController:: class, 'edit_user'])->name('edit_user');
Route::post('/delete_user/{id}', [App\Http\Controllers\UserController:: class, 'delete_user'])->name('delete_user');

Route::post('/import',[App\Http\Controllers\UserController:: class, 'import'])->name('import');

//assignments
Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', [App\Http\Controllers\DashboardController:: class, 'index'])->name('dashboard');
    Route::get('assignments', [App\Http\Controllers\UploadController:: class, 'index'])->name('assignments.index');


Route::get('create_assignment', [App\Http\Controllers\UploadController:: class, 'createAssignmentView'])->name('assignments.create');
Route::post('assignments/store', [App\Http\Controllers\UploadController:: class, 'storeAssignment'])->name('assignments.store');
Route::get('assignments/{id}/edit', [App\Http\Controllers\UploadController:: class, 'editAssignment'])->name('assignments.edit');
Route::post('assignments/update', [App\Http\Controllers\UploadController:: class, 'updateAssignment'])->name('assignments.update');
Route::delete('assignments/delete/{id}', [App\Http\Controllers\UploadController:: class, 'destroyAssignment'])->name('assignments.destroy');
Route::get('assignments/{id}/download', [App\Http\Controllers\UploadController:: class, 'downloadAssignment'])->name('assignments.download');
Route::get('assignments/{id}/view', [App\Http\Controllers\UploadController:: class, 'viewAssignment'])->name('assignments.view');
Route::get('assignments/{id}/submissions', [App\Http\Controllers\UploadController:: class, 'viewSubmissions'])->name('assignments.submissions');
Route::post('upload_assignment', [App\Http\Controllers\UploadController:: class, 'upload'])->name('upload_assignment');
Route::post('/assignments/store', [App\Http\Controllers\UploadController:: class, 'storeAssignment']);

Route::get('/users/view', [UserController::class, 'index'])->name('users');

Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

Route::get('/submit_ass', [App\Http\Controllers\SubmitController::class, 'index'])->name('submit_ass');
Route::get('/course', [App\Http\Controllers\CourseController::class, 'index'])->name('course');
Route::get('/year', [App\Http\Controllers\YearController::class, 'index'])->name('year');


Route::get('/roles', function () {
    return view('roles.index', [
        'roles' => \App\Models\Role::with('permissions')->get()
    ]);

//class

//students
Route::get('/students/view', [App\Http\Controllers\ClassController::class, 'index'])->name('class.view');

// //subject
Route::prefix('subject')->name('subject.')->group(function () {
    Route::get('/view', [App\Http\Controllers\SubjectController::class, 'index'])->name('view');
    Route::get('/create', [App\Http\Controllers\SubjectController::class, 'createSubject'])->name('create');
    Route::post('/store', [App\Http\Controllers\SubjectController::class, 'store'])->name('store');
    Route::delete('/{id}', [App\Http\Controllers\SubjectController::class, 'destroy'])->name('destroy');
    Route::post('/update/{id}', [App\Http\Controllers\SubjectController::class, 'update'])->name('update');
});
});
//stream
Route::prefix('streams')->name('streams.')->group(function () {
    Route::get('/view', [App\Http\Controllers\SettingController::class, 'index'])->name('view');
    Route::get('/create', [App\Http\Controllers\SettingController::class, 'createStream'])->name('create');
    Route::post('/store', [App\Http\Controllers\SettingController::class, 'store'])->name('store');
    Route::delete('/{id}', [App\Http\Controllers\SettingController::class, 'destroy'])->name('destroy');
    Route::post('/update/{id}', [App\Http\Controllers\SettingController::class, 'update'])->name('update');
});

Route::prefix('class')->name('class.')->group(function () {
    Route::get('/view', [App\Http\Controllers\ClassController::class, 'index'])->name('view');
    Route::get('/create', [App\Http\Controllers\ClassController::class, 'createClass'])->name('create');
    Route::post('/store', [App\Http\Controllers\ClassController::class, 'store'])->name('store');
    Route::delete('/{id}', [App\Http\Controllers\ClassController::class, 'destroy'])->name('destroy');
    Route::post('/update/{id}', [App\Http\Controllers\ClassController::class, 'update'])->name('update');
});

Route::prefix('students')->name('class.')->group(function () {
    Route::get('/view', [App\Http\Controllers\UserController::class, 'studentsView'])->name('students.view');
    Route::get('/create', [App\Http\Controllers\UserController::class, 'createStudent'])->name('students.create');
    Route::post('/store', [App\Http\Controllers\UserController::class, 'storeStudent'])->name('store');
    Route::delete('/{id}', [App\Http\Controllers\UserController::class, 'destroyStudent'])->name('destroy');
    Route::post('/update/{id}', [App\Http\Controllers\UserController::class, 'updateStudent'])->name('update');
    Route::post('/import', [App\Http\Controllers\UserController::class, 'importStudents'])->name('students.import');

});

Route::prefix('parents')->name('class.')->group(function () {
    Route::get('/view', [App\Http\Controllers\ParentsController::class, 'parentsView'])->name('parents.view');
    Route::get('/create', [App\Http\Controllers\ParentsController::class, 'createParent']);
    Route::post('/store', [App\Http\Controllers\ParentsController::class, 'storeParent'])->name('store');
    Route::delete('/{id}', [App\Http\Controllers\ParentsController::class, 'destroyParent'])->name('destroy');
    Route::post('/update/{id}', [App\Http\Controllers\ParentsController::class, 'updateParent'])->name('update');
    Route::post('/import', [App\Http\Controllers\ParentsController::class, 'importParents'])->name('parents.import');
    Route::get('/second_student', [App\Http\Controllers\ParentsController::class, 'secondStudent']);
    Route::post('/second_student_store', [App\Http\Controllers\ParentsController::class, 'secondStudentStore']);
});


Route::prefix('confirmations')->name('class.')->group(function () {
    Route::get('/create', [App\Http\Controllers\ConfirmationController::class, 'create'])->name('create');
    Route::post('/store', [App\Http\Controllers\ConfirmationController::class, 'store'])->name('store');
    Route::delete('/{id}', [App\Http\Controllers\ConfirmationController::class, 'destroy'])->name('destroy');
    Route::post('/update/{id}', [App\Http\Controllers\ConfirmationController::class, 'update'])->name('update');
    Route::post('/import', [App\Http\Controllers\ConfirmationController::class, 'import'])->name('import');
    Route::get('/second_student', [App\Http\Controllers\ConfirmationController::class, 'secondStudent']);
    Route::post('/second_student_store', [App\Http\Controllers\ConfirmationController::class, 'secondStudentStore']);
});

Route::get('/confirmations/teachers', [App\Http\Controllers\ConfirmationController::class, 'confirmTeacher'])->name('confirmTeachers.view');


// routes/web.php
Route::get('/test-email', function () {
    try {
        Mail::raw('Test email from Laravel!', function ($message) {
            $message->to('peterndahi2018@gmail.com')
                   ->subject('Test Email');
        });
        return 'Email sent successfully!';
    } catch (Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

Route::post('/teachers/{id}/confirm', [App\Http\Controllers\ConfirmationController::class, 'confirmTeacherAction'])->name('teachers.confirm');
Route::get('/teachers/{id}/view', [App\Http\Controllers\ConfirmationController::class, 'confirmTeacherView'])->name('teachers.confirm.view');
Route::post('/teachers/confirm/{id}', [App\Http\Controllers\ConfirmationController::class, 'test'])->name('test');

Route::post('/findTeacher/{id}', [App\Http\Controllers\StudentController::class, 'findTeacher']);
Route::get('/findStudent', [App\Http\Controllers\StudentController::class, 'findStudent']);
Route::get('/findStudents/{id}', [App\Http\Controllers\StudentController::class, 'findStudents']);
Route::post('/checkClass', [App\Http\Controllers\ClassController::class, 'checkClass']);

Route::post('/activate/{token}', [App\Http\Controllers\Auth\ActivationController::class, 'submitForm'])->name('activation.submit');
Route::get('/activation/{token}', [App\Http\Controllers\Auth\ActivationController::class, 'showForm'])->name('activate');
});
require __DIR__.'/auth.php';
