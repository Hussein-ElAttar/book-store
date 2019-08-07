<?php

namespace App\Listeners;

use App\Events\UserVerified;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogVerificationEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserVerified  $event
     * @return void
     */
    public function handle(UserVerified $event)
    {
        Log::info('Verification Email sent to: '. $event->user_email);
    }
}
