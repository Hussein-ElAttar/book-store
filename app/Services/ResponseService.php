<?php

namespace App\Services;
use App\Lib\Responses\Response;

class ResponseService
{
    public static function getResponse(Response $response, $http_code=200, $headers=[], $options=0){
        return response()->json($response, $http_code, $headers, $options);
    }

    // public static function getSuccessResponse($data=NULL, $message=NULL){
    //     return response()->json([
    //         "success" => 1,
    //         "message" => $message,
    //         "data"    => $data,
    //     ]);
    // }

    // public static function getFailureResponse($errors=NULL, $message=NULL){
    //     return response()->json([
    //         "success" => 1,
    //         "message" => $message,
    //         "errors"  => $errors,
    //     ]);
    // }
}