<?php

namespace App\Services;

use App\Jobs\SendEmailJob;
use App\Events\UserVerified;
use Illuminate\Support\Carbon;
use App\Services\TymonJWTService;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\URL;
use App\Repositories\UserRepository;
use App\Services\Interfaces\IJWTService;
use Illuminate\Support\Facades\Password;

class UserService
{
    private $jwtService;

    public function __construct(IJWTService $jwtService) {
        $this->jwtService = $jwtService;
    }

    public function getLoginTokens($credentials)
    {
        return $this->jwtService->getAccessAndRefreshTokens($credentials);
    }

    public function register($name, $email, $password)
    {
        $user = UserRepository::storeUser($name, $email, $password);

        $this->sendActivationLinkEmail($user->id, $user->email);

        return $user;
    }

    public function getNewAccessToken($user)
    {
        return $this->jwtService->refreshJWT($user);
    }

    public function sendActivationLinkEmail($user)
    {
        if ($user->hasVerifiedEmail()) {
            throw new CustomException('User already has verified email!', 422);
        }

        $temporarySignedURL = URL::temporarySignedRoute(
            'verifyUserEmail', Carbon::now()->addMinutes(60), ['id' => $user->id]
        );

        dispatch(new SendEmailJob($user->email, $temporarySignedURL));
    }

    public function verifyEmail($user)
    {
        if ($user->hasVerifiedEmail()) {
            throw new CustomException('Email Already Verified', 422);
        }

        $user->markEmailAsVerified();
        event(new UserVerified($user->email));
    }

    public function resetPassword($email, $password, $password_confirmation, $token)
    {
        $data = compact('email', 'password', 'password_confirmation', 'token');

        $response = Password::broker()->reset($data, function ($user, $password) {
            UserRepository::updateUserPasswordByModel($user, $password);
        });

        if($response != Password::PASSWORD_RESET) {
            throw new CustomException(trans($response), 400);
        }
    }

    public function SendResetPasswordEmail($email)
    {
        $data = compact('email');
        $response = Password::broker()->sendResetLink($data);

        if($response != Password::RESET_LINK_SENT) {
            throw new CustomException(trans($response), 400);
        }
    }
}