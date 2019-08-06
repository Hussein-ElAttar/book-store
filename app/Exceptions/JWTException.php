<?php

namespace App\Exceptions;

use Exception;
use App\Exceptions\Interfaces\ICustomException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class JWTException extends CustomException
{
}