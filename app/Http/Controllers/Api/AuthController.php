<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        $access_token = auth('api')->claims(['type' => 'access_token'])
            ->attempt($credentials);

        if (! $access_token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $refresh_token = auth('api')->claims(['type' => 'refresh_token'])
            ->setTTL(100)->attempt($credentials);

        return $this->respondWithTokens($access_token, $refresh_token);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = JWTAuth::claims(['type' => 'access_token'])
            ->fromUser(auth('api')->user());

        return $this->respondWithTokens($token);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithTokens($accessToken, $refreshToken = NULL)
    {
        $response = ['access_token' => $accessToken];
        if($refreshToken){
            $response['refresh_token'] = $refreshToken;
        }
        return response()->json($response);
    }
}
