<?php

namespace App\Http\Controllers\Api\Auth;

use App\Jobs\SendEmailJob;
use App\Events\UserVerified;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    use VerifiesEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        if (
            $request->hasValidSignature()
            && $request->get('id') == $request->user()->getKey()
        ){
            if ($request->user()->hasVerifiedEmail()) {
                event(new UserVerified($request->user()->email));
                return response()->json('Email Already Verified', 422);
            }
            return response()->json('Email verified!');
        } else {
            return response()->json('invalid url', 400);
        }
    }

    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json('User already have verified email!', 422);
        }

        $user_email = $request->user()->email;
        $user_id = $request->user()->id;

        $temporarySignedURL = URL::temporarySignedRoute(
            'verification.verify', Carbon::now()->addMinutes(60), ['id' => $user_id]
        );
        dispatch(new SendEmailJob($user_email, $temporarySignedURL));
        return response()->json('Your Activation link has been submitted');
    }
}