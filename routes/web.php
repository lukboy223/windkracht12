<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\instructorController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\Instructor;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/lessons/{lesson}/cancel', [LessonController::class, 'cancel'])->name('lessons.cancel')->middleware('auth');
Route::get('/lessons', [LessonController::class, 'index'])->name('lessons.index')->middleware('auth');

// Booking routes
Route::middleware(['auth'])->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create/{id}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
});

// Payment routes
Route::middleware(['auth'])->group(function () {
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
});

// Students CRUD, only for admin and instructor roles
Route::middleware(['auth', Instructor::class])->group(function () {
    Route::resource('students', StudentController::class);
});

// Instructor dashboard and related pages, only for instructor role
Route::middleware(['auth', Instructor::class])->group(function () {
    // Route::resource('instructor', instructorController::class);
    Route::get('/instructor/bsn/{id}', [\App\Http\Controllers\InstructorController::class, 'showBsnForm'])->name('instructors.bsn.form');
    Route::post('/instructor/bsn/{id}', [\App\Http\Controllers\InstructorController::class, 'saveBsn'])->name('instructors.bsn.save');
});

// Lesson routes for instructors
Route::middleware(['auth'])->group(function () {
    Route::get('/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
    Route::post('/lessons', [LessonController::class, 'store'])->name('lessons.store');
});

require __DIR__.'/auth.php';
