<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\ResponseService;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Constants\MessageConstants;
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

    public function refreshJWT(Request $request)
    {
        $accessToken = $this->userService->refreshJWT();

        return $this->respondWithTokens($accessToken, null);
    }

    public function revokeJWT(Request $request){
        $token = JWTAuth::getToken();

        $this->userService->revokeJWT($token);

        return ResponseService::getSuccessResponse($token);
    }

    public function sendActivationLinkEmail()
    {
        $this->userService->sendActivationLinkEmail(Auth::user());

        return ResponseService::getSuccessResponse(null, MessageConstants::USER_ACTIVITON_LINK_EMAIL_SENT);
    }

    public function SendResetPasswordEmail(SendResetPasswordEmailRequest $request)
    {
        $email = $request->email;

        $this->userService->SendResetPasswordEmail($email);

        return ResponseService::getSuccessResponse(null, MessageConstants::USER_RESET_PASSWORD_EMAIL_SENT);
    }

    public function resetPassword(ResetUserPasswordRequest $request)
    {
        $this->userService->resetPassword(
            $request->email,
            $request->password,
            $request->password_confirmation,
            $request->token
        );

        return ResponseService::getSuccessResponse(null, MessageConstants::USER_PASSWORD_RESET);
    }

    public function verifyEmail(Request $request)
    {
        $user_id = $request->get('id');

        $this->userService->verifyEmail($user_id);

        return ResponseService::getSuccessResponse(null, MessageConstants::USER_EMAIL_ACTIVATED);

    }

    protected function respondWithTokens($accessToken, $refreshToken)
    {
        $response = array_filter(compact('accessToken', 'refreshToken'));

        return ResponseService::getSuccessResponse($response);
    }
}
