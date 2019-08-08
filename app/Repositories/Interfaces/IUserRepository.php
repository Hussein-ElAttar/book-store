<?php
namespace App\Repositories\Interfaces;

interface IUserRepository
{
    public static function storeUser($name, $email, $password);
}