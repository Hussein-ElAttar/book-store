<?php

namespace App\Services;

use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    public function sendActivationEmailLink($user_email, $activation_link)
    {
        $email = new VerificationEmail($activation_link);
        Mail::to($user_email)->send($email);
    }
}
