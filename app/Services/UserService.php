<?php

namespace App\Services;

use App\Services\JWTService;
use App\Repositories\UserRepository;
use App\Exceptions\CustomException;
use App\Jobs\SendEmailJob;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserService{
    private $jwtService;

    public function __construct(JWTService $jwtService) {
        $this->jwtService = $jwtService;
    }

    public function getLoginTokens($credentials)
    {
        return $this->jwtService->getAccessAndRefreshTokens($credentials);
    }

    public function register($name, $email, $password)
    {
        $user = UserRepository::storeUser($name, $email, $password);

        return $user;
    }

    public function getNewAccessToken()
    {
        return $this->jwtService->refreshJWT();
    }

    public function sendActivationLinkEmail()
    {
        if (auth('api')->user()->hasVerifiedEmail()) {
            throw new CustomException('User already have verified email!', 422);
        }

        $user_email = auth('api')->user()->email;
        $user_id    = auth('api')->user()->id;

        $temporarySignedURL = URL::temporarySignedRoute(
            'verifyUserEmail', Carbon::now()->addMinutes(60), ['id' => $user_id]
        );
        dispatch(new SendEmailJob($user_email, $temporarySignedURL));
    }

    public function verifyEmail()
    {
        if (auth('api')->user()->hasVerifiedEmail()) {
            throw new CustomException('Email Already Verified', 422);
        }

        auth('api')->user()->markEmailAsVerified();
        event(new UserVerified(auth('api')->user()->email));
    }

    public function resetPassword($email, $password, $password_confirmation, $token)
    {
        $data = compact('email', 'password', 'password_confirmation', 'token');

        $response = Password::broker()->reset($data, function ($user, $password) {
            UserRepository::updateUserPasswordByModel($user, $password);
        });

        if($response != Password::PASSWORD_RESET){
            throw new CustomException(trans($response), 400);
        }
    }

    public function SendResetPasswordEmail($email)
    {
        $data = compact('email');
        $response = Password::broker()->sendResetLink($data);

        if($response != Password::RESET_LINK_SENT){
            throw new CustomException(trans($response), 400);
        }
    }
}