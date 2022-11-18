<?php

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $email;
    public $reset_text;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($q, $email)
    {
        $this->reset_text = $q;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Password Reset';

        $link = config('app.client_url') . '/password/reset/'.$this->reset_text.'/'.$this->email;

        return $this
            ->subject($subject)
            ->view('emails.auth.password-reset-email')
            ->with('link', $link);
    }
}
