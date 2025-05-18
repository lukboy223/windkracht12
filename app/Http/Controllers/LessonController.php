<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
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
