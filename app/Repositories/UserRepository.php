<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Support\Str;

class UserRepository implements IUserRepository
{
    public static function storeUser($name, $email, $password){
        $fields = compact('name', 'email', 'password');
        return User::create($fields);
    }

    public static function updateUserPasswordByModel($user, $password){
        $user->password = $password;
        $user->setRememberToken(Str::random(60));
        $user->save();
    }
    public static function getUserById($user_id){
        return User::find($user_id);
    }
}