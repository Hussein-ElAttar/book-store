<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;

class UserRepository implements IUserRepository
{
    public static function storeUser($name, $email, $password){
        $fields = compact('name', 'email', 'password');
        return User::create($fields);
    }
}