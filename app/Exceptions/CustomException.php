<?php

namespace App\Exceptions;

use App\Constants\ExceptionConstants;
use Exception;
use App\Exceptions\Interfaces\ICustomException;

class CustomException extends Exception implements ICustomException
{
    protected $statusCode;
    protected $errors;

    public function __construct(int $exceptionCode = 0, array $errors = []) {
        $this->code       = $exceptionCode;
        $this->message    = ExceptionConstants::MESSAGES[$exceptionCode];
        $this->statusCode = ExceptionConstants::HTTP_CODES[$exceptionCode];
        $this->errors     = $errors;
    }

    public function getStatusCode(): int {
        return $this->statusCode;
    }

    public function getErrors(): array {
        return $this->errors;
    }
}
