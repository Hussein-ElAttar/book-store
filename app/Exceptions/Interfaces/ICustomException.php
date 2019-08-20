<?php

namespace App\Exceptions\Interfaces;

use Throwable;

Interface ICustomException extends Throwable
{
    public function getErrors();

    public function getStatusCode();

}