<?php

  

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class SendEmailJob implements ShouldQueue

{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;
    protected $user_email;
    protected $message;

    public function __construct($user_email, $message)
    {
        $this->user_email = $user_email;
        $this->message = $message;
    }

    public function handle()
    {
        try{
            $email = new VerificationEmail($this->message);
            Mail::to($this->user_email)->send($email);
        } catch(Exception $e){ }
    }

}