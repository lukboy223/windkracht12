<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Package;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingPaymentReminder extends Mailable
{
    use Queueable, SerializesModels;

    protected $booking;
    protected $package;
    protected $amount;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking, Package $package, float $amount)
    {
        $this->booking = $booking;
        $this->package = $package;
        $this->amount = $amount;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Herinnering: Voltooi je betaling voor kitesurfles')
            ->markdown('emails.bookings.payment-reminder', [
                'booking' => $this->booking,
                'package' => $this->package,
                'amount' => $this->amount,
            ]);
    }
}
