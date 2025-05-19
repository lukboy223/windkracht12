<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function index()
    {


        $user = auth()->user();
        $student = \App\Models\Student::where('user_id', $user->id)->first();
        $isStudent = (bool) $student;

        if ($isStudent) {
            $registrationIds = \App\Models\Registration::where('student_id', $student->id)->pluck('id');
            $lessons = \App\Models\Lesson::with(['instructor.user', 'registration.student.user'])
                ->whereIn('registration_id', $registrationIds)
                ->orderByDesc('start_date')
                ->orderByDesc('start_time')
                ->get();
        } else {
            $lessons = \App\Models\Lesson::with(['instructor.user', 'registration.student.user'])
                ->where('instructor_id', $user->id)
                ->orderByDesc('start_date')
                ->orderByDesc('start_time')
                ->get();
        }

        return view('lessons.index', compact('lessons', 'isStudent'));
    }

    public function cancel(Request $request, Lesson $lesson)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        // Update lesson status
        $lesson->lesson_status = 'Canceled';
        $lesson->save();

        // Create notification for the instructor and/or student
        Notification::create([
            'user_id' => $lesson->instructor_id, // or target student, depending on your logic
            'target_audience' => 'Both',
            'message' => 'Les op ' . $lesson->start_date . ' om ' . $lesson->start_time . ' is geannuleerd. Reden: ' . $request->reason,
            'type' => 'Lesson Cancellation',
            'date' => now(),
        ]);

        return redirect()->back()->with('success', 'Les geannuleerd en notificatie verstuurd.');
    }
}
