<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Constants\GenericConstants;
use Illuminate\Support\Facades\Config;
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
            "activation_link"=> $this->activation_link,
            "email_ttl_minutes"=> Config::get('constants.user_activation_temp_url_ttl_minutes'),
        ]);
    }
}
