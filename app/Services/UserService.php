<?php

namespace App\Services;
use Exception;
use App\Events\UserVerified;
use App\Services\EmailService;
use Illuminate\Support\Carbon;
use App\Constants\GenericConstants;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\URL;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Constants\ExceptionConstants;
use Illuminate\Support\Facades\Config;
use App\Services\Interfaces\IJWTService;
use Illuminate\Support\Facades\Password;

class UserService
{
    private $jwtService;

    public function __construct(IJWTService $jwtService, EmailService $emailService) {
        $this->jwtService   = $jwtService;
        $this->emailService = $emailService;
    }

    public function storeUser($name, $email, $password)
    {
        $user = UserRepository::storeUser($name, $email, Hash::make($password));
        $user->assignRole('editor');

        $this->sendActivationLinkEmail($user, $user->email);

        return $user;
    }

    public function sendActivationLinkEmail($user)
    {
        if ($user->hasVerifiedEmail()) {
            throw new CustomException(ExceptionConstants::USER_ALREADY_VERIFIED);
        }

        $temporarySignedURL = URL::temporarySignedRoute(
            'activateUserEmail',
            Carbon::now()->addMinutes(
                Config::get('constants.user_activation_temp_url_ttl_minutes')
            ),['id' => $user->id]
        );

        $this->emailService->sendActivationEmailLink($user->email, $temporarySignedURL);
    }

    public function activateUser($user_id)
    {
        $user = UserRepository::getUserById($user_id);

        if ($user->hasVerifiedEmail()) {
            throw new CustomException(ExceptionConstants::USER_ALREADY_VERIFIED);
        }

        $user->markEmailAsVerified();
        event(new UserVerified($user->email));
    }

    public function resetPassword($email, $password, $password_confirmation, $token)
    {
        $data = compact('email', 'password', 'password_confirmation', 'token');

        $response = Password::broker()->reset($data, function ($user, $password) {
            UserRepository::updateUserPasswordByModel($user, Hash::make($password));
        });

        if($response != Password::PASSWORD_RESET) {
            throw new Exception(trans($response));
        }
    }

    public function SendResetPasswordEmail($email)
    {
        $data = compact('email');
        $response = Password::broker()->sendResetLink($data);

        if($response != Password::RESET_LINK_SENT) {
            throw new Exception(trans($response));
        }
    }
}