<?php

namespace App\Services;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\RegisterUserRequest;
use App\Repositories\UserRepository;

class UserService{
    private $jwt_service;

    public function __construct(JWTService $jwt_service) {
        $this->jwt_service = $jwt_service;
    }

    public function getLoginTokens($credentials)
    {
        return $this->jwt_service->getAccessAndRefreshTokens($credentials);
    }

    public function register($name, $email, $password)
    {
        $password = Hash::make($password);
        $user     = UserRepository::storeUser($name, $email, $password);

        return $user;
    }

}