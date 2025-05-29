<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Lesson;
use App\Models\Package;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingPaymentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    protected $booking;
    protected $package;
    protected $lesson;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking, Package $package, Lesson $lesson)
    {
        $this->booking = $booking;
        $this->package = $package;
        $this->lesson = $lesson;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Betalingsbevestiging en informatie over je kitesurfles')
            ->markdown('emails.bookings.payment-confirmation', [
                'booking' => $this->booking,
                'package' => $this->package,
                'lesson' => $this->lesson,
            ]);
    }
}
