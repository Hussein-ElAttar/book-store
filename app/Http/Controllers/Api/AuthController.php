<?php

namespace App\Http\Controllers\Api;

use App\Constants\ResponseMessageConstants;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\IJWTService;

// use function App\Providers\constant;

class AuthController extends Controller
{
    private $jwtService;

    public function __construct(IJWTService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function authenticate(Request $request)
    {
        $credentials = ['email'=> $request->email, 'password'=> $request->password];

        $tokens = $this->jwtService->authenticate($credentials);

        return $this->respondWithTokens($tokens['access_token'], $tokens['refresh_token']);
    }

    public function refreshJWT()
    {
        // Tymon Middlewares handles the refresh and send it back in the header
        return ResponseService::getSuccessResponse(null, ResponseMessageConstants::TOKEN_REFRESHED);
    }

    public function revokeJWT(){
        $token = JWTAuth::getToken();

        $this->jwtService->revokeJWT($token);

        return ResponseService::getSuccessResponse(null, ResponseMessageConstants::TOKEN_INVALIDATED);
    }

    protected function respondWithTokens($accessToken, $refreshToken)
    {
        $response = array_filter(compact('accessToken', 'refreshToken'));

        return ResponseService::getSuccessResponse($response);
    }
}
