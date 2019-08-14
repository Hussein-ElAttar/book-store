<?php
namespace App\Repositories\Interfaces;

interface IUserRepository
{
    public static function storeUser($name, $email, $password);
    public static function updateUserPasswordByModel($user, $password);
    public static function getUserById($user_id);
}
