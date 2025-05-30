<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Instructor;
use App\Models\Lesson;
use App\Models\Package;
use App\Models\Registration;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Notification; // Import the Notification model
use Carbon\Carbon;

use function Illuminate\Log\log;

class BookingController extends Controller
{
    public function index()
    {
        $packages = Package::where('isactive', true)->get();
        return view('bookings.index', compact('packages'));
    }
    
    public function create($id)
    {
        $package = Package::findOrFail($id);
        
        return view('bookings.create', compact('package', 'id'));
    }
    
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'package_id' => 'required|string|exists:packages,id',
            'date' => 'required|date|after:today',
            'time' => 'required|in:morning,afternoon',
            'location' => 'required|string|in:Zandvoort,Muiderberg,Wijk aan Zee,IJmuiden,Scheveningen,Hoek van Holland',
            'participants' => 'required|integer|min:1|max:2',
            'partner_name' => 'nullable|required_if:participants,2|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);
        
        try {
            DB::beginTransaction();
            $booking = new Booking();
            $booking->user_id = Auth::id();
            $booking->package_id = $validated['package_id'];
            $booking->booking_date = $validated['date'];
            $booking->booking_time = $validated['time'];
            $booking->location = $validated['location']; // Store the location
            $booking->participants = $validated['participants'];
            $booking->partner_name = $validated['partner_name'] ?? null;
            $booking->notes = $validated['notes'] ?? null;
            $booking->status = 'confirmed'; // Auto-confirm for now
            $booking->save();

            // Get the student associated with the current user
            $student = Student::where('user_id', Auth::id())->first();
            
            if (!$student) {
                // Create a student record if it doesn't exist
                $student = new Student();
                $student->user_id = Auth::id();
                $student->relation_number = 'S' . str_pad(Auth::id(), 5, '0', STR_PAD_LEFT);
                $student->save();
            }

            // Create a registration for this booking
            $registration = new Registration();
            $registration->student_id = $student->id;
            $registration->package_id = $validated['package_id'];
            $registration->booking_id = $booking->id;
            $registration->start_date = $validated['date'];
            
            // Set the end date for multi-lesson packages
            if (strpos($validated['package_id'], 'duo-three') !== false) {
                // For 3-lesson packages, set end date to 6 weeks from start
                $registration->end_date = Carbon::parse($validated['date'])->addWeeks(6);
                $registration->remaining_lessons = 3;
            } elseif (strpos($validated['package_id'], 'duo-five') !== false) {
                // For 5-lesson packages, set end date to 10 weeks from start
                $registration->end_date = Carbon::parse($validated['date'])->addWeeks(10);
                $registration->remaining_lessons = 5;
            } else {
                $registration->remaining_lessons = 1;
            }
            
            $registration->isactive = true;
            $registration->save();

            // Find an available instructor for this booking time
            // We'll convert morning/afternoon to time ranges
            $startTime = $validated['time'] === 'morning' ? '09:00:00' : '13:00:00';
            $endTime = $validated['time'] === 'morning' ? '12:30:00' : '16:30:00';
            
            // Find instructors who don't have lessons at this time
            // Simplified query that doesn't rely on the duration column
            $busyInstructorIds = Lesson::where('start_date', $validated['date'])
                ->where('start_time', 'LIKE', 
                    $validated['time'] === 'morning' ? '09:%' : '13:%')
                ->pluck('instructor_id')
                ->toArray();
                
            // Ensure we're using the correct ID format for instructor lookups
            // First, get the mapping between user_id and instructor.id
            $instructors = Instructor::all();
            $availableInstructors = $instructors->filter(function($instructor) use ($busyInstructorIds) {
                return !in_array($instructor->id, $busyInstructorIds) && 
                       !in_array($instructor->user_id, $busyInstructorIds);
            });
            
            // Get a random available instructor
            $availableInstructor = $availableInstructors->isNotEmpty() ? 
                $availableInstructors->random() : 
                $instructors->random();

            // Create the lesson in the lessons table
            // Only create the first lesson now for multi-lesson packages
            $lesson = new Lesson();
            $lesson->registration_id = $registration->id;
            $lesson->instructor_id = $availableInstructor->id;
            $lesson->start_date = $validated['date'];
            $lesson->start_time = $validated['time'] === 'morning' ? '09:00:00' : '13:00:00';
            $lesson->lesson_status = 'Awaiting payment'; // Set initial status
            $lesson->number_of_students = $validated['participants'];
            $lesson->save();
            
            // Decrement the remaining lessons count
            $registration->remaining_lessons -= 1;
            $registration->save();
            
            // Create a payment notification for the user
            Notification::create([
                'user_id' => Auth::id(),
                'target_audience' => 'Student',
                'message' => 'Je boeking is aangemaakt, maar nog niet betaald. <a href="' . route('payments.create', [
                    'booking_id' => $booking->id,
                    'amount' => $this->calculateAmount($validated['package_id'], $validated['participants'])
                ]) . '">Klik hier om te betalen</a>',
                'type' => 'Payment Reminder',
                'date' => now(),
                'isactive' => true,
            ]);
            
            // Send payment reminder email
            $package = Package::findOrFail($validated['package_id']);
            $amount = $this->calculateAmount($validated['package_id'], $validated['participants']);
            \Mail::to(Auth::user()->email)->send(new \App\Mail\BookingPaymentReminder($booking, $package, $amount));
            
            DB::commit();
            
            // Instead of redirecting to payment form directly, show success message with link to payment
              return redirect()->route('payments.create', [
                'booking_id' => $booking->id,
                'amount' => $this->calculateAmount($validated['package_id'], $validated['participants'])
            ])->with('booking_message', 'Je les is ingepland met instructeur ' . 
                $availableInstructor->user->name . ' op ' . $validated['date'] . ' (' . 
                ($validated['time'] === 'morning' ? 'ochtend' : 'middag') . '). Voltooi je betaling om de boeking te bevestigen.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Log the error for debugging
            Log::error('Booking error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'package_id' => $request->input('package_id'),
                'date' => $request->input('date'),
                'time' => $request->input('time'),
                'participants' => $request->input('participants'),
                'partner_name' => $request->input('partner_name'),
                'notes' => $request->input('notes'),
            ]);
            return back()->withInput()->with('error', 'Er is iets misgegaan: ' . $e->getMessage());
        }
    }

    // Helper method to calculate payment amount
    private function calculateAmount($packageId, $participants)
    {
        $package = Package::findOrFail($packageId);
        return $package->price * $participants;
    }
}
