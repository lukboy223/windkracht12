<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Notification;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $booking_id = $request->query('booking_id');
        $amount = $request->query('amount');
        
        if (!$booking_id || !$amount) {
            return redirect()->route('dashboard')->with('error', 'Ongeldige betaalgegevens');
        }
        
        $booking = Booking::findOrFail($booking_id);
        
        // Ensure user can only pay for their own bookings
        if ($booking->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'Ongeautoriseerde betaling');
        }
        
        return view('payments.create', compact('booking', 'amount'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:ideal,creditcard,paypal',
            'agree_terms' => 'required|accepted',
        ]);
        
        try {
            DB::beginTransaction();
            
            $booking = Booking::findOrFail($validated['booking_id']);
            
            // Ensure user can only pay for their own bookings
            if ($booking->user_id !== Auth::id()) {
                return redirect()->route('dashboard')->with('error', 'Ongeautoriseerde betaling');
            }
            
            // Create payment record
            $payment = new Payment();
            $payment->booking_id = $booking->id;
            $payment->user_id = Auth::id();
            $payment->amount = $validated['amount'];
            $payment->payment_method = $validated['payment_method'];
            $payment->status = 'completed';
            $payment->paid_at = now();
            $payment->save();
            
            // Update booking status
            $booking->status = 'confirmed';
            $booking->save();
            
            // Update lesson status from planning to planned
            $registration = $booking->registration;
            if ($registration) {
                $lessons = \App\Models\Lesson::where('registration_id', $registration->id)->get();
                foreach ($lessons as $lesson) {
                    $lesson->lesson_status = 'Planned';
                    $lesson->save();
                }
                
                // Send payment confirmation email with lesson details
                $package = \App\Models\Package::findOrFail($booking->package_id);
                $firstLesson = $lessons->first(); // Get the first lesson to include in the email
                if ($firstLesson) {
                    \Mail::to($request->user()->email)->send(new \App\Mail\BookingPaymentConfirmation($booking, $package, $firstLesson));
                }
            }
            
            // Delete any payment reminder notifications for this booking
            Notification::where('user_id', Auth::id())
                ->where('type', 'Payment Reminder')
                ->where('message', 'like', '%booking_id=' . $booking->id . '%')
                ->delete();
            
            DB::commit();
            
            return redirect()->route('dashboard')->with('success', 'Betaling geslaagd! Je boeking is bevestigd.');
            
        } catch (\Exception $e) {
            Log::error('Betaling mislukt: ' . $e->getMessage(), [
                'booking_id' => $validated['booking_id'],
                'user_id' => Auth::id(),
            ]);
            DB::rollback();
            return back()->withInput()->with('error', 'Betaling mislukt: ' . $e->getMessage());
        }
    }
    
    private function calculateAmount($booking)
    {
        $package = \App\Models\Package::findOrFail($booking->package_id);
        return $package->price * $booking->participants;
    }
}
