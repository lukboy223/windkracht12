<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserActivation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public User $user, public string $token)
    {
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Activeer je account')
            ->markdown('emails.user.activation', [
                'url' => route('registration.complete.form', ['token' => $this->token, 'email' => $this->user->email]),
            ]);
    }
}
