<?php
// app/Mail/ResetPasswordMail.php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetLink;

    // Inject the reset link into the mailable
    public function __construct($resetLink)
    {
        $this->resetLink = $resetLink;
    }

    // Build the message
    public function build()
    {
        return $this->subject('Password Reset Request')
                    ->view('emails.resetPassword')  // Reference the email view
                    ->with(['resetLink' => $this->resetLink]);
    }
}
