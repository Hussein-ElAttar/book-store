<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\ResponseService;
use App\Constants\ResponseMessageConstants;
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

    public function sendActivationLinkEmail()
    {
        $this->userService->sendActivationLinkEmail(Auth::user());

        return ResponseService::getSuccessResponse([], ResponseMessageConstants::USER_ACTIVITON_LINK_EMAIL_SENT);
    }

    public function SendResetPasswordEmail(SendResetPasswordEmailRequest $request)
    {
        $email = $request->email;

        $this->userService->SendResetPasswordEmail($email);

        return ResponseService::getSuccessResponse([], ResponseMessageConstants::USER_RESET_PASSWORD_EMAIL_SENT);
    }

    public function resetPassword(ResetUserPasswordRequest $request)
    {
        $this->userService->resetPassword(
            $request->email,
            $request->password,
            $request->password_confirmation,
            $request->token
        );

        return ResponseService::getSuccessResponse([], ResponseMessageConstants::USER_PASSWORD_RESET);
    }

    public function activateUser(Request $request)
    {
        $user_id = $request->get('id');

        $this->userService->activateUser($user_id);

        return ResponseService::getSuccessResponse([], ResponseMessageConstants::USER_EMAIL_ACTIVATED);

    }
}
