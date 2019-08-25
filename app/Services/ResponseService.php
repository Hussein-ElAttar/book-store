<?php

namespace App\Services;

class ResponseService
{
    public static function getSuccessResponse($data=[], string $message='', int $http_code=200){
        return response()->json([
            "success" => true,
            "code"    => 1,
            "message" => $message,
            "data"    => $data ,
            "errors"  => [],
        ], $http_code);
    }

    public static function getFailureResponse(int $code = 0, array $errors=[], string $message='', int $http_code=400){
        return response()->json([
            "success" => false,
            "code"    => $code,
            "message" => $message,
            "data"    => [],
            "errors"  => $errors,
        ], $http_code);
    }
}