<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Lesson;
use App\Models\Registration;
use App\Models\Student;

class DashboardController extends Controller
{
    // Example for DashboardController.php


    public function index()
    {
        $user = Auth::user();
        $lessons = collect();

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Check if user is a student
        $student = \App\Models\Student::where('user_id', $user->id)->first();
        $instructor = \App\Models\Instructor::where('user_id', $user->id)->first();

        if ($student) {
            // Student: lessons via registrations
            $registrationIds = \App\Models\Registration::where('student_id', $student->id)->pluck('id');
            $lessons = \App\Models\Lesson::whereIn('registration_id', $registrationIds)
                ->where('start_date', '>=', $startOfWeek->toDateString())
                ->where('start_date', '<=', $endOfWeek->toDateString())
                ->orderBy('start_date')
                ->orderBy('start_time')
                ->get();
        } elseif ($instructor) {
            // Instructor: lessons where instructor_id matches user
            $lessons = \App\Models\Lesson::where('instructor_id', $user->instructor->id)
                ->where('start_date', '>=', $startOfWeek->toDateString())
                ->where('start_date', '<=', $endOfWeek->toDateString())
                ->orderBy('start_date')
                ->orderBy('start_time')
                ->get();
        }else {
            // Admin: all lessons
            $lessons = 'admin';
        }
        $notifications = \App\Models\Notification::where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->take(10)
            ->get();

        return view('dashboard', compact('lessons', 'notifications'));
    }
}
