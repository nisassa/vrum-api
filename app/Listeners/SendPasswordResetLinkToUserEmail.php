<?php

namespace App\Listeners;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use App\Mail\Auth\PasswordResetEmail;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;

class SendPasswordResetLinkToUserEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var $email
     */
    public string $email;

    /**
     * Create a new job instance.
     *
     * @param string $email;
     * @return void
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::where([
            ['discard', '=', 0],
            ['email', '=', $this->email],
        ])->first();

        if ($user) {
            // generate the reset link
            $q = $this->urlfriendly(base64_encode(openssl_random_pseudo_bytes(24)));

            // Create the password reset record
            PasswordReset::create([
                'email' => $user->email,
                'token' => $q,
                'created_at' => now()->toDateTimeString()
            ]);

            // Create mailable
            $mailable = new PasswordResetEmail($q, $user->email);

            // Recipients are all the non-empty user emails
            $recipient = [
                $user->email,
            ];

            // Send email to user
            Mail::to($recipient)->send($mailable);
        }
    }

    private static function urlfriendly($text)
    {
        return preg_replace('/[^-\w]+/', '',
            strtolower(iconv('utf-8', 'us-ascii//TRANSLIT',
                trim(preg_replace('/[^\\pL\d]+/u', '-', $text), '-')))) ?: '-';
    }
}
