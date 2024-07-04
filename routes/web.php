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

Route::post('/users', [App\Http\Controllers\UserController:: class, 'add_bulk'])->name('add_bulk');
Route::post('/add_user', [App\Http\Controllers\UserController:: class, 'add_user'])->name('add_user');

Route::post('/import',[App\Http\Controllers\UserController:: class, 'import'])->name('import');

Route::get('dashboard', [App\Http\Controllers\DashboardController:: class, 'index'])->name('dashboard');
Route::get('upload_ass', [App\Http\Controllers\UploadController:: class, 'index'])->name('upload_ass');
Route::post('upload_assignment', [App\Http\Controllers\UploadController:: class, 'upload'])->name('upload_assignment');

Route::get('/users', [UserController::class, 'index'])->name('users');

Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

Route::post('/users', [UserController::class, 'store'])->name('users.store');


require __DIR__.'/auth.php';
