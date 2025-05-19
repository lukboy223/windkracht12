<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\instructorController;
use App\Http\Middleware\Instructor;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/lessons/{lesson}/cancel', [LessonController::class, 'cancel'])->name('lessons.cancel')->middleware('auth');
Route::get('/lessons', [LessonController::class, 'index'])->name('lessons.index')->middleware('auth');

// Students CRUD, only for admin and instructor roles
Route::middleware(['auth', Instructor::class])->group(function () {
    Route::resource('students', StudentController::class);
});

// Instructor dashboard and related pages, only for instructor role
Route::middleware(['auth', Instructor::class])->group(function () {
    Route::resource('instructor', instructorController::class);
});

require __DIR__.'/auth.php';
