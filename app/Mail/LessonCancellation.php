<?php

namespace App\Mail;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LessonCancellation extends Mailable
{
    use Queueable, SerializesModels;

    protected $lesson;
    protected $recipient;
    protected $reason;
    protected $isInstructor;

    /**
     * Create a new message instance.
     */
    public function __construct(Lesson $lesson, User $recipient, string $reason, bool $isInstructor)
    {
        $this->lesson = $lesson;
        $this->recipient = $recipient;
        $this->reason = $reason;
        $this->isInstructor = $isInstructor;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Kitesurfles Geannuleerd')
            ->markdown('emails.lessons.cancellation', [
                'lesson' => $this->lesson,
                'recipient' => $this->recipient,
                'reason' => $this->reason,
                'isInstructor' => $this->isInstructor,
            ]);
    }
}
