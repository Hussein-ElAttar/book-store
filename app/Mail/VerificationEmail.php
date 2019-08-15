<?php

namespace App\Mail;

use App\Constants;
use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerificationEmail extends Mailable implements ShouldQueue
{
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($activation_link)
    {
        $this->activation_link = $activation_link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.verificationEmail', [
            "activation_link"=>$this->activation_link,
            "email_ttl_minutes"=>Constants::EMAIL_VALIDATION_URL_TTL_MINUTES
        ]);
    }
}
