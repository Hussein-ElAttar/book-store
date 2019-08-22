<?php

namespace App\Exceptions;

use App\Constants\ExceptionConstants;
use Exception;
use App\Exceptions\Interfaces\ICustomException;

class CustomException extends Exception implements ICustomException
{
    protected $statusCode;
    protected $errors;

    public function __construct($exceptionCode, $errors = []) {
        $this->code       = $exceptionCode ?? 0;
        $this->message    = ExceptionConstants::MESSAGES[$exceptionCode] ?? '';
        $this->statusCode = ExceptionConstants::HTTP_CODES[$exceptionCode] ?? 400;
        $this->errors     = $errors;
    }

    public function getStatusCode() {
        return $this->statusCode;
    }

    public function getErrors() {
        return $this->errors;
    }
}
