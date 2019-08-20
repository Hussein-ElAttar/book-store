<?php

namespace App\Services;

class ResponseService
{
    public static function getSuccessResponse($data=[], $message='', $http_code=200){
        return response()->json([
            "success" => true,
            "message" => $message,
            "data"    => $data ?? [],
        ], $http_code);
    }

    public static function getFailureResponse($errors=[], $message='', $http_code=400){
        return response()->json([
            "success" => false,
            "message" => $message,
            "errors"  => $errors ?? [],
        ], $http_code);
    }
}