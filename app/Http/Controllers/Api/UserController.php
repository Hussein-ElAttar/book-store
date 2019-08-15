<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\ResetUserPasswordRequest;
use App\Http\Requests\User\SendResetPasswordEmailRequest;

// use function App\Providers\constant;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function storeUser(storeUserRequest $request)
    {
        $user = $this->userService->storeUser(
            $request->name,
            $request->email,
            $request->password
        );

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
        $access_token = $this->userService->getNewAccessToken(Auth::user());

        return $this->respondWithTokens($access_token, NULL);
    }

    public function sendActivationLinkEmail()
    {
        $this->userService->sendActivationLinkEmail(Auth::user());

        return response()->json('Your Activation link has been submitted');
    }

    public function SendResetPasswordEmail(SendResetPasswordEmailRequest $request)
    {
        $email = $request->email;

        $this->userService->SendResetPasswordEmail($email);

        return response()->json(['message'=>'We have e-mailed your password reset link!'], 200);
    }

    public function resetPassword(ResetUserPasswordRequest $request)
    {
        $this->userService->resetPassword(
            $request->email,
            $request->password,
            $request->password_confirmation,
            $request->token
        );

        return response()->json(['message'=>'Your password was rest successfully'], 200);
    }

    public function verifyEmail(Request $request)
    {
        $user_id = $request->get('id');

        $this->userService->verifyEmail($user_id);

        return response()->json('Email verified!');
    }

    protected function respondWithTokens($accessToken, $refreshToken)
    {
        $response = array_filter(compact('accessToken', 'refreshToken'));

        return response()->json($response);
    }
}
