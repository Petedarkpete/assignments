<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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

Route::post('/add_user', [App\Http\Controllers\UserController:: class, 'add_user'])->name('add_user');
Route::post('/add_parent', [App\Http\Controllers\UserController:: class, 'add_parent'])->name('add_parent');
Route::post('/add_year', [App\Http\Controllers\YearController:: class, 'add_year'])->name('add_year');
Route::post('/add_class', [App\Http\Controllers\ClassController:: class, 'add_class'])->name('add_class');

Route::post('/edit_user/{id}', [App\Http\Controllers\UserController:: class, 'edit_user'])->name('edit_user');
Route::post('/delete_user/{id}', [App\Http\Controllers\UserController:: class, 'delete_user'])->name('delete_user');

Route::post('/import',[App\Http\Controllers\UserController:: class, 'import'])->name('import');

Route::get('dashboard', [App\Http\Controllers\DashboardController:: class, 'index'])->name('dashboard');
Route::get('upload_ass', [App\Http\Controllers\UploadController:: class, 'index'])->name('upload_ass');
Route::post('upload_assignment', [App\Http\Controllers\UploadController:: class, 'upload'])->name('upload_assignment');

Route::get('/users', [UserController::class, 'index'])->name('users');

Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

Route::get('/submit_ass', [App\Http\Controllers\SubmitController::class, 'index'])->name('submit_ass');
Route::get('/course', [App\Http\Controllers\CourseController::class, 'index'])->name('course');
Route::get('/year', [App\Http\Controllers\YearController::class, 'index'])->name('year');
Route::get('/class', [App\Http\Controllers\ClassController::class, 'index'])->name('class');

Route::get('/roles', function () {
    return view('roles.index', [
        'roles' => \App\Models\Role::with('permissions')->get()
    ]);
});

require __DIR__.'/auth.php';
