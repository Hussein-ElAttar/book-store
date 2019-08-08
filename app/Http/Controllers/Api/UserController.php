<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Requests\User\ResetUserPasswordRequest;
use App\Http\Requests\User\SendResetPasswordEmailRequest;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function register(RegisterUserRequest $request)
    {
        $data     = $request->all();
        $name     = $data['name'];
        $email    = $data['email'];
        $password = $data['password'];

        $user = $this->userService->register($name, $email, $password);

        return response()->json($user, 200);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        $tokens = $this->userService->getLoginTokens($credentials);

        return $this->respondWithTokens($tokens['access_token'], $tokens['refresh_token']);
    }

    public function GetNewAccessToken()
    {
        $access_token = $this->userService->getNewAccessToken();

        return $this->respondWithTokens($access_token, NULL);
    }

    public function sendActivationLinkEmail()
    {
        $this->userService->sendActivationLinkEmail();

        return response()->json('Your Activation link has been submitted');
    }

    public function SendResetPasswordEmail(SendResetPasswordEmailRequest $request)
    {
        $email    = $request->email;

        $this->userService->SendResetPasswordEmail($email);

        return response()->json(['message'=>'We have e-mailed your password reset link!'], 200);
    }

    public function resetPassword(ResetUserPasswordRequest $request)
    {
        $email                 = $request->email;
        $password              = $request->password;
        $password_confirmation = $request->password_confirmation;
        $token                 = $request->token;

        $this->userService->resetPassword($email, $password, $password_confirmation, $token);

        return response()->json(['message'=>'Your password was rest successfully'], 200);
    }

    public function verifyEmail(Request $request)
    {
        $this->userService->verifyEmail();
        return response()->json('Email verified!');
    }

    protected function respondWithTokens($accessToken, $refreshToken)
    {
        $response = array_filter(compact('accessToken', 'refreshToken'));
        return response()->json($response);
    }
}
