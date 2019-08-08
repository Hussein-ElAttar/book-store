<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\RegisterUserRequest;
use App\Services\UserService;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function register(RegisterUserRequest $request)
    {
        $data = $request->all();
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

    public function refreshJWT()
    {
        $access_token = JWTAuth::claims(['type' => 'access_token'])
            ->fromUser(auth('api')->user());

        return $this->respondWithTokens($access_token, NULL);
    }

    protected function respondWithTokens($accessToken, $refreshToken)
    {
        $response = ['access_token' => $accessToken];
        if($refreshToken){
            $response['refresh_token'] = $refreshToken;
        }
        return response()->json($response);
    }
}
