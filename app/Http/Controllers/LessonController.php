<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    public function index()
    {


        $user = auth()->user();
        $instructor = \App\Models\Instructor::where('user_id', $user->id)->first();
        // dd($instructor);
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
                ->where('instructor_id', $instructor->id)
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

        try {
            \DB::beginTransaction();
            
            // Update lesson status
            $lesson->lesson_status = 'Canceled';
            $lesson->save();

            // Get the instructor and student users
            $instructor = $lesson->instructor->user;
            $student = $lesson->registration->student->user;

            // Send email to the instructor
            \Mail::to($instructor->email)->send(
                new \App\Mail\LessonCancellation(
                    $lesson, 
                    $instructor, 
                    $request->reason,
                    true // isInstructor flag
                )
            );

            // Send email to the student
            \Mail::to($student->email)->send(
                new \App\Mail\LessonCancellation(
                    $lesson, 
                    $student, 
                    $request->reason,
                    false // isInstructor flag
                )
            );

            // Create notification for the instructor and student
            Notification::create([
                'user_id' => $instructor->id,
                'target_audience' => 'Instructor',
                'message' => 'Les op ' . $lesson->start_date . ' om ' . $lesson->start_time . ' is geannuleerd. Reden: ' . $request->reason,
                'type' => 'Lesson Cancellation',
                'date' => now(),
                'isactive' => true,
            ]);

            Notification::create([
                'user_id' => $student->id,
                'target_audience' => 'Student',
                'message' => 'Les op ' . $lesson->start_date . ' om ' . $lesson->start_time . ' is geannuleerd. Reden: ' . $request->reason,
                'type' => 'Lesson Cancellation',
                'date' => now(),
                'isactive' => true,
            ]);
            
            \DB::commit();

            return redirect()->back()->with('success', 'Les geannuleerd en betrokkenen geïnformeerd.');
            
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error canceling lesson: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Er is iets misgegaan bij het annuleren van de les.');
        }
    }
    
    public function create()
    {
        // Ensure the current user is an instructor
        $user = auth()->user();
        $instructor = \App\Models\Instructor::where('user_id', $user->id)->first();
        
        if (!$instructor) {
            return redirect()->route('dashboard')
                ->with('error', 'Alleen instructeurs kunnen lessen inplannen.');
        }
        
        // Get registrations with remaining lessons or that are still active
        $registrations = \App\Models\Registration::where('isactive', true)
            ->where(function($query) {
                $query->where('remaining_lessons', '>', 0)
                      ->orWhere('end_date', '>=', now());
            })
            ->with(['student.user'])
            ->get();
        
        return view('lessons.create', compact('registrations', 'instructor'));
    }
    
    public function store(Request $request)
    {
        // Ensure the current user is an instructor
        $user = auth()->user();
        $instructor = \App\Models\Instructor::where('user_id', $user->id)->first();
        
        if (!$instructor) {
            return redirect()->route('dashboard')
                ->with('error', 'Alleen instructeurs kunnen lessen inplannen.');
        }
        
        $validated = $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'start_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|in:09:00:00,13:00:00',
            'remark' => 'nullable|string|max:1000',
        ]);
        
        try {
            DB::beginTransaction();
            
            $registration = \App\Models\Registration::findOrFail($validated['registration_id']);
            
            // Create the lesson
            $lesson = new \App\Models\Lesson();
            $lesson->registration_id = $registration->id;
            $lesson->instructor_id = $instructor->id;
            $lesson->start_date = $validated['start_date'];
            $lesson->start_time = $validated['start_time'];
            $lesson->lesson_status = 'Planned';
            $lesson->remark = $validated['remark'];
            $lesson->number_of_students = 
                $registration->booking ? $registration->booking->participants : 1;
            $lesson->save();
            
            // Decrement remaining lessons if greater than 0
            if ($registration->remaining_lessons > 0) {
                $registration->remaining_lessons -= 1;
                $registration->save();
            }
            
            // Create notification for student
            \App\Models\Notification::create([
                'user_id' => $registration->student->user_id,
                'target_audience' => 'Student',
                'message' => 'Er is een nieuwe les ingepland op ' . 
                    \Carbon\Carbon::parse($validated['start_date'])->format('d-m-Y') . ' om ' .
                    \Carbon\Carbon::parse($validated['start_time'])->format('H:i') . '.',
                'type' => 'Lesson Change',
                'date' => now(),
                'isactive' => true,
            ]);
            
            DB::commit();
            
            return redirect()->route('lessons.index')
                ->with('success', 'Les is succesvol ingepland.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Fout bij het inplannen van een les: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'data' => $validated,
            ]);
            
            return back()->withInput()
                ->with('error', 'Er is een fout opgetreden bij het inplannen van de les: ' . $e->getMessage());
        }
    }
}
